<?php
defined('BASEPATH') or exit('No direct script access allowed');

class EventAndNotice extends CI_Controller
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
        $this->load->view('superadmin/Events/index', $data);
    }

    // Add event (AJAX call)
    public function add_event()
    {
        $data = array(
            'name'            => $this->input->post('name'),
            'description'     => $this->input->post('description'),
            'date'            => $this->input->post('date'),
            'time'            => $this->input->post('time'),
            'fee'             => $this->input->post('fee'),
            'max_participants' => $this->input->post('max_participants')
        );

        if ($this->Event_model->insert_event($data)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }

    // Delete event
    public function delete($id)
    {
        $this->Event_model->delete_event($id);
        redirect('superadmin/EventAndNotice');
    }
}
