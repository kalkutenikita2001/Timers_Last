<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Staff_salary_model extends CI_Model {

    private $table_name = 'staff_salary';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_salary_records() {
        $this->db->select('ss.*, s.name, s.email, s.role, s.contact');
        $this->db->from($this->table_name.' ss');
        $this->db->join('staff s', 'ss.id = s.id', 'left'); // FK is `id`
        $this->db->where('ss.status !=', 'Deleted');
        $this->db->order_by('ss.sr_no', 'DESC');
        return $this->db->get()->result_array();
    }

    public function get_salary_by_staff_id($staff_id) {
        return $this->db->get_where($this->table_name, ['id' => $staff_id])->row_array();
    }

    public function add_salary_record($data) {
        // Ensure defaults
        $data = array_merge([
            'hours_worked' => 0,
            'days_present' => 0,
            'sessions'     => 0,
            'hourly_rate'  => 0.00,
            'total_salary' => 0.00,
            'status'       => 'Pending'
        ], $data);
        return $this->db->insert($this->table_name, $data);
    }

    public function update_salary_record($staff_id, $data) {
        $this->db->where('id', $staff_id);
        return $this->db->update($this->table_name, $data);
    }

    public function delete_salary_record($staff_id) {
        $this->db->where('id', $staff_id);
        return $this->db->delete($this->table_name);
    }

    public function mark_as_paid($staff_id, $hours, $days, $sessions, $rate, $total_salary) {
        $update_data = [
            'hours_worked' => $hours,
            'days_present' => $days,
            'sessions'     => $sessions,
            'hourly_rate'  => $rate,
            'total_salary' => $total_salary,
            'status'       => 'Paid',
            'paid_at'      => date('Y-m-d H:i:s'),
            'updated_at'   => date('Y-m-d H:i:s'),
        ];
        $this->db->where('id', $staff_id);
        return $this->db->update($this->table_name, $update_data);
    }
}
