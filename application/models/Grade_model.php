<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Grade_model extends CI_Model {

    private $table = 'grades';

    // Get all grades for a class + semester (joined with student & subject)
    public function get_by_class_semester($class_id, $semester) {
        return $this->db
            ->select('grades.id, grades.score, grades.semester,
                      students.id as student_id, students.name as student_name,
                      subjects.id as subject_id, subjects.name as subject_name')
            ->join('students', 'students.id = grades.student_id')
            ->join('subjects', 'subjects.id = grades.subject_id')
            ->where('students.class_id', $class_id)
            ->where('grades.semester', $semester)
            ->order_by('students.name, subjects.name', 'ASC')
            ->get($this->table)->result();
    }

    // Get all grades for one student (report card)
    public function get_report_card($student_id, $semester) {
        return $this->db
            ->select('grades.score, grades.semester,
                      subjects.name as subject_name')
            ->join('subjects', 'subjects.id = grades.subject_id')
            ->where('grades.student_id', $student_id)
            ->where('grades.semester', $semester)
            ->order_by('subjects.name', 'ASC')
            ->get($this->table)->result();
    }

    // Get existing grade for one student + subject + semester
    public function get_one($student_id, $subject_id, $semester) {
        return $this->db
            ->where('student_id', $student_id)
            ->where('subject_id', $subject_id)
            ->where('semester',   $semester)
            ->get($this->table)->row();
    }

    // Save bulk grades (insert or update per student+subject+semester)
    public function save_bulk($grades_data) {
        $this->db->trans_start();

        foreach ($grades_data as $row) {
            $existing = $this->get_one(
                $row['student_id'],
                $row['subject_id'],
                $row['semester']
            );

            if ($existing) {
                $this->db
                    ->where('id', $existing->id)
                    ->update($this->table, ['score' => $row['score']]);
            } else {
                $this->db->insert($this->table, $row);
            }
        }

        $this->db->trans_complete();
        
        return $this->db->trans_status();
    }

    // Get GPA summary per student for a class+semester
    public function get_gpa_summary($class_id, $semester) {
        return $this->db
            ->select('students.id as student_id,
                      students.name as student_name,
                      classes.name as class_name,
                      AVG(grades.score) as average,
                      COUNT(grades.id)  as total_subjects,
                      MIN(grades.score) as lowest,
                      MAX(grades.score) as highest')
            ->join('students', 'students.id = grades.student_id')
            ->join('classes',  'classes.id  = students.class_id')
            ->where('students.class_id', $class_id)
            ->where('grades.semester',   $semester)
            ->group_by('students.id')
            ->order_by('average', 'DESC')
            ->get($this->table)->result();
    }

    // Get subjects assigned to a class (from class_subjects)
    public function get_class_subjects($class_id) {
        return $this->db
            ->select('subjects.id, subjects.name')
            ->join('subjects', 'subjects.id = class_subjects.subject_id')
            ->where('class_subjects.class_id', $class_id)
            ->order_by('subjects.name', 'ASC')
            ->get('class_subjects')->result();
    }

    // Get students in a class with their scores for a specific subject+semester
    public function get_students_with_scores($class_id, $subject_id, $semester) {
        $students = $this->db
            ->select('students.id as student_id, students.name as student_name')
            ->where('class_id', $class_id)
            ->order_by('name', 'ASC')
            ->get('students')->result();

        // Get existing scores
        $existing = $this->db
            ->select('grades.student_id, grades.score')
            ->join('students', 'students.id = grades.student_id')
            ->where('students.class_id', $class_id)
            ->where('grades.subject_id', $subject_id)
            ->where('grades.semester',   $semester)
            ->get($this->table)->result();

        $score_map = [];
        foreach ($existing as $row) {
            $score_map[$row->student_id] = $row->score;
        }

        foreach ($students as $student) {
            $student->score = $score_map[$student->student_id] ?? null;
        }

        return $students;
    }
}