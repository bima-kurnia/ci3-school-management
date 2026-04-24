<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment_model extends CI_Model {

    private $table = 'payments';

    // Get all payments (joined with student + class)
    public function get_all() {
        return $this->db
            ->select('payments.*, students.name as student_name,
                      classes.name as class_name')
            ->join('students', 'students.id = payments.student_id')
            ->join('classes',  'classes.id  = students.class_id', 'left')
            ->order_by('payments.payment_date', 'DESC')
            ->get($this->table)->result();
    }

    // Get payments by student
    public function get_by_student($student_id) {
        return $this->db
            ->select('payments.*, students.name as student_name,
                      classes.name as class_name')
            ->join('students', 'students.id = payments.student_id')
            ->join('classes',  'classes.id  = students.class_id', 'left')
            ->where('payments.student_id', $student_id)
            ->order_by('payments.payment_date', 'DESC')
            ->get($this->table)->result();
    }

    // Get single payment
    public function get_by_id($id) {
        return $this->db
            ->select('payments.*, students.name as student_name,
                      classes.name as class_name')
            ->join('students', 'students.id = payments.student_id')
            ->join('classes',  'classes.id  = students.class_id', 'left')
            ->where('payments.id', $id)
            ->get($this->table)->row();
    }

    // Get payments filtered by month+year
    public function get_by_month($month, $year) {
        return $this->db
            ->select('payments.*, students.name as student_name,
                      classes.name as class_name')
            ->join('students', 'students.id = payments.student_id')
            ->join('classes',  'classes.id  = students.class_id', 'left')
            ->where('MONTH(payments.payment_date)', $month)
            ->where('YEAR(payments.payment_date)',  $year)
            ->order_by('payments.payment_date', 'DESC')
            ->get($this->table)->result();
    }

    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data) {
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    public function delete($id) {
        return $this->db->where('id', $id)->delete($this->table);
    }

    // ---------- Summary stats ----------

    // Total income (all time)
    public function get_total_income() {
        return $this->db->select_sum('amount')->get($this->table)->row()->amount ?? 0;
    }

    // Total income this month
    public function get_income_this_month() {
        return $this->db
            ->select_sum('amount')
            ->where('MONTH(payment_date)', date('m'))
            ->where('YEAR(payment_date)',  date('Y'))
            ->get($this->table)->row()->amount ?? 0;
    }

    // Total payments count
    public function get_total_count() {
        return $this->db->count_all($this->table);
    }

    // Monthly income breakdown (last 12 months) for chart
    public function get_monthly_breakdown() {
        return $this->db->query("
            SELECT
                DATE_FORMAT(payment_date, '%b %Y') as month_label,
                DATE_FORMAT(payment_date, '%Y-%m') as month_key,
                SUM(amount) as total
            FROM payments
            WHERE payment_date >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH)
            GROUP BY month_key, month_label
            ORDER BY month_key ASC
        ")->result();
    }

    // Income by description/type
    public function get_by_description() {
        return $this->db
            ->select('description, SUM(amount) as total, COUNT(id) as count')
            ->group_by('description')
            ->order_by('total', 'DESC')
            ->get($this->table)->result();
    }
}