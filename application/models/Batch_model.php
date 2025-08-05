<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Batch_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_batches($filters = []) {
        $this->db->select('*');
        $this->db->from('batches');

        if (!empty($filters['batch'])) {
            $this->db->like('batch', $filters['batch']);
        }
        if (!empty($filters['date'])) {
            $date = date('Y-m-d', strtotime(str_replace('/', '-', $filters['date'])));
            $this->db->where('date', $date);
        }
        if (!empty($filters['time'])) {
            $this->db->like('time', $filters['time']);
        }
        if (!empty($filters['category'])) {
            $this->db->where('category', $filters['category']);
        }
        if (!empty($filters['center_name'])) {
            $this->db->like('center_name', $filters['center_name']);
        }

        $query = $this->db->get();
        return $query->result_array();
    }

    public function add_batch($data) {
        return $this->db->insert('batches', $data);
    }

    public function update_batch($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('batches', $data);
    }

    public function delete_batch($id) {
        $this->db->where('id', $id);
        return $this->db->delete('batches');
    }
}
?>