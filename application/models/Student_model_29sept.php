<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Student_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    // fetch all students
    public function get_all_students()
    {
        $query = $this->db->get('students'); // SELECT * FROM students
        return $query->result_array();
    }

    // fetch single student by id
    public function get_student_by_id($id)
    {
        $this->db->select('students.*, batches.duration, batches.end_date');
        $this->db->from('students');
        $this->db->join('batches', 'students.batch_id = batches.id', 'left');
        $this->db->where('students.id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }
    public function get_students_by_center($center_id)
    {
        if (empty($center_id))
            return [];
        $query = $this->db->get_where('students', ['center_id' => $center_id]);
        return $query->result_array();
    }

public function add_student($data) {
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
        if (empty($center_id))
            return 0;
        $this->db->where('center_id', $center_id);
        return (int) $this->db->count_all_results('students');
    }

    /**
     * Paginated fetch for students of a center with optional search.
     *
     * @param int $center_id
     * @param int $limit
     * @param int $offset
     * @param string|null $search  // searches name, contact, parent_name
     * @return array
     */
    public function get_students_by_center_paginated($center_id, $limit = 10, $offset = 0, $search = null)
    {
        if (empty($center_id))
            return [];

        $this->db->from('students');
        $this->db->where('center_id', (int) $center_id);

        if (!empty($search)) {
            $s = trim($search);
            $this->db->group_start();
            $this->db->like('name', $s);
            $this->db->or_like('contact', $s);
            $this->db->or_like('parent_name', $s);
            $this->db->group_end();
        }

        $this->db->order_by('created_at', 'DESC'); // latest first
        if ((int) $limit > 0)
            $this->db->limit((int) $limit, (int) $offset);

        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Count students for a center with optional search filter.
     *
     * @param int $center_id
     * @param string|null $search
     * @return int
     */
    public function count_students_by_center($center_id, $search = null)
    {
        if (empty($center_id))
            return 0;

        $this->db->from('students');
        $this->db->where('center_id', (int) $center_id);

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
        $query = $this->db->get_where('student_addmission_history', ['student_id' => $id]);
        return $query->result_array();
    }

    public function get_student_by_id_batch($id)
    {

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
         st.staff_name as coach_name
    ");
        $this->db->from("students sah");
        $this->db->join("center_details c", "c.id = sah.center_id", "left");
        $this->db->join("batches b", "b.id = sah.batch_id", "left");
        $this->db->join("staff st", "st.assigned_batch = sah.batch_id", "left"); 
        $this->db->where("sah.id", $id);

        $query = $this->db->get();
        return $query->result_array();
    }


    public function get_student_by_id_history_batch($id)
    {
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
    ");
        $this->db->from("student_addmission_history sah");
        $this->db->join("center_details c", "c.id = sah.center_id", "left");
        $this->db->join("batches b", "b.id = sah.batch_id", "left");
        $this->db->where("sah.student_id", $id);

        $query = $this->db->get();
        return $query->result_array();
    }


    public function get_student_attendace($student_id)
    {
        $this->db->select("
        DATE_FORMAT(date, '%M %Y') as month_year, 
        id, student_id, date, time, status, created_at
    ");
        $this->db->from("attendance");
        $this->db->where("student_id", $student_id);
        $this->db->order_by("date", "ASC");

        $query = $this->db->get();
        $result = $query->result_array();

        // Group by month-year
        $attendance_by_month = [];
        foreach ($result as $row) {
            $attendance_by_month[$row['month_year']][] = $row;
        }

        return $attendance_by_month;
    }


   public function get_overrall_attendance_of_std($student_id)
{
    // ✅ Step 1: Get student's joining date
    $this->db->select('joining_date');
    $this->db->where('id', $student_id);
    $student = $this->db->get('students')->row();

    if (!$student) {
        return null; // Student not found
    }

    $joining_date = $student->joining_date;
    $today = date('Y-m-d');

    // ✅ Step 2: Count total possible days (from joining_date to today)
    $total_days = $this->db->query("
        SELECT DATEDIFF(?, ?) + 1 AS total_days
    ", [$today, $joining_date])->row()->total_days;

    // ✅ Step 3: Count present days from attendance table
    $present_days = $this->db->where('student_id', $student_id)
                             ->where('status', 'present')
                             ->where('date >=', $joining_date)
                             ->where('date <=', $today)
                             ->count_all_results('attendance');

    // ✅ Step 4: Calculate attendance percentage
    $attendance_percentage = 0;
    if ($total_days > 0) {
        $attendance_percentage = ($present_days / $total_days) * 100;
    }

    return [
        'student_id' => $student_id,
        'joining_date' => $joining_date,
        'total_days' => $total_days,
        'present_days' => $present_days,
        'attendance_percentage' => round($attendance_percentage, 2)
    ];
}
//
public function get_students()
{
    $this->db->select('students.*, batches.batch_name as batch_name, batches.category as category, batches.batch_level, center_details.name as center_name');
    $this->db->from('students');
    $this->db->join('batches', 'students.batch_id = batches.id', 'left');
    $this->db->join('center_details', 'students.center_id = center_details.id', 'left'); // if needed
    $query = $this->db->get();
    // print_r($query->result_array());die;
    return $query->result_array();
}
// ---------------------------------------26/9/25-------prajwal
public function activate_students_for_today() {
    $today = date('Y-m-d');

    // build & run update
    $this->db->where('joining_date', $today);
    $this->db->where('status !=', 'Active');
    $this->db->update('students', ['status' => 'Active']);

    // Debug info
    $last_query = $this->db->last_query();
    log_message('debug', "Activation Query: $last_query");

    $affected = $this->db->affected_rows();
    log_message('debug', "Activation affected rows: $affected");

    $db_error = $this->db->error(); // array('code','message')
    if (!empty($db_error['code'])) {
        log_message('error', "DB error activating students: ({$db_error['code']}) {$db_error['message']}");
    }

    // also return affected rows for the test route
    return $affected;
}
public function get_coordinator() {
    return $this->db->get('coordinator')->row_array();
}
}
