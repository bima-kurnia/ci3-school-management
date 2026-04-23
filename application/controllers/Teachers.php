<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Teachers extends My_Controller {

    public function __construct() {
        parent::__construct();
        $this->require_role('admin');
        $this->load->model('Teacher_model');
    }

    public function index() {
        $data['title']    = 'Teachers';
        $data['icon']     = 'user';
        $data['teachers'] = $this->Teacher_model->get_all();
        $this->load->view('teachers/index', $data);
    }

    public function create() {
        $data['title'] = 'Add Teacher';
        $data['icon']  = 'user';
        $this->form_validation->set_rules('name',   'Name',   'required|trim');
        $this->form_validation->set_rules('gender', 'Gender', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('teachers/form', $data);
        } else {
            $this->Teacher_model->insert([
                'name'   => $this->input->post('name'),
                'gender' => $this->input->post('gender'),
                'phone'  => $this->input->post('phone'),
            ]);
            $this->session->set_flashdata('success', 'Teacher added successfully.');
            redirect('teachers');
        }
    }

    public function edit($id) {
        $data['title']   = 'Edit Teacher';
        $data['icon']    = 'user';
        $data['teacher'] = $this->Teacher_model->get_by_id($id);
        if (!$data['teacher']) { show_404(); }

        $this->form_validation->set_rules('name',   'Name',   'required|trim');
        $this->form_validation->set_rules('gender', 'Gender', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('teachers/form', $data);
        } else {
            $this->Teacher_model->update($id, [
                'name'   => $this->input->post('name'),
                'gender' => $this->input->post('gender'),
                'phone'  => $this->input->post('phone'),
            ]);
            $this->session->set_flashdata('success', 'Teacher updated successfully.');
            redirect('teachers');
        }
    }

    public function delete($id) {
        $this->Teacher_model->delete($id);
        $this->session->set_flashdata('success', 'Teacher deleted.');
        redirect('teachers');
    }
}