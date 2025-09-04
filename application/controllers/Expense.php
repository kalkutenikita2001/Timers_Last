<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Expense extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Expense_model');
        $this->load->model('Center_model'); // optional for dropdown
    }

    // Show Expenses Page
    // public function index()
    // {
    //     $data['expenses'] = $this->Expense_model->get_all_expenses();
    //     $data['centers']  = $this->db->get('center_details')->result();
    //     $this->load->view('superadmin/Expenses', $data);
    // }
    public function index()
    {
        $data['expenses'] = $this->Expense_model->get_all_expenses();
        // return centers as arrays because your view uses $c['id'], $c['name']
        $data['centers']  = $this->db->get('center_details')->result_array();
        $this->load->view('superadmin/Expenses', $data);
    }

    // Save new expense
    // public function add()
    // {
    //     $dt = $this->input->post();
    //     $expenseData = [
    //         'center_id' => $this->input->post('center_id'),
    //         'title'     => $this->input->post('title'),
    //         'date'      => $this->input->post('date'),
    //         'amount'    => $this->input->post('amount'),
    //         'category'  => $this->input->post('category'),
    //         'description' => $this->input->post('description'),
    //         'type'      => 'manual',
    //         'status'    => 'pending',
    //         'added_by'    => $this->input->post('added_by'),
    //         'created_at' => date('Y-m-d H:i:s')

    //     ];

    //     $this->Expense_model->insert_expense($expenseData);
    //     $this->session->set_flashdata('success', 'Expense added successfully!');
    //     redirect('superadmin/Expenses');
    // }
    public function add()
    {
        $addedBy = $this->input->post('added_by');
        $status  = ($addedBy === 'superadmin') ? 'approved' : 'pending';

        $expenseData = [
            'center_id'   => $this->input->post('center_id'),
            'title'       => $this->input->post('title'),
            'date'        => $this->input->post('date'),
            'amount'      => $this->input->post('amount'),
            'category'    => $this->input->post('category'),
            'description' => $this->input->post('description'),
            'type'        => 'manual',
            'status'      => $status,           // <-- auto-approve for superadmin
            'added_by'    => $addedBy,
            'created_at'  => date('Y-m-d H:i:s')
        ];

        $this->Expense_model->insert_expense($expenseData);
        $this->session->set_flashdata('success', 'Expense added successfully!');
        redirect('superadmin/Expenses');
    }


    // Apply filter
    public function filter()
    {
        $this->load->model('Expense_model');
        $this->load->model('Center_model'); // if you want centers

        $filters = [
            'from_date'  => $this->input->post('from_date'),
            'to_date'    => $this->input->post('to_date'),
            'min_amount' => $this->input->post('min_amount'),
            'max_amount' => $this->input->post('max_amount'),
            'category'   => $this->input->post('category')
        ];

        $data['expenses'] = $this->Expense_model->filter_expenses($filters);
        $data['centers']  = $this->Center_model->get_all_centers();
        $this->load->view('superadmin/Expenses', $data);
    }

    public function approve($id)
    {
        $this->Expense_model->update_status($id, 'approved'); // ✅ Update in DB
        $this->session->set_flashdata('success', 'Expense approved!');
        redirect('superadmin/Expenses'); // ✅ Refresh page
    }

    public function reject($id)
    {
        $this->Expense_model->update_status($id, 'rejected'); // ✅ Update in DB
        $this->session->set_flashdata('error', 'Expense rejected!');
        redirect('superadmin/Expenses'); // ✅ Refresh page
    }
}
