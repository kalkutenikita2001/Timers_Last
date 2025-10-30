<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Office extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Office_model');
        $this->load->library('pagination');
        
        // Block access if not logged in
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    // List all offices
    public function index()
    {
        // Pagination configuration
        $config['base_url'] = base_url('office/index');
        $config['total_rows'] = $this->Office_model->get_total_offices();
        $config['per_page'] = 10;
        $config['uri_segment'] = 3;
        
        // Bootstrap 5 pagination styling
        $config['full_tag_open'] = '<nav><ul class="pagination justify-content-center">';
        $config['full_tag_close'] = '</ul></nav>';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['attributes'] = array('class' => 'page-link');

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['offices'] = $this->Office_model->get_all_offices($config['per_page'], $page);
        $data['links'] = $this->pagination->create_links();

        $this->load->view('office/list', $data);
    }

    // Add new office
    public function add()
    {
        $this->load->view('office/add');
    }

    // Save new office
    public function save()
    {
        $data = array(
            'office_name' => $this->input->post('office_name'),
            'location' => $this->input->post('location'),
            'contact_number' => $this->input->post('contact_number'),
            'email' => $this->input->post('email'),
            'office_head' => $this->input->post('office_head'),
            'working_hours' => $this->input->post('working_hours'),
            'created_at' => date('Y-m-d H:i:s')
        );

        if ($this->Office_model->add_office($data)) {
            $this->session->set_flashdata('success', 'Office added successfully');
        } else {
            $this->session->set_flashdata('error', 'Failed to add office');
        }

        redirect('office');
    }

    // View office details
    public function view($id)
    {
        $data['office'] = $this->Office_model->get_office_by_id($id);
        $data['staff'] = $this->Office_model->get_office_staff($id);
        $data['facilities'] = $this->Office_model->get_office_facilities($id);
        $this->load->view('office/view', $data);
    }

    // Edit office
    public function edit($id)
    {
        $data['office'] = $this->Office_model->get_office_by_id($id);
        $this->load->view('office/edit', $data);
    }

    // Update office
    public function update($id)
    {
        $data = array(
            'office_name' => $this->input->post('office_name'),
            'location' => $this->input->post('location'),
            'contact_number' => $this->input->post('contact_number'),
            'email' => $this->input->post('email'),
            'office_head' => $this->input->post('office_head'),
            'working_hours' => $this->input->post('working_hours')
        );

        if ($this->Office_model->update_office($id, $data)) {
            $this->session->set_flashdata('success', 'Office updated successfully');
        } else {
            $this->session->set_flashdata('error', 'Failed to update office');
        }

        redirect('office');
    }

    // Delete office
    public function delete($id)
    {
        if ($this->Office_model->delete_office($id)) {
            $this->session->set_flashdata('success', 'Office deleted successfully');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete office');
        }

        redirect('office');
    }

    // Search offices
    public function search()
    {
        $search_term = $this->input->get('term');
        $data['offices'] = $this->Office_model->search_offices($search_term);
        $data['search_term'] = $search_term;
        $this->load->view('office/list', $data);
    }

    // Add facility to office
    public function add_facility($office_id)
    {
        $data = array(
            'office_id' => $office_id,
            'facility_name' => $this->input->post('facility_name'),
            'description' => $this->input->post('description'),
            'created_at' => date('Y-m-d H:i:s')
        );

        if ($this->Office_model->add_facility($data)) {
            $this->session->set_flashdata('success', 'Facility added successfully');
        } else {
            $this->session->set_flashdata('error', 'Failed to add facility');
        }

        redirect('office/view/'.$office_id);
    }

    // Remove facility
    public function remove_facility($facility_id, $office_id)
    {
        if ($this->Office_model->remove_facility($facility_id)) {
            $this->session->set_flashdata('success', 'Facility removed successfully');
        } else {
            $this->session->set_flashdata('error', 'Failed to remove facility');
        }

        redirect('office/view/'.$office_id);
    }
}