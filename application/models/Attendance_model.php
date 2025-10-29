<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Attendance_model extends CI_Model
{
    protected $table = 'attendance';

    public function __construct()
    {
        parent::__construct();
    }

    // get rows for a specific date
    public function get_by_date($date)
    {
        return $this->db->select('*')
                        ->from($this->table)
                        ->where('date', $date)
                        ->get()
                        ->result_array();
    }

    // get single record by id
    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, ['id' => $id])->row_array();
    }

    // update by id
    public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    // Upsert by staff_id + date. Returns id (inserted or existing id after update)
    public function upsert_by_staff_date($staff_id, $date, $data)
    {
        // check existing
        $row = $this->db->get_where($this->table, ['staff_id' => $staff_id, 'date' => $date])->row_array();

        if ($row) {
            // preserve existing check_in_at/check_out_at if already present and not passed by $data
            $update = $data;
            if (isset($row['check_in_at']) && !empty($row['check_in_at']) && (empty($update['check_in_at']))) {
                unset($update['check_in_at']);
            }
            if (isset($row['check_out_at']) && !empty($row['check_out_at']) && (empty($update['check_out_at']))) {
                unset($update['check_out_at']);
            }
            $this->db->where('id', $row['id']);
            $ok = $this->db->update($this->table, $update);
            return $ok ? (int)$row['id'] : false;
        } else {
            // set created_at if not present
            if (!isset($data['created_at'])) $data['created_at'] = date('Y-m-d H:i:s');
            $this->db->insert($this->table, $data);
            return $this->db->insert_id() ? (int)$this->db->insert_id() : false;
        }
    }

    // optional delete
    public function delete($id)
    {
        return $this->db->delete($this->table, ['id' => $id]);
    }
}
