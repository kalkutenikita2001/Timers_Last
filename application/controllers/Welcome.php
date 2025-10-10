<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
{
	 public function __construct() {
        parent::__construct();
        $this->load->model('Student_model');
        $this->run_daily_activation();
    }
private function run_daily_activation() {
    $last_run_file = FCPATH . 'last_activation.txt';
    $today = date('Y-m-d');

    // Commenting time check for debugging
    // $current_time = date('H:i');
    // if ($current_time < '00:01') return;

    if (file_exists($last_run_file)) {
        $last_run = file_get_contents($last_run_file);
        if ($last_run == $today) return;
    }

    $updated = $this->Student_model->activate_students_for_today();

    file_put_contents($last_run_file, $today);

    log_message('info', "Daily activation run: $updated students activated on $today.");
}
public function test_activation()
{
    $this->load->model('Student_model');
    $updated = $this->Student_model->activate_students_for_today();
    echo "activate_students_for_today() returned: $updated";
}

	public function index()
	{
		$this->load->view('welcome_message');
	}
}
