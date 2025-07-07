<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Create a new category
    public function create_category($data) {
        $this->db->insert('categories', $data);
        return $this->db->insert_id();
    }

    // Get all categories
    public function get_all_categories() {
        $query = $this->db->get('categories');
        return $query->result();
    }

    // Get category by ID
    public function get_category($category_id) {
        $this->db->where('id', $category_id);
        $query = $this->db->get('categories');
        
        if ($query->num_rows() == 1) {
            return $query->row();
        }
        
        return false;
    }

    // Update category
    public function update_category($category_id, $data) {
        $this->db->where('id', $category_id);
        $this->db->update('categories', $data);
        
        return $this->db->affected_rows() > 0;
    }

    // Delete category
    public function delete_category($category_id) {
        $this->db->where('id', $category_id);
        $this->db->delete('categories');
        
        return $this->db->affected_rows() > 0;
    }

    // Get categories with course count
    public function get_categories_with_course_count() {
        $this->db->select('categories.*, COUNT(courses.id) as course_count');
        $this->db->from('categories');
        $this->db->join('courses', 'courses.category_id = categories.id', 'left');
        $this->db->where('courses.status', 'published');
        $this->db->group_by('categories.id');
        
        $query = $this->db->get();
        return $query->result();
    }
} 
