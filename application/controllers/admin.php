<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Leave_model'); // <---- ADD THIS
        $this->load->library('session');
        $this->load->helper('url');

        // ✅ Block access if not logged in
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }


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


    /**
     * AJAX endpoint: return paginated students for a center (with search)
     * GET params:
     *  - page (1-based)
     *  - per_page (default 10)
     *  - search (optional)
     *
     * URL: /admin/get_students_ajax
     */
    public function get_students_ajax()
    {
        $this->load->library('session');
        $this->load->model('Center_model');
        $this->load->model('Student_model');

        // Resolve center_id (same logic used earlier)
        $center_id = $this->session->userdata('center_id');
        if (!$center_id) {
            $alt_keys = ['center_name', 'username', 'name', 'center', 'user_name', 'id'];
            foreach ($alt_keys as $k) {
                $val = $this->session->userdata($k);
                if (!$val) continue;
                if ($k === 'id' && is_numeric($val)) {
                    $center_id = (int)$val;
                    break;
                }
                $row = $this->db->where('name', $val)->or_where('center_number', $val)->get('center_details')->row();
                if ($row) {
                    $center_id = (int)$row->id;
                    break;
                }
            }
        }

        if (!$center_id) {
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['success' => false, 'message' => 'Admin not logged in or center not found']));
        }

        $page = max(1, (int)$this->input->get('page'));
        $per_page = (int)$this->input->get('per_page');
        if ($per_page <= 0) $per_page = 10;
        $search = $this->input->get('search', TRUE); // XSS filtered by CI

        $offset = ($page - 1) * $per_page;

        $students = $this->Student_model->get_students_by_center_paginated($center_id, $per_page, $offset, $search);
        $total = $this->Student_model->count_students_by_center($center_id, $search);

        // prepare simple payload
        $payload = [];
        foreach ($students as $s) {
            $payload[] = [
                'id' => $s->id,
                'name' => $s->name,
                'contact' => $s->contact,
                'center' => $s->center_id,
                'batch' => $s->batch_id ?? $s->batch ?? '',
                'level' => $s->student_progress_category ?? $s->level ?? '',
                'category' => $s->student_progress_category ?? ($s->category ?? ''),
                'status' => $s->status ?? '',
                'created_at' => $s->created_at ?? ''
            ];
        }

        return $this->output->set_content_type('application/json')
            ->set_output(json_encode([
                'success' => true,
                'students' => $payload,
                'total' => (int)$total,
                'page' => (int)$page,
                'per_page' => (int)$per_page
            ]));
    }




    public function Leave()
    {
        $this->load->view('admin/Leave');
    }
    public function add_leave()
    {

        $data = [
            'user_id'    => $this->input->post('user_id'),
            'user_name'  => $this->session->userdata('username'), // use 'username'
            'role'       => $this->input->post('designation'),
            'leave_type' => $this->input->post('leave_type') == 'Other' ? $this->input->post('leave_type_other') : $this->input->post('leave_type'),
            'from_date'  => $this->input->post('from_date'),
            'to_date'    => $this->input->post('to_date'),
            'reason'     => $this->input->post('reason'),
            'status'     => 'pending'
        ];


        if ($this->Leave_model->add_leave($data)) {
            $this->session->set_flashdata('message', 'success');
            $this->session->set_flashdata('msg_text', 'Leave applied successfully!');
        } else {
            $this->session->set_flashdata('message', 'error');
            $this->session->set_flashdata('msg_text', 'Something went wrong. Please try again.');
        }

        redirect('admin/Leave');
    }



    // Approve or reject leave
    public function change_status($leave_id, $action)
    {
        $user_role = $this->session->userdata('role');
        $leave = $this->Leave_model->get_leave($leave_id);

        // Check if user has authority
        if (($user_role == 'admin' && $leave->role != 'Student') || ($user_role == 'superadmin' && $leave->role != 'Staff')) {
            show_error('You do not have permission to change this leave status.', 403);
            return;
        }

        if (!in_array($action, ['approved', 'rejected'])) {
            show_error('Invalid action.', 400);
            return;
        }

        $this->Leave_model->update_status($leave_id, $action);
        redirect('admin/Leave');
    }
} // end of Admin class
