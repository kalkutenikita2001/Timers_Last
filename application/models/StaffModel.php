<?php
defined('BASEPATH') or exit('No direct script access allowed');

class StaffModel extends CI_Model
{
    // public function insertStaff($data)
    // {
    //     return $this->db->insert('staff', $data);
    // }

    // public function getAllVenues()
    // {
    //     return $this->db->get('venues')->result_array();
    // }

    // public function getAllSlots()
    // {
    //     return $this->db->get('venue_slots')->result_array();
    // }


    public function insertStaff($data)
    {
        return $this->db->insert('staff', $data);
    }

    public function getAllVenues()
    {
        return $this->db->get('venues')->result_array();
    }

    // public function getAllSlots()
    // {
    //     return $this->db->get('venue_slots')->result_array();
    // }
    public function getAllSlots()
    {
        $this->db->select('venue_slots.*, venues.venue_name');
        $this->db->from('venue_slots');
        $this->db->join('venues', 'venue_slots.venue_id = venues.id', 'left');
        return $this->db->get()->result_array();
    }

    // Add this method to get all staff
    public function getAllStaff()
    {
        return $this->db->get('staff')->result_array();
    }
    public function deleteStaff($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('staff');
    }
    public function get_all_staff()
  {
    $query = $this->db->get('staff'); // SELECT * FROM staff
    return $query->result_array();
  } 
}
