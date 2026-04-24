<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payments extends My_Controller {

    public function __construct() {
        parent::__construct();
        $this->require_role('admin');
        $this->load->model([
            'Payment_model',
            'Student_model',
        ]);
    }

    // ---------- LIST: All payments ----------
    public function index() {
        $data['title']        = 'Payments';
        $data['icon']         = 'money';
        $data['payments']     = $this->Payment_model->get_all();
        $data['total_income'] = $this->Payment_model->get_total_income();
        $data['this_month']   = $this->Payment_model->get_income_this_month();
        $data['total_count']  = $this->Payment_model->get_total_count();

        $this->load->view('payments/index', $data);
    }

    // ---------- CREATE ----------
    public function create() {
        $data['title']    = 'Record Payment';
        $data['icon']     = 'money';
        $data['students'] = $this->Student_model->get_all();

        $this->form_validation->set_rules('student_id',   'Student',     'required');
        $this->form_validation->set_rules('amount',       'Amount',      'required|numeric');
        $this->form_validation->set_rules('description',  'Description', 'required|trim');
        $this->form_validation->set_rules('payment_date', 'Date',        'required');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('payments/form', $data);
        } else {
            $this->db->trans_start();

            $this->Payment_model->insert([
                'student_id'   => $this->input->post('student_id'),
                'amount'       => $this->input->post('amount'),
                'description'  => $this->input->post('description'),
                'payment_date' => $this->input->post('payment_date'),
            ]);

            $this->db->trans_complete();

            if ($this->db->trans_status()) {
                $this->session->set_flashdata('success', 'Payment recorded successfully.');
            } else {
                $this->session->set_flashdata('error', 'Failed to record payment.');
            }

            redirect('payments');
        }
    }

    // ---------- EDIT ----------
    public function edit($id) {
        $data['title']    = 'Edit Payment';
        $data['icon']     = 'money';
        $data['payment']  = $this->Payment_model->get_by_id($id);
        $data['students'] = $this->Student_model->get_all();

        if (!$data['payment']) { 
            show_404(); 
        }

        $this->form_validation->set_rules('student_id',   'Student',     'required');
        $this->form_validation->set_rules('amount',       'Amount',      'required|numeric');
        $this->form_validation->set_rules('description',  'Description', 'required|trim');
        $this->form_validation->set_rules('payment_date', 'Date',        'required');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('payments/form', $data);
        } else {
            $this->Payment_model->update($id, [
                'student_id'   => $this->input->post('student_id'),
                'amount'       => $this->input->post('amount'),
                'description'  => $this->input->post('description'),
                'payment_date' => $this->input->post('payment_date'),
            ]);

            $this->session->set_flashdata('success', 'Payment updated successfully.');

            redirect('payments');
        }
    }

    // ---------- DELETE ----------
    public function delete($id) {
        $this->Payment_model->delete($id);
        $this->session->set_flashdata('success', 'Payment deleted.');

        redirect('payments');
    }

    // ---------- DETAIL: Per student ----------
    public function student($student_id) {
        $student = $this->Student_model->get_by_id($student_id);

        if (!$student) { 
            show_404(); 
        }

        $data['title']    = 'Payment History';
        $data['icon']     = 'history';
        $data['student']  = $student;
        $data['payments'] = $this->Payment_model->get_by_student($student_id);
        $data['total']    = array_sum(array_column($data['payments'], 'amount'));

        $this->load->view('payments/student', $data);
    }

    // ---------- MONTHLY REPORT ----------
    public function report() {
        $month = $this->input->get('month') ?? date('m');
        $year  = $this->input->get('year')  ?? date('Y');

        $data['title']     = 'Payment Report';
        $data['icon']      = 'file-text';
        $data['month']     = $month;
        $data['year']      = $year;
        $data['payments']  = $this->Payment_model->get_by_month($month, $year);
        $data['monthly']   = $this->Payment_model->get_monthly_breakdown();
        $data['by_desc']   = $this->Payment_model->get_by_description();
        $data['subtotal']  = array_sum(array_column(
                                array_map(fn($p) => (array)$p, $data['payments']),
                                'amount'));

        // Build months list for filter dropdown
        $data['months'] = [];
        for ($m = 1; $m <= 12; $m++) {
            $data['months'][$m] = date('F', mktime(0, 0, 0, $m, 1));
        }

        // Build years list
        $data['years'] = range(date('Y') - 2, date('Y'));

        $this->load->view('payments/report', $data);
    }
}