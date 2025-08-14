<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Event_notice_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_events($filters = []) {
        $this->db->select('*');
        $this->db->from('events_notices');

        if (!empty($filters['title'])) {
            $this->db->like('title', $filters['title']);
        }
        if (!empty($filters['center_name'])) {
            $this->db->like('center_name', $filters['center_name']);
        }
        if (!empty($filters['date'])) {
            $date = date('Y-m-d', strtotime(str_replace('/', '-', $filters['date'])));
            $this->db->where('date', $date);
        }
        if (!empty($filters['time'])) {
            $this->db->like('time', $filters['time']);
        }
        if (!empty($filters['description'])) {
            $this->db->like('description', $filters['description']);
        }

        $query = $this->db->get();
        return $query->result_array();
    }

    public function add_event($data) {
        return $this->db->insert('events_notices', $data);
    }

    public function update_event($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('events_notices', $data);
    }

    public function delete_event($id) {
        $this->db->where('id', $id);
        return $this->db->delete('events_notices');
    }

    public function add_participation($data) {
        return $this->db->insert('event_participations', $data);
    }
}
?>