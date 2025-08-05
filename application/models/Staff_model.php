<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Staff_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Get all staff with optional filters
    public function get_staff($filters = []) {
        $this->db->select('*');
        $this->db->from('staff');

        if (!empty($filters['name'])) {
            $this->db->like('LOWER(name)', strtolower($filters['name']));
        }
        if (!empty($filters['contact'])) {
            $this->db->like('LOWER(contact)', strtolower($filters['contact']));
        }
        if (!empty($filters['address'])) {
            $this->db->like('LOWER(address)', strtolower($filters['address']));
        }
        if (!empty($filters['center_name'])) {
            $this->db->like('LOWER(center_name)', strtolower($filters['center_name']));
        }
        if (!empty($filters['batch'])) {
            $this->db->like('LOWER(batch)', strtolower($filters['batch']));
        }
        if (!empty($filters['date'])) {
            $this->db->like('DATE_FORMAT(date, "%d/%m/%Y")', $filters['date']);
        }
        if (!empty($filters['time'])) {
            $this->db->like('LOWER(time)', strtolower($filters['time']));
        }
        if (!empty($filters['category'])) {
            $this->db->like('LOWER(category)', strtolower($filters['category']));
        }

        $query = $this->db->get();
        return $query->result_array();
    }

    // Get a single staff member by ID
    public function get_staff_by_id($id) {
        $query = $this->db->get_where('staff', ['id' => $id]);
        return $query->row_array();
    }

    // Add a new staff member
    public function add_staff($data) {
        return $this->db->insert('staff', $data);
    }

    // Update an existing staff member
    public function update_staff($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('staff', $data);
    }

    // Delete a staff member
    public function delete_staff($id) {
        $this->db->where('id', $id);
        return $this->db->delete('staff');
    }

    // Get all center names for dropdown
    public function get_centers() {
        $this->db->select('center_name');
        $this->db->from('centers');
        $query = $this->db->get();
        return $query->result_array();
    }
}