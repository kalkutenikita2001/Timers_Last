<?php
class SubscriptionModel extends CI_Model {
    public function insert($data) {
        return $this->db->insert('subscriptions', $data);
    }
}
