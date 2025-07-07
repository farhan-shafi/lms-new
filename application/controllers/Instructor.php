<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Instructor extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('course_model');
        $this->load->model('category_model');
        $this->load->model('lesson_model');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('form_validation');
        
        // Check if user is logged in and is instructor
        if (!$this->session->userdata('user_id') || $this->session->userdata('role') != 'instructor') {
            $this->session->set_flashdata('error', 'You must be logged in as an instructor to access this page');
            redirect('auth/login');
        }
    }

    public function index() {
        redirect('instructor/dashboard');
    }

    public function dashboard() {
        // Get instructor's courses
        $instructor_id = $this->session->userdata('user_id');
        $data['courses'] = $this->course_model->get_instructor_courses($instructor_id);
        $data['title'] = 'Instructor Dashboard';
        
        // Load views
        $this->load->view('templates/header', $data);
        $this->load->view('instructor/dashboard', $data);
        $this->load->view('templates/footer');
    }

    // Course Management
    public function courses() {
        $instructor_id = $this->session->userdata('user_id');
        $data['courses'] = $this->course_model->get_instructor_courses($instructor_id);
        $data['title'] = 'My Courses';
        
        // Load views
        $this->load->view('templates/header', $data);
        $this->load->view('instructor/courses', $data);
        $this->load->view('templates/footer');
    }

    public function create_course() {
        // Get categories for dropdown
        $data['categories'] = $this->category_model->get_all_categories();
        
        // Form validation rules
        $this->form_validation->set_rules('title', 'Course Title', 'required');
        
        if ($this->form_validation->run() === FALSE) {
            $data['title'] = 'Create Course';
            
            // Load views
            $this->load->view('templates/header', $data);
            $this->load->view('instructor/create_course', $data);
            $this->load->view('templates/footer');
        } else {
            // Get form data
            $data = array(
                'title' => $this->input->post('title'),
                'description' => $this->input->post('description'),
                'category_id' => $this->input->post('category_id'),
                'instructor_id' => $this->session->userdata('user_id'),
                'status' => $this->input->post('status')
            );
            
            // Create course
            $course_id = $this->course_model->create_course($data);
            
            if ($course_id) {
                $this->session->set_flashdata('success', 'Course created successfully');
                redirect('instructor/courses');
            } else {
                $this->session->set_flashdata('error', 'Failed to create course');
                redirect('instructor/create_course');
            }
        }
    }

    public function edit_course($course_id) {
        // Get course details
        $data['course'] = $this->course_model->get_course($course_id);
        
        if (!$data['course']) {
            show_404();
        }
        
        // Check if the instructor owns this course
        if ($data['course']->instructor_id != $this->session->userdata('user_id')) {
            $this->session->set_flashdata('error', 'You do not have permission to edit this course');
            redirect('instructor/courses');
        }
        
        // Get categories for dropdown
        $data['categories'] = $this->category_model->get_all_categories();
        
        // Form validation rules
        $this->form_validation->set_rules('title', 'Course Title', 'required');
        
        if ($this->form_validation->run() === FALSE) {
            $data['title'] = 'Edit Course';
            
            // Load views
            $this->load->view('templates/header', $data);
            $this->load->view('instructor/edit_course', $data);
            $this->load->view('templates/footer');
        } else {
            // Get form data
            $update_data = array(
                'title' => $this->input->post('title'),
                'description' => $this->input->post('description'),
                'category_id' => $this->input->post('category_id'),
                'status' => $this->input->post('status')
            );
            
            // Update course
            $updated = $this->course_model->update_course($course_id, $update_data);
            
            if ($updated) {
                $this->session->set_flashdata('success', 'Course updated successfully');
                redirect('instructor/courses');
            } else {
                $this->session->set_flashdata('error', 'Failed to update course');
                redirect('instructor/edit_course/' . $course_id);
            }
        }
    }

    public function delete_course($course_id) {
        // Get course details
        $course = $this->course_model->get_course($course_id);
        
        if (!$course) {
            show_404();
        }
        
        // Check if the instructor owns this course
        if ($course->instructor_id != $this->session->userdata('user_id')) {
            $this->session->set_flashdata('error', 'You do not have permission to delete this course');
            redirect('instructor/courses');
        }
        
        // Delete course
        $deleted = $this->course_model->delete_course($course_id);
        
        if ($deleted) {
            $this->session->set_flashdata('success', 'Course deleted successfully');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete course');
        }
        
        redirect('instructor/courses');
    }

    // Lesson Management
    public function lessons($course_id) {
        // Get course details
        $data['course'] = $this->course_model->get_course($course_id);
        
        if (!$data['course']) {
            show_404();
        }
        
        // Check if the instructor owns this course
        if ($data['course']->instructor_id != $this->session->userdata('user_id')) {
            $this->session->set_flashdata('error', 'You do not have permission to manage lessons for this course');
            redirect('instructor/courses');
        }
        
        // Get lessons for this course
        $data['lessons'] = $this->lesson_model->get_course_lessons($course_id);
        $data['title'] = 'Manage Lessons - ' . $data['course']->title;
        
        // Load views
        $this->load->view('templates/header', $data);
        $this->load->view('instructor/lessons', $data);
        $this->load->view('templates/footer');
    }

    public function create_lesson($course_id) {
        // Get course details
        $data['course'] = $this->course_model->get_course($course_id);
        
        if (!$data['course']) {
            show_404();
        }
        
        // Check if the instructor owns this course
        if ($data['course']->instructor_id != $this->session->userdata('user_id')) {
            $this->session->set_flashdata('error', 'You do not have permission to create lessons for this course');
            redirect('instructor/courses');
        }
        
        // Form validation rules
        $this->form_validation->set_rules('title', 'Lesson Title', 'required');
        
        if ($this->form_validation->run() === FALSE) {
            $data['title'] = 'Create Lesson - ' . $data['course']->title;
            
            // Load views
            $this->load->view('templates/header', $data);
            $this->load->view('instructor/create_lesson', $data);
            $this->load->view('templates/footer');
        } else {
            // Get form data
            $data = array(
                'course_id' => $course_id,
                'title' => $this->input->post('title'),
                'content' => $this->input->post('content'),
                'video_url' => $this->input->post('video_url'),
                'sort_order' => $this->input->post('sort_order')
            );
            
            // Create lesson
            $lesson_id = $this->lesson_model->create_lesson($data);
            
            if ($lesson_id) {
                $this->session->set_flashdata('success', 'Lesson created successfully');
                redirect('instructor/lessons/' . $course_id);
            } else {
                $this->session->set_flashdata('error', 'Failed to create lesson');
                redirect('instructor/create_lesson/' . $course_id);
            }
        }
    }

    public function edit_lesson($lesson_id) {
        // Get lesson details
        $data['lesson'] = $this->lesson_model->get_lesson($lesson_id);
        
        if (!$data['lesson']) {
            show_404();
        }
        
        // Get course details
        $data['course'] = $this->course_model->get_course($data['lesson']->course_id);
        
        // Check if the instructor owns this course
        if ($data['course']->instructor_id != $this->session->userdata('user_id')) {
            $this->session->set_flashdata('error', 'You do not have permission to edit lessons for this course');
            redirect('instructor/courses');
        }
        
        // Form validation rules
        $this->form_validation->set_rules('title', 'Lesson Title', 'required');
        
        if ($this->form_validation->run() === FALSE) {
            $data['title'] = 'Edit Lesson - ' . $data['lesson']->title;
            
            // Load views
            $this->load->view('templates/header', $data);
            $this->load->view('instructor/edit_lesson', $data);
            $this->load->view('templates/footer');
        } else {
            // Get form data
            $update_data = array(
                'title' => $this->input->post('title'),
                'content' => $this->input->post('content'),
                'video_url' => $this->input->post('video_url'),
                'sort_order' => $this->input->post('sort_order')
            );
            
            // Update lesson
            $updated = $this->lesson_model->update_lesson($lesson_id, $update_data);
            
            if ($updated) {
                $this->session->set_flashdata('success', 'Lesson updated successfully');
                redirect('instructor/lessons/' . $data['lesson']->course_id);
            } else {
                $this->session->set_flashdata('error', 'Failed to update lesson');
                redirect('instructor/edit_lesson/' . $lesson_id);
            }
        }
    }

    public function delete_lesson($lesson_id) {
        // Get lesson details
        $lesson = $this->lesson_model->get_lesson($lesson_id);
        
        if (!$lesson) {
            show_404();
        }
        
        // Get course details
        $course = $this->course_model->get_course($lesson->course_id);
        
        // Check if the instructor owns this course
        if ($course->instructor_id != $this->session->userdata('user_id')) {
            $this->session->set_flashdata('error', 'You do not have permission to delete lessons for this course');
            redirect('instructor/courses');
        }
        
        $course_id = $lesson->course_id;
        
        // Delete lesson
        $deleted = $this->lesson_model->delete_lesson($lesson_id);
        
        if ($deleted) {
            $this->session->set_flashdata('success', 'Lesson deleted successfully');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete lesson');
        }
        
        redirect('instructor/lessons/' . $course_id);
    }
} 
