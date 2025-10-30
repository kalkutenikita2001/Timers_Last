<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Permission_model extends CI_Model
{

    // Get permissions for a given center
    public function get_by_center($center_id)
    {
        $this->db->select('permission_key, enabled');
        $this->db->from('center_permissions');
        $this->db->where('center_id', $center_id);
        $query = $this->db->get();
        $result = [];
        foreach ($query->result_array() as $row) {
            $result[$row['permission_key']] = (bool)$row['enabled'];
        }
        return $result;
    }

    // Save/update permissions
    public function save_permissions($center_id, $permissions)
    {
        foreach ($permissions as $key => $enabled) {
            $exists = $this->db->get_where('center_permissions', [
                'center_id' => $center_id,
                'permission_key' => $key
            ])->row();

            if ($exists) {
                $this->db->where('id', $exists->id)
                    ->update('center_permissions', ['enabled' => $enabled]);
            } else {
                $this->db->insert('center_permissions', [
                    'center_id' => $center_id,
                    'permission_key' => $key,
                    'enabled' => $enabled
                ]);
            }
        }
    }
    // Get all venues with their permissions
public function get_all_venues()
{
    $venues = $this->db->get('venues')->result_array();
    foreach ($venues as &$venue) {
        $venue['permissions'] = $this->get_venue_permissions($venue['id']);
    }
    return $venues;
}

// Get permissions for a specific venue
public function get_venue_permissions($venue_id)
{
    $this->db->where('venue_id', $venue_id);
    $permissions = $this->db->get('venue_permissions')->result_array();
    
    $result = [
        'admission' => false,
        'attendance' => false,
        'leave' => false,
        'expense' => false
    ];
    
    foreach ($permissions as $permission) {
        $result[$permission['permission_type']] = (bool)$permission['enabled'];
    }
    
    return $result;
}

// Save venue permissions
public function save_venue_permissions($venue_id, $permissions)
{
    // First delete existing permissions
    $this->db->where('venue_id', $venue_id);
    $this->db->delete('venue_permissions');
    
    // Insert new permissions
    // Ensure we handle admission as well; normalize keys we expect
    $expected = ['admission','attendance','leave','expense'];
    foreach ($expected as $type) {
        $enabled = isset($permissions[$type]) ? $permissions[$type] : 0;
        $this->db->insert('venue_permissions', [
            'venue_id' => $venue_id,
            'permission_type' => $type,
            'enabled' => $enabled ? 1 : 0,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
    return true;
}

public function check_venue_permission($venue_id, $permission_type) {
    $this->db->where('venue_id', $venue_id);
    $this->db->where('permission_type', $permission_type);
    $result = $this->db->get('venue_permissions')->row();
    return $result ? (bool)$result->enabled : false;
}
}
