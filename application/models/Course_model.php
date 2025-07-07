<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Course_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Create a new course
    public function create_course($data) {
        $this->db->insert('courses', $data);
        return $this->db->insert_id();
    }

    // Get all courses (for admin)
    public function get_all_courses() {
        $this->db->select('courses.*, categories.name as category_name, users.full_name as instructor_name');
        $this->db->from('courses');
        $this->db->join('categories', 'categories.id = courses.category_id', 'left');
        $this->db->join('users', 'users.id = courses.instructor_id', 'left');
        $this->db->order_by('courses.created_at', 'DESC');
        
        $query = $this->db->get();
        return $query->result();
    }

    // Get published courses
    public function get_published_courses() {
        $this->db->select('courses.*, categories.name as category_name, users.full_name as instructor_name');
        $this->db->from('courses');
        $this->db->join('categories', 'categories.id = courses.category_id', 'left');
        $this->db->join('users', 'users.id = courses.instructor_id', 'left');
        $this->db->where('courses.status', 'published');
        $this->db->order_by('courses.created_at', 'DESC');
        
        $query = $this->db->get();
        return $query->result();
    }

    // Get courses by instructor
    public function get_instructor_courses($instructor_id) {
        $this->db->select('courses.*, categories.name as category_name');
        $this->db->from('courses');
        $this->db->join('categories', 'categories.id = courses.category_id', 'left');
        $this->db->where('courses.instructor_id', $instructor_id);
        $this->db->order_by('courses.created_at', 'DESC');
        
        $query = $this->db->get();
        return $query->result();
    }

    // Get courses by category
    public function get_courses_by_category($category_id) {
        $this->db->select('courses.*, categories.name as category_name, users.full_name as instructor_name');
        $this->db->from('courses');
        $this->db->join('categories', 'categories.id = courses.category_id', 'left');
        $this->db->join('users', 'users.id = courses.instructor_id', 'left');
        $this->db->where('courses.category_id', $category_id);
        $this->db->where('courses.status', 'published');
        $this->db->order_by('courses.created_at', 'DESC');
        
        $query = $this->db->get();
        return $query->result();
    }

    // Get course by ID
    public function get_course($course_id) {
        $this->db->select('courses.*, categories.name as category_name, users.full_name as instructor_name');
        $this->db->from('courses');
        $this->db->join('categories', 'categories.id = courses.category_id', 'left');
        $this->db->join('users', 'users.id = courses.instructor_id', 'left');
        $this->db->where('courses.id', $course_id);
        
        $query = $this->db->get();
        
        if ($query->num_rows() == 1) {
            return $query->row();
        }
        
        return false;
    }

    // Update course
    public function update_course($course_id, $data) {
        $this->db->where('id', $course_id);
        $this->db->update('courses', $data);
        
        return $this->db->affected_rows() > 0;
    }

    // Delete course
    public function delete_course($course_id) {
        $this->db->where('id', $course_id);
        $this->db->delete('courses');
        
        return $this->db->affected_rows() > 0;
    }

    // Enroll student in course
    public function enroll_student($user_id, $course_id) {
        $data = array(
            'user_id' => $user_id,
            'course_id' => $course_id
        );
        
        // Check if already enrolled
        $this->db->where($data);
        $query = $this->db->get('enrollments');
        
        if ($query->num_rows() == 0) {
            // Not enrolled yet, insert new enrollment
            $this->db->insert('enrollments', $data);
            return $this->db->insert_id();
        }
        
        return false; // Already enrolled
    }

    // Get enrolled courses for a student
    public function get_enrolled_courses($user_id) {
        $this->db->select('courses.*, categories.name as category_name, users.full_name as instructor_name');
        $this->db->from('enrollments');
        $this->db->join('courses', 'courses.id = enrollments.course_id');
        $this->db->join('categories', 'categories.id = courses.category_id', 'left');
        $this->db->join('users', 'users.id = courses.instructor_id', 'left');
        $this->db->where('enrollments.user_id', $user_id);
        $this->db->order_by('enrollments.enrolled_at', 'DESC');
        
        $query = $this->db->get();
        $courses = $query->result();
        
        // Add progress information for each course
        $this->load->model('lesson_model');
        foreach ($courses as $course) {
            $progress = $this->lesson_model->get_course_progress($user_id, $course->id);
            $course->progress_percentage = $progress['percentage'];
            $course->completed_lessons = $progress['completed'];
            $course->total_lessons = $progress['total'];
            $course->next_lesson_id = $progress['next_lesson'];
        }
        
        return $courses;
    }

    // Check if user is enrolled in a course
    public function is_enrolled($user_id, $course_id) {
        $this->db->where('user_id', $user_id);
        $this->db->where('course_id', $course_id);
        $query = $this->db->get('enrollments');
        
        return $query->num_rows() > 0;
    }
} 
