<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DashboardController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('DashboardModel');
        $this->load->model('Student_model'); // optional; keep if you use it elsewhere
        $this->load->database();
        // avoid CI showing DB HTML errors — we will handle DB errors carefully
        $this->db->db_debug = false;
    }

    public function dashboard()
    {
        $data['activeStudents']  = $this->DashboardModel->getActiveStudentsCount();
        $data['totalStudents']   = $this->DashboardModel->getTotalStudentsCount();
        $data['totalIncome']     = $this->DashboardModel->getTotalIncome();
        $data['totalDue']        = $this->DashboardModel->getTotalDueAmount();
        $data['studentDistribution'] = $this->DashboardModel->getStudentDistribution();
        $data['monthlyRevenue']  = $this->DashboardModel->getMonthlyRevenue();

        // use model to get centers so mapping is centralised
        $data['centers'] = $this->DashboardModel->getCenters();

        $this->load->view('superadmin/dashboard', $data);
    }

    /**
     * AJAX: center_stats
     */
    public function center_stats()
    {
        $center_id = $this->input->get('center_id', true);

        try {
            $where = [];
            if (!empty($center_id) && is_numeric($center_id)) {
                $where['center_id'] = (int)$center_id;
            }

            // total students
            $this->db->reset_query();
            if (!empty($where)) $this->db->where($where);
            $total_students = (int) $this->db->count_all_results($this->DashboardModel->t('students'));

            // active students
            $this->db->reset_query();
            if (!empty($where)) $this->db->where($where);
            $this->db->where($this->DashboardModel->c('students','status'), 'Active');
            $active_students = (int) $this->db->count_all_results($this->DashboardModel->t('students'));

            // total paid
            $this->db->reset_query();
            if (!empty($where)) $this->db->where($where);
            $paidCol = $this->DashboardModel->c('students','paid_amount');
            $this->db->select("COALESCE(SUM($paidCol),0) AS total_paid", false);
            $paid_row = $this->db->get($this->DashboardModel->t('students'))->row();
            $total_paid = floatval($paid_row->total_paid ?? 0);

            // total due
            $this->db->reset_query();
            if (!empty($where)) $this->db->where($where);
            $dueCol = $this->DashboardModel->c('students','remaining_amount');
            $this->db->select("COALESCE(SUM($dueCol),0) AS total_due", false);
            $due_row = $this->db->get($this->DashboardModel->t('students'))->row();
            $total_due = floatval($due_row->total_due ?? 0);

            // --- attendance: distinct students present in last 7 days (based on attendance.present = 1) ---
            $this->db->reset_query();
            $seven_days_ago = date('Y-m-d', strtotime('-6 days'));
            $attTbl = $this->DashboardModel->t('attendance');
            $attDateCol = $this->DashboardModel->c('attendance','date');
            $attCreated = $this->DashboardModel->c('attendance','created_at');
            $attPresent = $this->DashboardModel->c('attendance','present');
            $attStudentId = $this->DashboardModel->c('attendance','student_id');

            $this->db->distinct();
            $this->db->select("$attTbl.$attStudentId");
            $this->db->from($attTbl);
            $this->db->where("DATE(COALESCE($attTbl.$attDateCol, $attTbl.$attCreated)) >= ", $seven_days_ago);
            $this->db->where("$attTbl.$attPresent", 1);

            if (!empty($center_id) && is_numeric($center_id)) {
                $stuTbl = $this->DashboardModel->t('students');
                $stuIdCol = $this->DashboardModel->c('students','id');
                $stuCenterCol = $this->DashboardModel->c('students','center_id');
                $this->db->join($stuTbl, "$stuTbl.$stuIdCol = $attTbl.$attStudentId", 'inner');
                $this->db->where("$stuTbl.$stuCenterCol", (int)$center_id);
            }

            $present_query = $this->db->get();
            if ($present_query === false) {
                $dbErr = $this->db->error();
                throw new Exception('DB error (attendance distinct): ' . ($dbErr['message'] ?? 'unknown'));
            }
            $present_count = $present_query->num_rows();
            $attendance_rate = ($total_students > 0) ? round(($present_count / $total_students) * 100, 2) : 0;

            // weekly attendance via model (Mon..Sun)
            $weekOrdered = $this->DashboardModel->getWeeklyAttendance($center_id);
            if (!is_array($weekOrdered) || count($weekOrdered) !== 7) {
                $weekOrdered = array_fill(0,7,0);
            }

            // revenue last 8 months (use admission_date by default)
            $months_back = 8;
            $labels = [];
            $data_vals = [];
            for ($i = $months_back - 1; $i >= 0; $i--) {
                $m = date('Y-m', strtotime("-{$i} months"));
                $labels[] = date('M Y', strtotime("-{$i} months"));
                $data_vals[$m] = 0.0;
            }

            $this->db->reset_query();
            $dateExpr = "DATE_FORMAT(COALESCE(" . $this->DashboardModel->c('students','created_at') . ", " . $this->DashboardModel->c('students','admission_date') . ", " . $this->DashboardModel->c('students','joining_date') . "), '%Y-%m')";
            $paidCol = $this->DashboardModel->c('students','paid_amount');
            $this->db->select("$dateExpr as ym, COALESCE(SUM(" . $paidCol . "),0) as total", false);
            $this->db->from($this->DashboardModel->t('students'));
            if (!empty($center_id) && is_numeric($center_id)) {
                $this->db->where($this->DashboardModel->c('students','center_id'), (int)$center_id);
            }
            $this->db->where("$dateExpr >=", date('Y-m', strtotime("-" . ($months_back - 1) . " months")));
            $this->db->group_by('ym');
            $this->db->order_by('ym','ASC');

            $rev_q = $this->db->get();
            if ($rev_q !== false) {
                foreach ($rev_q->result_array() as $r) {
                    $ym = $r['ym'];
                    if (isset($data_vals[$ym])) $data_vals[$ym] = (float)$r['total'];
                }
            }
            $revenue_data = array_values($data_vals);

            // student distribution
            $this->db->reset_query();
            $stuTbl = $this->DashboardModel->t('students');
            $catCol = $this->DashboardModel->c('students','student_progress_category');

            $this->db->select("COALESCE(SUM(CASE WHEN $catCol='Beginner' THEN 1 ELSE 0 END),0) as b,
                               COALESCE(SUM(CASE WHEN $catCol='Intermediate' THEN 1 ELSE 0 END),0) as i,
                               COALESCE(SUM(CASE WHEN $catCol='Advanced' THEN 1 ELSE 0 END),0) as a", false);
            $this->db->from($stuTbl);
            if (!empty($center_id) && is_numeric($center_id)) {
                $this->db->where($this->DashboardModel->c('students','center_id'), (int)$center_id);
            }
            $dist_row = $this->db->get()->row_array();
            $student_distribution = [
                isset($dist_row['b']) ? (int)$dist_row['b'] : 0,
                isset($dist_row['i']) ? (int)$dist_row['i'] : 0,
                isset($dist_row['a']) ? (int)$dist_row['a'] : 0
            ];

            $response = [
                'total_students' => $total_students,
                'active_students' => $active_students,
                'total_paid' => $total_paid,
                'total_due' => $total_due,
                'attendance_rate' => $attendance_rate,
                'weekly_attendance' => $weekOrdered,
                'revenue' => [
                    'labels' => $labels,
                    'data' => $revenue_data
                ],
                'student_distribution' => $student_distribution,
                'debug_center_id' => !empty($center_id) ? (int)$center_id : null
            ];

            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => 'success', 'data' => $response]));
        } catch (Exception $e) {
            log_message('error', 'DashboardController::center_stats error: ' . $e->getMessage());
            return $this->output
                ->set_status_header(500)
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => 'error', 'message' => 'Server error', 'detail' => $e->getMessage()]));
        }
    }

    /**
     * students_list
     */
       public function students_list()
    {
        $filter = $this->input->get('filter', true) ?? $this->input->post('filter', true);
        $center_id = $this->input->get('center_id', true) ?? $this->input->post('center_id', true);

        if (empty($filter)) {
            return $this->output
                ->set_status_header(400)
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => 'error', 'message' => 'filter is required']));
        }

        try {
            // let model fetch student rows for the filter and optional center
            $students = $this->DashboardModel->getStudentsByFilter($filter, $center_id);

            $result = [];

            if (!empty($students)) {
                // student id column name according to mapping
                $stuIdCol = $this->DashboardModel->c('students', 'id');
                // collect ids in the form returned by the model (result_array keys match mapping)
                $student_ids = array_column($students, $stuIdCol);

                // --- build attendance aggregation for these students
                $attTbl = $this->DashboardModel->t('attendance');
                $attDateCol = $this->DashboardModel->c('attendance','date');
                $attTimeCol = $this->DashboardModel->c('attendance','time');
                $attCreated = $this->DashboardModel->c('attendance','created_at');
                $attStudentId = $this->DashboardModel->c('attendance','student_id');
                $attPresent = $this->DashboardModel->c('attendance','present');

                $this->db->reset_query();
                $this->db->select(
                    "a.{$attStudentId} AS student_id, 
                     MAX(CONCAT(COALESCE(a.{$attDateCol},''),' ',COALESCE(a.{$attTimeCol},''))) AS last_attendance, 
                     COUNT(CASE WHEN a.{$attPresent}=1 AND DATE(COALESCE(a.{$attDateCol}, a.{$attCreated})) >= DATE_SUB(CURDATE(), INTERVAL 6 DAY) THEN 1 END) AS attendance_count_last_7_days",
                    false
                );
                $this->db->from("{$attTbl} a");
                $this->db->where_in("a.{$attStudentId}", $student_ids);
                $this->db->group_by("a.{$attStudentId}");
                $att_q = $this->db->get();
                $att_rows = $att_q ? $att_q->result_array() : [];

                $attendance_map = [];
                foreach ($att_rows as $ar) {
                    $sid = $ar['student_id'];
                    $attendance_map[$sid] = [
                        'last_attendance' => $ar['last_attendance'],
                        'attendance_count_last_7_days' => (int)($ar['attendance_count_last_7_days'] ?? 0)
                    ];
                }

                // build final result in the exact shape the frontend expects
                $nameCol = $this->DashboardModel->c('students','name');
                $contactCol = $this->DashboardModel->c('students','contact');
                $parentCol = $this->DashboardModel->c('students','parent_name');
                $batchCol = $this->DashboardModel->c('students','batch_id');
                $levelCol = $this->DashboardModel->c('students','student_progress_category');
                $paidCol = $this->DashboardModel->c('students','paid_amount');
                $remCol = $this->DashboardModel->c('students','remaining_amount');
                $statusCol = $this->DashboardModel->c('students','status');

                foreach ($students as $s) {
                    $sid = $s[$stuIdCol];
                    $last_att = isset($attendance_map[$sid]) ? $attendance_map[$sid]['last_attendance'] : null;
                    $att_count = isset($attendance_map[$sid]) ? (int)$attendance_map[$sid]['attendance_count_last_7_days'] : 0;

                    $result[] = [
                        'id' => $sid,
                        'name' => $s[$nameCol] ?? '',
                        'contact' => $s[$contactCol] ?? '',
                        'parent_name' => $s[$parentCol] ?? '',
                        'batch_id' => $s[$batchCol] ?? '',
                        'student_progress_category' => $s[$levelCol] ?? '',
                        'paid_amount' => floatval($s[$paidCol] ?? 0),
                        'remaining_amount' => floatval($s[$remCol] ?? 0),
                        'status' => $s[$statusCol] ?? '',
                        'last_attendance' => $last_att,
                        'attendance_count_last_7_days' => $att_count
                    ];
                }
            }

            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => 'success', 'data' => $result]));
        } catch (Exception $e) {
            log_message('error', 'DashboardController::students_list error: ' . $e->getMessage());
            return $this->output
                ->set_status_header(500)
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => 'error', 'message' => 'Server error']));
        }
    }


}
