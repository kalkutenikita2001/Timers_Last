<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Auth_model');
        $this->load->library('session');
        $this->load->helper('url');
    }

    public function index()
    {
        $this->load->view('base/adminlogin');  // make this consistent
    }


    public function handle_login()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $user = $this->Auth_model->get_user($username);  // use model

        if ($user && password_verify($password, $user->password)) {
            // Success
            $this->session->set_userdata([
                'id'        => $user->id,
                'username'  => $user->username,
                'role'      => $user->role,
                'logged_in' => TRUE
            ]);

            if ($user->role === 'superadmin') {
                redirect('superadmin/Students');
            } else {
                redirect('superadmin/CenterManagement2');
            }
        } else {
            $data['error'] = 'Invalid Username or Password!';
            $this->load->view('base/adminlogin', $data);
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('auth');
    }
}
