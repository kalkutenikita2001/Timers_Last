<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Test extends CI_Controller
{
    public function index()
    {
        $hash = '$2a$12$bXAELlCXZYA165AFty4V3.fzDym575xw68F5AxnhzC50Huj0RAaBu'; // copy full hash from DB
        var_dump(password_verify('superadmin', $hash));  // replace yourpassword with real plain password
    }
}


///Superadmin password hash for "superadmin":  //superadmin
///Admin password hash for "password"     //Admin@123