<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notifications_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    // Create a notification row
    public function create_notification($data)
    {
        $insert = [
            'user_id' => isset($data['user_id']) ? $data['user_id'] : null,
            'type'    => isset($data['type']) ? $data['type'] : null,
            'title'   => isset($data['title']) ? $data['title'] : null,
            'message' => isset($data['message']) ? $data['message'] : null,
            'item_id' => isset($data['item_id']) ? $data['item_id'] : null,
            'is_read' => 0,
            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->db->insert('notifications', $insert);
        return $this->db->insert_id();
    }

    public function get_unread_count($user_id = null)
    {
        if ($user_id !== null) $this->db->where('user_id', $user_id);
        $this->db->where('is_read', 0);
        return $this->db->count_all_results('notifications');
    }

    public function list_unread($limit = 50, $user_id = null)
    {
        if ($user_id !== null) $this->db->where('user_id', $user_id);
        $this->db->where('is_read', 0);
        $this->db->order_by('created_at', 'DESC');
        $q = $this->db->get('notifications', $limit);
        return $q->result_array();
    }

    public function mark_read($id = null, $user_id = null)
    {
        if ($id !== null) {
            $this->db->where('id', (int)$id);
        } else {
            if ($user_id !== null) $this->db->where('user_id', $user_id);
        }
        return $this->db->update('notifications', ['is_read' => 1]);
    }
}
