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
        $query = $this->db->get_where('students', ['id' => $id]);
        return $query->row_array();
    }

    // count students for a given center_id
    public function count_by_center($center_id)
    {
        if (empty($center_id)) return 0;
        $this->db->where('center_id', $center_id);
        return (int) $this->db->count_all_results('students');
    }
}
