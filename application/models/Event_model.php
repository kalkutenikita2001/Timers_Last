<?php
class Event_model extends CI_Model {
    public function get_all_events($search = null, $filter = null, $sort = null, $limit = null, $offset = null) {
        $this->db->select('*');
        $this->db->from('events');
        if ($search) {
            $this->db->group_start();
            $this->db->like('name', $search);
            $this->db->or_like('description', $search);
            $this->db->group_end();
        }
        if ($filter) {
            $today = date('Y-m-d');
            switch ($filter) {
                case 'today':
                    $this->db->where('date', $today);
                    break;
                case 'week':
                    $this->db->where('date >=', date('Y-m-d', strtotime('-1 week')));
                    $this->db->where('date <=', $today);
                    break;
                case 'month':
                    $this->db->where('date >=', date('Y-m-d', strtotime('-1 month')));
                    $this->db->where('date <=', $today);
                    break;
                case 'upcoming':
                    $this->db->where('date >', $today);
                    break;
                case 'past':
                    $this->db->where('date <', $today);
                    break;
            }
        }
        if ($sort) {
            switch ($sort) {
                case 'newest':
                    $this->db->order_by('created_at', 'DESC');
                    break;
                case 'oldest':
                    $this->db->order_by('created_at', 'ASC');
                    break;
                case 'price-low':
                    $this->db->order_by('fee', 'ASC');
                    break;
                case 'price-high':
                    $this->db->order_by('fee', 'DESC');
                    break;
            }
        } else {
            $this->db->order_by('created_at', 'DESC');
        }
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        return $this->db->get()->result_array();
    }

    public function get_events_count($search = null, $filter = null) {
        $this->db->from('events');
        if ($search) {
            $this->db->group_start();
            $this->db->like('name', $search);
            $this->db->or_like('description', $search);
            $this->db->group_end();
        }
        if ($filter) {
            $today = date('Y-m-d');
            switch ($filter) {
                case 'today':
                    $this->db->where('date', $today);
                    break;
                case 'week':
                    $this->db->where('date >=', date('Y-m-d', strtotime('-1 week')));
                    $this->db->where('date <=', $today);
                    break;
                case 'month':
                    $this->db->where('date >=', date('Y-m-d', strtotime('-1 month')));
                    $this->db->where('date <=', $today);
                    break;
                case 'upcoming':
                    $this->db->where('date >', $today);
                    break;
                case 'past':
                    $this->db->where('date <', $today);
                    break;
            }
        }
        return $this->db->count_all_results();
    }

    public function add_event($data) {
        $this->db->insert('events', $data);
        return $this->db->affected_rows() > 0;
    }

    public function get_participants($event_id) {
        // Stub method - replace with actual participant table logic
        // Example: SELECT * FROM participants WHERE event_id = $event_id
        return []; // Return empty array or fetch from a participants table
    }
}