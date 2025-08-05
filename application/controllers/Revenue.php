<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Revenue extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Revenue_model');
        $this->load->helper('url');
    }

    public function index() {
        $data['centers'] = $this->Revenue_model->get_centers();
        $this->load->view('superadmin/Finance', $data);
    }

    public function get_revenues() {
        $filters = array(
            'title' => $this->input->post('title'),
            'center_name' => $this->input->post('center_name'),
            'start_date' => $this->input->post('start_date'),
            'end_date' => $this->input->post('end_date'),
            'min_daily_revenue' => $this->input->post('min_daily_revenue'),
            'max_daily_revenue' => $this->input->post('max_daily_revenue'),
            'min_weekly_revenue' => $this->input->post('min_weekly_revenue'),
            'max_weekly_revenue' => $this->input->post('max_weekly_revenue'),
            'min_monthly_revenue' => $this->input->post('min_monthly_revenue'),
            'max_monthly_revenue' => $this->input->post('max_monthly_revenue'),
            'min_yearly_revenue' => $this->input->post('min_yearly_revenue'),
            'max_yearly_revenue' => $this->input->post('max_yearly_revenue')
        );
        $data = $this->Revenue_model->get_revenues($filters);
        echo json_encode($data);
    }

    public function get_total_revenue() {
        $data = $this->Revenue_model->get_total_revenue();
        echo json_encode($data);
    }

    public function add_revenue() {
        $data = array(
            'title' => $this->input->post('title'),
            'center_name' => $this->input->post('center_name'),
            'date' => $this->input->post('date'),
            'daily_revenue' => $this->input->post('daily_revenue'),
            'weekly_revenue' => $this->input->post('weekly_revenue'),
            'monthly_revenue' => $this->input->post('monthly_revenue'),
            'yearly_revenue' => $this->input->post('yearly_revenue'),
            'notes' => $this->input->post('notes') ?: 'N/A',
            'status' => 'pending'
        );

        if ($this->Revenue_model->add_revenue($data)) {
            echo json_encode(array('status' => 'success', 'message' => 'Revenue added successfully'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Failed to add revenue'));
        }
    }

    public function update_revenue() {
        $id = $this->input->post('id');
        $data = array(
            'title' => $this->input->post('title'),
            'center_name' => $this->input->post('center_name'),
            'date' => $this->input->post('date'),
            'daily_revenue' => $this->input->post('daily_revenue'),
            'weekly_revenue' => $this->input->post('weekly_revenue'),
            'monthly_revenue' => $this->input->post('monthly_revenue'),
            'yearly_revenue' => $this->input->post('yearly_revenue'),
            'notes' => $this->input->post('notes') ?: 'N/A'
        );

        if ($this->Revenue_model->update_revenue($id, $data)) {
            echo json_encode(array('status' => 'success', 'message' => 'Revenue updated successfully'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Failed to update revenue'));
        }
    }

    public function approve_revenue($id) {
        $data = array('status' => 'approved');
        if ($this->Revenue_model->update_revenue($id, $data)) {
            echo json_encode(array('status' => 'success', 'message' => 'Revenue approved successfully'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Failed to approve revenue'));
        }
    }

    public function reject_revenue($id) {
        $data = array('status' => 'rejected');
        if ($this->Revenue_model->update_revenue($id, $data)) {
            echo json_encode(array('status' => 'success', 'message' => 'Revenue rejected successfully'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Failed to reject revenue'));
        }
    }

    public function get_revenue($id) {
        $data = $this->Revenue_model->get_revenue_by_id($id);
        if ($data) {
            echo json_encode(array('status' => 'success', 'data' => $data));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Revenue not found'));
        }
    }
}