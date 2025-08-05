<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Staff extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Staff_model');
        $this->load->helper('url');
    }

    // Load the staff view
    public function index() {
        $data['centers'] = $this->Staff_model->get_centers();
        $this->load->view('superadmin/staff', $data);
    }

    // API to get all staff with optional filters
    public function get_staff() {
        $filters = [
            'name' => $this->input->get('name'),
            'contact' => $this->input->get('contact'),
            'address' => $this->input->get('address'),
            'center_name' => $this->input->get('center_name'),
            'batch' => $this->input->get('batch'),
            'date' => $this->input->get('date'),
            'time' => $this->input->get('time'),
            'category' => $this->input->get('category')
        ];

        $staff = $this->Staff_model->get_staff($filters);
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['status' => 'success', 'data' => $staff]));
    }

    // API to get a single staff member by ID
    public function get_staff_by_id($id) {
        $staff = $this->Staff_model->get_staff_by_id($id);
        if ($staff) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => 'success', 'data' => $staff]));
        } else {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => 'error', 'message' => 'Staff not found']));
        }
    }

    // API to add a new staff member
    public function add_staff() {
        $data = [
            'name' => $this->input->post('name'),
            'contact' => $this->input->post('contact'),
            'address' => $this->input->post('address'),
            'center_name' => $this->input->post('centerName'),
            'batch' => $this->input->post('batch'),
            'date' => $this->input->post('date'),
            'time' => $this->input->post('time'),
            'category' => $this->input->post('category')
        ];

        if (empty($data['name']) || empty($data['contact']) || empty($data['address']) || 
            empty($data['center_name']) || empty($data['batch']) || empty($data['date']) || 
            empty($data['time']) || empty($data['category'])) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => 'error', 'message' => 'All fields are required']));
            return;
        }

        if (!preg_match('/^[0-9]{10}$/', $data['contact'])) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => 'error', 'message' => 'Contact must be a 10-digit number']));
            return;
        }

        if (!in_array($data['category'], ['Coach', 'Coordinator'])) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => 'error', 'message' => 'Invalid category']));
            return;
        }

        if ($this->Staff_model->add_staff($data)) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => 'success', 'message' => 'Staff added successfully']));
        } else {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => 'error', 'message' => 'Failed to add staff']));
        }
    }

    // API to update a staff member
    public function update_staff($id) {
        $data = [
            'name' => $this->input->post('name'),
            'contact' => $this->input->post('contact'),
            'address' => $this->input->post('address'),
            'center_name' => $this->input->post('centerName'),
            'batch' => $this->input->post('batch'),
            'date' => $this->input->post('date'),
            'time' => $this->input->post('time'),
            'category' => $this->input->post('category')
        ];

        if (empty($data['name']) || empty($data['contact']) || empty($data['address']) || 
            empty($data['center_name']) || empty($data['batch']) || empty($data['date']) || 
            empty($data['time']) || empty($data['category'])) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => 'error', 'message' => 'All fields are required']));
            return;
        }

        if (!preg_match('/^[0-9]{10}$/', $data['contact'])) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => 'error', 'message' => 'Contact must be a 10-digit number']));
            return;
        }

        if (!in_array($data['category'], ['Coach', 'Coordinator'])) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => 'error', 'message' => 'Invalid category']));
            return;
        }

        if ($this->Staff_model->update_staff($id, $data)) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => 'success', 'message' => 'Staff updated successfully']));
        } else {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => 'error', 'message' => 'Failed to update staff']));
        }
    }

    // API to delete a staff member
    public function delete_staff($id) {
        if ($this->Staff_model->delete_staff($id)) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => 'success', 'message' => 'Staff deleted successfully']));
        } else {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => 'error', 'message' => 'Failed to delete staff']));
        }
    }
}