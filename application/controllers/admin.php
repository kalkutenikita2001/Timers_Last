<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function Dashboard()
    {
        $this->load->view('admin/Dashboard');
    }
}
