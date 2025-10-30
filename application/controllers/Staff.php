<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Staff extends CI_Controller {
  public function __construct() {
    parent::__construct();

    // Load the model - make sure the model file/class name matches this load call.
    // Preferred CI convention: file application/models/Staff_model.php and class Staff_model
    // If you use that convention, change to: $this->load->model('Staff_model');
    $this->load->model('StaffModel');
  }

  // GET /api/staff
  public function all(){
    $this->output->set_content_type('application/json');

    $rows = [];
    try {
      $rows = $this->StaffModel->get_all();
    } catch (Exception $e) {
      // log and return 500 JSON
      log_message('error', 'Staff::all() DB error: '.$e->getMessage());
      $this->output->set_status_header(500)->set_output(json_encode(['ok'=>false,'error'=>'db_error']));
      return;
    }

    // ensure we have an array
    if (!is_array($rows)) $rows = [];

    $mapped = array_map([$this, 'map_row'], $rows);
    $this->output->set_output(json_encode($mapped));
  }

  // GET /api/staff/{id}
  public function one($id) {
    $this->output->set_content_type('application/json');
    $id = (int)$id;
    if ($id <= 0) {
      $this->output->set_status_header(400)->set_output(json_encode(['ok'=>false,'error'=>'invalid_id']));
      return;
    }

    try {
      $row = $this->StaffModel->get_by_id($id);
    } catch (Exception $e) {
      log_message('error', 'Staff::one() DB error: '.$e->getMessage());
      $this->output->set_status_header(500)->set_output(json_encode(['ok'=>false,'error'=>'db_error']));
      return;
    }

    if (!$row) {
      $this->output->set_status_header(404)->set_output(json_encode(['ok'=>false,'error'=>'not_found']));
      return;
    }

    $this->output->set_output(json_encode($this->map_row($row)));
  }

  // POST /api/staff/{id}/active  with JSON: { "active": 1|0 }
  public function set_active($id) {
    $this->output->set_content_type('application/json');
    $id = (int)$id;
    if ($id <= 0) {
      $this->output->set_status_header(400)->set_output(json_encode(['ok'=>false,'error'=>'invalid_id']));
      return;
    }

    $raw = $this->input->raw_input_stream;
    $body = json_decode($raw, true);
    if (!is_array($body) || !isset($body['active'])) {
      $this->output->set_status_header(400)->set_output(json_encode(['ok'=>false,'error'=>'active required']));
      return;
    }

    $active = (int)!!$body['active'];

    try {
      $ok = $this->StaffModel->update_active($id, $active);
    } catch (Exception $e) {
      log_message('error', 'Staff::set_active() DB error: '.$e->getMessage());
      $this->output->set_status_header(500)->set_output(json_encode(['ok'=>false,'error'=>'db_error']));
      return;
    }

    if (!$ok) {
      $this->output->set_status_header(500)->set_output(json_encode(['ok'=>false,'error'=>'db']));
      return;
    }

    // return the fresh row so UI can update
    $row = $this->StaffModel->get_by_id($id);
    $this->output->set_output(json_encode([
      'ok' => true,
      'staff' => $this->map_row($row)
    ]));
  }

  /** Map DB → UI shape */
  private function map_row($r) {
    if (!is_array($r)) $r = [];

    // status derived from active tinyint(1)
    $activeVal = isset($r['active']) ? (int)$r['active'] : 1;
    $status = ($activeVal === 0) ? 'Deactive' : 'Active';

    return [
      'id'            => isset($r['id']) ? (int)$r['id'] : 0,
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
      'active'        => $activeVal,
      'status'        => $status,

      // UI extras (left as defaults)
      'attendance'    => new stdClass(),
      'payouts'       => [],
    ];
  }

  private function parse_list($val) {
    if ($val === null) return [];
    $s = trim($val);
    if ($s === '') return [];

    // If JSON array stored
    $first = substr(ltrim($s), 0, 1);
    if ($first === '[') {
      $arr = json_decode($s, true);
      return is_array($arr) ? $arr : [];
    }

    return array_values(array_filter(array_map('trim', explode(',', $s)), 'strlen'));
  }
}