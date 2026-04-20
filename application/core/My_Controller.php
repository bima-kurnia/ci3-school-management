<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class My_Controller extends CI_Controller {

    protected $current_user;

    public function __construct() {
        parent::__construct();

        // Check if user is logged in
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }

        // Make current user data available to all controllers
        $this->current_user = (object) array(
            'id'       => $this->session->userdata('user_id'),
            'username' => $this->session->userdata('username'),
            'role'     => $this->session->userdata('role'),
        );

        // Share to all views
        $this->load->vars(['current_user' => $this->current_user]);
    }

    // ---------- Role Helpers ----------
    protected function is_admin() {
        return $this->current_user->role === 'admin';
    }

    protected function is_teacher() {
        return $this->current_user->role === 'teacher';
    }

    protected function is_student() {
        return $this->current_user->role === 'student';
    }

    // Force a specific role or redirect
    protected function require_role($role) {
        if ($this->current_user->role !== $role) {
            show_error('You do not have permission to access this page.', 403);
        }
    }
}