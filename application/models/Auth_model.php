<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model {
    public function get_user_by_username($username) {
        return $this->db
            ->where('username', $username)
            ->get('users')
            ->row();
    }
}