<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Staff_model extends CI_Model {
  private $table = 'staff';

  public function get_all() {
    return $this->db->get($this->table)->result_array();
  }

  public function get_by_id($id) {
    return $this->db->get_where($this->table, ['id' => (int)$id])->row_array();
  }

  public function update_active($id, $active) {
    return $this->db->update($this->table, ['active' => (int)$active], ['id' => (int)$id]);
  }
}
