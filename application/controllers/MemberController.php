<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MemberController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function registerMember() {
        $post = json_decode(file_get_contents('php://input'), true);
        if (!$post) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
            return;
        }

        // ✅ Step 1: Insert personal details
        $memberData = [
            'name' => $post['name'],
            'gender' => $post['gender'],
            'email' => $post['email'],
            'phone' => $post['phone'],
            'dob' => $post['dob'],
            'blood_group' => $post['blood_group'],
            'address' => $post['address'],
            'alt_phone' => $post['alt_phone'],
            'joining_date' => $post['joining_date'],
            'document_path' => $post['document_path']
        ];
        $this->db->insert('members', $memberData);
        $memberId = $this->db->insert_id();

        // ✅ Step 2: Subscription (court/slot/plan)
        $subscription = [
            'member_id' => $memberId,
            'venue_id' => $post['venue_id'],
            'court_id' => $post['court_id'],
            'slot_id' => $post['slot_id'],
            'plan_start_date' => $post['plan_start_date'],
            'plan_end_date' => $post['plan_end_date']
        ];
        $this->db->insert('member_subscription', $subscription);

        // ✅ Step 3: Facilities (multiple)
        if (!empty($post['facilities'])) {
            foreach ($post['facilities'] as $facility) {
                $facilityData = [
                    'member_id' => $memberId,
                    'facility_id' => $facility['id'],
                    'facility_start_date' => $facility['start_date'],
                    'facility_end_date' => $facility['end_date'],
                    'rent' => $facility['rent']
                ];
                $this->db->insert('member_facilities', $facilityData);
            }
        }

        // ✅ Step 4: Payment info
        $paymentData = [
            'member_id' => $memberId,
            'invoice_id' => $post['invoice_id'],
            'invoice_date' => $post['invoice_date'],
            'discount_percent' => $post['discount_percent'],
            'payment_type' => $post['payment_type'],
            'total_amount' => $post['total_amount']
        ];
        $this->db->insert('member_payments', $paymentData);

        echo json_encode(['status' => 'success', 'member_id' => $memberId]);
    }
}
