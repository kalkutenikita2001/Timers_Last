<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Event_notice extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Event_notice_model');
    }

    public function index() {
        $this->load->view('superadmin/Event & Notice');
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
            'description' => $this->input->post('description', TRUE)
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
            'description' => $this->input->post('description', TRUE)
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
}
?>