<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class StaffModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        // ensure DB is loaded (safe even if autoloaded)
        $this->load->database();
    }

    /** 
     * Return all staff rows 
     */
    public function get_all()
    {
        $query = $this->db->get('staff');
        return $query ? $query->result_array() : [];
    }

    /** 
     * Return staff by id 
     */
    public function get_by_id($id)
    {
        $id = (int)$id;
        if ($id <= 0) return null;
        $query = $this->db->get_where('staff', ['id' => $id], 1);
        return $query ? $query->row_array() : null;
    }

    /** 
     * Update staff active status 
     */
    public function update_active($id, $active)
    {
        $id = (int)$id;
        $active = (int)$active;
        if ($id <= 0) return false;
        $this->db->where('id', $id);
        return $this->db->update('staff', ['active' => $active]);
    }

    /** 
     * Insert new staff record 
     */
    public function insertStaff($data)
    {
        return $this->db->insert('staff', $data);
    }

    /** 
     * Insert salary record linked to a staff_id safely 
     */
    public function insert_salary_for_staff($staff_id, array $data)
    {
        $staff_id = (int)$staff_id;
        if ($staff_id <= 0) {
            log_message('error', 'insert_salary_for_staff(): Invalid staff_id provided.');
            return false;
        }

        // Always include staff_id in insert
        $data['staff_id'] = $staff_id;

        // Auto-fill timestamps if missing
        if (!isset($data['created_at'])) $data['created_at'] = date('Y-m-d H:i:s');
        if (!isset($data['updated_at'])) $data['updated_at'] = date('Y-m-d H:i:s');

        return $this->db->insert('staff_salary', $data);
    }

    /** 
     * Utility: venues & slots 
     */
    public function getAllVenues()
    {
        return $this->db->get('venues')->result_array();
    }

    public function getAllSlots()
    {
        $this->db->select('venue_slots.*, venues.venue_name');
        $this->db->from('venue_slots');
        $this->db->join('venues', 'venue_slots.venue_id = venues.id', 'left');
        return $this->db->get()->result_array();
    }

    /** Aliases for backwards compatibility */
    public function getAllStaff()  { return $this->get_all(); }
    public function get_all_staff() { return $this->get_all(); }

    /** Delete staff by id */
    public function deleteStaff($id)
    {
        $this->db->where('id', (int)$id);
        return $this->db->delete('staff');
    }

    /** 
     * Return salary history for a staff id
     */
    public function get_salary_history($staff_id, $limit = 0)
    {
        $staff_id = (int)$staff_id;
        if ($staff_id <= 0) return [];

        // Prefer staff_id, fall back to sr_no for legacy data
        $linkCol = $this->db->field_exists('staff_id', 'staff_salary') ? 'staff_id' : (
                   $this->db->field_exists('sr_no', 'staff_salary') ? 'sr_no' : null);

        if ($linkCol === null) {
            log_message('warning', 'StaffModel::get_salary_history() - staff_salary link column not found');
            return [];
        }

        $this->db->from('staff_salary');
        $this->db->where($linkCol, $staff_id);
        $this->db->select('id, total_salary, paid_salary, paid_at, created_at, status');
        $this->db->order_by('paid_at', 'DESC');

        if ((int)$limit > 0) {
            $this->db->limit((int)$limit);
        }

        $rows = $this->db->get()->result_array();
        $out = [];

        foreach ($rows as $r) {
            $amount = 0.0;
            if (!empty($r['paid_salary'])) {
                $amount = (float)$r['paid_salary'];
            } elseif (!empty($r['total_salary'])) {
                $amount = (float)$r['total_salary'];
            }

            $dt = !empty($r['paid_at']) ? $r['paid_at'] : ($r['created_at'] ?? null);
            $label = $dt ? date('M Y', strtotime($dt)) : '(unknown)';

            $out[] = [
                'id'       => (int)($r['id'] ?? 0),
                'label'    => $label,
                'amount'   => $amount,
                'status'   => $r['status'] ?? null,
                'paid_at'  => $r['paid_at'] ?? null,
                'raw'      => $r,
            ];
        }

        return $out;
    }
}