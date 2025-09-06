<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ParticipantController extends CI_Controller
{
    public function form()
    {
        $event_id = $this->input->get('event');

        // Fetch all events for dropdown
        $data['events'] = $this->db->get('events')->result();

        // Highlight selected event
        $data['event_id'] = $event_id;

        $this->load->view('superadmin/participant_form', $data);
    }

    public function save()
    {
        $this->load->helper('security');

        $event_id = $this->input->post('event', TRUE);

        // Fetch event name from DB
        $event = $this->db->get_where('events', ['id' => $event_id])->row();

        $data = [
            'event_id'   => $event_id,
            'event_name' => $event ? $event->name : '',
            'name'       => $this->input->post('name', TRUE),
            'email'      => $this->input->post('email', TRUE),
            'phone'      => $this->input->post('phone', TRUE),
            'address'    => $this->input->post('address', TRUE),
        ];

        if ($this->db->insert('participants', $data)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }
}
