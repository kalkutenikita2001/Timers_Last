<?php
defined('BASEPATH') or exit('No direct script access allowed');

class EventController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Event_model');
    }

    // Show all events
    public function index()
    {
        $data['events'] = $this->Event_model->get_all_events();
        $this->load->view('superadmin/EventAndNotice', $data);
    }

    // Save new event (AJAX)
    public function saveEvent()
    {
        $data = array(
            'name'             => $this->input->post('name'),
            'description'      => $this->input->post('description'),
            'date'             => $this->input->post('date'),
            'time'             => $this->input->post('time'),
            'fee'              => $this->input->post('fee'),
            'max_participants' => $this->input->post('maxParticipants')
        );

        if ($this->Event_model->insert_event($data)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }
    public function deleteEvent($id)
    {
        if ($this->Event_model->delete_event($id)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }
}
