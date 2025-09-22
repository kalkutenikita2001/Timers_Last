<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DashboardController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('DashboardModel');
        $this->load->model('Student_model'); // optional
        $this->load->database();
        // Helpful: ensure DB errors throw exceptions so we return JSON errors instead of HTML
        $this->db->db_debug = false;
    }

    public function dashboard()
    {
        // existing data used by view
        $data['activeStudents']  = $this->DashboardModel->getActiveStudentsCount();
        $data['totalStudents']   = $this->DashboardModel->getTotalStudentsCount();
        $data['totalIncome']     = $this->DashboardModel->getTotalIncome();
        $data['totalDue']        = $this->DashboardModel->getTotalDueAmount();
        $data['studentDistribution'] = $this->DashboardModel->getStudentDistribution();
        $data['monthlyRevenue']  = $this->DashboardModel->getMonthlyRevenue();

        // fetch centers for right sidebar
        $query = $this->db->get('center_details');
        $data['centers'] = $query->result();

        $this->load->view('superadmin/dashboard', $data);
    }

    /**
     * AJAX: center_stats
     * returns JSON structure:
     * { status:'success', data: {
     *    total_students,
     *    active_students,
     *    total_paid,
     *    total_due,
     *    attendance_rate,
     *    weekly_attendance: [nMon..nSun],   // 7 integers - counts of present students per day
     *    revenue: { labels: ['Aug 2025', ...], data: [1234, ...] }, // last 8 months
     *    student_distribution: [beginner, intermediate, advanced],
     *    debug_center_id: <center id> (optional)
     * } }
     */
    public function center_stats()
    {
        // allow either GET param or none
        $center_id = $this->input->get('center_id', true);

        try {
            // --- totals (reuse logic you had) ---
            $where = [];
            if (!empty($center_id) && is_numeric($center_id)) {
                $where['center_id'] = (int)$center_id;
            }

            // total students
            $this->db->reset_query();
            if (!empty($where)) $this->db->where($where);
            $total_students = (int) $this->db->count_all_results('students');

            // active students
            $this->db->reset_query();
            if (!empty($where)) $this->db->where($where);
            $this->db->where('status', 'Active');
            $active_students = (int) $this->db->count_all_results('students');

            // total paid
            $this->db->reset_query();
            if (!empty($where)) $this->db->where($where);
            $this->db->select('COALESCE(SUM(paid_amount),0) AS total_paid', false);
            $paid_row = $this->db->get('students')->row();
            $total_paid = floatval($paid_row->total_paid ?? 0);

            // total due
            $this->db->reset_query();
            if (!empty($where)) $this->db->where($where);
            $this->db->select('COALESCE(SUM(remaining_amount),0) AS total_due', false);
            $due_row = $this->db->get('students')->row();
            $total_due = floatval($due_row->total_due ?? 0);

            // --- attendance rate (distinct students present in last 7 days) ---
            $this->db->reset_query();
            $seven_days_ago = date('Y-m-d', strtotime('-6 days')); // include today -> 7 day window
            $this->db->distinct();
            $this->db->select('attendance.student_id');
            $this->db->where("DATE(COALESCE(attendance.date, attendance.created_at)) >= ", $seven_days_ago);
            $this->db->where("attendance.status", "present");
            if (!empty($center_id) && is_numeric($center_id)) {
                // join to students to filter by center
                $this->db->join('students', 'students.id = attendance.student_id', 'inner');
                $this->db->where('students.center_id', (int)$center_id);
            }
            $present_query = $this->db->get('attendance');
            if ($present_query === false) {
                // DB error - surface message
                $dbErr = $this->db->error();
                throw new Exception('DB error (attendance distinct): ' . ($dbErr['message'] ?? 'unknown'));
            }
            $present_count = $present_query->num_rows();
            $attendance_rate = ($total_students > 0) ? round(($present_count / $total_students) * 100, 2) : 0;

            // --- weekly attendance: counts per day for last 7 days (Mon..Sun expected by view) ---
            // We'll produce an array ordered as the existing chart labels: Mon,Tue,...Sun
            $this->db->reset_query();
            $daily_counts = array_fill(0, 7, 0); // default

            // Build 7-day window (from 6 days ago to today)
            $days = [];
            for ($i = 6; $i >= 0; $i--) {
                $d = date('Y-m-d', strtotime("-{$i} days"));
                $days[] = $d;
            }
            // Query attendance grouped by date (use COALESCE(attendance.date, attendance.created_at))
            $this->db->select("DATE(COALESCE(attendance.date, attendance.created_at)) as att_date, COUNT(DISTINCT attendance.student_id) as cnt", false);
            $this->db->from('attendance');
            $this->db->where("DATE(COALESCE(attendance.date, attendance.created_at)) >= ", $days[0]);
            $this->db->where("attendance.status", "present");
            if (!empty($center_id) && is_numeric($center_id)) {
                $this->db->join('students', 'students.id = attendance.student_id', 'inner');
                $this->db->where('students.center_id', (int)$center_id);
            }
            $this->db->group_by('att_date');
            $this->db->order_by('att_date', 'ASC');
            $att_q = $this->db->get();
            if ($att_q === false) {
                $dbErr = $this->db->error();
                throw new Exception('DB error (attendance daily): ' . ($dbErr['message'] ?? 'unknown'));
            }
            $att_rows = $att_q->result_array();
            $map = [];
            foreach ($att_rows as $r) {
                $map[$r['att_date']] = (int)$r['cnt'];
            }
            // The front-end expects Mon..Sun labels; compute weekday order for the last 7 days in Mon..Sun order
            // We'll map the days[] array (which is chronological) into Mon..Sun index.
            // Build an array where index 0 = Monday
            $weekOrdered = array_fill(0, 7, 0); // Monday index 0
            foreach ($days as $d) {
                $ts = strtotime($d);
                // PHP: N returns 1 (Mon) .. 7 (Sun)
                $weekdayN = (int)date('N', $ts);
                $idx = $weekdayN - 1; // 0-6
                $weekOrdered[$idx] = isset($map[$d]) ? (int)$map[$d] : 0;
            }
            // Now weekOrdered is Mon..Sun counts for the last 7 calendar days (possibly spanning weeks)

            // --- revenue: last 8 months (center filtered) using students.paid_amount sums by month ---
            // fallback if paid amounts are not per month in your schema: this uses students.paid_amount aggregated by MONTH of created/updated date is not available
            // We will aggregate using students.created_at if available; else aggregate by payment_date not present — use existing monthlyRevenue fallback
            $months_back = 8;
            $labels = [];
            $data_vals = [];
            // build months list from oldest -> newest
            for ($i = $months_back - 1; $i >= 0; $i--) {
                $m = date('Y-m', strtotime("-{$i} months"));
                $labels[] = date('M Y', strtotime("-{$i} months"));
                $data_vals[$m] = 0.0;
            }

            // We'll attempt to sum students.paid_amount grouped by YEAR-MONTH of created_at (or admission_date if created_at missing)
            $this->db->reset_query();
            // The expression will try COALESCE(students.created_at, students.admission_date, students.joining_date)
            $dateExpr = "DATE_FORMAT(COALESCE(students.created_at, students.admission_date, students.joining_date), '%Y-%m')";
            $this->db->select("$dateExpr as ym, COALESCE(SUM(students.paid_amount),0) as total", false);
            $this->db->from('students');
            if (!empty($center_id) && is_numeric($center_id)) {
                $this->db->where('students.center_id', (int)$center_id);
            }
            // only consider last N months
            $this->db->where("$dateExpr >=", date('Y-m', strtotime("-" . ($months_back - 1) . " months")));
            $this->db->group_by('ym');
            $this->db->order_by('ym', 'ASC');
            $rev_q = $this->db->get();
            if ($rev_q === false) {
                $dbErr = $this->db->error();
                // If this fails because date columns are missing, we still return zeroed months
            } else {
                foreach ($rev_q->result_array() as $r) {
                    $ym = $r['ym'];
                    if (isset($data_vals[$ym])) $data_vals[$ym] = (float)$r['total'];
                }
            }
            // convert associative to numeric array in same label order
            $revenue_data = array_values($data_vals);

            // --- student distribution (Beginner / Intermediate / Advanced) ---
            $this->db->reset_query();
            $this->db->select("COALESCE(SUM(CASE WHEN student_progress_category='Beginner' THEN 1 ELSE 0 END),0) as b,
                               COALESCE(SUM(CASE WHEN student_progress_category='Intermediate' THEN 1 ELSE 0 END),0) as i,
                               COALESCE(SUM(CASE WHEN student_progress_category='Advanced' THEN 1 ELSE 0 END),0) as a", false);
            $this->db->from('students');
            if (!empty($center_id) && is_numeric($center_id)) {
                $this->db->where('center_id', (int)$center_id);
            }
            $dist_row = $this->db->get()->row_array();
            $student_distribution = [
                isset($dist_row['b']) ? (int)$dist_row['b'] : 0,
                isset($dist_row['i']) ? (int)$dist_row['i'] : 0,
                isset($dist_row['a']) ? (int)$dist_row['a'] : 0
            ];

            // Build response
            $response = [
                'total_students' => $total_students,
                'active_students' => $active_students,
                'total_paid' => $total_paid,
                'total_due' => $total_due,
                'attendance_rate' => $attendance_rate,
                'weekly_attendance' => $weekOrdered, // Mon..Sun
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
            // log and return JSON error
            log_message('error', 'DashboardController::center_stats error: ' . $e->getMessage());
            return $this->output
                ->set_status_header(500)
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => 'error', 'message' => 'Server error', 'detail' => $e->getMessage()]));
        }
    }

    /**
     * students_list remains the same as before (works fine)
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
            $this->db->reset_query();
            $this->db->select('students.*');
            $this->db->from('students');
            if (!empty($center_id) && is_numeric($center_id)) {
                $this->db->where('students.center_id', (int)$center_id);
            }

            switch ($filter) {
                case 'active':
                    $this->db->where('students.status', 'Active');
                    break;
                case 'attendance':
                    $seven_days_ago = date('Y-m-d', strtotime('-6 days'));
                    $this->db->join('attendance', 'attendance.student_id = students.id', 'inner');
                    $this->db->where("DATE(COALESCE(attendance.date, attendance.created_at)) >= ", $seven_days_ago);
                    $this->db->where('attendance.status', 'present');
                    $this->db->group_by('students.id');
                    break;
                case 'due':
                    $this->db->where('students.remaining_amount >', 0);
                    break;
                case 'paid':
                    $this->db->where('students.paid_amount >', 0);
                    break;
                default:
                    return $this->output->set_content_type('application/json')->set_output(json_encode(['status' => 'success', 'data' => []]));
            }

            $students = $this->db->get()->result_array();

            $result = [];
            if (!empty($students)) {
                $student_ids = array_column($students, 'id');

                $this->db->reset_query();
                $this->db->select("a.student_id, MAX(CONCAT(COALESCE(a.date,''),' ',COALESCE(a.time,''))) AS last_attendance, COUNT(CASE WHEN a.status='present' AND DATE(COALESCE(a.date,a.created_at)) >= DATE_SUB(CURDATE(), INTERVAL 6 DAY) THEN 1 END) AS attendance_count_last_7_days", false);
                $this->db->from('attendance a');
                $this->db->where_in('a.student_id', $student_ids);
                $this->db->group_by('a.student_id');
                $att_q = $this->db->get();
                $att_rows = $att_q->result_array();
                $attendance_map = [];
                foreach ($att_rows as $ar) {
                    $sid = $ar['student_id'];
                    $attendance_map[$sid] = [
                        'last_attendance' => $ar['last_attendance'],
                        'attendance_count_last_7_days' => (int)($ar['attendance_count_last_7_days'] ?? 0)
                    ];
                }

                foreach ($students as $s) {
                    $sid = $s['id'];
                    $last_att = isset($attendance_map[$sid]) ? $attendance_map[$sid]['last_attendance'] : null;
                    $att_count = isset($attendance_map[$sid]) ? (int)$attendance_map[$sid]['attendance_count_last_7_days'] : 0;

                    $result[] = [
                        'id' => $s['id'],
                        'name' => $s['name'] ?? '',
                        'contact' => $s['contact'] ?? '',
                        'parent_name' => $s['parent_name'] ?? '',
                        'batch_id' => $s['batch_id'] ?? '',
                        'student_progress_category' => $s['student_progress_category'] ?? '',
                        'paid_amount' => floatval($s['paid_amount'] ?? 0),
                        'remaining_amount' => floatval($s['remaining_amount'] ?? 0),
                        'status' => $s['status'] ?? '',
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
