<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Leave extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Leave_model');
        $this->load->library('session');
        $this->load->helper('url');

        // Make sure user is logged in
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    // Leave list
    public function index()
    {
        $user_role = $this->session->userdata('role');
        $center_name = $this->session->userdata('username'); // center name stored in session

        // Fetch leaves
        $data['leaves'] = $this->Leave_model->get_leaves($user_role, $center_name);
        $this->load->model('Student_model');
        $this->load->model('Staff_model');

        $data['students'] = $this->Student_model->get_all_students();
        $data['staff'] = $this->Staff_model->get_all_staff();

        // Load views
        if ($user_role == 'admin') {
            $this->load->view('admin/Leave', $data);
        } elseif ($user_role == 'superadmin') {
            $this->load->view('superadmin/Leave', $data);
        } else {
            show_error('Unauthorized access', 403);
        }
    }

    // Add leave (same for both roles if needed)
    public function add_leave()
    {
        $data = [
            'user_id' => $this->input->post('user_id'),
            'user_name' => $this->session->userdata('username'), // admin/superadmin session
            'applicant_name' => $this->input->post('name'), // new column
            'role' => $this->input->post('designation'),
            'leave_type' => $this->input->post('leave_type') == 'Other' ? $this->input->post('leave_type_other') : $this->input->post('leave_type'),
            'from_date' => $this->input->post('from_date'),
            'to_date' => $this->input->post('to_date'),
            'reason' => $this->input->post('reason'),
            'center_name' => $this->input->post('center_name'),
            'status' => 'pending'
        ];


        if ($this->Leave_model->add_leave($data)) {
            $this->session->set_flashdata('message', 'success');
            $this->session->set_flashdata('msg_text', 'Leave applied successfully!');
        } else {
            $this->session->set_flashdata('message', 'error');
            $this->session->set_flashdata('msg_text', 'Something went wrong. Please try again.');
        }

        redirect('Leave');
    }

    // Approve/reject leave
    public function change_status($leave_id, $action)
    {
        $user_role = $this->session->userdata('role');
        $leave = $this->Leave_model->get_leave($leave_id);

        // Role-based permission
        // if (($user_role == 'admin' && $leave->role != 'Student') || ($user_role == 'superadmin' && $leave->role != 'Staff')) {
        //     show_error('You do not have permission to change this leave status.', 403);
        //     return;
        // }

        if ($user_role == 'admin' && $leave->role != 'Student') {
            show_error('You do not have permission', 403);
        }

        if (!in_array($action, ['approved', 'rejected'])) {
            show_error('Invalid action.', 400);
            return;
        }

        $this->Leave_model->update_status($leave_id, $action);
        redirect('Leave');
    }
}
