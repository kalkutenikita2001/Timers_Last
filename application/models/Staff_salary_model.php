<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Staff_salary_model extends CI_Model
{
    private $table = 'staff_salary';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get the latest salary record for a staff member
     */
    public function get_salary_by_staff_id($staff_id)
{
    // Try to fetch the most recent non-pending record first
    $row = $this->db
        ->where('staff_id', $staff_id)
        ->where_in('status', ['Paid', 'Partially Paid'])
        ->order_by('created_at', 'DESC')
        ->limit(1)
        ->get($this->table)
        ->row_array();

    // If no Paid record exists, fallback to latest Pending
    if (!$row) {
        $row = $this->db
            ->where('staff_id', $staff_id)
            ->order_by('created_at', 'DESC')
            ->limit(1)
            ->get($this->table)
            ->row_array();
    }

    return $row;
}

    /**
     * Add new salary record
     */
    public function add_salary_record($data)
    {
        $data['created_at'] = $data['created_at'] ?? date('Y-m-d H:i:s');
        $data['updated_at'] = $data['updated_at'] ?? date('Y-m-d H:i:s');
        return $this->db->insert($this->table, $data);
    }

    /**
     * Update an existing salary record — only the latest Pending one
     */
   public function update_salary_record($staff_id, $data)
{
    $data['updated_at'] = date('Y-m-d H:i:s');

    // Try updating the pending record first
    $this->db
        ->where('staff_id', $staff_id)
        ->where('status', 'Pending')
        ->order_by('created_at', 'DESC')
        ->limit(1)
        ->update($this->table, $data);

    if ($this->db->affected_rows() === 0) {
        // If no pending found, update the latest record instead
        $this->db
            ->where('staff_id', $staff_id)
            ->order_by('created_at', 'DESC')
            ->limit(1)
            ->update($this->table, $data);
    }

    return true;
}

    /**
     * Delete all salary records for a given staff (HARD DELETE)
     */
    public function delete_salary_record($staff_id)
    {
        return $this->db
            ->where('staff_id', $staff_id)
            ->delete($this->table);
    }

    /**
     * Get all salary records joined with staff table
     */
    public function get_all_salary_records()
    {
        return $this->db
            ->select('ss.*, s.name, s.email, s.role, s.contact')
            ->from("{$this->table} ss")
            ->join('staff s', 'ss.staff_id = s.id', 'left')
            ->where('ss.status !=', 'Deleted')
            ->order_by('ss.created_at', 'DESC')
            ->get()
            ->result_array();
    }
}