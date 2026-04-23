<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends My_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model(['Student_model', 'Teacher_model', 'Class_model']);
    }

    public function index() {
        $data['title']          = 'Dashboard';
        $data['total_students'] = $this->Student_model->count_all();
        $data['total_teachers'] = $this->Teacher_model->count_all();
        $data['total_classes']  = $this->Class_model->count_all();
        $data['total_subjects'] = $this->db->count_all('subjects');
        $this->load->view('dashboard/index', $data);
    }
}