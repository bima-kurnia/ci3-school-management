<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Class_subjects extends My_Controller {

    public function __construct() {
        parent::__construct();
        $this->require_role('admin');
        $this->load->model([
            'Class_subject_model',
            'Class_model',
            'Subject_model',
            'Teacher_model',
        ]);
    }

    // Overview — all assignments
    public function index() {
        $data['title']       = 'Class Subjects';
        $data['icon']        = 'sitemap';
        $data['assignments'] = $this->Class_subject_model->get_all();
        
        $this->load->view('class_subjects/index', $data);
    }

    // Assign a subject + teacher to a class
    public function create() {
        $data['title']    = 'Assign Subject to Class';
        $data['icon']     = 'sitemap';
        $data['classes']  = $this->Class_model->get_all();
        $data['subjects'] = $this->Subject_model->get_all();
        $data['teachers'] = $this->Teacher_model->get_all();

        $this->form_validation->set_rules('class_id',   'Class',   'required');
        $this->form_validation->set_rules('subject_id', 'Subject', 'required');
        $this->form_validation->set_rules('teacher_id', 'Teacher', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('class_subjects/form', $data);
        } else {
            $class_id   = $this->input->post('class_id');
            $subject_id = $this->input->post('subject_id');

            // Prevent duplicate subject in same class
            if ($this->Class_subject_model->is_duplicate($class_id, $subject_id)) {
                $this->session->set_flashdata('error', 'This subject is already assigned to that class.');

                redirect('class_subjects/create');
            }

            $this->Class_subject_model->insert([
                'class_id'   => $class_id,
                'subject_id' => $subject_id,
                'teacher_id' => $this->input->post('teacher_id'),
            ]);
            $this->session->set_flashdata('success', 'Subject assigned successfully.');

            redirect('class_subjects');
        }
    }

    public function edit($id) {
        $data['title']      = 'Edit Assignment';
        $data['icon']       = 'sitemap';
        $data['assignment'] = $this->Class_subject_model->get_by_id($id);
        if (!$data['assignment']) { show_404(); }

        $data['classes']  = $this->Class_model->get_all();
        $data['subjects'] = $this->Subject_model->get_all();
        $data['teachers'] = $this->Teacher_model->get_all();

        $this->form_validation->set_rules('class_id',   'Class',   'required');
        $this->form_validation->set_rules('subject_id', 'Subject', 'required');
        $this->form_validation->set_rules('teacher_id', 'Teacher', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('class_subjects/form', $data);
        } else {
            $class_id   = $this->input->post('class_id');
            $subject_id = $this->input->post('subject_id');

            // Prevent duplicate (exclude current record)
            if ($this->Class_subject_model->is_duplicate($class_id, $subject_id, $id)) {
                $this->session->set_flashdata('error', 'This subject is already assigned to that class.');

                redirect('class_subjects/edit/' . $id);
            }

            $this->Class_subject_model->update($id, [
                'class_id'   => $class_id,
                'subject_id' => $subject_id,
                'teacher_id' => $this->input->post('teacher_id'),
            ]);

            $this->session->set_flashdata('success', 'Assignment updated successfully.');

            redirect('class_subjects');
        }
    }

    public function delete($id) {
        $this->Class_subject_model->delete($id);
        $this->session->set_flashdata('success', 'Assignment removed.');

        redirect('class_subjects');
    }

    // View all subjects assigned to a specific class
    public function by_class($class_id) {
        $data['title']       = 'Subjects by Class';
        $data['icon']        = 'sitemap';
        $data['class']       = $this->Class_model->get_by_id($class_id);

        if (!$data['class']) { 
            show_404(); 
        }

        $data['assignments'] = $this->Class_subject_model->get_by_class($class_id);

        $this->load->view('class_subjects/by_class', $data);
    }
}