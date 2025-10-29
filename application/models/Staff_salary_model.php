<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Staff_salary_model extends CI_Model {

    private $table = 'staff_salary';

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_salary_by_staff_id($staff_id)
    {
        return $this->db
            ->where('id', $staff_id)
            ->get($this->table)
            ->row_array();
    }

    public function add_salary_record($data)
    {
        $data['created_at'] = $data['created_at'] ?? date('Y-m-d H:i:s');
        $data['updated_at'] = $data['updated_at'] ?? date('Y-m-d H:i:s');
        return $this->db->insert($this->table, $data);
    }

    public function update_salary_record($staff_id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db
            ->where('id', $staff_id)
            ->update($this->table, $data);
    }

    public function delete_salary_record($staff_id)
    {
        return $this->db
            ->where('id', $staff_id)
            ->delete($this->table); // HARD DELETE
    }

    public function get_all_salary_records()
    {
        return $this->db
            ->select('ss.*, s.name, s.email, s.role, s.contact')
            ->from("{$this->table} ss")
            ->join('staff s', 'ss.id = s.id', 'left')
            ->where('ss.status !=', 'Deleted')
            ->order_by('ss.sr_no', 'DESC')
            ->get()
            ->result_array();
    }
}