<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lesson_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Create a new lesson
    public function create_lesson($data) {
        $this->db->insert('lessons', $data);
        return $this->db->insert_id();
    }

    // Get all lessons for a course
    public function get_course_lessons($course_id) {
        $this->db->where('course_id', $course_id);
        $this->db->order_by('sort_order', 'ASC');
        $query = $this->db->get('lessons');
        return $query->result();
    }

    // Get lesson by ID
    public function get_lesson($lesson_id) {
        $this->db->where('id', $lesson_id);
        $query = $this->db->get('lessons');
        
        if ($query->num_rows() == 1) {
            return $query->row();
        }
        
        return false;
    }

    // Update lesson
    public function update_lesson($lesson_id, $data) {
        $this->db->where('id', $lesson_id);
        $this->db->update('lessons', $data);
        
        return $this->db->affected_rows() > 0;
    }

    // Delete lesson
    public function delete_lesson($lesson_id) {
        $this->db->where('id', $lesson_id);
        $this->db->delete('lessons');
        
        return $this->db->affected_rows() > 0;
    }

    // Update lesson order
    public function update_lesson_order($lesson_id, $sort_order) {
        $data = array('sort_order' => $sort_order);
        $this->db->where('id', $lesson_id);
        $this->db->update('lessons', $data);
        
        return $this->db->affected_rows() > 0;
    }

    // Mark lesson as completed for a user
    public function mark_lesson_completed($user_id, $lesson_id) {
        $data = array(
            'user_id' => $user_id,
            'lesson_id' => $lesson_id,
            'completed' => TRUE,
            'last_accessed' => date('Y-m-d H:i:s')
        );
        
        // Check if record exists
        $this->db->where('user_id', $user_id);
        $this->db->where('lesson_id', $lesson_id);
        $query = $this->db->get('lesson_progress');
        
        if ($query->num_rows() > 0) {
            // Update existing record
            $this->db->where('user_id', $user_id);
            $this->db->where('lesson_id', $lesson_id);
            $this->db->update('lesson_progress', $data);
        } else {
            // Insert new record
            $this->db->insert('lesson_progress', $data);
        }
        
        return $this->db->affected_rows() > 0;
    }

    // Check if lesson is completed by user
    public function is_lesson_completed($user_id, $lesson_id) {
        $this->db->where('user_id', $user_id);
        $this->db->where('lesson_id', $lesson_id);
        $this->db->where('completed', TRUE);
        $query = $this->db->get('lesson_progress');
        
        return $query->num_rows() > 0;
    }

    // Get user's progress for a course
    public function get_course_progress($user_id, $course_id) {
        // Get all lessons for the course
        $this->db->where('course_id', $course_id);
        $lessons = $this->db->get('lessons')->result();
        $total_lessons = count($lessons);
        
        if ($total_lessons == 0) {
            return 0; // No lessons in the course
        }
        
        // Get completed lessons
        $this->db->select('lesson_progress.*');
        $this->db->from('lesson_progress');
        $this->db->join('lessons', 'lessons.id = lesson_progress.lesson_id');
        $this->db->where('lesson_progress.user_id', $user_id);
        $this->db->where('lessons.course_id', $course_id);
        $this->db->where('lesson_progress.completed', TRUE);
        $completed_lessons = $this->db->get()->num_rows();
        
        // Calculate progress percentage
        return ($completed_lessons / $total_lessons) * 100;
    }
} 
