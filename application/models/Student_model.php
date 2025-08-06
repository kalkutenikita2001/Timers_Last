<?php
class Student_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_students() {
        $this->db->select('id, center, name, contact, batch, category, plan_expiry');
        $query = $this->db->get('students');
        return $query->result_array();
    }

    public function add_student($data) {
        return $this->db->insert('students', $data);
    }

    public function get_student_by_id($id) {
        $this->db->select('id, center, name, contact, batch, category, plan_expiry, parent_name, emergency_contact, email, address, coach, coordinator, duration, total_fees, amount_paid, remaining_amount, payment_method');
        $query = $this->db->get_where('students', ['id' => $id]);
        return $query->row_array();
    }

    public function update_student($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('students', $data);
    }

    public function delete_student($id) {
        $this->db->where('id', $id);
        return $this->db->delete('students');
    }

    public function filter_students($filters) {
        $this->db->select('id, center, name, contact, batch, category, plan_expiry');
        if ($filters['name']) {
            $this->db->like('LOWER(name)', strtolower($filters['name']), 'both');
        }
        if ($filters['contact']) {
            $this->db->like('contact', $filters['contact'], 'both'); // Changed to LIKE for partial match
        }
        if ($filters['center']) {
            $this->db->like('LOWER(center)', strtolower($filters['center']), 'both');
        }
        if ($filters['batch']) {
            $this->db->like('batch', $filters['batch'], 'both'); // Changed to LIKE for partial match
        }
        if ($filters['category']) {
            $this->db->where('category', $filters['category']);
        }
        $query = $this->db->get('students');
        return $query->result_array();
    }
}
?>