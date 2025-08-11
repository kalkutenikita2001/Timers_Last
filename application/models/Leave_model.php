<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Leave_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_leaves($filters = []) {
        if (!empty($filters['center'])) {
            $this->db->where('center_name', $filters['center']);
        }
        $query = $this->db->get('leaves');
        return $query->result_array();
    }

    public function add_leave($data) {
        $this->db->insert('leaves', $data);
        return $this->db->insert_id();
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
?>
