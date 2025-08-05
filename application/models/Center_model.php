<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Center_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Get all centers with optional filters
    public function get_centers($filters = []) {
        $this->db->select('*');
        $this->db->from('centers');

        if (!empty($filters['center_name'])) {
            $this->db->like('LOWER(center_name)', strtolower($filters['center_name']));
        }
        if (!empty($filters['admin'])) {
            $this->db->like('LOWER(admin)', strtolower($filters['admin']));
        }
        if (!empty($filters['coordinator'])) {
            $this->db->like('LOWER(coordinator)', strtolower($filters['coordinator']));
        }
        if (!empty($filters['coach'])) {
            $this->db->like('LOWER(coach)', strtolower($filters['coach']));
        }
        if (!empty($filters['address'])) {
            $this->db->like('LOWER(address)', strtolower($filters['address']));
        }

        $query = $this->db->get();
        return $query->result_array();
    }

    // Get a single center by ID
    public function get_center_by_id($id) {
        $query = $this->db->get_where('centers', ['id' => $id]);
        return $query->row_array();
    }

    // Add a new center
    public function add_center($data) {
        return $this->db->insert('centers', $data);
    }

    // Update an existing center
    public function update_center($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('centers', $data);
    }

    // Delete a center
    public function delete_center($id) {
        $this->db->where('id', $id);
        return $this->db->delete('centers');
    }
}