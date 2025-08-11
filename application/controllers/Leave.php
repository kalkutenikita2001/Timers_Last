<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Leave extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Leave_model');
    }

    public function index() {
        $this->load->view('superadmin/leave');
    }

    public function get_leaves() {
        $filters = $this->input->post();
        unset($filters[$this->security->get_csrf_token_name()]);
        $leaves = $this->Leave_model->get_leaves($filters);
        echo json_encode(['status' => 'success', 'data' => $leaves]);
    }

    public function add_leave() {
        $data = [
            'name' => $this->input->post('name', TRUE),
            'batch' => $this->input->post('batch', TRUE),
            'level' => $this->input->post('level', TRUE),
            'date' => $this->input->post('date', TRUE),
            'reason' => $this->input->post('reason', TRUE),
            'description' => $this->input->post('description', TRUE),
            'center_name' => $this->input->post('center', TRUE),
            'status' => $this->input->post('status', TRUE) // Add status field
        ];

        if ($this->Leave_model->add_leave($data)) {
            echo json_encode(['status' => 'success', 'message' => 'Leave added successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to add leave']);
        }
    }

    public function update_status() {
        $id = $this->input->post('id', TRUE);
        $status = $this->input->post('status', TRUE);

        if ($this->Leave_model->update_leave($id, ['status' => $status])) {
            echo json_encode(['status' => 'success', 'message' => 'Leave status updated successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update leave status']);
        }
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
            echo json_encode(['status' => 'success', 'message' => 'Leave updated successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update leave']);
        }
    }

    public function delete_leave() {
        $id = $this->input->post('id', TRUE);

        if ($this->Leave_model->delete_leave($id)) {
            echo json_encode(['status' => 'success', 'message' => 'Leave deleted successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete leave']);
        }
    }

    public function get_batches() {
        $batches = $this->Leave_model->get_batches();
        echo json_encode(['status' => 'success', 'data' => $batches]);
    }
}
?>