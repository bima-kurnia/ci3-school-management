<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Class_subject_model extends CI_Model {

    private $table = 'class_subjects';

    // Get all assignments for a specific class (with subject & teacher names)
    public function get_by_class($class_id) {
        return $this->db
            ->select('class_subjects.id, subjects.name as subject_name,
                      teachers.name as teacher_name, teachers.id as teacher_id,
                      subjects.id as subject_id')
            ->join('subjects', 'subjects.id = class_subjects.subject_id', 'left')
            ->join('teachers', 'teachers.id = class_subjects.teacher_id', 'left')
            ->where('class_subjects.class_id', $class_id)
            ->get($this->table)->result();
    }

    // Get all assignments (for full overview)
    public function get_all() {
        return $this->db
            ->select('class_subjects.id, classes.name as class_name,
                      subjects.name as subject_name, teachers.name as teacher_name')
            ->join('classes',  'classes.id  = class_subjects.class_id',   'left')
            ->join('subjects', 'subjects.id = class_subjects.subject_id', 'left')
            ->join('teachers', 'teachers.id = class_subjects.teacher_id', 'left')
            ->order_by('classes.name', 'ASC')
            ->get($this->table)->result();
    }

    public function get_by_id($id) {
        return $this->db->where('id', $id)->get($this->table)->row();
    }

    // Check if subject already assigned to this class
    public function is_duplicate($class_id, $subject_id, $exclude_id = null) {
        $this->db->where('class_id',   $class_id)
            ->where('subject_id', $subject_id);

        if ($exclude_id) {
            $this->db->where('id !=', $exclude_id);
        }

        return $this->db->count_all_results($this->table) > 0;
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
}