<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Student_model');

        // Run auto activation on every request
        $updated = $this->Student_model->activate_students_for_today();
        log_message('info', "Global auto activation ran, $updated students updated.");
    }
}
