<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Venue_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Get all venues
    public function get_all_venues($filters = array()) {
        $this->db->select('v.*, GROUP_CONCAT(b.type, ":", b.duration, ":", b.time_start, ":", b.time_end SEPARATOR ";") as batches');
        $this->db->from('venues v');
        $this->db->join('batches b', 'b.venue_id = v.id', 'left');
        if (!empty($filters['name'])) {
            $this->db->like('v.name', $filters['name']);
        }
        if (!empty($filters['time_start'])) {
            $this->db->where('v.time_start >=', $filters['time_start']);
        }
        if (!empty($filters['time_end'])) {
            $this->db->where('v.time_end <=', $filters['time_end']);
        }
        $this->db->group_by('v.id');
        $query = $this->db->get();
        return $query->result();
    }

    // Get venue by ID
    public function get_venue_by_id($id) {
        $this->db->select('v.*, GROUP_CONCAT(b.type, ":", b.duration, ":", b.time_start, ":", b.time_end SEPARATOR ";") as batches');
        $this->db->from('venues v');
        $this->db->join('batches b', 'b.venue_id = v.id', 'left');
        $this->db->where('v.id', $id);
        $this->db->group_by('v.id');
        $query = $this->db->get();
        return $query->row();
    }

    // Add new venue
    public function add_venue($data) {
        if (strtotime($data['time_end']) <= strtotime($data['time_start'])) {
            return false;
        }
        $this->db->insert('venues', $data);
        return $this->db->insert_id();
    }

    // Update venue
    public function update_venue($id, $data) {
        if (strtotime($data['time_end']) <= strtotime($data['time_start'])) {
            return false;
        }
        $this->db->where('id', $id);
        return $this->db->update('venues', $data);
    }

    // Delete venue
    public function delete_venue($id) {
        $this->db->where('id', $id);
        $this->db->delete('venues');
        return $this->db->affected_rows() > 0;
    }

    // Get batches by venue
    public function get_batches_by_venue($venue_id) {
        $this->db->where('venue_id', $venue_id);
        $query = $this->db->get('batches');
        return $query->result();
    }

    // Get batch by ID
    public function get_batch_by_id($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('batches');
        return $query->row();
    }

    // Add new batch
    public function add_batch($data) {
        if (strtotime($data['time_end']) <= strtotime($data['time_start'])) {
            return false;
        }
        if ($data['duration'] < 1) {
            return false;
        }
        $this->db->insert('batches', $data);
        return $this->db->insert_id();
    }

    // Update batch
    public function update_batch($id, $data) {
        if (strtotime($data['time_end']) <= strtotime($data['time_start'])) {
            return false;
        }
        if ($data['duration'] < 1) {
            return false;
        }
        $this->db->where('id', $id);
        return $this->db->update('batches', $data);
    }

    // Delete batch
    public function delete_batch($id) {
        $this->db->where('id', $id);
        $this->db->delete('batches');
        return $this->db->affected_rows() > 0;
    }
}