<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Students extends My_Controller {

    public function __construct() {
        parent::__construct();
        $this->require_role('admin');
        $this->load->model(['Student_model', 'Class_model']);
    }

    public function index() {
        $data['title']    = 'Students';
        $data['icon']     = 'user-circle';
        $data['students'] = $this->Student_model->get_all();
        $this->load->view('students/index', $data);
    }

    public function create() {
        $data['title']   = 'Add Student';
        $data['icon']    = 'user-circle';
        $data['classes'] = $this->Class_model->get_all();

        $this->form_validation->set_rules('name',       'Name',       'required|trim');
        $this->form_validation->set_rules('class_id',   'Class',      'required');
        $this->form_validation->set_rules('gender',     'Gender',     'required');
        $this->form_validation->set_rules('birth_date', 'Birth Date', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('students/form', $data);
        } else {
            $insert = [
                'name'       => $this->input->post('name'),
                'class_id'   => $this->input->post('class_id'),
                'gender'     => $this->input->post('gender'),
                'birth_date' => $this->input->post('birth_date'),
                'address'    => $this->input->post('address'),
            ];
            $this->Student_model->insert($insert);
            $this->session->set_flashdata('success', 'Student added successfully.');
            redirect('students');
        }
    }

    public function edit($id) {
        $data['title']   = 'Edit Student';
        $data['icon']    = 'user-circle';
        $data['student'] = $this->Student_model->get_by_id($id);
        $data['classes'] = $this->Class_model->get_all();
        if (!$data['student']) { show_404(); }

        $this->form_validation->set_rules('name',       'Name',       'required|trim');
        $this->form_validation->set_rules('class_id',   'Class',      'required');
        $this->form_validation->set_rules('gender',     'Gender',     'required');
        $this->form_validation->set_rules('birth_date', 'Birth Date', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('students/form', $data);
        } else {
            $update = [
                'name'       => $this->input->post('name'),
                'class_id'   => $this->input->post('class_id'),
                'gender'     => $this->input->post('gender'),
                'birth_date' => $this->input->post('birth_date'),
                'address'    => $this->input->post('address'),
            ];
            $this->Student_model->update($id, $update);
            $this->session->set_flashdata('success', 'Student updated successfully.');
            redirect('students');
        }
    }

    public function delete($id) {
        $this->Student_model->delete($id);
        $this->session->set_flashdata('success', 'Student deleted.');
        redirect('students');
    }
}