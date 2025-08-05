<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Batch extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Batch_model');
    }

    public function index() {
        $this->load->view('superadmin/batch');
    }

    public function get_batches() {
        $filters = $this->input->post();
        unset($filters[$this->security->get_csrf_token_name()]); // Remove CSRF token from filters
        $batches = $this->Batch_model->get_batches($filters);
        echo json_encode(['status' => 'success', 'data' => $batches]);
    }

    public function add_batch() {
        $data = [
            'batch' => $this->input->post('batch', TRUE),
            'date' => $this->input->post('date', TRUE),
            'time' => $this->input->post('time', TRUE),
            'category' => $this->input->post('category', TRUE),
            'center_name' => $this->input->post('center_name', TRUE)
        ];

        if ($this->Batch_model->add_batch($data)) {
            echo json_encode(['status' => 'success', 'message' => 'Batch added successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to add batch']);
        }
    }

    public function update_batch() {
        $id = $this->input->post('id', TRUE);
        $data = [
            'batch' => $this->input->post('batch', TRUE),
            'date' => $this->input->post('date', TRUE),
            'time' => $this->input->post('time', TRUE),
            'category' => $this->input->post('category', TRUE),
            'center_name' => $this->input->post('center_name', TRUE)
        ];

        if ($this->Batch_model->update_batch($id, $data)) {
            echo json_encode(['status' => 'success', 'message' => 'Batch updated successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update batch']);
        }
    }

    public function delete_batch() {
        $id = $this->input->post('id', TRUE);
        if ($this->Batch_model->delete_batch($id)) {
            echo json_encode(['status' => 'success', 'message' => 'Batch deleted successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete batch']);
        }
    }
}
?>