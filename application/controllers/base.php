<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class base extends CI_Controller {

	public function adminlogin(){
		$this->load->view('base/adminlogin');
	}
	public function superadminlogin(){
		$this->load->view('base/superadminlogin');
	}
}