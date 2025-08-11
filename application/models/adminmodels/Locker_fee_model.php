<?php
class Locker_fee_model extends CI_Model {
    public function __construct() {
        parent::__construct();
    }

    public function get_all_locker_fees($filters = []) {
        $this->db->select('*');
        $this->db->from('venue_locker_fees');

        // Apply filters if provided
        if (!empty($filters['filterVenue'])) {
            $this->db->where('venue', $filters['filterVenue']);
        }
        if (!empty($filters['filterTitle'])) {
            $this->db->like('title', $filters['filterTitle']);
        }
        if (!empty($filters['filterDate'])) {
            $this->db->where('date', $filters['filterDate']);
        }
        if (!empty($filters['filterMinAmount'])) {
            $this->db->where('amount >=', $filters['filterMinAmount']);
        }
        if (!empty($filters['filterMaxAmount'])) {
            $this->db->where('amount <=', $filters['filterMaxAmount']);
        }

        $query = $this->db->get();
        return $query->result();
    }

    public function get_locker_fee_by_id($id) {
        $query = $this->db->get_where('venue_locker_fees', array('id' => $id));
        return $query->row();
    }

    public function add_locker_fee($data) {
        $this->db->insert('venue_locker_fees', $data);
        return $this->db->affected_rows() > 0 ? $this->db->insert_id() : false;
    }

    public function update_locker_fee($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('venue_locker_fees', $data);
        return $this->db->affected_rows() > 0;
    }

    public function delete_locker_fee($id) {
        $this->db->where('id', $id);
        $this->db->delete('venue_locker_fees');
        return $this->db->affected_rows() > 0;
    }
}