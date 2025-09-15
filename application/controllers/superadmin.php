<?php
defined('BASEPATH') or exit('No direct script access allowed');

class superadmin extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('DashboardModel');
		$this->load->model('Student_model'); // Load the Student_model
		$this->load->model('Finance_model');
	}

	public function dashboard()
	{
		$data['activeStudents']  = $this->DashboardModel->getActiveStudentsCount();
		$data['totalStudents']   = $this->DashboardModel->getTotalStudentsCount();
		$data['totalIncome']     = $this->DashboardModel->getTotalIncome();
		$data['totalDue']        = $this->DashboardModel->getTotalDueAmount();
		$data['studentDistribution'] = $this->DashboardModel->getStudentDistribution();
		$data['monthlyRevenue']  = $this->DashboardModel->getMonthlyRevenue();

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
		$data['students'] = $this->Student_model->get_all_students();
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

		$this->load->view('superadmin/Permission');
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
			// if no student id is provided, redirect back to list
			redirect('superadmin/students');
		}

		$data['student'] = $this->Student_model->get_student_by_id($id);

		if (!$data['student']) {
			// if student not found, you can also redirect or show error
			$this->session->set_flashdata('error', 'Student not found.');
			redirect('superadmin/students');
		}
		// Load facilities
		$this->load->model('Facility_model');
		$data['facilities'] = $this->Facility_model->get_facilities_by_student($id);


		$this->load->view('superadmin/student_details', $data);
	}
}
