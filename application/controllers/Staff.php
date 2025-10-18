<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Staff extends CI_Controller {
  public function __construct() {
    parent::__construct();
    $this->load->model('Staff_model');
  }

  // GET /api/staff
  public function all(){
    $rows = $this->Staff_model->get_all();
    $mapped = array_map([$this, 'map_row'], $rows);
    $this->output->set_content_type('application/json')->set_output(json_encode($mapped));
  }

  // GET /api/staff/{id}
  public function one($id) {
    $row = $this->Staff_model->get_by_id($id);
    if (!$row) { show_404(); return; }
    $this->output->set_content_type('application/json')->set_output(json_encode($this->map_row($row)));
  }

  // POST /api/staff/{id}/active  with JSON: { "active": 1|0 }
  public function set_active($id) {
    $this->output->set_content_type('application/json');

    $raw = $this->input->raw_input_stream;
    $body = json_decode($raw, true);
    if (!is_array($body) || !isset($body['active'])) {
      $this->output->set_status_header(400)->set_output(json_encode(['ok'=>false,'error'=>'active required']));
      return;
    }

    $active = (int)!!$body['active'];
    $ok = $this->Staff_model->update_active($id, $active);
    if (!$ok) {
      $this->output->set_status_header(500)->set_output(json_encode(['ok'=>false,'error'=>'db']));
      return;
    }

    // return the fresh row so UI can update
    $row = $this->Staff_model->get_by_id($id);
    $this->output->set_output(json_encode([
      'ok' => true,
      'staff' => $this->map_row($row)
    ]));
  }

  /** Map DB → UI shape */
  private function map_row($r) {
    // status derived from active tinyint(1)
    $status = (isset($r['active']) && (int)$r['active'] === 0) ? 'Deactive' : 'Active';

    return [
      'id'            => (int)$r['id'],
      'name'          => (string)($r['name'] ?? ''),
      'email'         => (string)($r['email'] ?? ''),
      'contact'       => (string)($r['contact'] ?? ''),
      'joining_date'  => (string)($r['joining_date'] ?? ''),
      'role'          => (string)($r['role'] ?? ''),
      'salary'        => (float)($r['salary'] ?? 0),

      // centers / slots are TEXT (CSV). Split to arrays for the UI.
      'centers'       => $this->parse_list($r['centers'] ?? ''),
      'slots'         => $this->parse_list($r['slots'] ?? ''),

      // new
      'active'        => isset($r['active']) ? (int)$r['active'] : 1,
      'status'        => $status,

      // UI extras (left as defaults)
      'attendance'    => new stdClass(),
      'payouts'       => [],
    ];
  }

  private function parse_list($val) {
    if (!$val) return [];
    $val = trim($val);
    if (strlen($val) && $val[0] === '[') { // JSON array stored
      $arr = json_decode($val, true);
      return is_array($arr) ? $arr : [];
    }
    return array_values(array_filter(array_map('trim', explode(',', $val)), 'strlen'));
  }
}
