<?php
// Updated Model: Analytics_model.php (in CI3 models folder)
// No new table needed, reuse existing tables with optimized queries

defined('BASEPATH') OR exit('No direct script access allowed');

class Analytics_model extends CI_Model {

    public function get_total_revenue() {
        $query = $this->db->select_sum('rent_amount')->get('facilities');
        return (float) $query->row()->rent_amount;
    }

    public function get_total_expenses() {
        $query = $this->db->select_sum('amount')->where('status', 'approved')->get('expenses');
        return (float) $query->row()->amount;
    }

    public function get_total_students() {
        return $this->db->count_all('students');
    }

    public function get_active_students() {
        return $this->db->where('status', 'Active')->count_all_results('students');
    }

    public function get_total_batches() {
        return $this->db->count_all('batches');
    }

    public function get_total_centers() {
        return $this->db->count_all('center_details');
    }

    public function get_total_staff() {
        return $this->db->count_all('staff');
    }

    public function get_total_events() {
        return $this->db->count_all('events');
    }

    public function get_monthly_revenue() {
        return $this->db->select("DATE_FORMAT(rent_date, '%b %Y') as label, SUM(rent_amount) as value")
                        ->group_by("DATE_FORMAT(rent_date, '%b %Y')")
                        ->order_by('rent_date')
                        ->get('facilities')
                        ->result_array();
    }

    public function get_student_distribution() {
        return $this->db->select("student_progress_category as label, COUNT(*) as value")
                        ->group_by('student_progress_category')
                        ->get('students')
                        ->result_array();
    }

    public function get_revenue_vs_expense() {
        $revenue = $this->db->select("DATE_FORMAT(rent_date, '%b %Y') as label, SUM(rent_amount) as value")
                            ->group_by("DATE_FORMAT(rent_date, '%b %Y')")
                            ->order_by('rent_date')
                            ->get('facilities')
                            ->result_array();

        $expense = $this->db->select("DATE_FORMAT(date, '%b %Y') as label, SUM(amount) as value")
                            ->where('status', 'approved')
                            ->group_by("DATE_FORMAT(date, '%b %Y')")
                            ->order_by('date')
                            ->get('expenses')
                            ->result_array();

        return ['revenue' => $revenue, 'expense' => $expense];
    }

    public function get_batch_distribution() {
        return $this->db->select("batch_level as label, COUNT(*) as value")
                        ->group_by('batch_level')
                        ->get('batches')
                        ->result_array();
    }

    public function get_staff_distribution() {
        return $this->db->select("role as label, COUNT(*) as value")
                        ->group_by('role')
                        ->get('staff')
                        ->result_array();
    }

    public function get_outstanding_fees() {
        $query = $this->db->select_sum('remaining_amount')->get('students');
        return (float) $query->row()->remaining_amount;
    }

    public function get_event_fees() {
        return (float) $this->db->select("SUM(p.id * e.fee) as total")
                               ->from('events e')
                               ->join('participants p', 'e.id = p.event_id', 'left')
                               ->get()
                               ->row()->total;
    }

    public function get_facility_revenue_sum() {
        return $this->get_total_revenue();
    }

    public function get_beginner_students() {
        return $this->db->where('student_progress_category', 'Beginner')->count_all_results('students');
    }

    public function get_intermediate_students() {
        return $this->db->where('student_progress_category', 'Intermediate')->count_all_results('students');
    }

    public function get_admins() {
        return $this->db->where('role', 'admin')->count_all_results('staff');
    }

    public function get_coaches() {
        return $this->db->where('role', 'coach')->count_all_results('staff');
    }

    public function get_managers() {
        return $this->db->where('role', 'manager')->count_all_results('staff');
    }

    public function get_total_participants() {
        return $this->db->count_all('participants');
    }

    public function get_total_event_revenue() {
        return $this->get_event_fees();
    }

    public function get_upcoming_events() {
        return $this->db->where('date >', date('Y-m-d'))->count_all_results('events');
    }

    // Paginated details

    public function get_facility_revenue_details($page = null, $per_page = null) {
        if ($page && $per_page) {
            $this->db->limit($per_page, ($page - 1) * $per_page);
        }
        return $this->db->select('id, center_id, facility_name, subtype_name, rent_amount, rent_date')
                        ->order_by('id', 'DESC')
                        ->get('facilities')
                        ->result_array();
    }

    public function count_facilities() {
        return $this->db->count_all('facilities');
    }

    public function get_event_revenue_details($page = null, $per_page = null) {
        $this->db->select('e.id, e.name, e.date, e.fee, COUNT(p.id) as participants, (COUNT(p.id) * e.fee) as total_revenue');
        $this->db->from('events e');
        $this->db->join('participants p', 'e.id = p.event_id', 'left');
        $this->db->group_by('e.id');
        $this->db->order_by('e.id', 'DESC');
        if ($page && $per_page) {
            $this->db->limit($per_page, ($page - 1) * $per_page);
        }
        return $this->db->get()->result_array();
    }

    public function count_events() {
        return $this->db->count_all('events');
    }

    public function get_student_fees_details($page = null, $per_page = null) {
        if ($page && $per_page) {
            $this->db->limit($per_page, ($page - 1) * $per_page);
        }
        return $this->db->select('id, name, center_id, batch_id, paid_amount, remaining_amount')
                        ->order_by('id', 'DESC')
                        ->get('students')
                        ->result_array();
    }

    public function get_expenses_details($page = null, $per_page = null) {
        $this->db->where('status', 'approved');
        if ($page && $per_page) {
            $this->db->limit($per_page, ($page - 1) * $per_page);
        }
        return $this->db->select('id, center_id, title, date, amount, status')
                        ->order_by('id', 'DESC')
                        ->get('expenses')
                        ->result_array();
    }

    public function count_expenses() {
        return $this->db->where('status', 'approved')->count_all_results('expenses');
    }

    public function get_students_details($page = null, $per_page = null) {
        if ($page && $per_page) {
            $this->db->limit($per_page, ($page - 1) * $per_page);
        }
        return $this->db->select('id, name, center_id, batch_id, student_progress_category, status')
                        ->order_by('id', 'DESC')
                        ->get('students')
                        ->result_array();
    }

    public function get_staff_details($page = null, $per_page = null) {
        if ($page && $per_page) {
            $this->db->limit($per_page, ($page - 1) * $per_page);
        }
        return $this->db->select('id, staff_name as name, center_id, role, joining_date')
                        ->order_by('id', 'DESC')
                        ->get('staff')
                        ->result_array();
    }

    public function count_staff() {
        return $this->db->count_all('staff');
    }

    public function get_events_details($page = null, $per_page = null) {
        if ($page && $per_page) {
            $this->db->limit($per_page, ($page - 1) * $per_page);
        }
        return $this->db->select('id, name, date, fee, max_participants, venue')
                        ->order_by('id', 'DESC')
                        ->get('events')
                        ->result_array();
    }
}