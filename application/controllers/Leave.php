<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Leave extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Leave_model');
    }

    public function index() {
        $data['leaves'] = $this->Leave_model->get_leaves();
        $this->load->view('superadmin/leave', $data);
    }

    public function get_leaves() {
        $filters = $this->input->post();
        unset($filters[$this->security->get_csrf_token_name()]);
        $leaves = $this->Leave_model->get_leaves($filters);
        $response = [
            'status' => 'success',
            'data' => $leaves,
            'csrf_token' => $this->security->get_csrf_hash()
        ];
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    public function add_leave() {
        $data = [
            'name' => $this->input->post('name', TRUE),
            'batch' => $this->input->post('batch', TRUE),
            'level' => $this->input->post('level', TRUE),
            'date' => $this->input->post('date', TRUE),
            'reason' => $this->input->post('reason', TRUE),
            'description' => $this->input->post('description', TRUE),
            'center_name' => 'Center-A', // Hardcoded as per your code
            'status' => $this->input->post('status', TRUE) ?: 'Pending' // Default to 'Pending' if not provided
        ];

        if ($this->Leave_model->add_leave($data)) {
            $response = [
                'status' => 'success',
                'message' => 'Leave added successfully',
                'csrf_token' => $this->security->get_csrf_hash()
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Failed to add leave',
                'csrf_token' => $this->security->get_csrf_hash()
            ];
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    public function update_leave() {
        $id = $this->input->post('id', TRUE);
        $data = [
            'name' => $this->input->post('name', TRUE),
            'batch' => $this->input->post('batch', TRUE),
            'level' => $this->input->post('level', TRUE),
            'date' => $this->input->post('date', TRUE),
            'reason' => $this->input->post('reason', TRUE),
            'description' => $this->input->post('description', TRUE)
        ];

        if ($this->Leave_model->update_leave($id, $data)) {
            $response = [
                'status' => 'success',
                'message' => 'Leave updated successfully',
                'csrf_token' => $this->security->get_csrf_hash()
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Failed to update leave',
                'csrf_token' => $this->security->get_csrf_hash()
            ];
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    public function delete_leave() {
        $id = $this->input->post('id', TRUE);

        if ($this->Leave_model->delete_leave($id)) {
            $response = [
                'status' => 'success',
                'message' => 'Leave deleted successfully',
                'csrf_token' => $this->security->get_csrf_hash()
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Failed to delete leave',
                'csrf_token' => $this->security->get_csrf_hash()
            ];
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    public function get_by_id($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('leaves');
        $leave = $query->row_array();
        if ($leave) {
            $response = [
                'status' => 'success',
                'data' => $leave,
                'csrf_token' => $this->security->get_csrf_hash()
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Leave not found',
                'csrf_token' => $this->security->get_csrf_hash()
            ];
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }

    public function get_batches() {
        $batches = $this->Leave_model->get_batches();
        $response = [
            'status' => 'success',
            'data' => $batches,
            'csrf_token' => $this->security->get_csrf_hash()
        ];
        $this->output->set_content_type('application/json')->set_output(json_encode($response));
    }
}