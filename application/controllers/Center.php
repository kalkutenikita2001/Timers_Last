<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Center extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Center_model');
    }

    public function index() {
        $this->load->view('center_management');
    }

    public function save() {
        $this->output->set_content_type('application/json');
        log_message('debug', 'Save method called with data: ' . json_encode($this->input->raw_input_stream));
        $data = json_decode($this->input->raw_input_stream, true);

        if (!$data) {
            $this->output->set_status_header(400);
            echo json_encode(['message' => 'Invalid input data']);
            return;
        }

        $result = $this->Center_model->save_center($data);
        if ($result) {
            log_message('debug', 'Center saved successfully');
            echo json_encode(['message' => 'Center added successfully']);
        } else {
            $this->output->set_status_header(500);
            log_message('error', 'Failed to save center');
            echo json_encode(['message' => 'Failed to add center']);
        }
    }

    public function get_all() {
        $this->output->set_content_type('application/json');
        log_message('debug', 'get_all method called');
        $centers = $this->Center_model->get_all_centers();
        echo json_encode($centers);
    }

    public function get($id) {
        $this->output->set_content_type('application/json');
        log_message('debug', 'get method called for ID: ' . $id);
        $center = $this->Center_model->get_center($id);
        if ($center) {
            echo json_encode($center);
        } else {
            $this->output->set_status_header(404);
            echo json_encode(['message' => 'Center not found']);
        }
    }

    public function filter() {
        $this->output->set_content_type('application/json');
        log_message('debug', 'filter method called with name: ' . $this->input->post('filterCenterName'));
        $name = $this->input->post('filterCenterName');
        $centers = $this->Center_model->filter_centers($name);
        echo json_encode($centers);
    }


    public function update_facility() {
        $this->output->set_content_type('application/json');
        $data = json_decode($this->input->raw_input_stream, true);
        if (!$data) {
            $this->output->set_status_header(400);
            echo json_encode(['message' => 'Invalid input data']);
            return;
        }
        $result = $this->Center_model->update_facility($data);
        if ($result) {
            echo json_encode(['message' => 'Facility updated successfully']);
        } else {
            $this->output->set_status_header(500);
            echo json_encode(['message' => 'Failed to update facility']);
        }
    }

    public function update_staff() {
        $this->output->set_content_type('application/json');
        $data = json_decode($this->input->raw_input_stream, true);
        if (!$data) {
            $this->output->set_status_header(400);
            echo json_encode(['message' => 'Invalid input data']);
            return;
        }
        $result = $this->Center_model->update_staff($data);
        if ($result) {
            echo json_encode(['message' => 'Staff updated successfully']);
        } else {
            $this->output->set_status_header(500);
            echo json_encode(['message' => 'Failed to update staff']);
        }
    }
}
?>