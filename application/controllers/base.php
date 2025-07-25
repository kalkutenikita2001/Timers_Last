<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class base extends CI_Controller {

	public function login(){
		$this->load->view('base/login');
	}
}