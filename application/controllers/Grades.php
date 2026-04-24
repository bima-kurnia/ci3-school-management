<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Grades extends My_Controller {

    public function __construct() {
        parent::__construct();

        if (!$this->is_admin() && !$this->is_teacher()) {
            show_error('Access denied.', 403);
        }

        $this->load->model([
            'Grade_model',
            'Class_model',
            'Subject_model',
            'Student_model',
        ]);

        // Available semesters
        $currentYear = date('Y');
        $this->semesters = [
            ($currentYear - 1) . "-1",
            ($currentYear - 1) . "-2",
            $currentYear . "-1",
            $currentYear . "-2",
            ($currentYear + 1) . "-1"
        ];
    }

    // ---------- STEP 1: Pick class + subject + semester ----------
    public function index() {
        $data['title']     = 'Grades';
        $data['icon']      = 'pencil-square-o';
        $data['classes']   = $this->Class_model->get_all();
        $data['semesters'] = $this->semesters;

        $this->load->view('grades/index', $data);
    }

    // ---------- STEP 2: Input grades for a subject ----------
    public function input() {
        $class_id   = $this->input->get_post('class_id');
        $subject_id = $this->input->get_post('subject_id');
        $semester   = $this->input->get_post('semester');

        if (!$class_id || !$subject_id || !$semester) {
            $this->session->set_flashdata('error', 'Please fill all filter fields.');
            redirect('grades');
        }

        $class   = $this->Class_model->get_by_id($class_id);
        $subject = $this->Subject_model->get_by_id($subject_id);

        if (!$class || !$subject) { 
            show_404(); 
        }

        $data['title']    = 'Input Grades';
        $data['icon']     = 'pencil-square-o';
        $data['class']    = $class;
        $data['subject']  = $subject;
        $data['semester'] = $semester;
        $data['students'] = $this->Grade_model->get_students_with_scores(
                                $class_id, $subject_id, $semester);

        if (empty($data['students'])) {
            $this->session->set_flashdata('error', 'No students found in this class.');

            redirect('grades');
        }

        $this->load->view('grades/input', $data);
    }

    // ---------- STEP 3: Save grades ----------
    public function save() {
        $class_id   = $this->input->post('class_id');
        $subject_id = $this->input->post('subject_id');
        $semester   = $this->input->post('semester');
        $scores     = $this->input->post('scores'); // [student_id => score]

        if (!$class_id || !$subject_id || !$semester || empty($scores)) {
            $this->session->set_flashdata('error', 'Invalid submission.');

            redirect('grades');
        }

        $batch = [];
        foreach ($scores as $student_id => $score) {

            // Allow empty score (skip) or validate 0-100
            if ($score === '' || $score === null) continue;
            $score = floatval($score);
            if ($score < 0)   $score = 0;
            if ($score > 100) $score = 100;

            $batch[] = [
                'student_id' => (int)$student_id,
                'subject_id' => (int)$subject_id,
                'semester'   => $semester,
                'score'      => $score,
            ];
        }

        if (empty($batch)) {
            $this->session->set_flashdata('error', 'No scores were submitted.');

            redirect('grades');
        }

        $result = $this->Grade_model->save_bulk($batch);

        if ($result) {
            $this->session->set_flashdata('success', 'Grades saved successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to save grades.');
        }

        redirect("grades/input?class_id={$class_id}&subject_id={$subject_id}&semester={$semester}");
    }

    // ---------- GPA Summary (per class + semester) ----------
    public function summary() {
        $data['title']     = 'Grade Summary';
        $data['icon']      = 'bar-chart';
        $data['classes']   = $this->Class_model->get_all();
        $data['semesters'] = $this->semesters;
        $data['summary']   = [];
        $data['class']     = null;
        $data['semester']  = null;

        $class_id = $this->input->get('class_id');
        $semester = $this->input->get('semester');

        if ($class_id && $semester) {
            $data['class']    = $this->Class_model->get_by_id($class_id);
            $data['semester'] = $semester;
            $data['summary']  = $this->Grade_model->get_gpa_summary($class_id, $semester);
        }

        $this->load->view('grades/summary', $data);
    }

    // ---------- Report Card (per student) ----------
    public function report_card($student_id) {
        $this->load->model('Student_model');
        $student  = $this->Student_model->get_by_id($student_id);

        if (!$student) { 
            show_404(); 
        }

        $semester = $this->input->get('semester') ?? $this->semesters[0];

        $data['title']     = 'Report Card';
        $data['icon']      = 'file-text';
        $data['student']   = $student;
        $data['semester']  = $semester;
        $data['semesters'] = $this->semesters;
        $data['grades']    = $this->Grade_model->get_report_card($student_id, $semester);
        $data['average']   = !empty($data['grades'])
            ? round(array_sum(array_column(
                array_map(fn($g) => (array)$g, $data['grades']), 'score')) / count($data['grades']), 2)
            : null;

        $this->load->view('grades/report_card', $data);
    }

    // AJAX: Get subjects by class
    public function get_subjects($class_id) {
        $subjects = $this->Grade_model->get_class_subjects($class_id);
        
        echo json_encode($subjects);
    }

    // Grade label helper (called from view)
    public function get_grade_label($score) {
        $grades = [
            90 => ['bg-success', 'A'],
            80 => ['bg-info', 'B'],
            70 => ['bg-primary', 'C'],
            60 => ['bg-warning', 'D'],
            0  => ['bg-danger', 'F'],
        ];

        foreach ($grades as $threshold => $data) {
            if ($score >= $threshold) {
                return "<span class='badge {$data[0]}' style='font-size:16px'>{$data[1]}</span>";
            }
        }
    }
}