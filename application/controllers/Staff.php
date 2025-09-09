<?php
defined('BASEPATH') or exit('No direct script access allowed');



class Staff extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Staff_model');
        $this->load->helper('url');
    }

    // ✅ Get all staff for a center (to refresh UI)
    public function getStaffByCenter($centerId) {
        $filters = $this->input->get(); 
        $filters['center_id'] = $centerId;

        $staff = $this->Staff_model->get_staff($filters);

        echo json_encode([
            'status' => 'success',
            'data' => $staff
        ]);
    }

    // ✅ Get single staff by ID
    public function getStaffById($id) {
        $staff = $this->Staff_model->get_staff_by_id($id);

        if ($staff) {
            echo json_encode([
                'status' => 'success',
                'staff' => $staff
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Staff not found'
            ]);
        }
    }

    // ✅ Add new staff
    public function addStaff() {
        $data = json_decode($this->input->raw_input_stream, true);

        if ($this->Staff_model->add_staff($data)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }

    // ✅ Update staff
    public function updateStaff() {
        $data = json_decode($this->input->raw_input_stream, true);
        $id = $data['id'];
        unset($data['id']); // remove id before update

        if ($this->Staff_model->update_staff($id, $data)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }

    // ✅ Delete staff
    public function deleteStaff($id) {
        if ($this->Staff_model->delete_staff($id)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }
    //facilities saved
    public function store(){
        $facilities= new Facility_model();
        $data=[
            'facility_name'=>$this->request->getPost('facility_name'),
            'subtype_name'=>$this->request->getPost('subtype_name'),
            'rent_amount'=>$this->request->getPost('rent_amount')
        ];
        $facilities->save($data);
        return redirect()->to(base_url('view_center_details'))->with('status','Facility Added Successfully');

    }
}
