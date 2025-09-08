<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Participant_model extends CI_Model
{


    public function get_by_event($event_id)
    {
        return $this->db
            ->where('event_id', $event_id)
            ->get('participants')
            ->result();
    }
    public function get_event_name($event_id)
    {
        $this->db->select('event_name');
        $this->db->from('participants');
        $this->db->where('event_id', $event_id);
        $this->db->where('event_name IS NOT NULL'); // avoid nulls
        $this->db->limit(1);
        $query = $this->db->get();
        $row = $query->row();

        return $row ? $row->event_name : null;
    }
}
