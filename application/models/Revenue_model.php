<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Revenue_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_revenues($filters = array()) {
        $this->db->select('*');
        $this->db->from('revenues');
        
        if (!empty($filters['title'])) {
            $this->db->like('LOWER(title)', strtolower($filters['title']));
        }
        if (!empty($filters['center_name'])) {
            $this->db->where('center_name', $filters['center_name']);
        }
        if (!empty($filters['start_date'])) {
            $this->db->where('date >=', $filters['start_date']);
        }
        if (!empty($filters['end_date'])) {
            $this->db->where('date <=', $filters['end_date']);
        }
        if (!empty($filters['min_daily_revenue'])) {
            $this->db->where('daily_revenue >=', $filters['min_daily_revenue']);
        }
        if (!empty($filters['max_daily_revenue'])) {
            $this->db->where('daily_revenue <=', $filters['max_daily_revenue']);
        }
        if (!empty($filters['min_weekly_revenue'])) {
            $this->db->where('weekly_revenue >=', $filters['min_weekly_revenue']);
        }
        if (!empty($filters['max_weekly_revenue'])) {
            $this->db->where('weekly_revenue <=', $filters['max_weekly_revenue']);
        }
        if (!empty($filters['min_monthly_revenue'])) {
            $this->db->where('monthly_revenue >=', $filters['min_monthly_revenue']);
        }
        if (!empty($filters['max_monthly_revenue'])) {
            $this->db->where('monthly_revenue <=', $filters['max_monthly_revenue']);
        }
        if (!empty($filters['min_yearly_revenue'])) {
            $this->db->where('yearly_revenue >=', $filters['min_yearly_revenue']);
        }
        if (!empty($filters['max_yearly_revenue'])) {
            $this->db->where('yearly_revenue <=', $filters['max_yearly_revenue']);
        }
        
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_total_revenue() {
        $this->db->select('center_name AS title, date, SUM(daily_revenue) AS daily_revenue, SUM(weekly_revenue) AS weekly_revenue, SUM(monthly_revenue) AS monthly_revenue, SUM(yearly_revenue) AS yearly_revenue, "N/A" AS notes, status');
        $this->db->from('revenues');
        $this->db->group_by('center_name, date, status');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function add_revenue($data) {
        return $this->db->insert('revenues', $data);
    }

    public function update_revenue($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('revenues', $data);
    }

    public function get_revenue_by_id($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('revenues');
        return $query->row_array();
    }

    public function get_centers() {
        return array('ABC', 'XYZ', 'PQR', 'LMN');
    }
}