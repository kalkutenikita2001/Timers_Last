<?php defined('BASEPATH') or exit('No direct script access allowed');

class DashboardModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    // Get Active Students Count
    public function getActiveStudentsCount()
    {
        return $this->db
            ->where('status', 'Active')
            ->count_all_results('students');
    }

    public function getTotalStudentsCount()
    {
        return $this->db->count_all('students');
    }

    public function getTotalIncome()
    {
        return $this->db
            ->select_sum('paid_amount')
            ->get('students')
            ->row()
            ->paid_amount ?? 0;
    }

    public function getTotalDueAmount()
    {
        return $this->db
            ->select_sum('remaining_amount')
            ->get('students')
            ->row()
            ->remaining_amount ?? 0;
    }

    public function getStudentDistribution()
    {
        $query = $this->db
            ->select('student_progress_category, COUNT(*) as count')
            ->from('students')
            ->group_by('student_progress_category')
            ->get();

        $result = $query->result_array();

        $distribution = [
            'Beginner'     => 0,
            'Intermediate' => 0,
            'Advanced'     => 0
        ];

        foreach ($result as $row) {
            if (!empty($row['student_progress_category']) && isset($distribution[$row['student_progress_category']])) {
                $distribution[$row['student_progress_category']] = (int)$row['count'];
            }
        }

        return $distribution;
    }

    // sum of paid_amount grouped by month
    public function getMonthlyRevenue()
    {
        $query = $this->db->select("DATE_FORMAT(admission_date, '%Y-%m') as month, SUM(paid_amount) as revenue")
            ->from('students')
            ->group_by("DATE_FORMAT(admission_date, '%Y-%m')")
            ->order_by("month", "ASC")
            ->get();

        return $query->result_array();
    }

    /**
     * Returns all centers from center_details table.
     * Each center row is returned as an object (to match how view used $c->id / $c->name).
     */
    public function getCenters()
    {
        $query = $this->db
            ->select('id, name')
            ->from('center_details')
            ->order_by('name', 'ASC')
            ->get();

        return $query->result(); // returns array of objects -> $c->id, $c->name in view
    }

    /**
     * Get aggregated stats for a center (or all centers when $center_id is null).
     * Returns:
     *  - total_students
     *  - active_students
     *  - attendance_rate (percentage, fallback using students.last_attendance within last 7 days)
     *  - total_due (sum of remaining_amount)
     *  - total_paid (sum of paid_amount)
     */
    public function getCenterStats($center_id = null)
    {
        // Build base SQL
        $sql = "SELECT
                    COUNT(*) AS total_students,
                    SUM(CASE WHEN status = 'Active' THEN 1 ELSE 0 END) AS active_students,
                    SUM(CASE WHEN remaining_amount IS NOT NULL THEN remaining_amount ELSE 0 END) AS total_due,
                    SUM(CASE WHEN paid_amount IS NOT NULL THEN paid_amount ELSE 0 END) AS total_paid,
                    SUM(CASE WHEN last_attendance IS NOT NULL AND last_attendance != '' AND DATE(last_attendance) >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) THEN 1 ELSE 0 END) AS recent_attendance_count
                FROM students
                WHERE 1=1";

        $params = array();
        if (!empty($center_id)) {
            $sql .= " AND center_id = ?";
            $params[] = $center_id;
        }

        $query = $this->db->query($sql, $params);
        $row = $query->row_array();

        // Normalize values
        $total_students = isset($row['total_students']) ? (int)$row['total_students'] : 0;
        $active_students = isset($row['active_students']) ? (int)$row['active_students'] : 0;
        $total_due = isset($row['total_due']) ? (float)$row['total_due'] : 0.0;
        $total_paid = isset($row['total_paid']) ? (float)$row['total_paid'] : 0.0;
        $recent_attendance_count = isset($row['recent_attendance_count']) ? (int)$row['recent_attendance_count'] : 0;

        // Attendance rate fallback calculation:
        $attendance_rate = 0.0;
        if ($active_students > 0) {
            $attendance_rate = round(($recent_attendance_count / $active_students) * 100, 2);
            if ($attendance_rate > 100) $attendance_rate = 100;
        }

        return array(
            'total_students'  => $total_students,
            'active_students' => $active_students,
            'attendance_rate' => $attendance_rate, // like 45.67
            'total_due'       => $total_due,
            'total_paid'      => $total_paid,
        );
    }

    /**
     * Fetch students matching a given filter and optional center.
     * $filter: 'active' | 'attendance' | 'due' | 'paid' | 'all'
     * $center_id: center id or null for all centers
     *
     * Returns array of rows with fields:
     * id, name, contact, parent_name, remaining_amount, paid_amount, status, last_attendance, batch_id, student_progress_category
     */
    public function getStudentsByFilter($filter = 'all', $center_id = null)
    {
        $this->db->select('id, name, contact, parent_name, remaining_amount, paid_amount, status, last_attendance, batch_id, student_progress_category, admission_date');
        $this->db->from('students');

        // apply center filter if provided
        if (!empty($center_id)) {
            $this->db->where('center_id', $center_id);
        }

        // apply filter conditions
        switch ($filter) {
            case 'active':
                $this->db->where('status', 'Active');
                break;

            case 'attendance':
                // students whose last_attendance falls within last 7 days
                $this->db->where("DATE(last_attendance) >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)");
                break;

            case 'due':
                // remaining_amount > 0 (or not null and > 0)
                $this->db->where('remaining_amount >', 0);
                break;

            case 'paid':
                // paid_amount > 0
                $this->db->where('paid_amount >', 0);
                break;

            case 'all':
            default:
                // no extra where
                break;
        }

        $this->db->order_by('name', 'ASC');

        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * NEW: Get weekly attendance counts for the last 7 days.
     * Returns a 7-element numeric array ordered Mon..Sun.
     *
     * @param int|null $center_id
     * @return array [Mon, Tue, Wed, Thu, Fri, Sat, Sun]
     */
    public function getWeeklyAttendance($center_id = null)
    {
        // Build date window: from 6 days ago to today (inclusive)
        $days = [];
        for ($i = 6; $i >= 0; $i--) {
            $days[] = date('Y-m-d', strtotime("-{$i} days"));
        }
        $startDate = $days[0];

        // Prepare query: count DISTINCT students present per date
        $this->db->reset_query();
        $this->db->select("DATE(COALESCE(attendance.date, attendance.created_at)) as att_date, COUNT(DISTINCT attendance.student_id) as cnt", false);
        $this->db->from('attendance');
        $this->db->where("DATE(COALESCE(attendance.date, attendance.created_at)) >= ", $startDate);
        $this->db->where("attendance.status", "present");

        if (!empty($center_id) && is_numeric($center_id)) {
            // join students to filter by center
            $this->db->join('students', 'students.id = attendance.student_id', 'inner');
            $this->db->where('students.center_id', (int)$center_id);
        }

        $this->db->group_by('att_date');
        $this->db->order_by('att_date', 'ASC');

        $q = $this->db->get();
        if ($q === false) {
            // On DB error, return zeroed week (so front-end continues to work)
            return array_fill(0, 7, 0);
        }

        $rows = $q->result_array();
        $map = [];
        foreach ($rows as $r) {
            $map[$r['att_date']] = (int)$r['cnt'];
        }

        // Build Mon..Sun array (index 0 = Monday)
        $weekOrdered = array_fill(0, 7, 0);
        foreach ($days as $d) {
            $ts = strtotime($d);
            // PHP date('N'): 1 (Mon) .. 7 (Sun)
            $weekdayN = (int)date('N', $ts);
            $idx = $weekdayN - 1; // 0..6
            $weekOrdered[$idx] = isset($map[$d]) ? $map[$d] : 0;
        }

        return $weekOrdered;
    }
}
