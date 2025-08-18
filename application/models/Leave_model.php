<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Leave_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_leaves($filters = []) {
        if (!empty($filters['filterName'])) {
            $this->db->like('name', $filters['filterName']);
        }
        if (!empty($filters['filterBatch'])) {
            $this->db->where('batch', $filters['filterBatch']);
        }
        if (!empty($filters['filterLevel'])) {
            $this->db->like('level', $filters['filterLevel']);
        }
        if (!empty($filters['filterDate'])) {
            $this->db->where('date', $filters['filterDate']);
        }
        // Remove center_name filter to ensure all records are fetched when no filters are applied
        $query = $this->db->get('leaves');
        return $query->result_array();
    }

    public function add_leave($data) {
        return $this->db->insert('leaves', $data);
    }

    public function update_leave($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('leaves', $data);
    }

    public function delete_leave($id) {
        $this->db->where('id', $id);
        return $this->db->delete('leaves');
    }

    public function get_batches() {
        $query = $this->db->get('batches');
        return $query->result_array();
    }
}