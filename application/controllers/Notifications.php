<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notifications extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Notifications_model');
        $this->load->library('session');
        $this->load->helper('url');
    }

    // GET: /notifications/unread_count
    public function unread_count()
    {
        // If admin, filter by user_id from session; if superadmin, use null
        $user_id = null;
        if ($this->session->userdata('role') === 'admin') {
            $user_id = $this->session->userdata('id');
        }
        log_message('error', 'Fetching unread_count for user_id: ' . print_r($user_id, true));
        $count = $this->Notifications_model->get_unread_count($user_id);
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['count' => (int)$count]));
    }

    // GET: /notifications/list_unread
    public function list_unread()
    {
        // If admin, filter by user_id from session; if superadmin, use null
        $user_id = null;
        if ($this->session->userdata('role') === 'admin') {
            $user_id = $this->session->userdata('id');
        }
        log_message('error', 'Fetching list_unread for user_id: ' . print_r($user_id, true));
        $list = $this->Notifications_model->list_unread(50, $user_id);
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($list));
    }

    // POST: /notifications/mark_read
    public function mark_read()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        $user_id = null;
        if ($this->session->userdata('role') === 'admin') {
            $user_id = $this->session->userdata('id');
        }
        log_message('error', 'Marking notifications read for user_id: ' . print_r($user_id, true));
        if (!empty($input['mark_all'])) {
            $this->Notifications_model->mark_read(null, $user_id);
        } elseif (!empty($input['id'])) {
            $this->Notifications_model->mark_read((int)$input['id'], $user_id);
        } else {
            $this->Notifications_model->mark_read(null, $user_id);
        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['ok' => true]));
    }
}
