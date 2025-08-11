<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Income_expenses_model extends CI_Model {
    public function __construct() {
        parent::__construct();
    }

    public function get_income_expenses($filters = []) {
        $this->db->select('*');
        $this->db->from('income_expenses');

        if (!empty($filters['title'])) {
            $this->db->like('title', $filters['title']);
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
        if (!empty($filters['min_amount'])) {
            $this->db->where('amount >=', $filters['min_amount']);
        }
        if (!empty($filters['max_amount'])) {
            $this->db->where('amount <=', $filters['max_amount']);
        }

        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_summary($filters = []) {
        $this->db->select('center_name, 
                           SUM(CASE WHEN type = "income" AND status = "approved" THEN amount ELSE 0 END) as total_income,
                           SUM(CASE WHEN type = "expense" AND status = "approved" THEN amount ELSE 0 END) as total_expense');
        $this->db->from('income_expenses');
        $this->db->where('status', 'approved');

        if (!empty($filters['center_name'])) {
            $this->db->where('center_name', $filters['center_name']);
        }
        if (!empty($filters['start_date'])) {
            $this->db->where('date >=', $filters['start_date']);
        }
        if (!empty($filters['end_date'])) {
            $this->db->where('date <=', $filters['end_date']);
        }
        if (!empty($filters['min_amount'])) {
            $this->db->where('amount >=', $filters['min_amount']);
        }
        if (!empty($filters['max_amount'])) {
            $this->db->where('amount <=', $filters['max_amount']);
        }

        $this->db->group_by('center_name');
        $query = $this->db->get();
        $result = $query->result_array();

        // Calculate balance
        foreach ($result as &$row) {
            $row['balance'] = $row['total_income'] - $row['total_expense'];
        }
        return $result;
    }

    public function get_income_expense($id) {
        $query = $this->db->get_where('income_expenses', ['id' => $id]);
        return $query->row_array();
    }

    public function add_income_expense($data) {
        return $this->db->insert('income_expenses', $data);
    }

    public function update_income_expense($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('income_expenses', $data);
    }

    public function approve_income_expense($id) {
        $this->db->where('id', $id);
        return $this->db->update('income_expenses', ['status' => 'approved']);
    }

    public function reject_income_expense($id) {
        $this->db->where('id', $id);
        return $this->db->update('income_expenses', ['status' => 'rejected']);
    }
}