<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Locker_fees extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('adminmodels/Locker_fee_model');
        $this->load->helper('url');
        $this->load->library('session');
    }

    public function index() {
        $filters = array(
            'filterVenue' => $this->input->post('filterVenue'),
            'filterTitle' => $this->input->post('filterTitle'),
            'filterDate' => $this->input->post('filterDate'),
            'filterMinAmount' => $this->input->post('filterMinAmount'),
            'filterMaxAmount' => $this->input->post('filterMaxAmount')
        );

        $data['locker_fees'] = $this->Locker_fee_model->get_all_locker_fees($filters);
        $data['csrf_token'] = $this->security->get_csrf_hash();

        if ($this->input->is_ajax_request()) {
            echo json_encode(array(
                'locker_fees' => $data['locker_fees'],
                'csrf_token' => $data['csrf_token']
            ));
        } else {
            $this->load->view('admin/locker_fees', $data);
        }
    }

    public function filter() {
        $filters = array(
            'filterVenue' => $this->input->post('filterVenue'),
            'filterTitle' => $this->input->post('filterTitle'),
            'filterDate' => $this->input->post('filterDate'),
            'filterMinAmount' => $this->input->post('filterMinAmount'),
            'filterMaxAmount' => $this->input->post('filterMaxAmount')
        );

        $data['locker_fees'] = $this->Locker_fee_model->get_all_locker_fees($filters);
        $data['csrf_token'] = $this->security->get_csrf_hash();

        echo json_encode(array(
            'locker_fees' => $data['locker_fees'],
            'csrf_token' => $data['csrf_token']
        ));
    }

    public function add() {
        $data = array(
            'venue' => $this->input->post('venue'),
            'title' => $this->input->post('title'),
            'date' => $this->input->post('date'),
            'amount' => $this->input->post('amount'),
            'description' => $this->input->post('description')
        );

        $result = $this->Locker_fee_model->add_locker_fee($data);
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
            'venue' => $this->input->post('venue'),
            'title' => $this->input->post('title'),
            'date' => $this->input->post('date'),
            'amount' => $this->input->post('amount'),
            'description' => $this->input->post('description')
        );
        $result = $this->Locker_fee_model->update_locker_fee($id, $data);
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
        $fee = $this->Locker_fee_model->get_locker_fee_by_id($id);
        if ($fee) {
            $response = array(
                'status' => 'success',
                'data' => $fee,
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
        $result = $this->Locker_fee_model->delete_locker_fee($id);
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