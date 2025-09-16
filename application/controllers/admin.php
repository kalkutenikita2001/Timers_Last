<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

    public function Dashboard()
    {
        $this->load->view('admin/Dashboard');
    }

    public function EventAndNotice()
    {
        $this->load->model('Event_model');
        $data['events'] = $this->Event_model->get_all_events();
        $this->load->view('admin/EventAndNotice', $data);
    }

    // Save new event (AJAX)
    public function saveEvent()
    {
        $this->load->model('Event_model');
        $data = array(
            'name'             => $this->input->post('name'),
            'description'      => $this->input->post('description'),
            'date'             => $this->input->post('date'),
            'time'             => $this->input->post('time'),
            'fee'              => $this->input->post('fee'),
            'max_participants' => $this->input->post('maxParticipants'),
            'venue'            => $this->input->post('venue')
        );
        $this->Event_model->insert_event($data);
        echo json_encode(['status' => 'success']);
    }

    public function view_participants($event_id)
    {
        $this->load->model('Participant_model');

        $data['event_id']     = $event_id;
        $data['participants']  = $this->Participant_model->get_by_event($event_id);
        $data['event_name']    = $this->Participant_model->get_event_name($event_id);

        $this->load->view('admin/participants', $data);
    }

    public function Expenses()
    {
        $this->load->model('Expense_model');
        $this->load->model('Center_model');

        // logged-in admin’s center id from session
        $center_id = $this->session->userdata('id');

        $data['expenses'] = $this->Expense_model->get_expenses_by_center($center_id);

        // if you want admins to add expenses only for their own center → remove dropdown
        $data['centers'] = [$this->Center_model->get_center_by_id($center_id)];

        $this->load->view('admin/Expenses', $data);
    }
    public function add_expense()
    {
        $this->load->model('Expense_model');

        $data = [
            'center_id'   => $this->session->userdata('id'), // only his center
            'title'       => $this->input->post('title'),
            'date'        => $this->input->post('date'),
            'amount'      => $this->input->post('amount'),
            'category'    => $this->input->post('category'),
            'description' => $this->input->post('description'),
            'status'      => 'pending', // admin added → pending approval
            'added_by'    => 'admin',
            'created_at'  => date('Y-m-d H:i:s'),
        ];

        $this->Expense_model->insert($data);

        redirect('Admin/Expenses'); // ✅ redirect back to Admin expenses page
    }


    // Fetch Center Name + Total/Active/Deactive Students
    public function get_center_stats()
    {
        // ensure session / db libs are loaded
        $this->load->library('session');
        $this->load->model('Center_model');
        $this->load->model('Student_model');

        // 1) Try center_id from session first (best)
        $center_id = $this->session->userdata('center_id');

        // 2) If not found, try common alternate session keys and resolve center_id by name
        if (!$center_id) {
            $alt_keys = ['center_name', 'username', 'name', 'center', 'user_name', 'id'];
            foreach ($alt_keys as $k) {
                $val = $this->session->userdata($k);
                if ($val) {
                    // if 'id' style numeric is stored as center id
                    if ($k === 'id' && is_numeric($val)) {
                        $center_id = (int)$val;
                        break;
                    }
                    // try to find center by name or center_number
                    $center_row = $this->db->where('name', $val)->or_where('center_number', $val)->get('center_details')->row();
                    if ($center_row) {
                        $center_id = (int)$center_row->id;
                        break;
                    }
                }
            }
        }

        if (!$center_id) {
            // not logged in as center admin or session missing identifying info
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['success' => false, 'message' => 'Admin not logged in or center not found in session']));
        }

        // validate center
        $center = $this->Center_model->get_by_id($center_id);
        if (!$center) {
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['success' => false, 'message' => 'Center not found']));
        }

        // total students
        $total = $this->Student_model->count_by_center($center_id);

        // Active / Deactive counts (adjust if your DB uses different status strings)
        $active = (int) $this->db->where('center_id', $center_id)->where('status', 'Active')->count_all_results('students');
        $deactive = (int) $this->db->where('center_id', $center_id)->where('status', 'Deactive')->count_all_results('students');

        return $this->output->set_content_type('application/json')
            ->set_output(json_encode([
                'success'          => true,
                'center_name'      => $center->name,
                'total_students'   => (int)$total,
                'active_students'  => $active,
                'deactive_students' => $deactive
            ]));
    }
    public function Leave()
    {
        $this->load->view('admin/Leave');
    }
} // end of Admin class
