<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DashboardController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('DashboardModel');
        // optionally: $this->load->helper('url'); if not already autoloaded
    }

    /**
     * Loads the dashboard view and passes centers and stats.
     */
    public function dashboard()
    {
        // existing stats (keeps backward compatibility)
        $data['activeStudents']  = $this->DashboardModel->getActiveStudentsCount();
        $data['totalStudents']   = $this->DashboardModel->getTotalStudentsCount();
        $data['totalIncome']     = $this->DashboardModel->getTotalIncome();
        $data['totalDue']        = $this->DashboardModel->getTotalDueAmount();
        $data['studentDistribution'] = $this->DashboardModel->getStudentDistribution();
        $data['monthlyRevenue']  = $this->DashboardModel->getMonthlyRevenue();

        // Add attendanceRate (fallback) so view variable exists
        $statsAll = $this->DashboardModel->getCenterStats(null);
        $data['attendanceRate'] = isset($statsAll['attendance_rate']) ? $statsAll['attendance_rate'] : 0;

        // Load centers so view shows center buttons
        $data['centers'] = $this->DashboardModel->getCenters();

        // Load dashboard view
        $this->load->view('superadmin/dashboard', $data);
    }

    /**
     * AJAX endpoint: returns JSON stats for a given center_id (or for all centers when omitted).
     * GET param: center_id (optional)
     * Example URL: /dashboard/center_stats?center_id=21
     */
    public function center_stats()
    {
        $center_id = $this->input->get('center_id', true);

        if ($center_id === '') {
            $center_id = null;
        }

        $stats = $this->DashboardModel->getCenterStats($center_id);

        $output = array(
            'status' => 'success',
            'data' => array(
                'total_students'  => (int)($stats['total_students'] ?? 0),
                'active_students' => (int)($stats['active_students'] ?? 0),
                'attendance_rate' => is_numeric($stats['attendance_rate']) ? (float)$stats['attendance_rate'] : 0.0,
                'total_due'       => (float)($stats['total_due'] ?? 0.0),
                'total_paid'      => (float)($stats['total_paid'] ?? 0.0),
            )
        );

        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($output));
    }

    /**
     * AJAX endpoint: returns JSON list of student rows for the requested filter and center.
     * GET params:
     *  - filter: 'active' | 'attendance' | 'due' | 'paid' | 'all' (default 'all')
     *  - center_id: optional center id
     *
     * Example: /dashboard/students_list?filter=active&center_id=21
     */
    public function students_list()
    {
        $filter = $this->input->get('filter', true) ?? 'all';
        $center_id = $this->input->get('center_id', true);

        if ($center_id === '') $center_id = null;

        // sanitize filter - allow only expected values
        $allowed = ['active', 'attendance', 'due', 'paid', 'all'];
        if (!in_array($filter, $allowed)) $filter = 'all';

        $rows = $this->DashboardModel->getStudentsByFilter($filter, $center_id);

        $output = array(
            'status' => 'success',
            'data' => $rows
        );

        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($output));
    }
}
