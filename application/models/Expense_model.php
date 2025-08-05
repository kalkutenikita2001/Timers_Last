<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Expense_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function add_expense($data) {
        // Validate inputs
        if (!$this->validate_expense($data)) {
            return ['status' => 'error', 'message' => 'Invalid input data.'];
        }

        $insert_data = [
            'title' => $data['title'],
            'date' => $data['date'],
            'amount' => $data['amount'],
            'description' => $data['description'],
            'type' => $data['type'],
            'status' => 'pending',
            'created_at' => date('Y-m-d H:i:s')
        ];

        if ($this->db->insert('expenses', $insert_data)) {
            return ['status' => 'success', 'message' => 'Expense added successfully.'];
        }
        return ['status' => 'error', 'message' => 'Failed to add expense.'];
    }

    public function update_expense($id, $data) {
        // Validate inputs
        if (!$this->validate_expense($data)) {
            return ['status' => 'error', 'message' => 'Invalid input data.'];
        }

        $update_data = [
            'title' => $data['title'],
            'date' => $data['date'],
            'amount' => $data['amount'],
            'description' => $data['description'],
            'type' => $data['type'],
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->db->where('id', $id);
        if ($this->db->update('expenses', $update_data)) {
            return ['status' => 'success', 'message' => 'Expense updated successfully.'];
        }
        return ['status' => 'error', 'message' => 'Failed to update expense.'];
    }

    public function get_expense($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('expenses');
        if ($query->num_rows() > 0) {
            return ['status' => 'success', 'data' => $query->row_array()];
        }
        return ['status' => 'error', 'message' => 'Expense not found.'];
    }

    public function get_centerwise_expenses($filters = []) {
        $this->db->where('type', 'centerwise');
        if (!empty($filters['title'])) {
            $this->db->like('title', $filters['title']);
        }
        if (!empty($filters['description'])) {
            $this->db->like('description', $filters['description']);
        }
        $query = $this->db->get('expenses');
        return $query->result_array();
    }

    public function get_own_expenses($filters = []) {
        $this->db->where('type', 'own');
        if (!empty($filters['title'])) {
            $this->db->like('title', $filters['title']);
        }
        if (!empty($filters['description'])) {
            $this->db->like('description', $filters['description']);
        }
        $query = $this->db->get('expenses');
        return $query->result_array();
    }

    public function approve_expense($id) {
        $this->db->where('id', $id);
        $this->db->where('status', 'pending');
        if ($this->db->update('expenses', ['status' => 'approved', 'updated_at' => date('Y-m-d H:i:s')])) {
            return ['status' => 'success', 'message' => 'Expense approved successfully.'];
        }
        return ['status' => 'error', 'message' => 'Expense already processed or not found.'];
    }

    public function reject_expense($id) {
        $this->db->where('id', $id);
        $this->db->where('status', 'pending');
        if ($this->db->update('expenses', ['status' => 'rejected', 'updated_at' => date('Y-m-d H:i:s')])) {
            return ['status' => 'success', 'message' => 'Expense rejected successfully.'];
        }
        return ['status' => 'error', 'message' => 'Expense already processed or not found.'];
    }

    private function validate_expense($data) {
        if (empty($data['title']) || !preg_match('/^[A-Za-z\s]+$/', $data['title']) || strlen($data['title']) > 50) {
            return false;
        }
        $today = date('Y-m-d');
        if (empty($data['date']) || $data['date'] > $today) {
            return false;
        }
        if (empty($data['amount']) || !is_numeric($data['amount']) || $data['amount'] <= 0) {
            return false;
        }
        if ($data['type'] === 'centerwise') {
            if (empty($data['description']) || strlen($data['description']) > 200) {
                return false;
            }
        } else {
            if (empty($data['description']) || !preg_match('/^[A-Za-z\s]+$/', $data['description']) || strlen($data['description']) > 50) {
                return false;
            }
        }
        if (!in_array($data['type'], ['centerwise', 'own'])) {
            return false;
        }
        return true;
    }
}
?>