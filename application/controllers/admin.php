<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class admin extends CI_Controller {

	public function Sidebar(){
		$this->load->view('admin/Sidebar');
	}
	public function Navbar(){
		$this->load->view('admin/Navbar');
	}
	public function Batch(){
		$this->load->view('admin/Batch');
	}
	public function EventAndNotice(){
		$this->load->view('admin/EventAndNotice');
	}
	public function Admission(){
		$this->load->view('admin/Admission');
	}
	public function IncomeAndExpenses(){
		$this->load->view('admin/IncomeAndExpenses');
	}
	public function Attendance(){
		$this->load->view('admin/Attendance');
	}
	public function Leave(){
		$this->load->view('admin/Leave');
	}
	public function Profile(){
		$this->load->view('admin/Profile');
	}
	public function Dashboard(){
		$this->load->view('admin/Dashboard');
	}
	public function venue(){
		$this->load->view('admin/venue');
	}
	
}