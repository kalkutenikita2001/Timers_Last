<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DashboardController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('DashboardModel');
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
}
