<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admission extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Admission_model');
        $this->load->helper('url');
    }

    public function index() {
        $this->load->view('superadmin/new_admission');
    }

    public function receipt() {
        $student_id = $this->input->get('student_id');
        if (!$student_id) {
            show_error('Invalid student ID', 400);
        }
        $data['student_id'] = $student_id;
        $this->load->view('superadmin/receipt', $data);
    }

    public function get_centers() {
        $this->output->set_content_type('application/json');
        log_message('debug', 'get_centers method called');
        $centers = $this->Admission_model->get_all_centers();
        echo json_encode($centers);
    }

    public function get_batches($center_id) {
        $this->output->set_content_type('application/json');
        log_message('debug', 'get_batches method called for center ID: ' . $center_id);
        $batches = $this->Admission_model->get_batches_by_center($center_id);
        echo json_encode($batches);
    }

    public function get_categories() {
        $this->output->set_content_type('application/json');
        log_message('debug', 'get_categories method called');
        $categories = ['Beginner', 'Intermediate', 'Advanced'];
        echo json_encode($categories);
    }

    public function get_lockers($center_id) {
        $this->output->set_content_type('application/json');
        log_message('debug', 'get_lockers method called for center ID: ' . $center_id);
        $lockers = $this->Admission_model->get_lockers_by_center($center_id);
        echo json_encode($lockers);
    }

   public function get_student($student_id) {
    $this->output->set_content_type('application/json');
    log_message('debug', 'get_student method called for student ID: ' . $student_id);
    if (!is_numeric($student_id) || $student_id <= 0) {
        log_message('error', 'Invalid student ID: ' . $student_id);
        echo json_encode(['success' => false, 'message' => 'Invalid student ID']);
        return;
    }
    $student = $this->Admission_model->get_student_by_id($student_id);
    if ($student) {
        echo json_encode($student);
    } else {
        log_message('error', 'Student not found for ID: ' . $student_id);
        echo json_encode(['success' => false, 'message' => 'Student not found']);
    }
}

    public function get_students() {
        $this->output->set_content_type('application/json');
        log_message('debug', 'get_students method called');
        $students = $this->Admission_model->get_students();
        foreach ($students as &$student) {
            // Calculate status based on joining_date + duration and last_attendance
            $expiry_date = date('Y-m-d', strtotime($student['joining_date'] . ' + ' . $student['duration'] . ' months'));
            $today = date('Y-m-d');
            $is_expired = $expiry_date < $today;
            $is_absent = $student['last_attendance'] && (strtotime($today) - strtotime($student['last_attendance'])) / (60 * 60 * 24) >= 5;
            
            if ($is_expired || $is_absent) {
                $student['status'] = 'Deactive';
                // Update status in database if needed
                $this->db->where('id', $student['id']);
                $this->db->update('students', ['status' => 'Deactive']);
            } else {
                $student['status'] = $student['status'] ?? 'Active';
            }
        }
        echo json_encode($students);
    }

    public function get_deactivated_students() {
        $this->output->set_content_type('application/json');
        log_message('debug', 'get_deactivated_students method called');
        $students = $this->Admission_model->get_deactivated_students();
        foreach ($students as &$student) {
            $student['status'] = 'Deactive'; // Already filtered by expiration
        }
        echo json_encode($students);
    }

    public function update_student() {
        $this->output->set_content_type('application/json');
        log_message('debug', 'update_student method called with data: ' . json_encode($this->input->post()));
        $data = [
            'name' => $this->input->post('name'),
            'contact' => $this->input->post('contact'),
            'center_id' => $this->input->post('center_id'),
            'batch_id' => $this->input->post('batch_id'),
            'category' => $this->input->post('category')
        ];
        $student_id = $this->input->post('id');
        $this->db->where('id', $student_id);
        $result = $this->db->update('students', $data);
        echo json_encode(['success' => $result, 'message' => $result ? 'Student updated successfully' : 'Failed to update student']);
    }

    public function delete_student($student_id) {
        $this->output->set_content_type('application/json');
        log_message('debug', 'delete_student method called for student ID: ' . $student_id);
        $this->db->trans_start();
        $this->db->where('student_id', $student_id);
        $this->db->delete('student_facilities');
        $this->db->where('id', $student_id);
        $result = $this->db->delete('students');
        $this->db->trans_complete();
        echo json_encode(['success' => $result, 'message' => $result ? 'Student deleted successfully' : 'Failed to delete student']);
    }

    public function toggle_status($student_id) {
        $this->output->set_content_type('application/json');
        log_message('debug', 'toggle_status method called for student ID: ' . $student_id);
        $this->db->select('status');
        $this->db->where('id', $student_id);
        $student = $this->db->get('students')->row_array();

        if ($student) {
            $new_status = $student['status'] === 'Active' ? 'Deactive' : 'Active';
            $this->db->where('id', $student_id);
            $this->db->update('students', ['status' => $new_status]);
            if ($this->db->affected_rows() > 0) {
                echo json_encode(['success' => true, 'status' => $new_status, 'message' => 'Student status updated successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update student status']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Student not found']);
        }
    }

  public function renew_student() {
    $this->output->set_content_type('application/json');
    log_message('debug', 'renew_student method called with data: ' . json_encode($this->input->post()));

    $input = json_decode(file_get_contents('php://input'), true);
    $student_id = $input['student_id'] ?? null;

    if (!$student_id || !is_numeric($student_id) || $student_id <= 0) {
        log_message('error', 'Missing or invalid student_id in renew_student request: ' . $student_id);
        echo json_encode(['success' => false, 'message' => 'Invalid or missing student ID']);
        return;
    }

    $this->db->trans_start();

    $data = [
        'name' => $input['name'] ?? null,
        'contact' => $input['contact'] ?? null,
        'center_id' => $input['center_id'] ?? null,
        'batch_id' => $input['batch_id'] ?? null,
        'category' => $input['category'] ?? null,
        'total_fees' => $input['total_fees'] ?? 0,
        'paid_amount' => $input['paid_amount'] ?? 0,
        'remaining_amount' => ($input['total_fees'] ?? 0) - ($input['paid_amount'] ?? 0),
        'payment_method' => $input['payment_method'] ?? null,
        'joining_date' => date('Y-m-d'),
        'duration' => $input['duration'] ?? null,
        'admission_date' => date('Y-m-d'),
        'status' => 'Active'
    ];

    // Validate required fields
    $required_fields = ['name', 'contact', 'center_id', 'batch_id', 'category', 'total_fees', 'payment_method', 'duration'];
    foreach ($required_fields as $field) {
        if (!isset($data[$field]) || empty($data[$field])) {
            log_message('error', "Missing or empty field: $field");
            $this->db->trans_rollback();
            echo json_encode(['success' => false, 'message' => "Missing or invalid $field"]);
            return;
        }
    }

    // Validate numeric fields
    if (!is_numeric($data['total_fees']) || $data['total_fees'] <= 0 || !is_numeric($data['paid_amount']) || $data['paid_amount'] < 0) {
        log_message('error', 'Invalid numeric values for total_fees or paid_amount');
        $this->db->trans_rollback();
        echo json_encode(['success' => false, 'message' => 'Invalid fees or paid amount']);
        return;
    }
    if ($data['paid_amount'] > $data['total_fees']) {
        log_message('error', 'Paid amount exceeds total fees');
        $this->db->trans_rollback();
        echo json_encode(['success' => false, 'message' => 'Paid amount cannot exceed total fees']);
        return;
    }

    $this->db->where('id', $student_id);
    $result = $this->db->update('students', $data);

    if (!$result) {
        log_message('error', 'Failed to update students table: ' . $this->db->error()['message']);
        $this->db->trans_rollback();
        echo json_encode(['success' => false, 'message' => 'Failed to update student record: ' . $this->db->error()['message']]);
        return;
    }

    $this->db->trans_complete();
    if ($this->db->trans_status() === FALSE) {
        log_message('error', 'Transaction failed: ' . $this->db->error()['message']);
        echo json_encode(['success' => false, 'message' => 'Transaction failed: ' . $this->db->error()['message']]);
    } else {
        $student = $this->Admission_model->get_student_by_id($student_id);
        echo json_encode(['success' => true, 'student' => $student, 'message' => 'Admission renewed successfully']);
    }
}

    public function export_students() {
        $this->output->set_content_type('application/json');
        log_message('debug', 'export_students method called');
        $students = $this->Admission_model->get_students();
        echo json_encode($students);
    }

    public function save() {
        $this->output->set_content_type('application/json');
        log_message('debug', 'Save admission called with data: ' . $this->input->raw_input_stream);
        $data = json_decode($this->input->raw_input_stream, true);

        if (!$data) {
            $this->output->set_status_header(400);
            echo json_encode(['success' => false, 'message' => 'Invalid input data']);
            return;
        }

        $student_id = $this->Admission_model->save_admission($data);
        if ($student_id) {
            log_message('debug', 'Admission saved successfully with student ID: ' . $student_id);
            echo json_encode(['success' => true, 'student_id' => $student_id]);
        } else {
            $this->output->set_status_header(500);
            log_message('error', 'Failed to save admission');
            echo json_encode(['success' => false, 'message' => 'Failed to save admission']);
        }
    }
     public function get_deactive_students() {
        header('Content-Type: application/json');

        $students = $this->Admission_model->get_deactive_students();

        if ($students) {
            echo json_encode([
                'status' => 'success',
                'count'  => count($students),
                'data'   => $students
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'No deactive students found'
            ]);
        }
    }
    public function update_joining_date() {
    $student_id   = $this->input->post('student_id');
    $joining_date = $this->input->post('joining_date');

    if ($student_id && $joining_date) {
        $this->db->where('id', $student_id);
        $this->db->update('students', ['joining_date' => $joining_date]);

        $this->session->set_flashdata('success', 'Joining date updated successfully.');
    } else {
        $this->session->set_flashdata('error', 'Invalid data.');
    }
    redirect('superadmin/re_admission');
}
public function expiring_students() {
        $students = $this->Admission_model->get_students_expiring_soon();

        if (!empty($students)) {
            $response = [
                "status" => "success",
                "data" => $students
            ];
        } else {
            $response = [
                "status" => "success",
                "data" => [],
                "message" => "No students expiring within 10 days"
            ];
        }

        echo json_encode($response);
    }
}
?>