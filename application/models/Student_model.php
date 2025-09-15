<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Student_model extends CI_Model
{

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
}
