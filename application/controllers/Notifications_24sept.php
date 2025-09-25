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
        $count = $this->Notifications_model->get_unread_count(null);
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['count' => (int)$count]));
    }

    // GET: /notifications/list_unread
    public function list_unread()
    {
        $list = $this->Notifications_model->list_unread(50, null);
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($list));
    }

    // POST: /notifications/mark_read
    public function mark_read()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        if (!empty($input['mark_all'])) {
            $this->Notifications_model->mark_read(null, null);
        } elseif (!empty($input['id'])) {
            $this->Notifications_model->mark_read((int)$input['id'], null);
        } else {
            $this->Notifications_model->mark_read(null, null);
        }
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['ok' => true]));
    }
}
