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

    public function get_salary_records() {
        $records = $this->db
            ->select('s.id AS staff_id, s.name, s.salary AS staff_base_salary,
                      ss.sr_no, ss.hours_worked, ss.days_present, ss.sessions, ss.hourly_rate,
                      ss.total_salary AS ss_total_salary, ss.status, ss.paid_at, ss.created_at AS salary_created_at, ss.updated_at AS salary_updated_at')
            ->from('staff s')
            ->join('staff_salary ss', 'ss.id = s.id', 'left')
            ->order_by('s.id', 'ASC')
            ->get()
            ->result_array();

        foreach ($records as &$r) {
            // normalize/guarantee total_salary field for the view
            if (isset($r['ss_total_salary']) && $r['ss_total_salary'] !== null && $r['ss_total_salary'] !== '') {
                $r['total_salary'] = (float)$r['ss_total_salary'];
            } else {
                $r['total_salary'] = isset($r['staff_base_salary']) ? (float)$r['staff_base_salary'] : 0.0;
            }
            $r['hours_worked'] = (int)($r['hours_worked'] ?? 0);
            $r['hourly_rate'] = (float)($r['hourly_rate'] ?? 0);
            $r['status'] = $r['status'] ?? 'Pending';
        }

        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['success' => true, 'data' => $records]));
    }

    public function add_salary_record() {
        $input = json_decode(file_get_contents('php://input'), true);
        $staff_id = (int)($input['staff_id'] ?? $input['id'] ?? 0);
        if ($staff_id <= 0) {
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['success' => false, 'message' => 'Invalid staff_id']));
        }

        $data = [
            'id' => $staff_id, // IMPORTANT: FK to staff.id
            'hours_worked' => (int)($input['hours_worked'] ?? 0),
            'days_present' => (int)($input['days_present'] ?? 0),
            'sessions'     => (int)($input['sessions'] ?? 0),
            'hourly_rate'  => (float)($input['hourly_rate'] ?? 0),
            'total_salary' => (float)($input['total_salary'] ?? 0),
            'status'       => $input['status'] ?? 'Pending',
            'created_at'   => date('Y-m-d H:i:s'),
            'updated_at'   => date('Y-m-d H:i:s'),
        ];

        if ($this->Staff_salary_model->add_salary_record($data)) {
            echo json_encode(['success' => true, 'message' => 'Salary record added', 'sr_no' => $this->db->insert_id()]);
        } else {
            echo json_encode(['success' => false, 'message' => 'DB insert failed: '.$this->db->error()['message']]);
        }
    }

    public function update_salary_record() {
        $input = json_decode(file_get_contents('php://input'), true);
        $staff_id = (int)($input['staff_id'] ?? $input['id'] ?? 0);
        if ($staff_id <= 0) {
            return $this->output->set_content_type('application/json')->set_output(json_encode(['success'=>false,'message'=>'Invalid staff_id']));
        }

        $data = [
            'hours_worked' => (int)($input['hours_worked'] ?? 0),
            'days_present' => (int)($input['days_present'] ?? 0),
            'sessions'     => (int)($input['sessions'] ?? 0),
            'hourly_rate'  => (float)($input['hourly_rate'] ?? 0),
            'total_salary' => (float)($input['total_salary'] ?? 0),
            'updated_at'   => date('Y-m-d H:i:s'),
        ];

        if (isset($input['status']) && $input['status'] === 'Paid') {
            $data['status'] = 'Paid';
            $data['paid_at'] = date('Y-m-d H:i:s');
        }

        $existing = $this->Staff_salary_model->get_salary_by_staff_id($staff_id);
        if ($existing) {
            $ok = $this->Staff_salary_model->update_salary_record($staff_id, $data);
        } else {
            $data['id'] = $staff_id;
            $data['created_at'] = date('Y-m-d H:i:s');
            $ok = $this->Staff_salary_model->add_salary_record($data);
        }

        echo $this->output->set_content_type('application/json')->set_output(json_encode(['success'=>(bool)$ok]));
    }

    public function delete_salary_record()
    {
        // accept either form POST or JSON body
        $input = json_decode(file_get_contents('php://input'), true);
        $staff_id = $this->input->post('id') ?? $input['id'] ?? $input['staff_id'] ?? null;
        $staff_id = (int)$staff_id;

        if ($staff_id <= 0) {
            $resp = ['success' => false, 'message' => 'Invalid staff id'];
            return $this->output->set_content_type('application/json')->set_output(json_encode($resp));
        }

        $ok = $this->Staff_salary_model->delete_salary_record($staff_id);

        $resp = $ok ? ['success' => true, 'message' => 'Deleted'] : ['success' => false, 'message' => 'Delete failed: ' . ($this->db->error()['message'] ?? 'DB error')];
        return $this->output->set_content_type('application/json')->set_output(json_encode($resp));
    }

    public function mark_salary_paid()
    {
        // accept either JSON body or form POST
        $input = json_decode(file_get_contents('php://input'), true) ?: [];
        $staff_id = $this->input->post('staff_id') ?? $input['staff_id'] ?? $input['id'] ?? null;
        $staff_id = (int)$staff_id;

        if ($staff_id <= 0) {
            $resp = ['success' => false, 'message' => 'Invalid staff_id'];
            return $this->output->set_content_type('application/json')->set_output(json_encode($resp));
        }

        $hours = (int)($this->input->post('hours_worked') ?? $input['hours_worked'] ?? 0);
        $days  = (int)($this->input->post('days_present') ?? $input['days_present'] ?? 0);
        $sessions = (int)($this->input->post('sessions') ?? $input['sessions'] ?? 0);
        $rate = (float)($this->input->post('hourly_rate') ?? $input['hourly_rate'] ?? 0);
        $total = (float)($this->input->post('total_salary') ?? $input['total_salary'] ?? ($hours * $rate));

        $ok = $this->Staff_salary_model->mark_as_paid($staff_id, $hours, $days, $sessions, $rate, $total);

        $resp = $ok ? ['success' => true, 'message' => 'Marked as paid'] : ['success' => false, 'message' => 'Failed to update: '.($this->db->error()['message'] ?? 'DB error')];
        return $this->output->set_content_type('application/json')->set_output(json_encode($resp));
    }
}
