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
     * Controller expects this exact method name: get_all()
     * Return: array of associative arrays (rows) or []
     */
    public function get_all()
    {
        $query = $this->db->get('staff');
        return $query ? $query->result_array() : [];
    }

    /**
     * Controller expects get_by_id($id)
     */
    public function get_by_id($id)
    {
        $id = (int)$id;
        if ($id <= 0) return null;
        $query = $this->db->get_where('staff', ['id' => $id], 1);
        return $query ? $query->row_array() : null;
    }

    /**
     * Controller expects update_active($id, $active)
     */
    public function update_active($id, $active)
    {
        $id = (int)$id;
        $active = (int)$active;
        if ($id <= 0) return false;
        $this->db->where('id', $id);
        return $this->db->update('staff', ['active' => $active]);
    }

    /* ---- keep/offer your original helpers (optional) ---- */

    public function insertStaff($data)
    {
        return $this->db->insert('staff', $data);
    }

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

    // aliases you already had — keep them if other code uses them
    public function getAllStaff()
    {
        return $this->get_all();
    }

    public function get_all_staff()
    {
        return $this->get_all();
    }

    public function deleteStaff($id)
    {
        $this->db->where('id', (int)$id);
        return $this->db->delete('staff');
    }

   
public function get_salary_history($staff_id, $limit = 0)
{
    $staff_id = (int)$staff_id;
    if ($staff_id <= 0) return [];

    $linkCol = $this->db->field_exists('staff_id', 'staff_salary') ? 'staff_id' : (
               $this->db->field_exists('sr_no', 'staff_salary') ? 'sr_no' : null);

    if ($linkCol === null) {
        // No obvious link column — return empty so we don't accidentally return all rows
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
        // choose numeric amount: prefer paid_salary then total_salary then 0
        $amount = 0.0;
        if (isset($r['paid_salary']) && $r['paid_salary'] !== null && $r['paid_salary'] !== '') {
            $amount = (float)$r['paid_salary'];
        } elseif (isset($r['total_salary']) && $r['total_salary'] !== null && $r['total_salary'] !== '') {
            $amount = (float)$r['total_salary'];
        }

        // label for UI: prefer paid_at date else created_at
        $dt = !empty($r['paid_at']) ? $r['paid_at'] : (!empty($r['created_at']) ? $r['created_at'] : null);
        $label = $dt ? date('M Y', strtotime($dt)) : '(unknown)';

        $out[] = [
            'id'    => isset($r['id']) ? (int)$r['id'] : null,
            'label' => $label,
            'amount'=> $amount,
            'status'=> $r['status'] ?? null,
            'paid_at'=> $r['paid_at'] ?? null,
            'raw'   => $r,
        ];
    }

    return $out;
}
}