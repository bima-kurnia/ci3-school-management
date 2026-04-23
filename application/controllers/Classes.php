<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Classes extends My_Controller {

    public function __construct() {
        parent::__construct();
        $this->require_role('admin');
        $this->load->model('Class_model');
    }

    public function index() {
        $data['title']   = 'Classes';
        $data['icon']    = 'building';
        $data['classes'] = $this->Class_model->get_all();
        $this->load->view('classes/index', $data);
    }

    public function create() {
        $data['title'] = 'Add Class';
        $data['icon']  = 'building';
        $this->form_validation->set_rules('name', 'Class Name', 'required|trim|is_unique[classes.name]');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('classes/form', $data);
        } else {
            $this->Class_model->insert(['name' => $this->input->post('name')]);
            $this->session->set_flashdata('success', 'Class added successfully.');
            redirect('classes');
        }
    }

    public function edit($id) {
        $data['title'] = 'Edit Class';
        $data['icon']  = 'building';
        $data['class'] = $this->Class_model->get_by_id($id);
        if (!$data['class']) { show_404(); }

        $this->form_validation->set_rules('name', 'Class Name', 'required|trim');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('classes/form', $data);
        } else {
            $this->Class_model->update($id, ['name' => $this->input->post('name')]);
            $this->session->set_flashdata('success', 'Class updated successfully.');
            redirect('classes');
        }
    }

    public function delete($id) {
        $this->Class_model->delete($id);
        $this->session->set_flashdata('success', 'Class deleted.');
        redirect('classes');
    }
}