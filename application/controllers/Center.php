<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Center extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Center_model');
        $this->load->helper('url');
    }

    // Load the centers view
    public function index() {
        $this->load->view('superadmin/centers');
    }

    // API to get all centers with optional filters
    public function get_centers() {
        $filters = [
            'center_name' => $this->input->get('center_name'),
            'admin' => $this->input->get('admin'),
            'coordinator' => $this->input->get('coordinator'),
            'coach' => $this->input->get('coach'),
            'address' => $this->input->get('address')
        ];

        $centers = $this->Center_model->get_centers($filters);
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['status' => 'success', 'data' => $centers]));
    }

    // API to get a single center by ID
    public function get_center($id) {
        $center = $this->Center_model->get_center_by_id($id);
        if ($center) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => 'success', 'data' => $center]));
        } else {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => 'error', 'message' => 'Center not found']));
        }
    }

    // API to add a new center
    public function add_center() {
        $data = [
            'center_name' => $this->input->post('centerName'),
            'admin' => $this->input->post('admin'),
            'coordinator' => $this->input->post('coordinator'),
            'coach' => $this->input->post('coach'),
            'address' => $this->input->post('address')
        ];

        if (empty($data['center_name']) || empty($data['admin']) || empty($data['coordinator']) || empty($data['coach']) || empty($data['address'])) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => 'error', 'message' => 'All fields are required']));
            return;
        }

        if ($this->Center_model->add_center($data)) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => 'success', 'message' => 'Center added successfully']));
        } else {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => 'error', 'message' => 'Failed to add center']));
        }
    }

    // API to update a center
    public function update_center($id) {
        $data = [
            'center_name' => $this->input->post('centerName'),
            'admin' => $this->input->post('admin'),
            'coordinator' => $this->input->post('coordinator'),
            'coach' => $this->input->post('coach'),
            'address' => $this->input->post('address')
        ];

        if (empty($data['center_name']) || empty($data['admin']) || empty($data['coordinator']) || empty($data['coach']) || empty($data['address'])) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => 'error', 'message' => 'All fields are required']));
            return;
        }

        if ($this->Center_model->update_center($id, $data)) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => 'success', 'message' => 'Center updated successfully']));
        } else {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => 'error', 'message' => 'Failed to update center']));
        }
    }

    // API to delete a center
    public function delete_center($id) {
        if ($this->Center_model->delete_center($id)) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => 'success', 'message' => 'Center deleted successfully']));
        } else {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => 'error', 'message' => 'Failed to delete center']));
        }
    }
}