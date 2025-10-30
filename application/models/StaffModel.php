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
}