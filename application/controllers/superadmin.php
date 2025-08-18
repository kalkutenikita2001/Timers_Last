<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class superadmin extends CI_Controller {

	public function dashboard(){
		$this->load->view('superadmin/dashboard');
	}
	public function Sidebar(){
		$this->load->view('superadmin/Sidebar');
	}
	public function Navbar(){
		$this->load->view('superadmin/Navbar');
	}
	public function Login(){
		$this->load->view('superadmin/Login');
	}
public function SignUp(){
		$this->load->view('superadmin/SignUp');
	}
	public function Center(){
		$this->load->view('superadmin/Center');
	}
	public function Staff(){
		$this->load->view('superadmin/Staff');
	}
	public function Batch(){
		$this->load->view('superadmin/Batch');
	}
	public function EventAndNotice(){
		$this->load->view('superadmin/EventAndNotice');
	}
	public function Admission(){
		$this->load->view('superadmin/Admission');
	}
	public function Students(){
		$this->load->view('superadmin/Students');
	}
	public function Leave(){
		$this->load->view('superadmin/Leave');
	}
	public function Expenses(){
		$this->load->view('superadmin/Expenses');
	}
	public function Finance(){
		$this->load->view('superadmin/Finance');
	}
		public function Superadmin_profile(){
		$this->load->view('superadmin/Superadmin_profile');
	}
}