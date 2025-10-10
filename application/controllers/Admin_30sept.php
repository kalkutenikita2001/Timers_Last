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
        $this->load->model('Student_model'); // Load the Student_model
        $this->load->model('Notifications_model');

        // ✅ Block access if not logged in
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }


    public function Dashboard()
    {


        $center_id = $this->session->userdata('center_id');

     
        if (!$center_id) {
            redirect('auth/logout');
            return;
        }

        


        $this->load->view('admin/Dashboard');
    }

    public function EventAndNotice()
    {
         $center_id = $this->session->userdata('center_id');

     
        if (!$center_id) {
            redirect('auth/logout');
            return;
        }

        $this->load->model('Event_model');
        $data['events'] = $this->Event_model->get_all_events();
        $this->load->view('admin/EventAndNotice', $data);
    }

    // Save new event (AJAX)
    public function saveEvent()
    {
        $this->load->model('Event_model');
        $data = array(
            'name' => $this->input->post('name'),
            'description' => $this->input->post('description'),
            'date' => $this->input->post('date'),
            'time' => $this->input->post('time'),
            'fee' => $this->input->post('fee'),
            'max_participants' => $this->input->post('maxParticipants'),
            'venue' => $this->input->post('venue')
        );
        $this->Event_model->insert_event($data);
        echo json_encode(['status' => 'success']);
    }

    public function view_participants($event_id)
    {
        $this->load->model('Participant_model');

        $data['event_id'] = $event_id;
        $data['participants'] = $this->Participant_model->get_by_event($event_id);
        $data['event_name'] = $this->Participant_model->get_event_name($event_id);

        $this->load->view('admin/participants', $data);
    }

    public function Expenses()
    {
         $center_id = $this->session->userdata('center_id');

     
        if (!$center_id) {
            redirect('auth/logout');
            return;
        }

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
        $this->load->model('Notifications_model');

        $data = [
            'center_id' => $this->session->userdata('id'), // only his center
            'title' => $this->input->post('title'),
            'date' => $this->input->post('date'),
            'amount' => $this->input->post('amount'),
            'category' => $this->input->post('category'),
            'description' => $this->input->post('description'),
            'status' => 'pending', // admin added → pending approval
            'added_by' => 'admin',
            'created_at' => date('Y-m-d H:i:s'),
        ];


        if ($this->Expense_model->insert($data)) {
            $this->session->set_flashdata('success', 'Expense added successfully!');

            // Debug: Log added_by and notification creation
            log_message('error', 'Expense added by user_id: ' . print_r($data['added_by'], true));
            $notif_id = $this->Notifications_model->create_notification([
                'user_id' => null, // null for superadmin, or set to superadmin's user_id
                'type' => 'expense_request',
                'title' => 'New Expense Added',
                'message' => 'A new expense has been added and needs approval.',
                'item_id' => null
            ]);
            log_message('error', 'Notification created for superadmin, notif_id: ' . print_r($notif_id, true));
        } else {
            $this->session->set_flashdata('error', 'Failed to add expense. Please try again.');
        }

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
                        $center_id = (int) $val;
                        break;
                    }
                    // try to find center by name or center_number
                    $center_row = $this->db->where('name', $val)->or_where('center_number', $val)->get('center_details')->row();
                    if ($center_row) {
                        $center_id = (int) $center_row->id;
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
                'success' => true,
                'center_name' => $center->name,
                'total_students' => (int) $total,
                'active_students' => $active,
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
                if (!$val)
                    continue;
                if ($k === 'id' && is_numeric($val)) {
                    $center_id = (int) $val;
                    break;
                }
                $row = $this->db->where('name', $val)->or_where('center_number', $val)->get('center_details')->row();
                if ($row) {
                    $center_id = (int) $row->id;
                    break;
                }
            }
        }

        if (!$center_id) {
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['success' => false, 'message' => 'Admin not logged in or center not found']));
        }

        $page = max(1, (int) $this->input->get('page'));
        $per_page = (int) $this->input->get('per_page');
        if ($per_page <= 0)
            $per_page = 10;
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
                'total' => (int) $total,
                'page' => (int) $page,
                'per_page' => (int) $per_page
            ]));
    }




    public function Leave()
    {
        $this->load->view('admin/Leave');
    }
    public function add_leave()
    {

        $data = [
            'user_id' => $this->input->post('user_id'),
            'user_name' => $this->session->userdata('username'), // use 'username'
            'role' => $this->input->post('designation'),
            'leave_type' => $this->input->post('leave_type') == 'Other' ? $this->input->post('leave_type_other') : $this->input->post('leave_type'),
            'from_date' => $this->input->post('from_date'),
            'to_date' => $this->input->post('to_date'),
            'reason' => $this->input->post('reason'),
            'status' => 'pending'
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
    public function CenterManagement2()
    {
        $this->load->view('admin/CenterManagement2');
    }
    public function New_admission()
    {
         $center_id = $this->session->userdata('center_id');

     
        if (!$center_id) {
            redirect('auth/logout');
            return;
        }


        $this->load->view('admin/New_admission');
    }
    public function Re_admission()
    {
         $center_id = $this->session->userdata('center_id');

     
        if (!$center_id) {
            redirect('auth/logout');
            return;
        }


        $this->load->view('admin/Re_admission');
    }
    // public function Students()
    // {
    //     // 🔍 Debug session first
    //     // echo "<pre>";
    //     // print_r($this->session->userdata());
    //     // echo "</pre>";
    //     // exit;
    //     $this->load->model('Student_model');

    //     $role = $this->session->userdata('role');
    //     $center_id = $this->session->userdata('center_id');

    //     if ($role === 'superadmin') {
    //         // superadmin sees all students
    //         $data['students'] = $this->Student_model->get_all_students();
    //     } else {
    //         // admin sees only their center students
    //         $data['students'] = $this->Student_model->get_students();
    //     }

    //     $this->load->view('admin/Students', $data); // your view file name
    // }

    public function Students()
    {
         $center_id = $this->session->userdata('center_id');

     
        if (!$center_id) {
            redirect('auth/logout');
            return;
        }


        $this->load->model('Student_model');


        $center_id = $this->session->userdata('center_id');

        $data['students'] = $this->Student_model->get_studentsbycenter($center_id);


        $this->load->view('admin/Students', $data); // your view file name
    }

    public function Renew_admission()
    {
        $this->load->view('admin/Renew_admission');
    }

    public function student_details($id = null)
    {
         $center_id = $this->session->userdata('center_id');

     
        if (!$center_id) {
            redirect('auth/logout');
            return;
        }


        if (!$id) {
            // if no student id is provided, redirect back to list
            redirect('admin/Students');
        }

        $data['student'] = $this->Student_model->get_student_by_id($id);

        if (!$data['student']) {
            // if student not found, you can also redirect or show error
            $this->session->set_flashdata('error', 'Student not found.');
            redirect('superadmin/students');
        }


        $data['student_get_current_batch'] = $this->Student_model->get_student_by_id_batch($id);


        $data['student_history'] = $this->Student_model->get_student_by_id_history($id);



        $data['student_history_batch'] = $this->Student_model->get_student_by_id_history_batch($id);


        $data['student_history_batch'] = $this->Student_model->get_student_by_id_history_batch($id);




        // Load facilities
        $this->load->model('Facility_model');
        $data['facilities'] = $this->Facility_model->get_facilities_of_student($id);



        $data['facilities_history'] = $this->Facility_model->get_facilities_history_by_student($id);




        $data['get_overrall_attendance'] = $this->Student_model->get_overrall_attendance_of_std($id);




        $data['student_attendace'] = $this->Student_model->get_student_attendace($id);

        // print_r($data['student_attendace'] );


        $this->load->view('admin/student_details', $data);
    }

    public function View_Renew_Students()
    {
        $this->load->view('admin/View_Renew_Students');
    }

    // ---------- Attendance endpoint (center filtered) ----------
    //Yash Sir Changes 

    public function get_attendance_ajax()
    {
        $center_id = $this->session->userdata('center_id');
        if (!$center_id) {
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['success' => false, 'attendance' => []]));
        }

        $this->db->select('attendance.id, attendance.student_id, attendance.date, attendance.time, attendance.status,
                           students.name, students.batch_id AS batch, students.student_progress_category AS level');
        $this->db->from('attendance');
        $this->db->join('students', 'attendance.student_id = students.id', 'left');
        $this->db->where('students.center_id', $center_id);
        $this->db->order_by('attendance.date', 'DESC');
        $this->db->order_by('attendance.time', 'DESC');
        $this->db->limit(200);
        $rows = $this->db->get()->result();

        return $this->output->set_content_type('application/json')
            ->set_output(json_encode(['success' => true, 'attendance' => $rows]));
    }

    // ---------- Chart data endpoint (center filtered) ----------

    public function get_students_chart()
    {
        $center_id = $this->session->userdata('center_id');
        if (!$center_id) {
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['success' => false, 'labels' => [], 'data' => []]));
        }

        $this->db->select('student_progress_category, COUNT(*) as total');
        $this->db->from('students');
        $this->db->where('center_id', $center_id);
        $this->db->group_by('student_progress_category');
        $rows = $this->db->get()->result();

        $counts = [];
        foreach ($rows as $row) {
            $key = $row->student_progress_category ?: 'Unknown';
            $counts[$key] = (int) $row->total;
        }

        $labels = ['Beginner', 'Intermediate', 'Advanced'];
        $data = [];
        foreach ($labels as $lbl) {
            $data[] = $counts[$lbl] ?? 0;
        }

        return $this->output->set_content_type('application/json')
            ->set_output(json_encode(['success' => true, 'labels' => $labels, 'data' => $data]));
    }


    /**
     * AJAX: return single student by id (center-scoped)
     * GET /admin/get_student_by_id/{id}
     */

    public function get_student_by_id($id = null)
    {
        if (!$id) {
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['success' => false, 'message' => 'Missing id']));
        }

        $center_id = $this->session->userdata('center_id');
        $role = $this->session->userdata('role');

        $student = $this->db->get_where('students', ['id' => (int) $id])->row_array();
        if (!$student) {
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['success' => false, 'message' => 'Student not found']));
        }

        // center scoping for non-superadmin users
        if ($role !== 'superadmin' && $center_id && isset($student['center_id']) && ((int) $student['center_id'] !== (int) $center_id)) {
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['success' => false, 'message' => 'Access denied']));
        }

        return $this->output->set_content_type('application/json')
            ->set_output(json_encode(['success' => true, 'student' => $student]));
    }


    /**
     * AJAX: update student (basic server-side update)
     * POST /admin/update_student_ajax
     */
    public function update_student_ajax()
    {
        $id = $this->input->post('id', TRUE);
        if (!$id) {
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['success' => false, 'message' => 'Missing id']));
        }

        // allowed fields to update (whitelist)
        $allowed = [
            'name',
            'contact',
            'parent_name',
            'emergency_contact',
            'email',
            'dob',
            'address',
            'center_id',
            'batch_id',
            'student_progress_category',
            'coach',
            'coordinator',
            'coordinator_phone',
            'batch_time',
            'course_fees',
            'total_fees',
            'paid_amount',
            'remaining_amount',
            'payment_method',
            'admission_date',
            'joining_date',
            'status'
        ];

        $update = [];
        foreach ($allowed as $f) {
            $val = $this->input->post($f, TRUE);
            if ($val !== null)
                $update[$f] = $val;
        }

        if (empty($update)) {
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['success' => false, 'message' => 'Nothing to update']));
        }

        $center_id = $this->session->userdata('center_id');
        $role = $this->session->userdata('role');

        $student = $this->db->get_where('students', ['id' => (int) $id])->row();
        if (!$student) {
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['success' => false, 'message' => 'Student not found']));
        }

        if ($role !== 'superadmin' && $center_id && (int) $student->center_id !== (int) $center_id) {
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['success' => false, 'message' => 'Access denied']));
        }

        $this->db->where('id', (int) $id);
        $ok = $this->db->update('students', $update);

        if ($ok) {
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['success' => true, 'message' => 'Saved']));
        }

        return $this->output->set_content_type('application/json')
            ->set_output(json_encode(['success' => false, 'message' => 'Update failed']));
    }


    /**
     * AJAX: delete student by id (center-scoped)
     * POST /admin/delete_student_ajax/{id}
     */
    public function delete_student_ajax($id = null)
    {
        if (!$id) {
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['success' => false, 'message' => 'Missing id']));
        }

        $center_id = $this->session->userdata('center_id');
        $role = $this->session->userdata('role');

        $student = $this->db->get_where('students', ['id' => (int) $id])->row();
        if (!$student) {
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['success' => false, 'message' => 'Student not found']));
        }

        if ($role !== 'superadmin' && $center_id && (int) $student->center_id !== (int) $center_id) {
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['success' => false, 'message' => 'Access denied']));
        }

        $this->db->where('id', (int) $id);
        $ok = $this->db->delete('students');

        if ($ok) {
            return $this->output->set_content_type('application/json')
                ->set_output(json_encode(['success' => true, 'message' => 'Deleted']));
        }

        return $this->output->set_content_type('application/json')
            ->set_output(json_encode(['success' => false, 'message' => 'Delete failed']));
    }

}
