<?php
// application/models/adminmodels/Add_on_facility_model.php
class Add_on_facility_model extends CI_Model {
    public function __construct() {
        parent::__construct();
    }

    public function get_all_add_on_facilities($filters = []) {
        $this->db->select('*');
        $this->db->from('add_on_facilities');

        // Apply filters if provided
        if (!empty($filters['filterFacility'])) {
            $this->db->where('facility', $filters['filterFacility']);
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

    public function get_add_on_facility_by_id($id) {
        $query = $this->db->get_where('add_on_facilities', array('id' => $id));
        return $query->row();
    }

    public function add_add_on_facility($data) {
        $this->db->insert('add_on_facilities', $data);
        return $this->db->affected_rows() > 0 ? $this->db->insert_id() : false;
    }

    public function update_add_on_facility($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('add_on_facilities', $data);
        return $this->db->affected_rows() > 0;
    }

    public function delete_add_on_facility($id) {
        $this->db->where('id', $id);
        $this->db->delete('add_on_facilities');
        return $this->db->affected_rows() > 0;
    }
}