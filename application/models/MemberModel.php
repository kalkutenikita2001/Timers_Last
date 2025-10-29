<?php
class MemberModel extends CI_Model {
    public function insert($data) {
        $this->db->insert('members', $data);
        return $this->db->insert_id();
    }
}
