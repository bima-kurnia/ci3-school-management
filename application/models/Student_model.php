<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student_model extends CI_Model {
    private $table = 'students';

    public function get_all() {
        return $this->db
            ->select('students.*, classes.name as class_name')
            ->join('classes', 'classes.id = students.class_id', 'left')
            ->order_by('students.name', 'ASC')
            ->get($this->table)->result();
    }

    public function get_by_id($id) {
        return $this->db
            ->select('students.*, classes.name as class_name')
            ->join('classes', 'classes.id = students.class_id', 'left')
            ->where('students.id', $id)
            ->get($this->table)->row();
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

    public function count_all() {
        return $this->db->count_all($this->table);
    }
}