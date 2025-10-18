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
        // Pull salary rows and enrich with staff fields.
        $records = $this->db
            ->select('ss.*, s.name AS staff_name, s.email, s.role, s.contact')
            ->from('staff_salary ss')
            ->join('staff s', 'ss.id = s.id', 'left')  // <-- ss.id is FK to staff.id in YOUR schema
            ->order_by('ss.sr_no', 'ASC')
            ->get()
            ->result_array();

        foreach ($records as &$r) {
            // expose staff_id for the front-end (maps from ss.id)
            $r['staff_id'] = (int)($r['id'] ?? 0);

            // prefer salary values from staff_salary (ss.*)
            $r['total_salary'] = (float)($r['total_salary'] ?? 0);
            $r['hourly_rate']  = (float)($r['hourly_rate'] ?? 0);

            // formatted fields
            $r['total_salary_formatted'] = '₹' . number_format($r['total_salary'], 2);
            $r['hourly_rate_formatted']  = '₹' . number_format($r['hourly_rate'], 2);
            $r['paid_at_formatted']      = !empty($r['paid_at']) ? date('d-m-Y', strtotime($r['paid_at'])) : '';

            // name fallback
            $r['name'] = $r['staff_name'] ?? ($r['name'] ?? 'Unknown');
        }

        echo json_encode(['success' => true, 'data' => $records]);
    }

    public function add_salary_record() {
        $input = json_decode(file_get_contents('php://input'), true);

        // DB column is `id` (FK), front-end may send staff_id
        $data = [
            'id'            => (int)($input['staff_id'] ?? $input['id'] ?? 0),
            'hours_worked'  => (int)($input['hours_worked'] ?? 0),
            'days_present'  => (int)($input['days_present'] ?? 0),
            'sessions'      => (int)($input['sessions'] ?? 0),
            'hourly_rate'   => (float)($input['hourly_rate'] ?? 0),
            'total_salary'  => (float)($input['total_salary'] ?? 0),
            'status'        => 'Pending',
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
        ];

        if ($this->Staff_salary_model->add_salary_record($data)) {
            echo json_encode(['success' => true, 'message' => 'Salary record added', 'sr_no' => $this->db->insert_id()]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed: ' . $this->db->error()['message']]);
        }
    }

    public function update_salary_record() {
        $input = json_decode(file_get_contents('php://input'), true);
        $staff_id = (int)($input['staff_id'] ?? $input['id'] ?? 0); // accept both keys

        $data = [
            'hours_worked' => (int)($input['hours_worked'] ?? 0),
            'days_present' => (int)($input['days_present'] ?? 0),
            'sessions'     => (int)($input['sessions'] ?? 0),
            'hourly_rate'  => (float)($input['hourly_rate'] ?? 0),
            'total_salary' => (float)($input['total_salary'] ?? 0),
            'updated_at'   => date('Y-m-d H:i:s'),
        ];

        if (isset($input['status']) && $input['status'] === 'Paid') {
            $data['status']  = 'Paid';
            $data['paid_at'] = date('Y-m-d H:i:s');
        }

        if ($this->Staff_salary_model->update_salary_record($staff_id, $data)) {
            echo json_encode(['success' => true, 'message' => 'Updated']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed: ' . $this->db->error()['message']]);
        }
    }

   public function delete_salary_record()
{
    $staff_id = (int) $this->input->post('staff_id');
    if ($staff_id <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid staff_id']);
        return;
    }

    if ($this->Staff_salary_model->delete_salary_record($staff_id)) {
        echo json_encode(['success' => true, 'message' => 'Deleted']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed: '.$this->db->error()['message']]);
    }
}


    public function mark_salary_paid() {
        $input = json_decode(file_get_contents('php://input'), true);
        $staff_id = (int)($input['staff_id'] ?? $input['id'] ?? 0);

        $ok = $this->Staff_salary_model->mark_as_paid(
            $staff_id,
            (int)($input['hours_worked'] ?? 0),
            (int)($input['days_present'] ?? 0),
            (int)($input['sessions'] ?? 0),
            (float)($input['hourly_rate'] ?? 0),
            (float)($input['total_salary'] ?? 0)
        );

        echo json_encode($ok ? ['success'=>true,'message'=>'Marked paid'] :
                               ['success'=>false,'message'=>'Failed: '.$this->db->error()['message']]);
    }
}
