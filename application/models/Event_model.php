<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Event_model extends CI_Model
{
    public function get_all_events()
    {
        return $this->db->order_by('date', 'DESC')->get('events')->result();
    }

    public function insert_event($data)
    {
        return $this->db->insert('events', $data);
    }

    public function get_event($id)
    {
        return $this->db->where('id', $id)->get('events')->row();
    }

    public function update_event($id, $data)
    {
        return $this->db->where('id', $id)->update('events', $data);
    }

    public function delete_event($id)
    {
        return $this->db->where('id', $id)->delete('events');
    }
}
