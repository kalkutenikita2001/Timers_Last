<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class VenueController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Venue_model');
    }

    public function index() {
        $data['venues'] = $this->Venue_model->get_all_venues();
        $this->load->view('venue/index', $data);
    }

    public function save_venue() {
        $postData = json_decode($this->input->raw_input_stream, true);

        if (!$postData) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid data received']);
            return;
        }

        $venue_id = $this->Venue_model->saveVenue($postData);

        if ($venue_id) {
            echo json_encode(['status' => 'success', 'message' => 'Venue saved successfully', 'venue_id' => $venue_id]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to save venue']);
        }
    }
}
