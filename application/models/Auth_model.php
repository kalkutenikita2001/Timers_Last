<?php
class Auth_model extends CI_Model
{
    // Get superadmin user
    public function get_superadmin($username)
    {
        return $this->db->where('username', $username)->get('users')->row();
    }

    // Get admin from center_details table
    // public function get_admin($center_number)
    // {
    //     return $this->db->where('center_number', $center_number)->get('center_details')->row();
    // }



    // Get admin by center name
    public function get_admin_by_name($name)
    {
        return $this->db->where('name', $name)->get('center_details')->row();
    }
}
