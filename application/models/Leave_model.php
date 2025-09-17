<?php
class Leave_model extends CI_Model
{

    // Get leaves based on role
    public function get_leaves($user_role)
    {
        if ($user_role == 'admin') {
            $this->db->where('role', 'Student'); // admin sees student leaves
        } elseif ($user_role == 'superadmin') {
            $this->db->where('role', 'Staff'); // superadmin sees staff leaves
        }
        $this->db->order_by('from_date', 'DESC');
        return $this->db->get('leaves')->result();
    }

    // Insert leave
    public function add_leave($data)
    {
        return $this->db->insert('leaves', $data);
    }

    // Update leave status
    public function update_status($leave_id, $status)
    {
        $this->db->where('id', $leave_id);
        return $this->db->update('leaves', ['status' => $status]);
    }

    // Get a single leave by ID
    public function get_leave($id)
    {
        return $this->db->get_where('leaves', ['id' => $id])->row();
    }
}
