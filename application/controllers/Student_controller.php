<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Student_controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Student_model');
        $this->load->helper(['form', 'url']);
        $this->load->library('form_validation');
    }

    public function index()
    {
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

    public function add_student()
    {
        $token = bin2hex(random_bytes(16));

        $data = [
            'name' => $this->input->post('studentName'),
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
            'amount_paid' => $this->input->post('paidAmount'),
            'remaining_amount' => $this->input->post('totalFees') - $this->input->post('amountPaid'),
            'payment_method' => $this->input->post('paymentMethod'),
            'plan_expiry' => date('Y-m-d', strtotime('+1 month')),
            'unique_token' => $token,
            'attendace_link' => base_url('Student_controller/mark/' . $token)
        ];


        $insert_id = $this->Student_model->add_student($data);

        if ($insert_id) {
            $attendance_link = base_url('Student_controller/mark/' . $token);
            $response = [
                'status' => 'success',
                'message' => 'Student added successfully',
                'data' => $data,
                'attendance_link' => $attendance_link
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

   
    public function mark($token)
    {
        $student = $this->Student_model->get_by_token($token);
        if (!$student) {
            show_error('Invalid link', 404);
        }

        // Load view to fetch location before marking
        $data['token'] = $token;
        $data['student_name'] = $student->name;
        $this->load->view('attendance_location_check', $data);
    }
    // Haversine formula for distance in METERS
    private function calculate_distance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // meters

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return round($earthRadius * $c, 2); // meters
    }

    public function mark_with_location()
    {
        $token = $this->input->post('token');
        $lat = $this->input->post('latitude');
        $lng = $this->input->post('longitude');

        $student = $this->Student_model->get_by_token($token);
        if (!$student) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid link']);
            return;
        }

        // Academy location
        $academyLat = 18.6090146;
        $academyLng = 73.7581723;

        $distance = $this->calculate_distance($lat, $lng, $academyLat, $academyLng);

        // Optional: limit to 100m
        // if ($distance > 2500) {
        //     echo json_encode([
        //         'status' => 'error',
        //         'message' => 'You are too far from the academy. Distance: ' . $distance . ' meters'
        //     ]);
        //     return;
        // }

        if (!isset($_COOKIE['device_id'])) {
            $device_id = bin2hex(random_bytes(8));
            setcookie('device_id', $device_id, time() + (86400 * 365), "/");
        } else {
            $device_id = $_COOKIE['device_id'];
        }

        if ($this->Student_model->check_today($student->id)) {
            echo json_encode(['status' => 'error', 'message' => 'Attendance already marked today.']);
            return;
        }

        if ($this->Student_model->device_used_today($device_id)) {
            echo json_encode(['status' => 'error', 'message' => 'Attendance already marked from this device today.']);
            return;
        }

        $this->Student_model->mark($student->id, $device_id);
        echo json_encode([
            'status' => 'success',
            'message' => 'Attendance marked successfully for ' . $student->name . '. Distance from academy: ' . $distance . ' meters'
        ]);
    }


    public function get_student($id)
    {
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

    public function edit_student($id)
    {
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

    public function delete_student($id)
    {
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

    public function renew_student($id)
    {
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

    public function filter_students()
    {
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