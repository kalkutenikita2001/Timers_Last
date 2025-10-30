<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class StaffsalaryController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Staff_salary_model');
        $this->load->library(['session', 'form_validation']);
        $this->load->database();
    }

    public function salary_manage() {
        $data['title'] = 'Salary Management';
        $this->load->view('superadmin/Salary_management', $data);
    }

    /* ==============================================================
       1. GET ALL RECORDS – SHOW EVERY STAFF (even without salary row)
       ============================================================== */
    public function get_salary_records()
    {
        $staff_list = $this->db
            ->select('s.id AS staff_id, s.name, s.salary AS staff_base_salary')
            ->from('staff s')
            ->where('s.active', 1) // only active staff
            ->order_by('s.name', 'ASC')
            ->get()
            ->result_array();

        $data = [];

        foreach ($staff_list as $s) {
            $staff_id = (int)$s['staff_id'];
            $base_salary = (float)($s['staff_base_salary'] ?? 0);

            $ss = $this->Staff_salary_model->get_salary_by_staff_id($staff_id);

            if ($ss) {
                $original = (float)($ss['original_salary'] ?? $ss['total_salary'] ?? $base_salary);
                $paid     = (strtolower($ss['status'] ?? '') === 'paid')
                            ? (float)($ss['paid_salary'] ?? $original)
                            : 0;
                $paid_at_formatted = $ss['paid_at'] ? date('d M Y g:i A', strtotime($ss['paid_at'])) : '';
            } else {
                $original = $base_salary;
                $paid = 0;
                $paid_at_formatted = '';

                // ✅ Auto-create pending salary record
                $this->Staff_salary_model->add_salary_record([
                    'staff_id'        => $staff_id,
                    'sr_no'           => $staff_id, // optional but keeps it in sync
                    'original_salary' => $original,
                    'status'          => 'Pending',
                    'created_at'      => date('Y-m-d H:i:s'),
                    'updated_at'      => date('Y-m-d H:i:s')
                ]);
            }

            $data[] = [
                'staff_id'               => $staff_id,
                'name'                   => $s['name'] ?? 'N/A',
                'hours_worked'           => $ss['hours_worked'] ?? 0,
                'days_present'           => $ss['days_present'] ?? 0,
                'sessions'               => $ss['sessions'] ?? 0,
                'hourly_rate'            => (float)($ss['hourly_rate'] ?? 0),
                'hourly_rate_formatted'  => '₹' . number_format((float)($ss['hourly_rate'] ?? 0), 2),

                'original_salary'        => $original,
                'original_salary_formatted' => '₹' . number_format($original, 2),
                'paid_salary'            => $paid,
                'paid_salary_formatted'  => $paid > 0 ? '₹' . number_format($paid, 2) : '',

                'total_salary'           => $original,
                'total_salary_formatted' => '₹' . number_format($original, 2),

                'status'                 => $ss['status'] ?? 'Pending',
                'paid_at_formatted'      => $paid_at_formatted,
                'sr_no'                  => $ss['sr_no'] ?? ''
            ];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['success' => true, 'data' => $data]));
    }

    /* ==============================================================
       2. UPDATE / MARK AS PAID
       ============================================================== */
    public function update_salary_record()
    {
        $input = json_decode(file_get_contents('php://input'), true) ?: [];

        $staff_id = (int)($input['staff_id'] ?? 0);
        if ($staff_id <= 0) {
            $this->_json_error('Invalid staff_id');
            return;
        }

        $hours    = (int)($input['hours_worked'] ?? 0);
        $days     = (int)($input['days_present'] ?? 0);
        $sessions = (int)($input['sessions'] ?? 0);
        $rate     = (float)($input['hourly_rate'] ?? 0);
        $original = (float)($input['original_salary'] ?? 0);
        $paid     = (float)($input['paid_salary'] ?? 0);
        $status   = $input['status'] ?? 'Pending';

        $data = [
            'staff_id'        => $staff_id,
            'sr_no'           => $staff_id, // optional sync
            'hours_worked'    => $hours,
            'days_present'    => $days,
            'sessions'        => $sessions,
            'hourly_rate'     => $rate,
            'original_salary' => $original,
            'updated_at'      => date('Y-m-d H:i:s')
        ];

        if ($status === 'Paid') {
            if ($paid <= 0) {
                $this->_json_error('Paid salary must be greater than 0');
                return;
            }
            $data['paid_salary'] = $paid;
            $data['status']      = 'Paid';
            $data['paid_at']     = date('Y-m-d H:i:s');
        } else {
            $data['status'] = 'Pending';
        }

        $existing = $this->Staff_salary_model->get_salary_by_staff_id($staff_id);

        if ($existing) {
            $ok = $this->Staff_salary_model->update_salary_record($staff_id, $data);
        } else {
            // ✅ Fix: correctly add staff_id instead of id
            $data['staff_id']  = $staff_id;
            $data['sr_no']     = $staff_id;
            $data['created_at'] = date('Y-m-d H:i:s');
            $ok = $this->Staff_salary_model->add_salary_record($data);
        }

        $resp = $ok
            ? ['success' => true, 'message' => 'Salary updated']
            : ['success' => false, 'message' => 'Update failed'];

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($resp));
    }

    /* ==============================================================
       3. DELETE – HARD DELETE SPECIFIC RECORD
       ============================================================== */
    public function delete_salary_record()
    {
        $input = json_decode(file_get_contents('php://input'), true) ?: [];
        $staff_id = (int)($input['staff_id'] ?? 0);

        if ($staff_id <= 0) {
            $this->_json_error('Invalid staff id');
            return;
        }

        $ok = $this->Staff_salary_model->delete_salary_record($staff_id);

        $resp = $ok
            ? ['success' => true, 'message' => 'Record deleted']
            : ['success' => false, 'message' => 'Delete failed'];

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($resp));
    }

    private function _json_error($msg)
    {
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['success' => false, 'message' => $msg]));
    }
}