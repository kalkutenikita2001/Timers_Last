<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Office_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_offices($limit = null, $offset = null)
    {
        if ($limit !== null && $offset !== null) {
            $this->db->limit($limit, $offset);
        }
        return $this->db->get('offices')->result_array();
    }

    public function get_office_by_id($id)
    {
        return $this->db->get_where('offices', ['id' => $id])->row_array();
    }

    public function add_office($data)
    {
        $this->db->insert('offices', $data);
        return $this->db->insert_id();
    }

    public function update_office($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('offices', $data);
    }

    public function delete_office($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('offices');
    }

    public function get_total_offices()
    {
        return $this->db->count_all('offices');
    }

    public function search_offices($search_term)
    {
        $this->db->like('office_name', $search_term);
        $this->db->or_like('location', $search_term);
        $this->db->or_like('contact_number', $search_term);
        return $this->db->get('offices')->result_array();
    }

    public function get_office_staff($office_id)
    {
        $this->db->select('staff.*');
        $this->db->from('staff');
        $this->db->where('office_id', $office_id);
        return $this->db->get()->result_array();
    }

    public function get_office_facilities($office_id)
    {
        $this->db->select('facilities.*');
        $this->db->from('facilities');
        $this->db->where('office_id', $office_id);
        return $this->db->get()->result_array();
    }

    public function add_facility($data)
    {
        return $this->db->insert('facilities', $data);
    }

    public function remove_facility($facility_id)
    {
        $this->db->where('id', $facility_id);
        return $this->db->delete('facilities');
    }
}