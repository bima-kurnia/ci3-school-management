<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Attendance_model extends CI_Model {

    private $table = 'attendance';

    // Get attendance by class and date (with student name)
    public function get_by_class_date($class_id, $date) {
        return $this->db
            ->select('attendance.id, attendance.status,
                      students.id as student_id, students.name as student_name')
            ->join('students', 'students.id = attendance.student_id', 'right')
            ->where('students.class_id', $class_id)
            ->where('attendance.date', $date)
            ->order_by('students.name', 'ASC')
            ->get($this->table)->result();
    }

    // Get all students in a class, with their attendance status if exists
    public function get_students_with_status($class_id, $date) {
        // Get all students in class
        $students = $this->db
            ->select('students.id as student_id, students.name as student_name')
            ->where('class_id', $class_id)
            ->order_by('name', 'ASC')
            ->get('students')->result();

        // Get existing attendance for this class+date
        $existing = $this->get_by_class_date($class_id, $date);

        // Map existing attendance by student_id
        $status_map = [];
        foreach ($existing as $row) {
            $status_map[$row->student_id] = $row->status;
        }

        // Merge: attach status to each student
        foreach ($students as $student) {
            $student->status = isset($status_map[$student->student_id])
                ? $status_map[$student->student_id]
                : null;
        }

        return $students;
    }

    // Check if attendance already saved for class + date
    public function is_taken($class_id, $date) {
        return $this->db
            ->join('students', 'students.id = attendance.student_id')
            ->where('students.class_id', $class_id)
            ->where('attendance.date', $date)
            ->count_all_results($this->table) > 0;
    }

    // Save bulk attendance (delete old + insert new)
    public function save_bulk($class_id, $date, $attendance_data) {
        $this->db->trans_start();

        // Delete existing records for this class + date
        $student_ids = $this->db
            ->select('id')
            ->where('class_id', $class_id)
            ->get('students')->result();

        $ids = array_column($student_ids, 'id');

        if (!empty($ids)) {
            $this->db
                ->where_in('student_id', $ids)
                ->where('date', $date)
                ->delete($this->table);
        }

        // Insert new records
        $insert_batch = [];
        foreach ($attendance_data as $student_id => $status) {
            $insert_batch[] = [
                'student_id' => $student_id,
                'date'       => $date,
                'status'     => $status,
            ];
        }

        if (!empty($insert_batch)) {
            $this->db->insert_batch($this->table, $insert_batch);
        }

        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    // Get attendance summary per student for a date range
    public function get_summary($class_id, $from, $to) {
        return $this->db
            ->select('students.name as student_name,
                      SUM(attendance.status = "present")  as total_present,
                      SUM(attendance.status = "absent")   as total_absent,
                      SUM(attendance.status = "late")     as total_late,
                      SUM(attendance.status = "excused")  as total_excused,
                      COUNT(attendance.id)                as total_days')
            ->join('students', 'students.id = attendance.student_id')
            ->where('students.class_id', $class_id)
            ->where('attendance.date >=', $from)
            ->where('attendance.date <=', $to)
            ->group_by('students.id')
            ->order_by('students.name', 'ASC')
            ->get($this->table)->result();
    }
}