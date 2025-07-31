<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class base extends CI_Controller {

	public function login(){
		$this->load->view('base/login');
	}
	public function adminlogin(){
		$this->load->view('base/adminlogin');
	}
	public function superadminlogin(){
		$this->load->view('base/superadminlogin');
	}
}