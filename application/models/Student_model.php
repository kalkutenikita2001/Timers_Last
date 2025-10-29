<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Student_model extends CI_Model
{
    // --- Configuration / schema mapping (edit here if your schema differs) ---
    // If attendance FK column is actually "student_id" change this to 'student_id'
    protected $ATT_STUDENT_FK = 'staff_id';      // attendance -> student FK (your dump showed staff_id)
    protected $ATT_DATE_COL    = 'date';
    protected $ATT_TIME_COL    = 'check_in_time'; // alias to "time"
    protected $ATT_PRESENT_COL = 'present';       // alias to "status" (1/0)
    protected $ATT_CREATED_COL = 'check_in_at';   // fallback created timestamp in attendance
    protected $STUDENTS_TABLE  = 'students';
    protected $ATT_TABLE       = 'attendance';
    protected $STAFF_TABLE     = 'staff';
    protected $BATCHES_TABLE   = 'batches';
    protected $CENTERS_TABLE   = 'center_details'; // many functions used this; your dashboard uses venues — adjust if needed

    public function __construct()
    {
        parent::__construct();
    }

    // fetch all students (returns array of arrays)
    public function get_all_students()
    {
        $query = $this->db->get($this->STUDENTS_TABLE);
        return $query->result_array();
    }

    // fetch single student by id (returns associative array or null)
    public function get_student_by_id($id)
    {
        if (empty($id)) return null;

        $this->db->select("{$this->STUDENTS_TABLE}.*, {$this->BATCHES_TABLE}.duration, {$this->BATCHES_TABLE}.end_date", false);
        $this->db->from($this->STUDENTS_TABLE);
        $this->db->join($this->BATCHES_TABLE, "{$this->STUDENTS_TABLE}.batch_id = {$this->BATCHES_TABLE}.id", 'left');
        $this->db->where("{$this->STUDENTS_TABLE}.id", (int)$id);
        $query = $this->db->get();
        return $query->row_array();
    }

    // fetch students by center (array of arrays)
    public function get_students_by_center($center_id)
    {
        if (empty($center_id)) return [];
        $query = $this->db->get_where($this->STUDENTS_TABLE, ['center_id' => (int)$center_id]);
        return $query->result_array();
    }

    // add student (legacy naming in your file inserted into 'student_attendencelink' — keep if needed)
    public function add_student($data)
    {
        $this->db->insert('student_attendencelink', $data);
        return $this->db->insert_id();
    }

    public function add_student_facility($data)
    {
        return $this->db->insert('student_facilities', $data);
    }

    // count students for a given center_id
    public function count_by_center($center_id)
    {
        if (empty($center_id)) return 0;
        $this->db->where('center_id', (int)$center_id);
        return (int) $this->db->count_all_results($this->STUDENTS_TABLE);
    }

    /**
     * Paginated fetch for students of a center with optional search.
     * Returns objects (to match existing usage).
     */
    public function get_students_by_center_paginated($center_id, $limit = 10, $offset = 0, $search = null)
    {
        if (empty($center_id)) return [];

        $this->db->from($this->STUDENTS_TABLE);
        $this->db->where('center_id', (int)$center_id);

        if (!empty($search)) {
            $s = trim($search);
            $this->db->group_start();
            $this->db->like('name', $s);
            $this->db->or_like('contact', $s);
            $this->db->or_like('parent_name', $s);
            $this->db->group_end();
        }

        $this->db->order_by('created_at', 'DESC');
        if ((int)$limit > 0) $this->db->limit((int)$limit, (int)$offset);

        $query = $this->db->get();
        return $query->result();
    }

    public function count_students_by_center($center_id, $search = null)
    {
        if (empty($center_id)) return 0;

        $this->db->from($this->STUDENTS_TABLE);
        $this->db->where('center_id', (int)$center_id);

        if (!empty($search)) {
            $s = trim($search);
            $this->db->group_start();
            $this->db->like('name', $s);
            $this->db->or_like('contact', $s);
            $this->db->or_like('parent_name', $s);
            $this->db->group_end();
        }

        return (int) $this->db->count_all_results();
    }

    public function get_student_by_id_history($id)
    {
        if (empty($id)) return [];
        $query = $this->db->get_where('student_addmission_history', ['student_id' => (int)$id]);
        return $query->result_array();
    }

    /**
     * get_student_by_id_batch
     * Returns an associative array (single student row with batch & center & coach name)
     */
    public function get_student_by_id_batch($id)
    {
        if (empty($id)) return [];

        // Select columns and coach name from staff.name (st.name)
        $this->db->select("
            sah.id as admission_id,
            sah.center_id,
            sah.batch_id,
            sah.*,
            c.id as center_id,
            c.name as center_name,
            c.center_number,
            c.address,
            c.rent_amount,
            c.rent_paid_date,
            c.center_timing_from,
            c.center_timing_to,
            c.password,
            c.created_at as center_created_at,
            c.updated_at as center_updated_at,
            b.id as batch_id,
            b.batch_name,
            b.batch_level,
            b.start_time,
            b.end_time,
            b.start_date,
            b.end_date,
            b.duration,
            b.category,
            b.created_at as batch_created_at,
            b.updated_at as batch_updated_at,
            st.name as coach_name
        ", false);

        $this->db->from($this->STUDENTS_TABLE . ' sah');
        $this->db->join($this->CENTERS_TABLE . ' c', "c.id = sah.center_id", 'left');
        $this->db->join($this->BATCHES_TABLE . ' b', "b.id = sah.batch_id", 'left');

        // join staff by st.id = sah.coach (students.coach stores staff.id)
        $this->db->join($this->STAFF_TABLE . ' st', "st.id = sah.coach", 'left');

        $this->db->where("sah.id", (int)$id);

        $query = $this->db->get();
        return $query->row_array();
    }

    public function get_student_by_id_history_batch($id)
    {
        if (empty($id)) return [];

        $this->db->select("
            sah.history_id as admission_history_id,
            sah.student_id,
            sah.center_id,
            sah.batch_id,
            sah.coach,
            c.id as center_id,
            c.name as center_name,
            c.center_number,
            c.address,
            c.rent_amount,
            c.rent_paid_date,
            c.center_timing_from,
            c.center_timing_to,
            c.password,
            c.created_at as center_created_at,
            c.updated_at as center_updated_at,
            b.id as batch_id,
            b.batch_name,
            b.batch_level,
            b.start_time,
            b.end_time,
            b.start_date,
            b.end_date,
            b.duration,
            b.category,
            b.created_at as batch_created_at,
            b.updated_at as batch_updated_at
        ", false);

        $this->db->from("student_addmission_history sah");
        $this->db->join($this->CENTERS_TABLE . " c", "c.id = sah.center_id", "left");
        $this->db->join($this->BATCHES_TABLE . " b", "b.id = sah.batch_id", "left");
        $this->db->where("sah.student_id", (int)$id);

        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * get_student_attendace
     * Returns attendance grouped by "Month Year" => array of rows
     * Adjusted to your schema: uses attendance.staff_id as FK and aliases check_in_time -> time, present -> status
     */
    public function get_student_attendace($student_id)
    {
        if (empty($student_id)) return [];

        $attFk = $this->ATT_STUDENT_FK;
        $dateCol = $this->ATT_DATE_COL;
        $timeCol = $this->ATT_TIME_COL;
        $presentCol = $this->ATT_PRESENT_COL;
        $createdCol = $this->ATT_CREATED_COL;

        $this->db->reset_query();
        $this->db->select("
            DATE_FORMAT({$dateCol}, '%M %Y') as month_year,
            id,
            {$attFk} AS student_id,
            {$dateCol} AS date,
            {$timeCol} AS time,
            {$presentCol} AS status,
            COALESCE({$createdCol}, created_at) AS created_at
        ", false);
        $this->db->from($this->ATT_TABLE);
        $this->db->where($attFk, $student_id);
        $this->db->order_by($dateCol, 'ASC');

        $query = $this->db->get();
        if ($query === false) {
            log_message('error', 'Student_model::get_student_attendace DB error: ' . print_r($this->db->error(), true));
            return [];
        }

        $result = $query->result_array();

        // Normalize the rows (map status 1->present, 0->absent, ensure time exists)
        foreach ($result as &$row) {
            // status normalization
            if (isset($row['status'])) {
                $row['status'] = ($row['status'] == 1 || strtolower($row['status']) === '1') ? 'present' : 'absent';
            } else {
                $row['status'] = 'absent';
            }

            // time fallback from created_at if empty
            if (empty($row['time']) && !empty($row['created_at'])) {
                $row['time'] = date('H:i', strtotime($row['created_at']));
            }
        }
        unset($row);

        // Group by month_year
        $attendance_by_month = [];
        foreach ($result as $row) {
            $attendance_by_month[$row['month_year']][] = $row;
        }

        return $attendance_by_month;
    }

    /**
     * get_overrall_attendance_of_std
     * Calculates attendance % between joining_date and today.
     * Uses attendance.present = 1 as present indicator.
     */
    public function get_overrall_attendance_of_std($student_id)
    {
        if (empty($student_id)) return null;

        // Step 1: get joining_date
        $this->db->select('joining_date');
        $this->db->where('id', (int)$student_id);
        $student = $this->db->get($this->STUDENTS_TABLE)->row();

        if (!$student) return null;

        $joining_date = $student->joining_date;
        $today = date('Y-m-d');

        // Step 2: compute total days (inclusive)
        $total_days_row = $this->db->query("SELECT DATEDIFF(?, ?) + 1 AS total_days", [$today, $joining_date])->row();
        $total_days = $total_days_row ? (int)$total_days_row->total_days : 0;

        // Step 3: count present days in attendance table (present = 1)
        $attFk = $this->ATT_STUDENT_FK;
        $present_count = $this->db->where($attFk, (int)$student_id)
            ->where($this->ATT_DATE_COL . ' >=', $joining_date)
            ->where($this->ATT_DATE_COL . ' <=', $today)
            ->where($this->ATT_PRESENT_COL, 1)
            ->count_all_results($this->ATT_TABLE);

        $attendance_percentage = 0;
        if ($total_days > 0) {
            $attendance_percentage = ($present_count / $total_days) * 100;
        }

        return [
            'student_id' => (int)$student_id,
            'joining_date' => $joining_date,
            'total_days' => $total_days,
            'present_days' => (int)$present_count,
            'attendance_percentage' => round($attendance_percentage, 2)
        ];
    }

    /**
     * get_students - returns students with batch & center info (array of arrays)
     */
    public function get_students()
    {
        $this->db->select('students.*, batches.batch_name as batch_name, batches.category as category, batches.batch_level, center_details.name as center_name', false);
        $this->db->from('students');
        $this->db->join('batches', 'students.batch_id = batches.id', 'left');
        $this->db->join('center_details', 'students.center_id = center_details.id', 'left');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_studentsbycenter($center_id)
    {
        if (empty($center_id)) return [];
        $this->db->select('students.*, batches.batch_name as batch_name, batches.category as category, batches.batch_level, center_details.name as center_name', false);
        $this->db->from('students');
        $this->db->join('batches', 'students.batch_id = batches.id', 'left');
        $this->db->join('center_details', 'students.center_id = center_details.id', 'left');
        $this->db->where('students.center_id', (int)$center_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * activate_students_for_today
     */
    public function activate_students_for_today()
    {
        $today = date('Y-m-d');

        $this->db->where('joining_date', $today);
        $this->db->where('status !=', 'Active');
        $this->db->update('students', ['status' => 'Active']);

        log_message('debug', "Activation Query: " . $this->db->last_query());

        $affected = $this->db->affected_rows();
        log_message('debug', "Activation affected rows: $affected");

        $db_error = $this->db->error();
        if (!empty($db_error['code'])) {
            log_message('error', "DB error activating students: ({$db_error['code']}) {$db_error['message']}");
        }

        return $affected;
    }

    public function get_coordinator()
    {
        return $this->db->get('coordinator')->row_array();
    }

    /**
     * get_last_attendace
     * Return last attendance record for student (or null)
     */
    public function get_last_attendace($student_id)
    {
        if (empty($student_id)) return null;

        $attFk = $this->ATT_STUDENT_FK;
        $dateCol = $this->ATT_DATE_COL;
        $timeCol = $this->ATT_TIME_COL;
        $createdCol = $this->ATT_CREATED_COL;

        $this->db->select("{$dateCol} as date, {$timeCol} as time, {$this->ATT_PRESENT_COL} as status, COALESCE({$createdCol}, created_at) as created_at", false);
        $this->db->from($this->ATT_TABLE);
        $this->db->where($attFk, (int)$student_id);
        $this->db->order_by($dateCol, 'DESC');
        $this->db->order_by($timeCol, 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();

        if ($query && $query->num_rows() > 0) {
            $row = $query->row_array();
            // normalize status
            $row['status'] = (isset($row['status']) && ($row['status'] == 1 || strtolower($row['status']) === '1')) ? 'present' : 'absent';
            if (empty($row['time']) && !empty($row['created_at'])) {
                $row['time'] = date('H:i', strtotime($row['created_at']));
            }
            return $row;
        }

        return null;
    }
}