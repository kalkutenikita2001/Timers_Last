<?php
// application/controllers/admincontroller/Add_on_facilities.php
defined('BASEPATH') OR exit('No direct script access allowed');

class Add_on_facilities extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('adminmodels/Add_on_facility_model');
        $this->load->helper('url');
        $this->load->library('session');
    }

    public function index() {
        $filters = array(
            'filterFacility' => $this->input->post('filterFacility'),
            'filterTitle' => $this->input->post('filterTitle'),
            'filterDate' => $this->input->post('filterDate'),
            'filterMinAmount' => $this->input->post('filterMinAmount'),
            'filterMaxAmount' => $this->input->post('filterMaxAmount')
        );

        $data['add_on_facilities'] = $this->Add_on_facility_model->get_all_add_on_facilities($filters);
        $data['csrf_token'] = $this->security->get_csrf_hash();

        if ($this->input->is_ajax_request()) {
            echo json_encode(array(
                'add_on_facilities' => $data['add_on_facilities'],
                'csrf_token' => $data['csrf_token']
            ));
        } else {
            $this->load->view('admin/add_on_facilities', $data);
        }
    }

    public function filter() {
        $filters = array(
            'filterFacility' => $this->input->post('filterFacility'),
            'filterTitle' => $this->input->post('filterTitle'),
            'filterDate' => $this->input->post('filterDate'),
            'filterMinAmount' => $this->input->post('filterMinAmount'),
            'filterMaxAmount' => $this->input->post('filterMaxAmount')
        );

        $data['add_on_facilities'] = $this->Add_on_facility_model->get_all_add_on_facilities($filters);
        $data['csrf_token'] = $this->security->get_csrf_hash();

        echo json_encode(array(
            'add_on_facilities' => $data['add_on_facilities'],
            'csrf_token' => $data['csrf_token']
        ));
    }

    public function add() {
        $data = array(
            'facility' => $this->input->post('facility'),
            'title' => $this->input->post('title'),
            'date' => $this->input->post('date'),
            'amount' => $this->input->post('amount'),
            'description' => $this->input->post('description')
        );

        $result = $this->Add_on_facility_model->add_add_on_facility($data);
        if ($result) {
            $response = array(
                'status' => 'success',
                'message' => 'Record added successfully',
                'insert_id' => $result,
                'csrf_token' => $this->security->get_csrf_hash()
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Failed to add record. Please check your input or database connection.',
                'csrf_token' => $this->security->get_csrf_hash()
            );
        }
        echo json_encode($response);
    }

    public function update() {
        $id = $this->input->post('id');
        $data = array(
            'facility' => $this->input->post('facility'),
            'title' => $this->input->post('title'),
            'date' => $this->input->post('date'),
            'amount' => $this->input->post('amount'),
            'description' => $this->input->post('description')
        );
        $result = $this->Add_on_facility_model->update_add_on_facility($id, $data);
        if ($result) {
            $response = array(
                'status' => 'success',
                'message' => 'Record updated successfully',
                'id' => $id,
                'csrf_token' => $this->security->get_csrf_hash()
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Failed to update record. Please try again.',
                'csrf_token' => $this->security->get_csrf_hash()
            );
        }
        echo json_encode($response);
    }

    public function get_by_id($id) {
        $facility = $this->Add_on_facility_model->get_add_on_facility_by_id($id);
        if ($facility) {
            $response = array(
                'status' => 'success',
                'data' => $facility,
                'csrf_token' => $this->security->get_csrf_hash()
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Record not found',
                'csrf_token' => $this->security->get_csrf_hash()
            );
        }
        echo json_encode($response);
    }

    public function delete($id) {
        $result = $this->Add_on_facility_model->delete_add_on_facility($id);
        if ($result) {
            $response = array(
                'status' => 'success',
                'message' => 'Record deleted successfully',
                'csrf_token' => $this->security->get_csrf_hash()
            );
        } else {
            $response = array(
                'status' => 'error',
                'message' => 'Failed to delete record. Please try again.',
                'csrf_token' => $this->security->get_csrf_hash()
            );
        }
        echo json_encode($response);
    }
}