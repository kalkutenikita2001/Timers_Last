<?php
class GroupModel extends CI_Model {
    public function insert($data) {
        return $this->db->insert('group_members', $data);
    }
}
