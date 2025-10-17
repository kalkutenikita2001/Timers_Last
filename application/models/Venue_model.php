<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Venue_model extends CI_Model {

    public function saveVenue($data) {
        // Save venue
        $venueData = [
            'venue_name' => $data['venue_name'],
            'password'   => $data['password'],
            'location'   => $data['location'],
            'num_courts' => $data['num_courts']
        ];

        $this->db->insert('venues', $venueData);
        $venue_id = $this->db->insert_id();

        // Save courts
        if (!empty($data['courts'])) {
            foreach ($data['courts'] as $court) {
                $this->db->insert('venue_courts', [
                    'venue_id' => $venue_id,
                    'court_name' => $court['court_name'],
                    'court_type' => $court['court_type']
                ]);
            }
        }

        // Save facilities
        if (!empty($data['facilities'])) {
            foreach ($data['facilities'] as $facility) {
                $this->db->insert('venue_facilities', [
                    'venue_id' => $venue_id,
                    'facility_name' => $facility['facility_name'],
                    'facility_type' => $facility['facility_type'],
                    'rent' => $facility['rent']
                ]);
            }
        }

        // Save slots
        if (!empty($data['slots'])) {
            foreach ($data['slots'] as $slot) {
                $this->db->insert('venue_slots', [
                    'venue_id' => $venue_id,
                    'from_time' => $slot['from_time'],
                    'to_time' => $slot['to_time'],
                    'slot_name' => $slot['slot_name']
                ]);
            }
        }

        // Save membership plans
        if (!empty($data['plans'])) {
            foreach ($data['plans'] as $plan) {
                $this->db->insert('membership_plans', [
                    'venue_id' => $venue_id,
                    'membership_name' => $plan['membership_name'],
                    'duration' => $plan['duration'],
                    'period' => $plan['period'],
                    'slot' => $plan['slot'],
                    'registration_fees' => $plan['registration_fees'],
                    'coaching_fees' => $plan['coaching_fees'],
                    'total_fees' => $plan['total_fees'],
                    'installments' => $plan['installments']
                ]);
            }
        }

        return $venue_id;
    }

 public function getAllVenues()
{
    $this->db->select('*');
    $this->db->from('venues');
    $query = $this->db->get();
    $venues = $query->result_array();

    foreach ($venues as &$venue) {
        $venue_id = $venue['id'];

        // Get courts
        $venue['courts'] = $this->db->get_where('venue_courts', ['venue_id' => $venue_id])->result_array();

        // Get facilities
        $venue['facilities'] = $this->db->get_where('venue_facilities', ['venue_id' => $venue_id])->result_array();

        // Get slots
        $venue['slots'] = $this->db->get_where('venue_slots', ['venue_id' => $venue_id])->result_array();

        // Get plans
        $venue['plans'] = $this->db->get_where('membership_plans', ['venue_id' => $venue_id])->result_array();
    }

    return $venues;
}
public function deleteVenue($id)
{
    // Begin transaction to ensure consistency
    $this->db->trans_start();

    // Delete related records first to maintain referential integrity
    $this->db->delete('venue_courts', ['venue_id' => $id]);
    $this->db->delete('venue_facilities', ['venue_id' => $id]);
    $this->db->delete('venue_slots', ['venue_id' => $id]);
    $this->db->delete('membership_plans', ['venue_id' => $id]);

    // Delete main venue
    $this->db->delete('venues', ['id' => $id]);

    $this->db->trans_complete();

    return $this->db->trans_status(); // returns TRUE if all queries succeeded
}
public function getVenueById($id)
{
    $venue = $this->db->get_where('venues', ['id' => $id])->row_array();
    if (!$venue) return null;

    $venue['courts'] = $this->db->get_where('venue_courts', ['venue_id' => $id])->result_array();
    $venue['facilities'] = $this->db->get_where('venue_facilities', ['venue_id' => $id])->result_array();
    $venue['slots'] = $this->db->get_where('venue_slots', ['venue_id' => $id])->result_array();
    $venue['plans'] = $this->db->get_where('membership_plans', ['venue_id' => $id])->result_array();

    return $venue;
}

}
