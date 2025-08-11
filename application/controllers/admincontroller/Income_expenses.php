<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Income_expenses extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('adminmodels/Income_expenses_model');
        $this->load->helper('url');
    }

    public function index() {
        $this->load->view('admin/Include/Sidebar');
        $this->load->view('admin/Include/Navbar');
        $this->load->view('admin/income_expenses');
    }

    public function get_income_expenses() {
        $filters = [
            'title' => $this->input->post('title'),
            'center_name' => $this->input->post('center_name'),
            'start_date' => $this->input->post('start_date'),
            'end_date' => $this->input->post('end_date'),
            'min_amount' => $this->input->post('min_amount'),
            'max_amount' => $this->input->post('max_amount')
        ];
        $data = $this->Income_expenses_model->get_income_expenses($filters);
        echo json_encode($data);
    }

    public function get_summary() {
        $filters = [
            'center_name' => $this->input->post('center_name'),
            'start_date' => $this->input->post('start_date'),
            'end_date' => $this->input->post('end_date'),
            'min_amount' => $this->input->post('min_amount'),
            'max_amount' => $this->input->post('max_amount')
        ];
        $data = $this->Income_expenses_model->get_summary($filters);
        echo json_encode($data);
    }

    public function get_income_expense($id) {
        $data = $this->Income_expenses_model->get_income_expense($id);
        if ($data) {
            echo json_encode(['status' => 'success', 'data' => $data]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Record not found']);
        }
    }

    public function add_income_expense() {
        $data = [
            'title' => $this->input->post('title'),
            'center_name' => $this->input->post('center_name'),
            'type' => $this->input->post('type'),
            'date' => $this->input->post('date'),
            'amount' => $this->input->post('amount'),
            'description' => $this->input->post('description') ?: 'N/A'
        ];

        if ($this->Income_expenses_model->add_income_expense($data)) {
            echo json_encode(['status' => 'success', 'message' => 'Income/Expense added successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to add income/expense']);
        }
    }

    public function update_income_expense() {
        $id = $this->input->post('id');
        $data = [
            'title' => $this->input->post('title'),
            'center_name' => $this->input->post('center_name'),
            'type' => $this->input->post('type'),
            'date' => $this->input->post('date'),
            'amount' => $this->input->post('amount'),
            'description' => $this->input->post('description') ?: 'N/A'
        ];

        if ($this->Income_expenses_model->update_income_expense($id, $data)) {
            echo json_encode(['status' => 'success', 'message' => 'Income/Expense updated successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update income/expense']);
        }
    }

    public function approve_income_expense($id) {
        if ($this->Income_expenses_model->approve_income_expense($id)) {
            echo json_encode(['status' => 'success', 'message' => 'Income/Expense approved successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to approve income/expense']);
        }
    }

    public function reject_income_expense($id) {
        if ($this->Income_expenses_model->reject_income_expense($id)) {
            echo json_encode(['status' => 'success', 'message' => 'Income/Expense rejected successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to reject income/expense']);
        }
    }
}