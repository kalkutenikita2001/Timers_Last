<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Event extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Event_model');
        $this->load->helper('url');
        $this->load->library('form_validation');
    }

    public function index() {
        $this->load->view('superadmin/EventList');
    }

    public function get_events() {
        $this->output->set_content_type('application/json');
        $search = $this->input->get('search');
        $filter = $this->input->get('filter');
        $sort = $this->input->get('sort');
        $page = $this->input->get('page', TRUE) ? max(1, (int)$this->input->get('page')) : 1;
        $limit = 6; // 2 cards per row, 3 rows per page to match the sample UI (6 cards total)

        $offset = ($page - 1) * $limit;
        $data = $this->Event_model->get_all_events($search, $filter, $sort, $limit, $offset);
        $total = $this->Event_model->get_events_count($search, $filter);
        $total_pages = ceil($total / $limit);

        echo json_encode([
            'events' => $data,
            'total' => $total,
            'page' => $page,
            'limit' => $limit,
            'total_pages' => $total_pages
        ]);
    }

    public function add_event() {
        $this->output->set_content_type('application/json');
        $this->form_validation->set_rules('name', 'Event Name', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');
        $this->form_validation->set_rules('date', 'Date', 'required|callback_valid_date');
        $this->form_validation->set_rules('time', 'Time', 'required');
        $this->form_validation->set_rules('fee', 'Fee', 'required|numeric|greater_than_equal_to[0]');
        $this->form_validation->set_rules('max_participants', 'Max Participants', 'required|numeric|greater_than[0]');

        if ($this->form_validation->run() === FALSE) {
            echo json_encode(['success' => false, 'message' => validation_errors()]);
            return;
        }

        $data = [
            'name' => $this->input->post('name'),
            'description' => $this->input->post('description'),
            'date' => $this->input->post('date'),
            'time' => $this->input->post('time'),
            'fee' => $this->input->post('fee'),
            'max_participants' => $this->input->post('max_participants')
        ];

        $result = $this->Event_model->add_event($data);
        echo json_encode(['success' => $result, 'message' => $result ? 'Event added successfully' : 'Failed to add event']);
    }

    public function valid_date($date) {
        $d = DateTime::createFromFormat('Y-m-d', $date);
        return $d && $d->format('Y-m-d') === $date;
    }

    public function send_form($event_id) {
        $this->output->set_content_type('application/json');
        // Simulate form sending (e.g., log or email)
        log_message('info', "Form sent for event ID: $event_id");
        echo json_encode(['success' => true, 'message' => 'Form sent successfully for event ID: ' . $event_id]);
    }

    public function view_participants($event_id) {
        $this->output->set_content_type('application/json');
        // Simulate participant fetching (extend with actual logic)
        $participants = $this->Event_model->get_participants($event_id); // Assuming a method in model
        echo json_encode(['success' => true, 'participants' => $participants ?: []]);
    }
}