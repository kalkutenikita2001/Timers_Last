<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model {
    public function validate_user($email, $password) {
        $this->db->where('email', $email);
        $query = $this->db->get('users');
        $user = $query->row_array();

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    public function create_user($data) {
        return $this->db->insert('users', $data);
    }

    public function store_otp($email, $otp) {
        $data = [
            'email' => $email,
            'otp' => $otp,
            'created_at' => date('Y-m-d H:i:s'),
            'expires_at' => date('Y-m-d H:i:s', strtotime('+10 minutes'))
        ];
        $this->db->insert('otps', $data);
    }

    public function verify_otp($email, $otp) {
        $this->db->where('email', $email);
        $this->db->where('otp', $otp);
        $this->db->where('expires_at >', date('Y-m-d H:i:s'));
        $query = $this->db->get('otps');
        return $query->num_rows() > 0;
    }

    public function get_user_by_email($email) {
        $this->db->where('email', $email);
        return $this->db->get('users')->row_array();
    }

    public function log_activity($user_id, $action, $description) {
        $data = [
            'user_id' => $user_id,
            'action' => $action,
            'description' => $description,
            'timestamp' => date('Y-m-d H:i:s')
        ];
        $this->db->insert('activity_logs', $data);
    }
}