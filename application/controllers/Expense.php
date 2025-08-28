<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Expense extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Expense_model');
        $this->load->helper('url');
        $this->load->library('session');
    }

    public function index() {
        $this->load->view('superadmin/Expenses');
    }

    public function add_expense() {
        $data = $this->input->post();
        $response = $this->Expense_model->add_expense($data);
        echo json_encode($response);
    }

    public function update_expense() {
        $data = $this->input->post();
        $id = $data['id'];
        unset($data['id']);
        $response = $this->Expense_model->update_expense($id, $data);
        echo json_encode($response);
    }

    public function get_expense($id) {
        $response = $this->Expense_model->get_expense($id);
        echo json_encode($response);
    }

    public function get_centerwise_expenses() {
        $filters = $this->input->post();
        $data = $this->Expense_model->get_centerwise_expenses($filters);
        echo json_encode($data);
    }

    public function get_own_expenses() {
        $filters = $this->input->post();
        $data = $this->Expense_model->get_own_expenses($filters);
        echo json_encode($data);
    }

    public function approve_expense($id) {
        $response = $this->Expense_model->approve_expense($id);
        echo json_encode($response);
    }

    public function reject_expense($id) {
        $response = $this->Expense_model->reject_expense($id);
        echo json_encode($response);
    }
}
?>