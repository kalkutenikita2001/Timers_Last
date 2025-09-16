<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function Dashboard()
    {
        $this->load->view('admin/Dashboard');
    }
    public function EventAndNotice()
    {
        $this->load->model('Event_model');
        $data['events'] = $this->Event_model->get_all_events();
        $this->load->view('admin/EventAndNotice', $data);
    }

    // Save new event (AJAX)
    public function saveEvent()
    {
        $this->load->model('Event_model');
        $data = array(
            'name' => $this->input->post('name'),
            'description' => $this->input->post('description'),
            'date' => $this->input->post('date'),
            'time' => $this->input->post('time'),
            'fee' => $this->input->post('fee'),
            'max_participants' => $this->input->post('maxParticipants'),
            'venue' => $this->input->post('venue')
        );
        $this->Event_model->insert_event($data);
        echo json_encode(['status' => 'success']);
    }
    public function view_participants($event_id)
    {
        $this->load->model('Participant_model');

        $data['event_id'] = $event_id;
        $data['participants'] = $this->Participant_model->get_by_event($event_id);
        $data['event_name'] = $this->Participant_model->get_event_name($event_id);

        $this->load->view('admin/participants', $data);
    }
    public function Expenses()
    {
        $this->load->model('Expense_model');
        $this->load->model('Center_model'); // ✅ Make sure this is loaded

        $data['expenses'] = $this->Expense_model->get_all_expenses();
        $data['centers']  = $this->Center_model->get_all_centers(); // ✅ Pass centers to view

        $this->load->view('admin/Expenses', $data);
    }
}
