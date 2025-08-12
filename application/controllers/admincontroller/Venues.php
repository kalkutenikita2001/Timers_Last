<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Venues extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('adminmodels/Venue_model');
        $this->load->helper('url');
        $this->load->library('form_validation');
    }

    public function index() {
        $filters = array(
            'name' => $this->input->post('filterName'),
            'time_start' => $this->input->post('filterTimeStart'),
            'time_end' => $this->input->post('filterTimeEnd')
        );
        $data['venues'] = $this->Venue_model->get_all_venues($filters);
        $data['csrf_token'] = $this->security->get_csrf_hash();
        $this->load->view('admin/venues', $data); // Updated to match existing file location
    }

    public function add() {
        $data = array(
            'name' => $this->input->post('name'),
            'time_start' => $this->input->post('time_start'),
            'time_end' => $this->input->post('time_end'),
            'description' => $this->input->post('description')
        );
        $id = $this->Venue_model->add_venue($data);
        if ($id) {
            echo json_encode(array('status' => 'success', 'insert_id' => $id, 'csrf_token' => $this->security->get_csrf_hash()));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Invalid time range', 'csrf_token' => $this->security->get_csrf_hash()));
        }
    }

    public function update() {
        $id = $this->input->post('id');
        $data = array(
            'name' => $this->input->post('name'),
            'time_start' => $this->input->post('time_start'),
            'time_end' => $this->input->post('time_end'),
            'description' => $this->input->post('description')
        );
        $result = $this->Venue_model->update_venue($id, $data);
        if ($result) {
            echo json_encode(array('status' => 'success', 'message' => 'Venue updated successfully', 'csrf_token' => $this->security->get_csrf_hash()));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Invalid time range', 'csrf_token' => $this->security->get_csrf_hash()));
        }
    }

    public function delete($id) {
        $result = $this->Venue_model->delete_venue($id);
        echo json_encode(array('status' => $result ? 'success' : 'error', 'message' => $result ? 'Venue deleted successfully' : 'Error deleting venue', 'csrf_token' => $this->security->get_csrf_hash()));
    }

    public function get_by_id($id) {
        $venue = $this->Venue_model->get_venue_by_id($id);
        if ($venue) {
            $batches = !empty($venue->batches) ? explode(';', $venue->batches) : array();
            $venue->batches = array_map(function($batch) {
                list($type, $duration, $time_start, $time_end) = explode(':', $batch);
                return (object) array('type' => $type, 'duration' => $duration, 'time_start' => $time_start, 'time_end' => $time_end);
            }, $batches);
            echo json_encode(array('status' => 'success', 'data' => $venue, 'csrf_token' => $this->security->get_csrf_hash()));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Venue not found', 'csrf_token' => $this->security->get_csrf_hash()));
        }
    }

    public function get_batches_by_venue($venue_id) {
        $batches = $this->Venue_model->get_batches_by_venue($venue_id);
        echo json_encode(array('status' => 'success', 'batches' => $batches, 'csrf_token' => $this->security->get_csrf_hash()));
    }

    public function add_batch() {
        $data = array(
            'venue_id' => $this->input->post('venue_id'),
            'type' => $this->input->post('type'),
            'duration' => $this->input->post('duration'),
            'time_start' => $this->input->post('time_start'),
            'time_end' => $this->input->post('time_end')
        );
        $id = $this->Venue_model->add_batch($data);
        if ($id) {
            echo json_encode(array('status' => 'success', 'insert_id' => $id, 'csrf_token' => $this->security->get_csrf_hash()));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Invalid time range or duration', 'csrf_token' => $this->security->get_csrf_hash()));
        }
    }

    public function update_batch() {
        $id = $this->input->post('id');
        $data = array(
            'type' => $this->input->post('type'),
            'duration' => $this->input->post('duration'),
            'time_start' => $this->input->post('time_start'),
            'time_end' => $this->input->post('time_end')
        );
        $result = $this->Venue_model->update_batch($id, $data);
        if ($result) {
            echo json_encode(array('status' => 'success', 'message' => 'Batch updated successfully', 'csrf_token' => $this->security->get_csrf_hash()));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Invalid time range or duration', 'csrf_token' => $this->security->get_csrf_hash()));
        }
    }

    public function delete_batch($id) {
        $result = $this->Venue_model->delete_batch($id);
        echo json_encode(array('status' => $result ? 'success' : 'error', 'message' => $result ? 'Batch deleted successfully' : 'Error deleting batch', 'csrf_token' => $this->security->get_csrf_hash()));
    }

    public function get_batch_by_id($id) {
        $batch = $this->Venue_model->get_batch_by_id($id);
        if ($batch) {
            echo json_encode(array('status' => 'success', 'data' => $batch, 'csrf_token' => $this->security->get_csrf_hash()));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Batch not found', 'csrf_token' => $this->security->get_csrf_hash()));
        }
    }
}