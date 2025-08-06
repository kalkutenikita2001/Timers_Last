<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student_controller extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Student_model');
        $this->load->helper(['form', 'url']);
        $this->load->library('form_validation');
    }

    public function index() {
        $students = $this->Student_model->get_all_students();
        $response = [
            'status' => 'success',
            'students' => $students,
            'message' => $students ? 'Students fetched successfully' : 'No students found'
        ];
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    public function add_student() {
        $data = [
            'name' => $this->input->post('name'),
            'contact' => $this->input->post('contact'),
            'parent_name' => $this->input->post('parentName'),
            'emergency_contact' => $this->input->post('emergencyContact'),
            'email' => $this->input->post('email'),
            'address' => $this->input->post('address'),
            'center' => $this->input->post('center'),
            'batch' => $this->input->post('batch'),
            'category' => $this->input->post('category'),
            'coach' => $this->input->post('coach'),
            'coordinator' => $this->input->post('coordinator'),
            'duration' => $this->input->post('duration'),
            'total_fees' => $this->input->post('totalFees'),
            'amount_paid' => $this->input->post('amountPaid'),
            'remaining_amount' => $this->input->post('totalFees') - $this->input->post('amountPaid'),
            'payment_method' => $this->input->post('paymentMethod'),
            'plan_expiry' => date('Y-m-d', strtotime('+1 month'))
        ];
        if ($this->Student_model->add_student($data)) {
            $response = [
                'status' => 'success',
                'message' => 'Student added successfully',
                'data' => $data
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Failed to add student'
            ];
        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    public function get_student($id) {
        $student = $this->Student_model->get_student_by_id($id);
        $response = [
            'status' => $student ? 'success' : 'error',
            'data' => $student ?: [],
            'message' => $student ? 'Student fetched successfully' : 'Student not found'
        ];
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    public function edit_student($id) {
        $data = [
            'name' => $this->input->post('editName'),
            'contact' => $this->input->post('editContact'),
            'center' => $this->input->post('editCenter'),
            'batch' => $this->input->post('editBatch'),
            'category' => $this->input->post('editCategory')
        ];
        if ($this->Student_model->update_student($id, $data)) {
            $response = [
                'status' => 'success',
                'message' => 'Student updated successfully'
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Failed to update student'
            ];
        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    public function delete_student($id) {
        if ($this->Student_model->delete_student($id)) {
            $response = [
                'status' => 'success',
                'message' => 'Student deleted successfully'
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Failed to delete student'
            ];
        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    public function renew_student($id) {
        $data = [
            'total_fees' => $this->input->post('renewTotalFees'),
            'amount_paid' => $this->input->post('renewAmountPaid'),
            'remaining_amount' => $this->input->post('renewTotalFees') - $this->input->post('renewAmountPaid'),
            'payment_method' => $this->input->post('renewPaymentMethod'),
            'plan_expiry' => date('Y-m-d', strtotime('+1 month'))
        ];
        if ($this->Student_model->update_student($id, $data)) {
            $student = $this->Student_model->get_student_by_id($id);
            $response = [
                'status' => 'success',
                'message' => 'Student renewed successfully',
                'data' => $student
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Failed to renew student'
            ];
        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }

    public function filter_students() {
        $filters = [
            'name' => $this->input->post('filterName') ?: '',
            'contact' => $this->input->post('filterContact') ?: '',
            'center' => $this->input->post('filterCenter') ?: '',
            'batch' => $this->input->post('filterBatch') ?: '',
            'category' => $this->input->post('filterCategory') ?: ''
        ];

        $students = $this->Student_model->filter_students($filters);
        $response = [
            'status' => 'success',
            'students' => $students,
            'message' => $students ? 'Students filtered successfully' : 'No students match the filter criteria'
        ];
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }
}
?>