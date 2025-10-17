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

    public function getAllSlots()
    {
        return $this->db->get('venue_slots')->result_array();
    }

    // Add this method to get all staff
    public function getAllStaff()
    {
        return $this->db->get('staff')->result_array();
    }
}
