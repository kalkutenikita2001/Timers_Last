<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Event_notice extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Event_notice_model');
        // Optional: Add role-based access control if needed
        // Example: Check if user is admin or superadmin
        // if (!$this->session->userdata('role') || !in_array($this->session->userdata('role'), ['admin', 'superadmin'])) {
        //     redirect('auth/login');
        // }
    }

    public function index() {
        // Load appropriate view based on user role
        $role = $this->session->userdata('role');
        if ($role === 'superadmin') {
            $this->load->view('superadmin/EventAndNotice');
        } elseif ($role === 'admin') {
            $this->load->view('admin/EventAndNotice');
        } else {
            redirect('auth/login');
        }
    }

    public function get_events() {
        $filters = $this->input->post();
        unset($filters[$this->security->get_csrf_token_name()]); // Remove CSRF token from filters
        $events = $this->Event_notice_model->get_events($filters);
        echo json_encode(['status' => 'success', 'data' => $events]);
    }

    public function add_event() {
        $data = [
            'title' => $this->input->post('title', TRUE),
            'center_name' => $this->input->post('center_name', TRUE),
            'date' => $this->input->post('date', TRUE),
            'time' => $this->input->post('time', TRUE),
            'description' => $this->input->post('description', TRUE),
            'created_at' => date('Y-m-d H:i:s')
        ];

        if ($this->Event_notice_model->add_event($data)) {
            echo json_encode(['status' => 'success', 'message' => 'Event/Notice added successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to add event/notice']);
        }
    }

    public function update_event() {
        $id = $this->input->post('id', TRUE);
        $data = [
            'title' => $this->input->post('title', TRUE),
            'center_name' => $this->input->post('center_name', TRUE),
            'date' => $this->input->post('date', TRUE),
            'time' => $this->input->post('time', TRUE),
            'description' => $this->input->post('description', TRUE),
            'created_at' => date('Y-m-d H:i:s')
        ];

        if ($this->Event_notice_model->update_event($id, $data)) {
            echo json_encode(['status' => 'success', 'message' => 'Event/Notice updated successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update event/notice']);
        }
    }

    public function delete_event() {
        $id = $this->input->post('id', TRUE);
        if ($this->Event_notice_model->delete_event($id)) {
            echo json_encode(['status' => 'success', 'message' => 'Event/Notice deleted successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete event/notice']);
        }
    }

    public function add_participation() {
        $data = [
            'student_name' => $this->input->post('student_name', TRUE),
            'event_title' => $this->input->post('event_title', TRUE),
            'payment_mode' => $this->input->post('payment_mode', TRUE),
            'created_at' => date('Y-m-d H:i:s')
        ];

        if ($this->Event_notice_model->add_participation($data)) {
            echo json_encode(['status' => 'success', 'message' => 'Participation added successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to add participation']);
        }
    }
}
?>