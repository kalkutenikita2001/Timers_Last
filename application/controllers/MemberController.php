<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MemberController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
public function registerMember()
{
    $post = json_decode(file_get_contents('php://input'), true);
    if (!$post) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
        return;
    }

    $this->db->trans_start();

    // 🟢 Ensure group flag is checked safely
    if (isset($post['group']) && $post['group'] == true && !empty($post['members'])) {
        $groupId = $post['group_id'] ?? 'GRP-' . time(); // fallback if not sent

        // 🟢 Insert subscription
        $subscription = [
            'venue_id' => $post['venue_id'],
            'court_id' => $post['court_id'],
            'slot_id' => $post['slot_id'],
            'plan_start_date' => $post['plan_start_date'],
            'plan_end_date' => $post['plan_end_date']
        ];
        $this->db->insert('member_subscription', $subscription);
        $subscriptionId = $this->db->insert_id();

        foreach ($post['members'] as $m) {
            $memberData = [
                'group_id' => $groupId,
                'name' => $m['name'],
                'gender' => $m['gender'],
                'email' => $m['email'],
                'phone' => $m['phone'],
                'dob' => $m['dob'],
                'blood_group' => $m['blood_group'],
                'address' => $m['address'],
                'joining_date' => date('Y-m-d')
            ];
            $this->db->insert('members', $memberData);
            $memberId = $this->db->insert_id();

           

            // 🟢 Facilities
            if (!empty($m['facilities'])) {
                foreach ($m['facilities'] as $f) {
                    $this->db->insert('member_facilities', [
                        'member_id' => $memberId,
                        'facility_id' => $f['id'],
                        'facility_start_date' => $f['start_date'] ?? null,
                        'facility_end_date' => $f['end_date'] ?? null,
                        'rent' => $f['rent'] ?? 0
                    ]);
                }
            }
        }

        // 🟢 Payment
        $this->db->insert('member_payments', [
            'invoice_id' => $post['invoice_id'],
            'invoice_date' => $post['invoice_date'],
            'discount_percent' => $post['discount_percent'] ?? 0,
            'payment_type' => $post['payment_type'],
            'total_amount' => $post['total_amount'],
            'group_id' => $groupId
        ]);

        $this->db->trans_complete();
        echo json_encode(['status' => 'success', 'group_id' => $groupId]);
    } else {
        // Handle individual case...
    }
}

  public function registerMemberold() {
    $post = json_decode(file_get_contents('php://input'), true);
    if (!$post) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
        return;
    }

    $this->db->trans_start();

    if (!empty($post['group']) && !empty($post['members'])) {
        $groupId = $post['group_id'];
        $planFeesPerMember = $post['plan_fees_per_member'];
        $totalPlanFees = $post['total_plan_fees'];

        // Insert subscription once for group
        $subscription = [
            'venue_id' => $post['venue_id'],
            'court_id' => $post['court_id'],
            'slot_id' => $post['slot_id'],
            'plan_start_date' => $post['plan_start_date'],
            'plan_end_date' => $post['plan_end_date']
        ];
        $this->db->insert('member_subscription', $subscription);
        $subscriptionId = $this->db->insert_id();

        foreach ($post['members'] as $m) {
            $memberData = [
                'group_id' => $groupId,
                'name' => $m['name'],
                'gender' => $m['gender'],
                'email' => $m['email'],
                'phone' => $m['phone'],
                'dob' => $m['dob'],
                'blood_group' => $m['blood_group'],
                'address' => $m['address'],
                'joining_date' => date('Y-m-d')
            ];
            $this->db->insert('members', $memberData);
            $memberId = $this->db->insert_id();

            // Link to subscription
            $this->db->insert('member_subscription_link', [
                'member_id' => $memberId,
                'subscription_id' => $subscriptionId,
                'plan_fees' => $planFeesPerMember
            ]);

            // Facilities
            if (!empty($m['facilities'])) {
                foreach ($m['facilities'] as $f) {
                    $this->db->insert('member_facilities', [
                        'member_id' => $memberId,
                        'facility_id' => $f['id'],
                        'facility_start_date' => $f['start_date'],
                        'facility_end_date' => $f['end_date'],
                        'rent' => $f['rent']
                    ]);
                }
            }
        }

        // One payment for group
        $this->db->insert('member_payments', [
            'invoice_id' => $post['invoice_id'],
            'invoice_date' => $post['invoice_date'],
            'discount_percent' => $post['discount_percent'],
            'payment_type' => $post['payment_type'],
            'total_amount' => $post['total_amount'],
            'group_id' => $groupId
        ]);
    } else {
        // Individual logic (your original)
        // ... same as before
    }

    $this->db->trans_complete();
    if ($this->db->trans_status() === FALSE) {
        echo json_encode(['status' => 'error', 'message' => 'Database error']);
    } else {
        echo json_encode(['status' => 'success', 'group_id' => $groupId ?? null, 'member_id' => $memberId ?? null]);
    }
}
}
