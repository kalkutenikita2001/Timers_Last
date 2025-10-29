<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Attendance extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // ensure DB + session loaded
        $this->load->database();
        $this->load->library('session');

        // models
        $this->load->model('StaffModel');
        $this->load->model('Attendance_model');

        // helpers
        $this->load->helper('url');
        $this->load->helper('date');
    }

    // main view (optional - you already load via Superadmin)
    public function index()
    {
        // If loaded directly, pass staff list to the view
        $data['staff_list'] = $this->StaffModel->getAllStaff();
        $this->load->view('superadmin/attendance', $data);
    }

    // simple health check
    public function ping()
    {
        echo 'ok';
    }

    // POST: date=YYYY-MM-DD
    public function get_by_date()
    {
        // require POST
        $date = $this->input->post('date') ?: date('Y-m-d');

        $rows = $this->Attendance_model->get_by_date($date);

        // prepare keyed response by staff_id for easy client merge
        $out = [];
        foreach ($rows as $r) {
            $out[$r['staff_id']] = $r;
        }

        // include new CSRF token (if enabled)
        $csrf_token = null;
        if (function_exists('get_instance')) {
            // CodeIgniter security helper
            $CI = &get_instance();
            if (property_exists($CI, 'security')) {
                $csrf_token = $CI->security->get_csrf_hash();
            }
        }

        header('Content-Type: application/json');
        echo json_encode(['status' => true, 'date' => $date, 'data' => $out, 'csrf_token' => $csrf_token]);
    }

    // POST: staff_id, date, present, check_in_time, check_out_time, notes (optional)
    public function save()
    {
        // Basic auth guard: ensure logged in (adjust if needed)
        if (!$this->session->userdata('logged_in')) {
            header('Content-Type: application/json');
            http_response_code(401);
            echo json_encode(['status' => false, 'message' => 'Not logged in']);
            return;
        }

        $staff_id = (int)$this->input->post('staff_id');
        $date     = $this->input->post('date') ?: date('Y-m-d');
        $present  = $this->input->post('present') !== null ? (int)$this->input->post('present') : 0;
        $ci_time  = trim($this->input->post('check_in_time') ?: '');
        $co_time  = trim($this->input->post('check_out_time') ?: '');
        $notes    = trim($this->input->post('notes') ?: '');

        if (!$staff_id) {
            header('Content-Type: application/json');
            echo json_encode(['status' => false, 'message' => 'Missing staff_id']);
            return;
        }

        // Build data for DB. We will upsert by staff_id + date.
        $data = [
            'staff_id' => $staff_id,
            'date' => $date,
            'present' => $present ? 1 : 0,
            'check_in_time' => $ci_time !== '' ? $ci_time : null,
            'check_out_time' => $co_time !== '' ? $co_time : null,
            'notes' => $notes,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // set server timestamp for check_in_at/check_out_at if times present
        if ($ci_time !== '') {
            // If an existing record already had check_in_at, keep it. We'll rely on upsert to do this.
            $data['check_in_at'] = date('Y-m-d H:i:s');
        }
        if ($co_time !== '') {
            $data['check_out_at'] = date('Y-m-d H:i:s');
        }

        // Perform upsert
        $id = $this->Attendance_model->upsert_by_staff_date($staff_id, $date, $data);

        // After saving, recompute worked_minutes if both check_in_at and check_out_at exist
        if ($id) {
            $rec = $this->Attendance_model->get_by_id($id);
            if ($rec && !empty($rec['check_in_at']) && !empty($rec['check_out_at'])) {
                $ci = strtotime($rec['check_in_at']);
                $co = strtotime($rec['check_out_at']);
                if ($co >= $ci) {
                    $minutes = (int)floor(($co - $ci) / 60);
                    $this->Attendance_model->update($id, ['worked_minutes' => $minutes]);
                }
            }
        }

        // return fresh CSRF token (if enabled) so client can update its meta
        $csrf_token = null;
        if (function_exists('get_instance')) {
            $CI = &get_instance();
            if (property_exists($CI, 'security')) {
                $csrf_token = $CI->security->get_csrf_hash();
            }
        }

        header('Content-Type: application/json');
        if ($id) {
            echo json_encode(['status' => true, 'id' => $id, 'message' => 'Saved', 'csrf_token' => $csrf_token]);
        } else {
            echo json_encode(['status' => false, 'message' => 'Save failed', 'csrf_token' => $csrf_token]);
        }
    }
}
