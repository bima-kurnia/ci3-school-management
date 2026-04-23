<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Attendance extends My_Controller {

    public function __construct() {
        parent::__construct();

        // Both admin and teacher can access attendance
        if (!$this->is_admin() && !$this->is_teacher()) {
            show_error('Access denied.', 403);
        }
        
        $this->load->model([
            'Attendance_model',
            'Class_model',
        ]);
    }

    // ---------- STEP 1: Pick class + date ----------
    public function index() {
        $data['title']   = 'Attendance';
        $data['icon']    = 'calendar';
        $data['classes'] = $this->Class_model->get_all();

        $this->load->view('attendance/index', $data);
    }

    // ---------- STEP 2: Fill attendance form ----------
    public function take() {
        $class_id = $this->input->get_post('class_id');
        $date     = $this->input->get_post('date');

        // Validate inputs
        if (!$class_id || !$date) {
            $this->session->set_flashdata('error', 'Please select a class and date.');

            redirect('attendance');
        }

        $class = $this->Class_model->get_by_id($class_id);
        if (!$class) { show_404(); }

        $data['title']    = 'Take Attendance';
        $data['icon']     = 'calendar-check-o';
        $data['class']    = $class;
        $data['date']     = $date;
        $data['students'] = $this->Attendance_model->get_students_with_status($class_id, $date);
        $data['is_taken'] = $this->Attendance_model->is_taken($class_id, $date);

        if (empty($data['students'])) {
            $this->session->set_flashdata('error', 'No students found in this class.');

            redirect('attendance');
        }

        $this->load->view('attendance/take', $data);
    }

    // ---------- STEP 3: Save attendance ----------
    public function save() {
        $class_id       = $this->input->post('class_id');
        $date           = $this->input->post('date');
        $attendance_raw = $this->input->post('attendance'); // array: [student_id => status]

        if (!$class_id || !$date || empty($attendance_raw)) {
            $this->session->set_flashdata('error', 'Invalid submission.');

            redirect('attendance');
        }

        // Sanitize statuses
        $allowed  = ['present', 'absent', 'late', 'excused'];
        $clean    = [];
        foreach ($attendance_raw as $student_id => $status) {
            if (in_array($status, $allowed)) {
                $clean[(int)$student_id] = $status;
            }
        }

        $result = $this->Attendance_model->save_bulk($class_id, $date, $clean);

        if ($result) {
            $this->session->set_flashdata('success', 'Attendance saved successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to save attendance. Please try again.');
        }

        redirect('attendance/take?class_id=' . $class_id . '&date=' . $date);
    }

    // ---------- Summary / Report ----------
    public function summary() {
        $data['title']   = 'Attendance Summary';
        $data['icon']    = 'bar-chart';
        $data['classes'] = $this->Class_model->get_all();
        $data['summary'] = [];
        $data['class']   = null;
        $data['from']    = null;
        $data['to']      = null;

        $class_id = $this->input->get('class_id');
        $from     = $this->input->get('from');
        $to       = $this->input->get('to');

        if ($class_id && $from && $to) {
            $data['class']   = $this->Class_model->get_by_id($class_id);
            $data['from']    = $from;
            $data['to']      = $to;
            $data['summary'] = $this->Attendance_model->get_summary($class_id, $from, $to);
        }

        $this->load->view('attendance/summary', $data);
    }
}