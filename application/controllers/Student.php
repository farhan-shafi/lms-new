<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('course_model');
        $this->load->model('category_model');
        $this->load->model('lesson_model');
        $this->load->helper('url');
        $this->load->library('session');
        
        // Check if user is logged in and is student
        if (!$this->session->userdata('user_id') || $this->session->userdata('role') != 'student') {
            $this->session->set_flashdata('error', 'You must be logged in as a student to access this page');
            redirect('auth/login');
        }
    }

    public function index() {
        redirect('student/dashboard');
    }

    public function dashboard() {
        // Get student's enrolled courses
        $student_id = $this->session->userdata('user_id');
        $data['courses'] = $this->course_model->get_enrolled_courses($student_id);
        $data['title'] = 'Student Dashboard';
        
        // Load views
        $this->load->view('templates/header', $data);
        $this->load->view('student/dashboard', $data);
        $this->load->view('templates/footer');
    }

    public function courses() {
        // Get all published courses
        $data['courses'] = $this->course_model->get_published_courses();
        $data['categories'] = $this->category_model->get_all_categories();
        $data['title'] = 'Browse Courses';
        
        // Load views
        $this->load->view('templates/header', $data);
        $this->load->view('student/courses', $data);
        $this->load->view('templates/footer');
    }

    public function my_courses() {
        // Get student's enrolled courses
        $student_id = $this->session->userdata('user_id');
        $data['courses'] = $this->course_model->get_enrolled_courses($student_id);
        $data['title'] = 'My Courses';
        
        // Load views
        $this->load->view('templates/header', $data);
        $this->load->view('student/my_courses', $data);
        $this->load->view('templates/footer');
    }

    public function course($course_id) {
        // Get course details
        $data['course'] = $this->course_model->get_course($course_id);
        
        if (!$data['course']) {
            show_404();
        }
        
        // Check if course is published
        if ($data['course']->status != 'published') {
            $this->session->set_flashdata('error', 'This course is not available');
            redirect('student/courses');
        }
        
        // Load the lessons for this course
        $data['lessons'] = $this->lesson_model->get_course_lessons($course_id);
        
        // Check if student is enrolled
        $student_id = $this->session->userdata('user_id');
        $data['is_enrolled'] = $this->course_model->is_enrolled($student_id, $course_id);
        
        // Get course progress if enrolled
        if ($data['is_enrolled']) {
            $data['progress'] = $this->lesson_model->get_course_progress($student_id, $course_id);
        }
        
        $data['title'] = $data['course']->title;
        
        // Load views
        $this->load->view('templates/header', $data);
        $this->load->view('student/course_detail', $data);
        $this->load->view('templates/footer');
    }

    public function lesson($course_id, $lesson_id) {
        // Get course details
        $data['course'] = $this->course_model->get_course($course_id);
        
        if (!$data['course']) {
            show_404();
        }
        
        // Check if course is published
        if ($data['course']->status != 'published') {
            $this->session->set_flashdata('error', 'This course is not available');
            redirect('student/courses');
        }
        
        // Load the lesson
        $data['lesson'] = $this->lesson_model->get_lesson($lesson_id);
        
        if (!$data['lesson'] || $data['lesson']->course_id != $course_id) {
            show_404();
        }
        
        // Check if student is enrolled
        $student_id = $this->session->userdata('user_id');
        $is_enrolled = $this->course_model->is_enrolled($student_id, $course_id);
        
        if (!$is_enrolled) {
            $this->session->set_flashdata('error', 'You need to enroll in this course to access lessons');
            redirect('student/course/' . $course_id);
        }
        
        // Get all lessons for navigation
        $data['lessons'] = $this->lesson_model->get_course_lessons($course_id);
        
        // Mark lesson as accessed/completed
        $this->lesson_model->mark_lesson_completed($student_id, $lesson_id);
        
        // Get course progress
        $data['progress'] = $this->lesson_model->get_course_progress($student_id, $course_id);
        
        // Check if lesson is completed
        $data['is_completed'] = $this->lesson_model->is_lesson_completed($student_id, $lesson_id);
        
        $data['title'] = $data['lesson']->title . ' - ' . $data['course']->title;
        
        // Load views
        $this->load->view('templates/header', $data);
        $this->load->view('student/lesson_view', $data);
        $this->load->view('templates/footer');
    }

    public function enroll($course_id) {
        // Get course details
        $course = $this->course_model->get_course($course_id);
        
        if (!$course || $course->status != 'published') {
            show_404();
        }
        
        // Enroll the student
        $student_id = $this->session->userdata('user_id');
        $enrolled = $this->course_model->enroll_student($student_id, $course_id);
        
        if ($enrolled) {
            $this->session->set_flashdata('success', 'You have successfully enrolled in this course');
        } else {
            $this->session->set_flashdata('info', 'You are already enrolled in this course');
        }
        
        redirect('student/course/' . $course_id);
    }

    public function profile() {
        $student_id = $this->session->userdata('user_id');
        $data['user'] = $this->user_model->get_user($student_id);
        $data['title'] = 'My Profile';
        
        // Load views
        $this->load->view('templates/header', $data);
        $this->load->view('student/profile', $data);
        $this->load->view('templates/footer');
    }

    public function edit_profile() {
        $student_id = $this->session->userdata('user_id');
        $data['user'] = $this->user_model->get_user($student_id);
        
        // Load form validation library
        $this->load->library('form_validation');
        
        // Form validation rules
        $this->form_validation->set_rules('full_name', 'Full Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        
        if ($this->form_validation->run() === FALSE) {
            $data['title'] = 'Edit Profile';
            
            // Load views
            $this->load->view('templates/header', $data);
            $this->load->view('student/edit_profile', $data);
            $this->load->view('templates/footer');
        } else {
            // Get form data
            $update_data = array(
                'full_name' => $this->input->post('full_name'),
                'email' => $this->input->post('email'),
                'bio' => $this->input->post('bio')
            );
            
            // If password is provided, update it
            if ($this->input->post('password') && $this->input->post('password') != '') {
                $update_data['password'] = $this->input->post('password');
            }
            
            // Update user
            $updated = $this->user_model->update_user($student_id, $update_data);
            
            if ($updated) {
                // Update session data
                $this->session->set_userdata('full_name', $update_data['full_name']);
                $this->session->set_userdata('email', $update_data['email']);
                
                $this->session->set_flashdata('success', 'Profile updated successfully');
                redirect('student/profile');
            } else {
                $this->session->set_flashdata('error', 'Failed to update profile');
                redirect('student/edit_profile');
            }
        }
    }

    public function mark_lesson_complete($lesson_id) {
        // Ensure AJAX request
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        $student_id = $this->session->userdata('user_id');
        $lesson = $this->lesson_model->get_lesson($lesson_id);
        
        if (!$lesson) {
            echo json_encode(array('success' => false, 'message' => 'Lesson not found'));
            return;
        }
        
        // Check if student is enrolled in the course
        $is_enrolled = $this->course_model->is_enrolled($student_id, $lesson->course_id);
        if (!$is_enrolled) {
            echo json_encode(array('success' => false, 'message' => 'You are not enrolled in this course'));
            return;
        }
        
        // Mark lesson as completed
        $result = $this->lesson_model->mark_lesson_completed($student_id, $lesson_id);
        
        if ($result) {
            // Get updated progress
            $progress = $this->lesson_model->get_course_progress($student_id, $lesson->course_id);
            
            echo json_encode(array(
                'success' => true, 
                'message' => 'Lesson marked as completed!',
                'progress' => $progress
            ));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Failed to mark lesson as completed'));
        }
    }

    public function toggle_lesson_completion($lesson_id) {
        // Ensure AJAX request
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        
        $student_id = $this->session->userdata('user_id');
        $lesson = $this->lesson_model->get_lesson($lesson_id);
        
        if (!$lesson) {
            echo json_encode(array('success' => false, 'message' => 'Lesson not found'));
            return;
        }
        
        // Check if student is enrolled in the course
        $is_enrolled = $this->course_model->is_enrolled($student_id, $lesson->course_id);
        if (!$is_enrolled) {
            echo json_encode(array('success' => false, 'message' => 'You are not enrolled in this course'));
            return;
        }
        
        // Check current completion status
        $is_completed = $this->lesson_model->is_lesson_completed($student_id, $lesson_id);
        
        if ($is_completed) {
            // Mark as incomplete
            $result = $this->lesson_model->mark_lesson_incomplete($student_id, $lesson_id);
            $message = 'Lesson marked as incomplete';
        } else {
            // Mark as completed
            $result = $this->lesson_model->mark_lesson_completed($student_id, $lesson_id);
            $message = 'Lesson marked as completed!';
        }
        
        if ($result) {
            // Get updated progress
            $progress = $this->lesson_model->get_course_progress($student_id, $lesson->course_id);
            
            echo json_encode(array(
                'success' => true, 
                'message' => $message,
                'progress' => $progress,
                'completed' => !$is_completed
            ));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Failed to update lesson status'));
        }
    }
} 
