<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Venue_model extends CI_Model {

    public function saveVenue($data) {
        // Save venue
        $venueData = [
            'venue_name' => $data['venue_name'],
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

    public function get_all_venues() {
        return $this->db->get('venues')->result_array();
    }
}
