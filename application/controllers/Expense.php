<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Expenses extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Expense_model');
        $this->load->model('Center_model'); // optional for dropdown
    }

    // Show Expenses Page
    public function index()
    {
        $data['expenses'] = $this->Expense_model->get_all_expenses();
        $data['centers']  = $this->db->get('center_details')->result();
        $this->load->view('superadmin/Expenses', $data);
    }

    // Save new expense
    public function add()
    {
        $expenseData = [
            'center_id' => $this->input->post('center_id'),
            'title'     => $this->input->post('title'),
            'date'      => $this->input->post('date'),
            'amount'    => $this->input->post('amount'),
            'category'  => $this->input->post('category'),
            'type'      => 'manual',
            'status'    => 'pending',
            'created_at' => date('Y-m-d H:i:s')
        ];
        $this->Expense_model->insert_expense($expenseData);
        $this->session->set_flashdata('success', 'Expense added successfully!');
        redirect('superadmin/Expenses');
    }

    // Apply filter
    public function filter()
    {
        $filters = [
            'from_date'  => $this->input->post('from_date'),
            'to_date'    => $this->input->post('to_date'),
            'min_amount' => $this->input->post('min_amount'),
            'max_amount' => $this->input->post('max_amount'),
            'category'   => $this->input->post('category')
        ];
        $data['expenses'] = $this->Expense_model->filter_expenses($filters);
        $data['centers']  = $this->db->get('center_details')->result();
        $this->load->view('superadmin/Expenses', $data);
    }

    // Approve Expense
    public function approve($id)
    {
        $this->Expense_model->update_status($id, 'approved');
        $this->session->set_flashdata('success', 'Expense approved!');
        redirect('superadmin/Expenses');
    }

    // Reject Expense
    public function reject($id)
    {
        $this->Expense_model->update_status($id, 'rejected');
        $this->session->set_flashdata('error', 'Expense rejected!');
        redirect('superadmin/Expenses');
    }
}
