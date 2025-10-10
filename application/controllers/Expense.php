<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Expense extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Expense_model');
        $this->load->model('Center_model'); // optional for dropdown
        $this->load->model('Notifications_model'); // For notifications
        $this->load->library('session');
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

    //Save new expense old
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
        // Get POST data
        $center_id   = $this->input->post('center_id');
        $title       = $this->input->post('title');
        $date        = $this->input->post('date');
        $amount      = $this->input->post('amount');
        $category    = $this->input->post('category');
        $description = $this->input->post('description');
        $added_by    = $this->input->post('added_by');

        // Optional: validate required fields
        if (!$center_id || !$title || !$date || !$amount || !$category || !$description) {
            $this->session->set_flashdata('error', 'Please fill all required fields.');
            redirect('superadmin/Expenses');
        }

        // Determine status: auto-approve if superadmin
        $status = 'pending';
        if ($this->session->userdata('role') === 'superadmin') {
            $status = 'approved';
        }

        // Prepare data array
        $expenseData = [
            'center_id'   => $center_id,
            'title'       => $title,
            'date'        => $date,
            'amount'      => $amount,
            'category'    => $category,
            'description' => $description,
            'type'        => 'manual',
            'status'      => $status,
            'added_by'    => $added_by,
            'created_at'  => date('Y-m-d H:i:s')
        ];

        // Insert into database
        if ($this->Expense_model->insert_expense($expenseData)) {
            $this->session->set_flashdata('success', 'Expense added successfully!');

            // Debug: Log added_by and notification creation
            log_message('error', 'Expense added by user_id: ' . print_r($added_by, true));
            $notif_id = $this->Notifications_model->create_notification([
                'user_id' => null, // null for superadmin, or set to superadmin's user_id
                'type'    => 'expense_request',
                'title'   => 'New Expense Added',
                'message' => 'A new expense has been added and needs approval.',
                'item_id' => null
            ]);
            // print_r($notif_id);die;
            log_message('error', 'Notification created for superadmin, notif_id: ' . print_r($notif_id, true));
        } else {
            $this->session->set_flashdata('error', 'Failed to add expense. Please try again.');
        }

        redirect('superadmin/Expenses');
    }





    //    public function add()
    // {
    //     // Get raw input data (JSON)
    //     $input = json_decode(file_get_contents('php://input'), true);

    //     $addedBy = $input['added_by'] ?: $this->session->userdata('user_role'); // Fallback to session
    //     $status = ($addedBy === 'superadmin') ? 'approved' : 'pending';

    //     $expenseData = [
    //         'center_id'   => $input['center_id'] ?: $this->session->userdata('center_id'), // Fallback
    //         'title'       => '', // Add logic or remove if not needed
    //         'date'        => $input['date'],
    //         'amount'      => $input['amount'],
    //         'category'    => $input['category'],
    //         'description' => $input['description'],
    //         'type'        => 'manual',
    //         'status'      => $status,
    //         'added_by'    => $addedBy,
    //         'created_at'  => date('Y-m-d H:i:s')
    //     ];

    //     $response = ['status' => 'error', 'message' => 'Failed to add expense'];
    //     if ($this->Expense_model->insert_expense($expenseData)) {
    //         $response = ['status' => 'success', 'message' => 'Expense added successfully'];
    //     }

    //     // Return JSON response
    //     header('Content-Type: application/json');
    //     echo json_encode($response);
    //     exit;
    // }
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
        // Approve expense
        $this->Expense_model->update_status($id, 'approved');

        // Get expense info to notify admin
        $expense = $this->db->get_where('expenses', ['id' => $id])->row_array();
        if ($expense && !empty($expense['added_by'])) {
            log_message('error', 'Approving expense, notify user_id: ' . print_r($expense['added_by'], true));
            $notif_id = $this->Notifications_model->create_notification([
                'user_id' => $expense['added_by'],
                'type'    => 'expense_status',
                'title'   => 'Expense Approved',
                'message' => 'Your expense \"' . $expense['title'] . '\" has been approved.',
                'item_id' => $id
            ]);
            log_message('error', 'Notification created for admin, notif_id: ' . print_r($notif_id, true));
        }

        $this->session->set_flashdata('success', 'Expense approved!');
        redirect('superadmin/Expenses');
    }

    public function reject($id)
    {
        $this->Expense_model->update_status($id, 'rejected');

        // Get expense info to notify admin
        $expense = $this->db->get_where('expenses', ['id' => $id])->row_array();
        if ($expense && !empty($expense['added_by'])) {
            log_message('error', 'Rejecting expense, notify user_id: ' . print_r($expense['added_by'], true));
            $notif_id = $this->Notifications_model->create_notification([
                'user_id' => $expense['added_by'],
                'type'    => 'expense_status',
                'title'   => 'Expense Rejected',
                'message' => 'Your expense \"' . $expense['title'] . '\" has been rejected.',
                'item_id' => $id
            ]);
            log_message('error', 'Notification created for admin, notif_id: ' . print_r($notif_id, true));
        }

        $this->session->set_flashdata('error', 'Expense rejected!');
        redirect('superadmin/Expenses');
    }
}
