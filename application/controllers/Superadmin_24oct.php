<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Superadmin extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('DashboardModel');
		$this->load->model('Student_model'); // Load the Student_model
		$this->load->model('Center_model');
		$this->load->model('Permission_model');
		$this->load->model('StaffModel');
		$this->load->database();

		// ✅ Block access if not logged in
		if (!$this->session->userdata('logged_in')) {
			redirect('auth/login');
		}
	}

	public function dashboard()
	{
		$center_id = $this->session->userdata('center_id');


		if (!$center_id) {
			redirect('auth/logout');
			return;
		}


		$data['activeStudents']  = $this->DashboardModel->getActiveStudentsCount();
		$data['totalStudents']   = $this->DashboardModel->getTotalStudentsCount();
		$data['totalIncome']     = $this->DashboardModel->getTotalIncome();
		$data['totalDue']        = $this->DashboardModel->getTotalDueAmount();
		$data['studentDistribution'] = $this->DashboardModel->getStudentDistribution();
		$data['monthlyRevenue']  = $this->DashboardModel->getMonthlyRevenue();

		// Fetch centers from DB
		$query = $this->db->get('center_details');
		$data['centers'] = $query->result(); // this will be an array of objects

		// print_r($data);
		// die; // Debugging line to check the data before loading the view

		$this->load->view('superadmin/dashboard', $data);
	}
	public function Sidebar()
	{
		$this->load->view('superadmin/Sidebar');
	}
	public function Navbar()
	{
		$this->load->view('superadmin/Navbar');
	}
	public function Login()
	{
		$this->load->view('superadmin/Login');
	}
	public function SignUp()
	{
		$this->load->view('superadmin/SignUp');
	}

	public function Superadmin_profile()
	{
		$this->load->view('superadmin/Superadmin_profile');
	}
	public function FinanceManagement2()
	{
		$this->load->view('superadmin/FinanceManagement2');
	}




	public function change_password()
	{
		header('Content-Type: application/json');

		$userType = $this->input->post('userType');
		$username = $this->input->post('username');
		$currentPassword = $this->input->post('currentPassword');
		$newPassword = $this->input->post('newPassword');

		// Validate input
		if (empty($userType) || empty($username) || empty($currentPassword) || empty($newPassword)) {
			echo json_encode(['success' => false, 'message' => 'All fields are required']);
			return;
		}

		if (strlen($newPassword) < 8) {
			echo json_encode(['success' => false, 'message' => 'New password must be at least 8 characters']);
			return;
		}

		// Check user type and update accordingly
		if ($userType === 'superadmin') {
			// Verify current password for superadmin
			$this->db->where('username', $username);
			$this->db->where('role', 'superadmin');
			$user = $this->db->get('users')->row();

			if (!$user) {
				echo json_encode(['success' => false, 'message' => 'User not found']);
				return;
			}

			// Verify current password (assuming you're using password_hash with PASSWORD_DEFAULT)
			if (!password_verify($currentPassword, $user->password)) {
				echo json_encode(['success' => false, 'message' => 'Current password is incorrect']);
				return;
			}

			// Update password
			$hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
			$this->db->where('id', $user->id);
			$this->db->update('users', ['password' => $hashedPassword]);
		} elseif ($userType === 'admin') {
			// Verify current password for admin
			$this->db->where('name', $username); // Assuming center_details.name is the admin username
			$admin = $this->db->get('center_details')->row();

			if (!$admin) {
				echo json_encode(['success' => false, 'message' => 'Admin not found']);
				return;
			}

			// Verify current password
			if (!password_verify($currentPassword, $admin->password)) {
				echo json_encode(['success' => false, 'message' => 'Current password is incorrect']);
				return;
			}

			// Update password
			$hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
			$this->db->where('id', $admin->id);
			$this->db->update('center_details', ['password' => $hashedPassword]);
		} else {
			echo json_encode(['success' => false, 'message' => 'Invalid user type']);
			return;
		}

		echo json_encode(['success' => true, 'message' => 'Password changed successfully']);
	}
	public function CenterManagement()
	{
		$this->load->view('superadmin/CenterManagement');
	}
	public function CenterManagement2()
	{
		$this->load->view('superadmin/CenterManagement2');
	}
	public function New_admission()
	{
		$this->load->view('superadmin/New_admission');
	}
	public function receipt()
	{
		$this->load->view('superadmin/receipt');
	}
	public function Re_admission()
	{
		$this->load->view('superadmin/Re_admission');
	}
	// public function Students()
	// {
	// 	$this->load->view('superadmin/Students');
	// }
	// show students list
	public function Students()
	{
		$data['students'] = $this->Student_model->get_students();
		$this->load->view('superadmin/Students', $data);
	}

	// view student details
	// public function student_details($id)
	// {
	// 	$data['student'] = $this->Student_model->get_student_by_id($id);
	// 	$this->load->view('superadmin/StudentDetails', $data);
	// }
	public function Renew_admission()
	{
		$this->load->view('superadmin/Renew_admission');
	}
	public function View_Re_Admission()
	{
		$this->load->view('superadmin/View_Re_Admission');
	}
	public function View_Renew_Students()
	{
		$this->load->view('superadmin/View_Renew_Students');
	}
	public function EvenetList()
	{
		$this->load->view('superadmin/EvenetList');
	}
	public function Report()
	{
		$this->load->view('superadmin/Report');
	}

	public function Finance()
	{
		$this->load->view('superadmin/Finance');
	}
	// API endpoint for AJAX
	public function getRevenue()
	{
		$filters = [
			'center_id'   => $this->input->post("center_id"),
			'start_date'  => $this->input->post("start_date"),
			'end_date'    => $this->input->post("end_date"),
		];

		$data = $this->Finance_model->getCombinedRevenue($filters);

		echo json_encode([
			'status' => true,
			'data'   => $data
		]);
	}

	public function Expenses()
	{
		$this->load->model('Expense_model');
		$this->load->model('Center_model'); // ✅ Make sure this is loaded

		$data['expenses'] = $this->Expense_model->get_all_expenses();
		$data['centers']  = $this->Center_model->get_all_centers(); // ✅ Pass centers to view

		$this->load->view('superadmin/Expenses', $data);
	}


	public function EventAndNotice()
	{
		$this->load->model('Event_model');
		$data['events'] = $this->Event_model->get_all_events();
		$this->load->view('superadmin/EventAndNotice', $data);
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


	public function view_center_details()
	{
		$this->load->view('superadmin/view_center_details');
	}

	public function partcipant_form()
	{

		$this->load->view('superadmin/participant_form');
	}


	public function Permission()
	{
		$data['centers'] = $this->Center_model->get_all_centers();

		$modules = [
			// 			'center_mgmt' => 'Center Management',
			'admission' => 'Admission Management',
			'students' => 'Students Management',
			'events' => 'Event Management',
			'leave' => 'Leave Management',
			'expenses' => 'Expense Management',
			// 'finance' => 'Finance Management'
		];

		foreach ($data['centers'] as &$center) {
			$center['permissions'] = $this->Permission_model->get_by_center($center['id']);
		}


		$data['modules'] = $modules;
		$this->load->view('superadmin/Permission', $data);
	}

	// Save permissions from form
	public function save_permissions($center_id)
	{
		$posted = $this->input->post('permissions') ?? [];

		$modules = [
			// 			'center_mgmt',
			'admission',
			'students',
			'events',
			'leave',
			'expenses',
			// 'finance'

		];

		$final = [];
		foreach ($modules as $key) {
			$final[$key] = isset($posted[$key]) ? 1 : 0;
		}

		$this->Permission_model->save_permissions($center_id, $final);

		$this->session->set_flashdata('success', 'Permissions updated.');
		redirect('superadmin/Permission');
	}

	public function add_new_center()
	{
		$this->load->view('superadmin/add_new_center');
	}

	public function adminlogin()
	{
		$this->load->view('superadmin/adminlogin');
	}
	public function student_details($id = null)
	{
		if (!$id) {
			redirect('superadmin/students');
		}

		$data['student'] = $this->Student_model->get_student_by_id($id);

		if (!$data['student']) {
			$this->session->set_flashdata('error', 'Student not found.');
			redirect('superadmin/students');
		}

		$data['student_get_current_batch'] = $this->Student_model->get_student_by_id_batch($id);
		$data['student_history'] = $this->Student_model->get_student_by_id_history($id);
		$data['student_history_batch'] = $this->Student_model->get_student_by_id_history_batch($id);

		// Facilities
		$this->load->model('Facility_model');
		$data['facilities'] = $this->Facility_model->get_facilities_of_student($id);



		$data['facilities_history'] = $this->Facility_model->get_facilities_history_by_student($id);

		$data['student_attendace'] = $this->Student_model->get_student_attendace($id);

		$data['get_last_attendace'] = $this->Student_model->get_last_attendace($id);

		// ✅ Fetch coordinator (only one entry in coordinator table)
		$data['coordinator'] = $this->Student_model->get_coordinator();
		$data['get_overrall_attendance'] = $this->Student_model->get_overrall_attendance_of_std($id);


		$this->load->view('superadmin/student_details', $data);
	}
	public function student_details_269530($id = null)
	{
		if (!$id) {
			// if no student id is provided, redirect back to list
			redirect('superadmin/students');
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







		$data['student_attendace'] = $this->Student_model->get_student_attendace($id);

		// print_r($data['student_attendace'] );


		$data['get_overrall_attendance'] = $this->Student_model->get_overrall_attendance_of_std($id);




		$this->load->view('superadmin/student_details', $data);
	}
	public function ViewPassword()
	{
		$center_data = $this->db->get('center_details')->result_array();
		$user_data   = $this->db->get('users')->result_array();

		$data = [
			'page_title'  => 'View Passwords',
			'center_data' => $center_data,
			'user_data'   => $user_data
		];

		$this->load->view('superadmin/ViewPassword', $data);
	}
	public function overall_report()
	{
		$this->load->view('superadmin/overall_report');
	}
	public function VenueManagement()
	{
		$this->load->view('superadmin/venue_management');
	}
	public function VenueForm()
	{
		$this->load->view('superadmin/venue_form');
	}



	public function Attendance()
	{
		$this->load->view('superadmin/attendance');
	}
	// public function Add_NewStaff()
	// {
	// 	$this->load->view('superadmin/Add_NewStaff');

	// }
	// public function Add_NewStaff()
	// {
	// 	$data['venues'] = $this->StaffModel->getAllVenues();
	// 	$data['slots']  = $this->StaffModel->getAllSlots();
	// 	$this->load->view('superadmin/Add_NewStaff', $data);
	// }

	// public function saveStaff()
	// {
	// 	// Debug: check if POST is received
	// 	$name         = $this->input->post('name');
	// 	$email        = $this->input->post('email');
	// 	$contact      = $this->input->post('contact');
	// 	$joining_date = $this->input->post('joining_date');
	// 	$salary       = $this->input->post('salary');
	// 	$role         = $this->input->post('role');

	// 	$centers      = $this->input->post('centers');
	// 	$slots        = $this->input->post('slots');

	// 	$data = array(
	// 		'name'         => $name,
	// 		'email'        => $email,
	// 		'contact'      => $contact,
	// 		'joining_date' => $joining_date,
	// 		'salary'       => $salary,
	// 		'role'         => $role,
	// 		'centers'      => !empty($centers) ? implode(',', $centers) : '',
	// 		'slots'        => !empty($slots) ? implode(',', $slots) : ''
	// 	);

	// 	$insert = $this->StaffModel->insertStaff($data);

	// 	if ($insert) {
	// 		$this->session->set_flashdata('success', 'Staff added successfully!');
	// 	} else {
	// 		$this->session->set_flashdata('error', 'Failed to add staff.');
	// 	}

	// 	redirect('superadmin/Add_NewStaff');
	// }
	public function Add_NewStaff()
	{
		$data['venues'] = $this->StaffModel->getAllVenues();
		$data['slots'] = $this->StaffModel->getAllSlots();
		$data['staff'] = $this->StaffModel->getAllStaff(); // Get staff data
		$this->load->view('superadmin/Add_NewStaff', $data);
	}

	// public function saveStaff()
	// {

	// 	$name = $this->input->post('name');
	// 	$email = $this->input->post('email');
	// 	$contact = $this->input->post('contact');
	// 	$joining_date = $this->input->post('joining_date');
	// 	$salary = $this->input->post('salary');
	// 	$role = $this->input->post('role');
	// 	$centers = $this->input->post('centers');
	// 	$slots = $this->input->post('slots');

	// 	$data = array(
	// 		'name' => $name,
	// 		'email' => $email,
	// 		'contact' => $contact,
	// 		'joining_date' => $joining_date,
	// 		'salary' => $salary,
	// 		'role' => $role,
	// 		'centers' => !empty($centers) ? implode(',', $centers) : '',
	// 		'slots' => !empty($slots) ? implode(',', $slots) : ''
	// 	);

	// 	$insert = $this->StaffModel->insertStaff($data);


	// 	// if ($insert) {
	// 	// 	$this->session->set_flashdata('success', 'Staff added successfully!');
	// 	// } else {
	// 	// 	$this->session->set_flashdata('error', 'Failed to add staff.');
	// 	// }

	// 	// redirect('superadmin/Add_NewStaff');

	// 	if ($insert) {
	// 		$response = array('status' => 'success', 'message' => 'Staff added successfully!');
	// 	} else {
	// 		$response = array('status' => 'error', 'message' => 'Failed to add staff.');
	// 	}
	// }
	public function saveStaff()
	{
		$name = $this->input->post('name');
		$email = $this->input->post('email');
		$contact = $this->input->post('contact');
		$joining_date = $this->input->post('joining_date');
		$salary = $this->input->post('salary');
		$role = $this->input->post('role');
		$centers = $this->input->post('centers');
		$slots = $this->input->post('slots');

		$data = array(
			'name' => $name,
			'email' => $email,
			'contact' => $contact,
			'joining_date' => $joining_date,
			'salary' => $salary,
			'role' => $role,
			'centers' => !empty($centers) ? implode(',', $centers) : '',
			'slots' => !empty($slots) ? implode(',', $slots) : ''
		);

		$insert = $this->StaffModel->insertStaff($data);

		if ($insert) {
			$response = array('success' => true, 'message' => 'Staff added successfully!');
		} else {
			$response = array('success' => false, 'message' => 'Failed to add staff.');
		}

		// Return JSON response
		header('Content-Type: application/json');
		echo json_encode($response);
		exit; // Important to stop further output
	}
	public function updateStaff()
	{
		$id = $this->input->post('id');
		$data = [
			'name' => $this->input->post('name'),
			'email' => $this->input->post('email'),
			'contact' => $this->input->post('contact'),
			'joining_date' => $this->input->post('joining_date'),
			'salary' => $this->input->post('salary'),
			'role' => $this->input->post('role'),
			'centers' => $this->input->post('centers') ? implode(',', $this->input->post('centers')) : '',
			'slots' => $this->input->post('slots') ? implode(',', $this->input->post('slots')) : '',
		];

		$this->db->where('id', $id);
		if ($this->db->update('staff', $data)) {
			$this->session->set_flashdata('success', 'Staff updated successfully.');
		} else {
			$this->session->set_flashdata('error', 'Failed to update staff.');
		}
		redirect('superadmin/Add_NewStaff');
	}
	public function deleteStaff()
	{
		$this->load->model('StaffModel');

		$staff_id = $this->input->post('id');

		if ($this->StaffModel->deleteStaff($staff_id)) {
			echo json_encode(['success' => true, 'message' => 'Staff member deleted successfully']);
		} else {
			echo json_encode(['success' => false, 'message' => 'Failed to delete staff member']);
		}
	}


	public function Salary_Management()
	{
		$this->load->view('superadmin/Salary_Management');
	}

	public function Staff_manage()
	{
		$this->load->view('superadmin/Staff_manage');
	}

	public function Staff_detail($id = null)
	{
		$this->load->view('superadmin/Staff_detail');
	}
	public function FNew_Admission()
	{
		$this->load->view('superadmin/fNew_Admission');
	}
	public function FRenewNew_Admission()
	{
		$this->load->view('superadmin/fRenewNew_Admission');
	}
	public function ReAdd()
	{
		$this->load->view('superadmin/ReAdd');
	}
}
