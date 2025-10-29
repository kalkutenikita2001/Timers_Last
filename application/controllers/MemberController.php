<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MemberController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(['MemberModel', 'GroupModel', 'SubscriptionModel', 'FacilityModel', 'PaymentModel']);
        $this->load->helper(['url', 'form']);
        $this->load->library('form_validation');
    }

    public function saveMember() {
        $post = $this->input->post();

        // --- 1️⃣ SAVE MEMBER ---
        $memberData = [
            'name' => $post['memberName'],
            'gender' => $post['memberGender'],
            'email' => $post['memberEmail'],
            'phone' => $post['memberPhone'],
            'alt_phone' => $post['memberAltPhone'],
            'dob' => $post['memberDOB'],
            'blood_group' => $post['memberBloodGroup'],
            'address' => $post['memberAddress'],
            'joining_date' => $post['memberJoiningDate'],
            'member_type' => $post['memberType'], // 'individual' or 'group_leader'
            'created_at' => date('Y-m-d H:i:s')
        ];

        // File upload
        if (!empty($_FILES['documentUpload']['name'])) {
            $config['upload_path'] = './uploads/documents/';
            $config['allowed_types'] = 'jpg|png|pdf|docx';
            $config['max_size'] = 2048;
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('documentUpload')) {
                $uploadData = $this->upload->data();
                $memberData['document_path'] = 'uploads/documents/' . $uploadData['file_name'];
            }
        }

        $member_id = $this->MemberModel->insert($memberData);

        // --- 2️⃣ SAVE GROUP MEMBERS (if applicable) ---
        if ($post['memberType'] == 'group_leader' && !empty($post['groupMembers'])) {
            foreach ($post['groupMembers'] as $gm) {
                $this->GroupModel->insert([
                    'leader_id' => $member_id,
                    'name' => $gm['name'],
                    'gender' => $gm['gender'],
                    'email' => $gm['email'],
                    'phone' => $gm['phone'],
                    'dob' => $gm['dob'],
                    'address' => $gm['address'],
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            }
        }

        // --- 3️⃣ SAVE SUBSCRIPTION ---
        $subscription = [
            'student_id' => $member_id,
            'center_id' => $post['centerSelect'],
            'slot_id' => $post['slotSelect'],
            'category' => $post['categorySelect'],
            'plan_id' => $post['planSelect'],
            'plan_start' => $post['planStartDate'],
            'plan_end' => $post['planEndDate']
        ];
        $this->SubscriptionModel->insert($subscription);

        // --- 4️⃣ SAVE FACILITIES ---
        if (!empty($post['facilities'])) {
            foreach ($post['facilities'] as $facility) {
                $this->FacilityModel->assignFacility([
                    'student_id' => $member_id,
                    'facility_id' => $facility['id'],
                    'facility_start' => $facility['start'],
                    'facility_end' => $facility['end'],
                    'rent' => $facility['rent']
                ]);
            }
        }

        // --- 5️⃣ SAVE PAYMENT ---
        $paymentData = [
            'student_id' => $member_id,
            'invoice_id' => $post['invoiceId'],
            'invoice_date' => $post['invoiceDate'],
            'discount_percent' => $post['discountPercent'],
            'discount_amount' => $post['discountAmount'],
            'total_amount' => $post['totalAmount'],
            'payment_type' => strtolower($post['paymentType']),
            'created_at' => date('Y-m-d H:i:s')
        ];

        $payment_id = $this->PaymentModel->insert($paymentData);

        if ($post['paymentType'] == 'Installment' && !empty($post['installments'])) {
            $this->PaymentModel->insertInstallments($payment_id, $post['installments']);
        }

        echo json_encode(['status' => 'success', 'message' => 'Member registered successfully!']);
    }
}
