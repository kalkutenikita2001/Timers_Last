<?php
// Updated Controller: Analytics.php (in CI3 controllers folder)

defined('BASEPATH') OR exit('No direct script access allowed');

class Analytics extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Analytics_model');
        $this->load->library('session');
        $this->load->helper('download');

        // Check if user is logged in (assume superadmin)
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 'superadmin') {
            redirect('login');
        }
    }

    // Get dashboard KPIs and charts data
    public function get_dashboard_data() {
        $data = [
            'total_revenue' => $this->Analytics_model->get_total_revenue(),
            'total_expenses' => $this->Analytics_model->get_total_expenses(),
            'total_students' => $this->Analytics_model->get_total_students(),
            'active_students' => $this->Analytics_model->get_active_students(),
            'total_batches' => $this->Analytics_model->get_total_batches(),
            'total_centers' => $this->Analytics_model->get_total_centers(),
            'total_staff' => $this->Analytics_model->get_total_staff(),
            'total_events' => $this->Analytics_model->get_total_events(),
            'monthly_revenue' => $this->Analytics_model->get_monthly_revenue(),
            'student_distribution' => $this->Analytics_model->get_student_distribution(),
            'revenue_vs_expense' => $this->Analytics_model->get_revenue_vs_expense(),
            'batch_distribution' => $this->Analytics_model->get_batch_distribution(),
            'staff_distribution' => $this->Analytics_model->get_staff_distribution(),
            'outstanding_fees' => $this->Analytics_model->get_outstanding_fees(),
            'event_fees' => $this->Analytics_model->get_event_fees(),
            'facility_revenue' => $this->Analytics_model->get_facility_revenue_sum(),
            'beginner_students' => $this->Analytics_model->get_beginner_students(),
            'intermediate_students' => $this->Analytics_model->get_intermediate_students(),
            'admins' => $this->Analytics_model->get_admins(),
            'coaches' => $this->Analytics_model->get_coaches(),
            'managers' => $this->Analytics_model->get_managers(),
            'total_participants' => $this->Analytics_model->get_total_participants(),
            'total_event_revenue' => $this->Analytics_model->get_total_event_revenue(),
            'upcoming_events' => $this->Analytics_model->get_upcoming_events()
        ];
        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    // Get paginated table data
    public function get_table_data() {
        $type = $this->input->get('type');
        $page = $this->input->get('page') ?: 1;
        $per_page = 10;
        $data = ['records' => [], 'total_records' => 0];

        switch ($type) {
            case 'facility_revenue':
                $data['records'] = $this->Analytics_model->get_facility_revenue_details($page, $per_page);
                $data['total_records'] = $this->Analytics_model->count_facilities();
                break;
            case 'event_revenue':
                $data['records'] = $this->Analytics_model->get_event_revenue_details($page, $per_page);
                $data['total_records'] = $this->Analytics_model->count_events();
                break;
            case 'student_fees':
                $data['records'] = $this->Analytics_model->get_student_fees_details($page, $per_page);
                $data['total_records'] = $this->Analytics_model->count_students();
                break;
            case 'expenses':
                $data['records'] = $this->Analytics_model->get_expenses_details($page, $per_page);
                $data['total_records'] = $this->Analytics_model->count_expenses();
                break;
            case 'students':
                $data['records'] = $this->Analytics_model->get_students_details($page, $per_page);
                $data['total_records'] = $this->Analytics_model->count_students();
                break;
            case 'staff':
                $data['records'] = $this->Analytics_model->get_staff_details($page, $per_page);
                $data['total_records'] = $this->Analytics_model->count_staff();
                break;
            case 'events':
                $data['records'] = $this->Analytics_model->get_events_details($page, $per_page);
                $data['total_records'] = $this->Analytics_model->count_events();
                break;
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    // Export CSV for a type
    public function export_csv() {
        $type = $this->input->get('type');
        $filename = ucfirst($type) . '_Report_' . date('Y-m-d') . '.csv';
        $header = [];
        $data = [];

        switch ($type) {
            case 'facility_revenue':
                $header = ['Facility ID', 'Center ID', 'Name', 'Subtype', 'Rent Amount', 'Rent Date'];
                $data = $this->Analytics_model->get_facility_revenue_details(); // All records
                break;
            case 'event_revenue':
                $header = ['Event ID', 'Name', 'Date', 'Fee', 'Participants', 'Total Revenue'];
                $data = $this->Analytics_model->get_event_revenue_details();
                break;
            case 'student_fees':
                $header = ['Student ID', 'Name', 'Center ID', 'Batch ID', 'Paid Amount', 'Remaining Amount'];
                $data = $this->Analytics_model->get_student_fees_details();
                break;
            case 'expenses':
                $header = ['ID', 'Center ID', 'Title', 'Date', 'Amount', 'Status'];
                $data = $this->Analytics_model->get_expenses_details();
                break;
            case 'students':
                $header = ['ID', 'Name', 'Center ID', 'Batch ID', 'Level', 'Status'];
                $data = $this->Analytics_model->get_students_details();
                break;
            case 'staff':
                $header = ['ID', 'Name', 'Center ID', 'Role', 'Joining Date'];
                $data = $this->Analytics_model->get_staff_details();
                break;
            case 'events':
                $header = ['ID', 'Name', 'Date', 'Fee', 'Max Participants', 'Venue'];
                $data = $this->Analytics_model->get_events_details();
                break;
        }

        $csv = implode(',', $header) . "\n";
        foreach ($data as $row) {
            $csv .= implode(',', array_map('strval', $row)) . "\n";
        }

        force_download($filename, $csv);
    }
}