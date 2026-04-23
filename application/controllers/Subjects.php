<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subjects extends My_Controller {

    public function __construct() {
        parent::__construct();
        $this->require_role('admin');
        $this->load->model('Subject_model');
    }

    public function index() {
        $data['title']    = 'Subjects';
        $data['icon']     = 'book';
        $data['subjects'] = $this->Subject_model->get_all();

        $this->load->view('subjects/index', $data);
    }

    public function create() {
        $data['title'] = 'Add Subject';
        $data['icon']  = 'book';
        
        $this->form_validation->set_rules('name', 'Subject Name', 'required|trim|is_unique[subjects.name]');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('subjects/form', $data);
        } else {
            $this->Subject_model->insert(['name' => $this->input->post('name')]);
            $this->session->set_flashdata('success', 'Subject added successfully.');

            redirect('subjects');
        }
    }

    public function edit($id) {
        $data['title']   = 'Edit Subject';
        $data['icon']    = 'book';
        $data['subject'] = $this->Subject_model->get_by_id($id);

        if (!$data['subject']) { 
            show_404(); 
        }

        $this->form_validation->set_rules('name', 'Subject Name', 'required|trim');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('subjects/form', $data);
        } else {
            $this->Subject_model->update($id, ['name' => $this->input->post('name')]);
            $this->session->set_flashdata('success', 'Subject updated successfully.');

            redirect('subjects');
        }
    }

    public function delete($id) {
        $this->Subject_model->delete($id);
        $this->session->set_flashdata('success', 'Subject deleted.');

        redirect('subjects');
    }
}