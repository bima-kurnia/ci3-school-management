<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('Auth_model');
    }

    // ---------- LOGIN ----------
    public function index() {
        // If already logged in, redirect to dashboard
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }

        $this->load->view('auth/login');
    }

    public function login() {
        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('auth/login');
        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            $user = $this->Auth_model->get_user_by_username($username);

            if ($user && password_verify($password, $user->password)) {
                // Set session
                $session_data = array(
                    'logged_in' => TRUE,
                    'user_id'   => $user->id,
                    'username'  => $user->username,
                    'role'      => $user->role,
                );

                $this->session->set_userdata($session_data);

                redirect('dashboard');
            } else {
                $this->session->set_flashdata('error', 'Invalid username or password.');

                redirect('auth');
            }
        }
    }

    // ---------- LOGOUT ----------
    public function logout() {
        $this->session->sess_destroy();
        
        redirect('auth');
    }
}