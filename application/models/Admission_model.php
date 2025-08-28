<?php
class Admission_model extends CI_Model {
    public function __construct() {
        parent::__construct();
    }

    public function get_all_centers() {
        return $this->db->get('centers')->result_array();
    }

    public function get_batches_by_center($center_id) {
        $this->db->select('id, timing, category, start_date');
        $this->db->where('center_id', $center_id);
        $batches = $this->db->get('batches')->result_array();
        
        foreach ($batches as &$batch) {
            $batch['days'] = $this->get_batch_days($batch['id']);
        }
        
        return $batches;
    }

    public function get_lockers_by_center($center_id) {
        $this->db->select('locker_no, rent as price, IFNULL((SELECT COUNT(*) FROM student_facilities sf WHERE sf.details LIKE CONCAT("%Locker No: ", f.locker_no, "%") AND sf.facility_name = "Locker"), 0) as is_booked');
        $this->db->from('facilities f');
        $this->db->where('f.center_id', $center_id);
        $this->db->where('f.type', 'locker');
        return $this->db->get()->result_array();
    }

    public function get_students() {
        $this->db->select('s.*, c.name as center_name, b.timing as batch_timing');
        $this->db->from('students s');
        $this->db->join('centers c', 's.center_id = c.id', 'left');
        $this->db->join('batches b', 's.batch_id = b.id', 'left');
        return $this->db->get()->result_array();
    }

    public function get_deactivated_students() {
        $this->db->select('s.*, c.name as center_name, b.timing as batch_timing, b.category as batch_category');
        $this->db->select('(SELECT GROUP_CONCAT(facility_name) FROM student_facilities sf WHERE sf.student_id = s.id) as facilities');
        $this->db->from('students s');
        $this->db->join('centers c', 's.center_id = c.id', 'left');
        $this->db->join('batches b', 's.batch_id = b.id', 'left');
        $this->db->where('DATE_ADD(s.joining_date, INTERVAL s.duration MONTH) < NOW()');
        return $this->db->get()->result_array();
    }

  public function get_student_by_id($student_id) {
    if (!is_numeric($student_id) || $student_id <= 0) {
        log_message('error', 'Invalid student ID provided: ' . $student_id);
        return null;
    }
    $this->db->select('s.*, c.name as center_name, b.timing as batch_timing, b.category as batch_category');
    $this->db->from('students s');
    $this->db->join('centers c', 's.center_id = c.id', 'left');
    $this->db->join('batches b', 's.batch_id = b.id', 'left');
    $this->db->where('s.id', $student_id);
    $student = $this->db->get()->row_array();

    if ($student) {
        $this->db->select('facility_name as name, details, amount');
        $this->db->from('student_facilities');
        $this->db->where('student_id', $student_id);
        $student['facilities'] = $this->db->get()->result_array();
    } else {
        log_message('error', 'No student found for ID: ' . $student_id);
    }

    return $student;
}

    private function get_batch_days($batch_id) {
        // Placeholder: Replace with actual logic to fetch days
        return 'Monday,Wednesday,Friday';
    }

    public function save_admission($data) {
        $this->db->trans_start();

        // Insert student data
        $student_data = array(
            'name' => $data['studentName'],
            'contact' => $data['contact'],
            'parent_name' => $data['parentName'],
            'emergency_contact' => $data['emergencyContact'],
            'email' => $data['email'],
            'dob' => $data['dob'],
            'address' => $data['address'],
            'center_id' => $data['center'],
            'batch_id' => $data['batch'],
            'category' => $data['category'],
            'coach' => $data['coach'],
            'coordinator' => $data['coordinator'],
            'coordinator_phone' => $data['coordinatorPhone'],
            'batch_time' => $data['batchTime'],
            'duration' => $data['duration'],
            'course_fees' => $data['courseFees'],
            'additional_fees' => $data['additionalFees'],
            'total_fees' => $data['totalFees'],
            'paid_amount' => $data['paidAmount'],
            'remaining_amount' => $data['remainingAmount'],
            'payment_method' => $data['paymentMethod'],
            'admission_date' => $data['admissionDate'],
            'joining_date' => $data['joiningDate'],
            'created_at' => date('Y-m-d H:i:s')
        );

        $this->db->insert('students', $student_data);
        $student_id = $this->db->insert_id();

        // Insert selected facilities
        if (!empty($data['facilities'])) {
            foreach ($data['facilities'] as $facility) {
                $facility_data = array(
                    'student_id' => $student_id,
                    'facility_name' => $facility['name'],
                    'details' => $facility['details'],
                    'amount' => $facility['amount'],
                    'created_at' => date('Y-m-d H:i:s')
                );
                $this->db->insert('student_facilities', $facility_data);
            }
        }

        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            return false;
        }
        return $student_id;
    }
}
?>