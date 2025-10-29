<?php defined('BASEPATH') or exit('No direct script access allowed');

class DashboardModel extends CI_Model
{
    /**
     * Central table & column mappings.
     * Edit ONLY this section when your DB changes.
     *
     * Logical names used by methods:
     *  - students
     *  - attendance
     *  - centers
     *
     * NOTE: In your DB snapshot I saw "venues" (id, venue_name).
     * The mapping below maps logical "centers" -> actual table "venues".
     */
    protected $T = [
        'students'   => 'students',
        'attendance' => 'attendance',
        'centers'    => 'venues'   // change to 'center_details' if you actually have that table
    ];

    protected $C = [
        'students' => [
            'id'                        => 'id',
            'name'                      => 'name',
            'contact'                   => 'contact',
            'parent_name'               => 'parent_name',
            'batch_id'                  => 'batch_id',
            'student_progress_category' => 'student_progress_category',
            'paid_amount'               => 'paid_amount',
            'remaining_amount'          => 'remaining_amount',
            'status'                    => 'status',
            'last_attendance'           => 'last_attendance',
            'center_id'                 => 'center_id',
            'created_at'                => 'created_at',
            'admission_date'            => 'admission_date',
            'joining_date'              => 'joining_date'
        ],
        'attendance' => [
            'id'            => 'id',
            'student_id'    => 'staff_id', // your attendance sample uses staff_id; but controller expects student_id - we will support mapping here
            // NOTE: In your attendance dump I see staff_id — if that column actually stores student id, keep it.
            // If attendance.student_id is named differently, change this mapping to the correct column (e.g. 'student_id' => 'student_id').
            'date'          => 'date',
            'time'          => 'check_in_time', // use check_in_time as attendance time
            'created_at'    => 'check_in_at',   // fallback created_at-like field
            'present'       => 'present'        // numeric 1/0 for present
        ],
        'centers' => [
            'id'   => 'id',
            'name' => 'venue_name' // venues.venue_name -> aliased to name in getCenters()
        ]
    ];

    public function __construct()
    {
        parent::__construct();
    }

       // helpers to get table/column names (public so controller can use them)
    public function t($logical) {
        return isset($this->T[$logical]) ? $this->T[$logical] : $logical;
    }

    public function c($logical_table, $col_key) {
        return $this->C[$logical_table][$col_key] ?? $col_key;
    }


    // Get Active Students Count
    public function getActiveStudentsCount()
    {
        $tbl = $this->t('students');
        $statusCol = $this->c('students', 'status');
        return (int) $this->db
            ->where($statusCol, 'Active')
            ->count_all_results($tbl);
    }

    public function getTotalStudentsCount()
    {
        return (int) $this->db->count_all($this->t('students'));
    }

    public function getTotalIncome()
    {
        $tbl = $this->t('students');
        $col = $this->c('students','paid_amount');

        $query = $this->db->select_sum($col)->get($tbl);
        $row = $query->row();
        return isset($row->{$col}) ? floatval($row->{$col}) : 0.0;
    }

    public function getTotalDueAmount()
    {
        $tbl = $this->t('students');
        $col = $this->c('students','remaining_amount');

        $query = $this->db->select_sum($col)->get($tbl);
        $row = $query->row();
        return isset($row->{$col}) ? floatval($row->{$col}) : 0.0;
    }

    public function getStudentDistribution()
    {
        $tbl = $this->t('students');
        $catCol = $this->c('students','student_progress_category');

        $query = $this->db
            ->select("$catCol as cat, COUNT(*) as count", false)
            ->from($tbl)
            ->group_by($catCol)
            ->get();

        $distribution = [
            'Beginner'     => 0,
            'Intermediate' => 0,
            'Advanced'     => 0
        ];

        foreach ($query->result_array() as $row) {
            $cat = $row['cat'] ?? null;
            if ($cat && isset($distribution[$cat])) {
                $distribution[$cat] = (int)$row['count'];
            }
        }
        return $distribution;
    }

    // sum of paid_amount grouped by month (YYYY-MM)
    public function getMonthlyRevenue()
    {
        $tbl = $this->t('students');
        // choose a date column that exists in your students table
        $dateCol = $this->c('students', 'admission_date');
        $paidCol = $this->c('students', 'paid_amount');

        // If admission_date can be NULL, the SQL will group by NULL-months -> ok but will produce fewer rows.
        $query = $this->db
            ->select("DATE_FORMAT($dateCol, '%Y-%m') as month, SUM($paidCol) as revenue", false)
            ->from($tbl)
            ->group_by("DATE_FORMAT($dateCol, '%Y-%m')")
            ->order_by("month", "ASC")
            ->get();

        return $query->result_array();
    }

    /**
     * Returns centers list as objects with id & name (so view keeps $c->id / $c->name)
     */
    public function getCenters()
    {
        $tbl = $this->t('centers');
        $idCol = $this->c('centers','id');
        $nameCol = $this->c('centers','name');

        $query = $this->db->select("$idCol as id, $nameCol as name", false)
            ->from($tbl)
            ->order_by($nameCol, 'ASC')
            ->get();

        return $query->result();
    }

    /**
     * Get weekly attendance counts for the last 7 days (Mon..Sun)
     * Returns numeric array [Mon, Tue, Wed, Thu, Fri, Sat, Sun]
     *
     * @param int|null $center_id
     * @return array
     */
    public function getWeeklyAttendance($center_id = null)
    {
        $attTbl = $this->t('attendance');
        $attDateCol = $this->c('attendance','date');
        $attCreated = $this->c('attendance','created_at');
        $attStudentId = $this->c('attendance','student_id'); // mapping currently set to 'staff_id' - adjust if necessary
        $attTimeCol = $this->c('attendance','time');
        $attPresent = $this->c('attendance','present');

        // Build date window: from 6 days ago to today inclusive
        $days = [];
        for ($i = 6; $i >= 0; $i--) {
            $days[] = date('Y-m-d', strtotime("-{$i} days"));
        }
        $startDate = $days[0];

        $this->db->reset_query();
        $this->db->select("DATE(COALESCE($attTbl.$attDateCol, $attTbl.$attCreated)) as att_date, COUNT(DISTINCT $attTbl.$attStudentId) as cnt", false);
        $this->db->from($attTbl);
        $this->db->where("DATE(COALESCE($attTbl.$attDateCol, $attTbl.$attCreated)) >= ", $startDate);
        // treat present=1 as present
        $this->db->where("$attTbl.$attPresent", 1);

        if (!empty($center_id) && is_numeric($center_id)) {
            $stuTbl = $this->t('students');
            $stuIdCol = $this->c('students','id');
            $stuCenterCol = $this->c('students','center_id');
            // join students to filter by center
            $this->db->join("$stuTbl", "$stuTbl.$stuIdCol = $attTbl.$attStudentId", 'inner');
            $this->db->where("$stuTbl.$stuCenterCol", (int)$center_id);
        }

        $this->db->group_by('att_date');
        $this->db->order_by('att_date','ASC');

        $q = $this->db->get();
        if ($q === false) {
            return array_fill(0,7,0);
        }

        $rows = $q->result_array();
        $map = [];
        foreach ($rows as $r) {
            $map[$r['att_date']] = (int)$r['cnt'];
        }

        // Build Mon..Sun array
        $weekOrdered = array_fill(0,7,0);
        foreach ($days as $d) {
            $weekdayN = (int)date('N', strtotime($d)); // 1..7
            $idx = $weekdayN - 1; // 0..6
            $weekOrdered[$idx] = isset($map[$d]) ? $map[$d] : 0;
        }

        return $weekOrdered;
    }

    /**
     * Get students matching a filter and optional center.
     * Returns same fields as original code expected.
     */
    public function getStudentsByFilter($filter = 'all', $center_id = null)
    {
        $tbl = $this->t('students');

        $selectCols = [
            $this->c('students','id') . ' AS id',
            $this->c('students','name') . ' AS name',
            $this->c('students','contact') . ' AS contact',
            $this->c('students','parent_name') . ' AS parent_name',
            $this->c('students','batch_id') . ' AS batch_id',
            $this->c('students','student_progress_category') . ' AS student_progress_category',
            $this->c('students','paid_amount') . ' AS paid_amount',
            $this->c('students','remaining_amount') . ' AS remaining_amount',
            $this->c('students','status') . ' AS status',
            $this->c('students','last_attendance') . ' AS last_attendance',
            $this->c('students','admission_date') . ' AS admission_date'
        ];

        $this->db->reset_query();
        $this->db->select(implode(', ', $selectCols), false);
        $this->db->from($tbl);

        if (!empty($center_id)) {
            $this->db->where($this->c('students','center_id'), (int)$center_id);
        }

        switch ($filter) {
            case 'active':
                $this->db->where($this->c('students','status'), 'Active');
                break;

            case 'attendance':
                // join attendance and filter last 7 days presence
                $attTbl = $this->t('attendance');
                $attDateCol = $this->c('attendance','date');
                $attCreated = $this->c('attendance','created_at');
                $attStudentId = $this->c('attendance','student_id');
                $attPresent = $this->c('attendance','present');

                $this->db->join($attTbl, "{$attTbl}.{$attStudentId} = {$tbl}.{$this->c('students','id')}", 'inner');
                $seven_days_ago = date('Y-m-d', strtotime('-6 days'));
                $this->db->where("DATE(COALESCE($attTbl.$attDateCol, $attTbl.$attCreated)) >= ", $seven_days_ago);
                $this->db->where("$attTbl.$attPresent", 1);
                $this->db->group_by($tbl . '.' . $this->c('students','id'));
                break;

            case 'due':
                $this->db->where($this->c('students','remaining_amount') . ' >', 0);
                break;

            case 'paid':
                $this->db->where($this->c('students','paid_amount') . ' >', 0);
                break;

            case 'all':
            default:
                // no extra where
                break;
        }

        $this->db->order_by($this->c('students','name'), 'ASC');

        $query = $this->db->get();
        return $query->result_array();
    }
}
