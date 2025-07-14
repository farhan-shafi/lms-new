<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('course_model');
        $this->load->model('category_model');
        $this->load->model('rating_model');
        $this->load->helper('url');
        $this->load->library('session');
    }

    public function index() {
        // Get all published courses for homepage
        $data['courses'] = $this->course_model->get_published_courses();
        $data['categories'] = $this->category_model->get_all_categories();
        $data['title'] = 'Home - Learning Management System';
        
        // Load views
        $this->load->view('templates/header', $data);
        $this->load->view('home/index', $data);
        $this->load->view('templates/footer');
    }

    public function courses() {
        // Get all published courses
        $data['courses'] = $this->course_model->get_published_courses();
        $data['categories'] = $this->category_model->get_all_categories();
        $data['title'] = 'All Courses - Learning Management System';
        
        // Load views
        $this->load->view('templates/header', $data);
        $this->load->view('home/courses', $data);
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
            // If user is not logged in or not the instructor/admin, show 404
            if (!$this->session->userdata('user_id') || 
                ($this->session->userdata('role') != 'admin' && 
                 $this->session->userdata('user_id') != $data['course']->instructor_id)) {
                show_404();
            }
        }
        
        // Load the lessons for this course
        $this->load->model('lesson_model');
        $data['lessons'] = $this->lesson_model->get_course_lessons($course_id);
        
        // Check if user is enrolled
        $data['is_enrolled'] = false;
        if ($this->session->userdata('user_id')) {
            $data['is_enrolled'] = $this->course_model->is_enrolled(
                $this->session->userdata('user_id'), 
                $course_id
            );
        }
        
        $data['title'] = $data['course']->title . ' - Learning Management System';
        
        // Load views
        $this->load->view('templates/header', $data);
        $this->load->view('home/course_detail', $data);
        $this->load->view('templates/footer');
    }

    public function lesson($course_id, $lesson_id) {
        // Check if user is logged in
        if (!$this->session->userdata('user_id')) {
            $this->session->set_flashdata('error', 'You need to login to access lessons');
            redirect('auth/login');
        }
        
        // Get course details
        $data['course'] = $this->course_model->get_course($course_id);
        
        if (!$data['course']) {
            show_404();
        }
        
        // Load the lesson
        $this->load->model('lesson_model');
        $data['lesson'] = $this->lesson_model->get_lesson($lesson_id);
        
        if (!$data['lesson'] || $data['lesson']->course_id != $course_id) {
            show_404();
        }
        
        // Check if user is enrolled or is instructor/admin
        $is_enrolled = $this->course_model->is_enrolled(
            $this->session->userdata('user_id'), 
            $course_id
        );
        
        $is_instructor = ($this->session->userdata('user_id') == $data['course']->instructor_id);
        $is_admin = ($this->session->userdata('role') == 'admin');
        
        if (!$is_enrolled && !$is_instructor && !$is_admin) {
            $this->session->set_flashdata('error', 'You need to enroll in this course to access lessons');
            redirect('home/course/' . $course_id);
        }
        
        // Get all lessons for navigation
        $data['lessons'] = $this->lesson_model->get_course_lessons($course_id);
        
        // Check if lesson is completed by the user
        $data['is_completed'] = $this->lesson_model->is_lesson_completed(
            $this->session->userdata('user_id'),
            $lesson_id
        );
        
        // Get course progress if user is a student
        if ($this->session->userdata('role') == 'student') {
            $progress = $this->lesson_model->get_course_progress(
                $this->session->userdata('user_id'),
                $course_id
            );
            $data['progress'] = $progress['percentage'];
        }
        
        $data['title'] = $data['lesson']->title . ' - ' . $data['course']->title;
        
        // Load views
        $this->load->view('templates/header', $data);
        $this->load->view('home/lesson_view', $data);
        $this->load->view('templates/footer');
    }

    public function category($category_id) {
        // Get category details
        $data['category'] = $this->category_model->get_category($category_id);
        
        if (!$data['category']) {
            show_404();
        }
        
        // Get courses in this category
        $data['courses'] = $this->course_model->get_courses_by_category($category_id);
        $data['categories'] = $this->category_model->get_all_categories();
        $data['title'] = $data['category']->name . ' Courses - Learning Management System';
        
        // Load views
        $this->load->view('templates/header', $data);
        $this->load->view('home/category', $data);
        $this->load->view('templates/footer');
    }

    public function enroll($course_id) {
        // Check if user is logged in
        if (!$this->session->userdata('user_id')) {
            $this->session->set_flashdata('error', 'You need to login to enroll in courses');
            redirect('auth/login');
        }
        
        // Check if user is a student
        if ($this->session->userdata('role') != 'student') {
            $this->session->set_flashdata('error', 'Only students can enroll in courses');
            redirect('home/course/' . $course_id);
        }
        
        // Get course details
        $course = $this->course_model->get_course($course_id);
        
        if (!$course || $course->status != 'published') {
            show_404();
        }
        
        // Enroll the student
        $enrolled = $this->course_model->enroll_student(
            $this->session->userdata('user_id'),
            $course_id
        );
        
        if ($enrolled) {
            $this->session->set_flashdata('success', 'You have successfully enrolled in this course');
        } else {
            $this->session->set_flashdata('info', 'You are already enrolled in this course');
        }
        
        redirect('home/course/' . $course_id);
    }
    
    public function about() {
        $data['title'] = 'About Us - Mentora Learning Platform';
        
        // Load views
        $this->load->view('templates/header', $data);
        $this->load->view('home/about', $data);
        $this->load->view('templates/footer');
    }
    
    public function contact() {
        // Load form validation library
        $this->load->library('form_validation');
        
        // Form validation rules
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('subject', 'Subject', 'required');
        $this->form_validation->set_rules('message', 'Message', 'required');
        
        if ($this->form_validation->run() === FALSE) {
            $data['title'] = 'Contact Us - Mentora Learning Platform';
            
            // Load views
            $this->load->view('templates/header', $data);
            $this->load->view('home/contact', $data);
            $this->load->view('templates/footer');
        } else {
            // Process the form submission
            // In a real application, you would send an email or save to database
            $this->session->set_flashdata('success', 'Thank you for contacting us! We will get back to you soon.');
            redirect('home/contact');
        }
    }
} 
