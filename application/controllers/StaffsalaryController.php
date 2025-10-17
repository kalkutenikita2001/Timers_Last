<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class StaffsalaryController extends CI_Controller {  // Changed class name to match filename

    public function __construct() {
        parent::__construct();
        $this->load->model('Staff_salary_model');
        $this->load->library(['session', 'form_validation']);
    }

    public function salary_manage() {
        $data['title'] = 'Salary Management';
        $this->load->view('superadmin/Salary_management', $data);
    }

    public function get_salary_records() {
        $records = $this->Staff_salary_model->get_all_salary_records();
        
        // Format data for frontend
        foreach ($records as &$record) {
            $record['total_salary_formatted'] = '₹' . number_format($record['total_salary'], 2);
            $record['hourly_rate_formatted'] = '₹' . number_format($record['hourly_rate'], 2);
            $record['paid_at_formatted'] = $record['paid_at'] ? date('d-m-Y', strtotime($record['paid_at'])) : '';
            // Add sr_no for frontend use
            $record['staff_id'] = $record['staff_id']; // Ensure staff_id is available
        }
        
        echo json_encode([
            'success' => true,
            'data' => $records
        ]);
    }

    public function add_salary_record() {
        $input = json_decode(file_get_contents('php://input'), true);
        
        $data = [
            'staff_id' => $input['staff_id'],
            'hours_worked' => intval($input['hours_worked'] ?? 0),
            'days_present' => intval($input['days_present'] ?? 0),
            'sessions' => intval($input['sessions'] ?? 0),
            'hourly_rate' => floatval($input['hourly_rate'] ?? 0),
            'total_salary' => floatval($input['total_salary'] ?? 0),
            'status' => 'Pending'
        ];

        if ($this->Staff_salary_model->add_salary_record($data)) {
            echo json_encode([
                'success' => true,
                'message' => 'Salary record added successfully',
                'sr_no' => $this->db->insert_id()
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Failed to add salary record: ' . $this->db->error()['message']
            ]);
        }
    }

    public function update_salary_record() {
        $input = json_decode(file_get_contents('php://input'), true);
        $staff_id = intval($input['staff_id']);
        
        $data = [
            'hours_worked' => intval($input['hours_worked'] ?? 0),
            'days_present' => intval($input['days_present'] ?? 0),
            'sessions' => intval($input['sessions'] ?? 0),
            'hourly_rate' => floatval($input['hourly_rate'] ?? 0),
            'total_salary' => floatval($input['total_salary'] ?? 0)
        ];

        // If marking as paid
        if (isset($input['status']) && $input['status'] === 'Paid') {
            $data['status'] = 'Paid';
            $data['paid_at'] = date('Y-m-d H:i:s');
        }

        if ($this->Staff_salary_model->update_salary_record($staff_id, $data)) {
            echo json_encode([
                'success' => true,
                'message' => 'Salary record updated successfully'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Failed to update salary record: ' . $this->db->error()['message']
            ]);
        }
    }

    public function delete_salary_record($staff_id) {
        $staff_id = intval($staff_id);
        if ($this->Staff_salary_model->delete_salary_record($staff_id)) {
            echo json_encode([
                'success' => true,
                'message' => 'Salary record deleted successfully'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Failed to delete salary record: ' . $this->db->error()['message']
            ]);
        }
    }

    public function mark_salary_paid() {
        $input = json_decode(file_get_contents('php://input'), true);
        $staff_id = intval($input['staff_id']);
        
        $result = $this->Staff_salary_model->mark_as_paid(
            $staff_id,
            intval($input['hours_worked']),
            intval($input['days_present']),
            intval($input['sessions']),
            floatval($input['hourly_rate']),
            floatval($input['total_salary'])
        );

        if ($result) {
            echo json_encode([
                'success' => true,
                'message' => 'Salary marked as paid successfully'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Failed to mark salary as paid: ' . $this->db->error()['message']
            ]);
        }
    }
}