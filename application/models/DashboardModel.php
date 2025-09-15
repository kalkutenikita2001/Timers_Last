<?php defined('BASEPATH') or exit('No direct script access allowed');

class DashboardModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    // Get Active Students Count
    public function getActiveStudentsCount()
    {
        return $this->db
            ->where('status', 'Active') // makes it case-insensitive
            ->count_all_results('students');
    }
    public function getTotalStudentsCount()
    {
        return $this->db->count_all('students');
    }
    public function getTotalIncome()
    {
        return $this->db
            ->select_sum('paid_amount')
            ->get('students')
            ->row()
            ->paid_amount ?? 0;
    }
    public function getTotalDueAmount()
    {
        return $this->db
            ->select_sum('remaining_amount')
            ->get('students')
            ->row()
            ->remaining_amount ?? 0;
    }
    public function getStudentDistribution()
    {
        $query = $this->db
            ->select('student_progress_category, COUNT(*) as count')
            ->from('students')
            ->group_by('student_progress_category')
            ->get();

        $result = $query->result_array();

        $distribution = [
            'Beginner'     => 0,
            'Intermediate' => 0,
            'Advanced'     => 0
        ];

        foreach ($result as $row) {
            if (isset($distribution[$row['student_progress_category']])) {
                $distribution[$row['student_progress_category']] = (int)$row['count'];
            }
        }

        return $distribution;
    }


    //sum of paid_amount grouped by month
    public function getMonthlyRevenue()
    {
        $query = $this->db->select("DATE_FORMAT(admission_date, '%Y-%m') as month, SUM(paid_amount) as revenue")
            ->from('students')
            ->group_by("DATE_FORMAT(admission_date, '%Y-%m')")
            ->order_by("month", "ASC")
            ->get();

        return $query->result_array();
    }
}
