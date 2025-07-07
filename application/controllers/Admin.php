<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('course_model');
        $this->load->model('category_model');
        $this->load->model('lesson_model');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('form_validation');
        
        // Check if user is logged in and is admin
        if (!$this->session->userdata('user_id') || $this->session->userdata('role') != 'admin') {
            $this->session->set_flashdata('error', 'You must be logged in as an admin to access this page');
            redirect('auth/login');
        }
    }

    public function index() {
        redirect('admin/dashboard');
    }

    public function dashboard() {
        // Get counts for dashboard
        $data['user_count'] = count($this->user_model->get_all_users());
        $data['course_count'] = count($this->course_model->get_all_courses());
        $data['category_count'] = count($this->category_model->get_all_categories());
        
        $data['title'] = 'Admin Dashboard';
        
        // Load views
        $this->load->view('templates/header', $data);
        $this->load->view('admin/dashboard', $data);
        $this->load->view('templates/footer');
    }

    // User Management
    public function users() {
        $data['users'] = $this->user_model->get_all_users();
        $data['title'] = 'Manage Users';
        
        // Load views
        $this->load->view('templates/header', $data);
        $this->load->view('admin/users', $data);
        $this->load->view('templates/footer');
    }

    public function create_user() {
        // Form validation rules
        $this->form_validation->set_rules('username', 'Username', 'required|is_unique[users.username]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');
        $this->form_validation->set_rules('full_name', 'Full Name', 'required');
        $this->form_validation->set_rules('role', 'Role', 'required');
        
        if ($this->form_validation->run() === FALSE) {
            $data['title'] = 'Create User';
            
            // Load views
            $this->load->view('templates/header', $data);
            $this->load->view('admin/create_user', $data);
            $this->load->view('templates/footer');
        } else {
            // Get form data
            $data = array(
                'username' => $this->input->post('username'),
                'email' => $this->input->post('email'),
                'password' => $this->input->post('password'),
                'full_name' => $this->input->post('full_name'),
                'role' => $this->input->post('role'),
                'bio' => $this->input->post('bio')
            );
            
            // Create user
            $user_id = $this->user_model->register($data);
            
            if ($user_id) {
                $this->session->set_flashdata('success', 'User created successfully');
                redirect('admin/users');
            } else {
                $this->session->set_flashdata('error', 'Failed to create user');
                redirect('admin/create_user');
            }
        }
    }

    public function edit_user($user_id) {
        // Get user details
        $data['user'] = $this->user_model->get_user($user_id);
        
        if (!$data['user']) {
            show_404();
        }
        
        // Form validation rules
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('full_name', 'Full Name', 'required');
        $this->form_validation->set_rules('role', 'Role', 'required');
        
        if ($this->form_validation->run() === FALSE) {
            $data['title'] = 'Edit User';
            
            // Load views
            $this->load->view('templates/header', $data);
            $this->load->view('admin/edit_user', $data);
            $this->load->view('templates/footer');
        } else {
            // Get form data
            $update_data = array(
                'username' => $this->input->post('username'),
                'email' => $this->input->post('email'),
                'full_name' => $this->input->post('full_name'),
                'role' => $this->input->post('role'),
                'bio' => $this->input->post('bio')
            );
            
            // If password is provided, update it
            if ($this->input->post('password')) {
                $update_data['password'] = $this->input->post('password');
            }
            
            // Update user
            $updated = $this->user_model->update_user($user_id, $update_data);
            
            if ($updated) {
                $this->session->set_flashdata('success', 'User updated successfully');
                redirect('admin/users');
            } else {
                $this->session->set_flashdata('error', 'Failed to update user');
                redirect('admin/edit_user/' . $user_id);
            }
        }
    }

    public function delete_user($user_id) {
        // Prevent deleting own account
        if ($user_id == $this->session->userdata('user_id')) {
            $this->session->set_flashdata('error', 'You cannot delete your own account');
            redirect('admin/users');
        }
        
        // Delete user
        $deleted = $this->user_model->delete_user($user_id);
        
        if ($deleted) {
            $this->session->set_flashdata('success', 'User deleted successfully');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete user');
        }
        
        redirect('admin/users');
    }

    // Category Management
    public function categories() {
        $data['categories'] = $this->category_model->get_all_categories();
        $data['title'] = 'Manage Categories';
        
        // Load views
        $this->load->view('templates/header', $data);
        $this->load->view('admin/categories', $data);
        $this->load->view('templates/footer');
    }

    public function create_category() {
        // Form validation rules
        $this->form_validation->set_rules('name', 'Category Name', 'required');
        
        if ($this->form_validation->run() === FALSE) {
            $data['title'] = 'Create Category';
            
            // Load views
            $this->load->view('templates/header', $data);
            $this->load->view('admin/create_category', $data);
            $this->load->view('templates/footer');
        } else {
            // Get form data
            $data = array(
                'name' => $this->input->post('name'),
                'description' => $this->input->post('description')
            );
            
            // Create category
            $category_id = $this->category_model->create_category($data);
            
            if ($category_id) {
                $this->session->set_flashdata('success', 'Category created successfully');
                redirect('admin/categories');
            } else {
                $this->session->set_flashdata('error', 'Failed to create category');
                redirect('admin/create_category');
            }
        }
    }

    public function edit_category($category_id) {
        // Get category details
        $data['category'] = $this->category_model->get_category($category_id);
        
        if (!$data['category']) {
            show_404();
        }
        
        // Form validation rules
        $this->form_validation->set_rules('name', 'Category Name', 'required');
        
        if ($this->form_validation->run() === FALSE) {
            $data['title'] = 'Edit Category';
            
            // Load views
            $this->load->view('templates/header', $data);
            $this->load->view('admin/edit_category', $data);
            $this->load->view('templates/footer');
        } else {
            // Get form data
            $update_data = array(
                'name' => $this->input->post('name'),
                'description' => $this->input->post('description')
            );
            
            // Update category
            $updated = $this->category_model->update_category($category_id, $update_data);
            
            if ($updated) {
                $this->session->set_flashdata('success', 'Category updated successfully');
                redirect('admin/categories');
            } else {
                $this->session->set_flashdata('error', 'Failed to update category');
                redirect('admin/edit_category/' . $category_id);
            }
        }
    }

    public function delete_category($category_id) {
        // Delete category
        $deleted = $this->category_model->delete_category($category_id);
        
        if ($deleted) {
            $this->session->set_flashdata('success', 'Category deleted successfully');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete category');
        }
        
        redirect('admin/categories');
    }

    // Course Management
    public function courses() {
        $data['courses'] = $this->course_model->get_all_courses();
        $data['title'] = 'Manage Courses';
        
        // Load views
        $this->load->view('templates/header', $data);
        $this->load->view('admin/courses', $data);
        $this->load->view('templates/footer');
    }

    public function create_course() {
        // Get categories for dropdown
        $data['categories'] = $this->category_model->get_all_categories();
        $data['instructors'] = $this->user_model->get_users_by_role('instructor');
        
        // Form validation rules
        $this->form_validation->set_rules('title', 'Course Title', 'required');
        $this->form_validation->set_rules('instructor_id', 'Instructor', 'required');
        
        if ($this->form_validation->run() === FALSE) {
            $data['title'] = 'Create Course';
            
            // Load views
            $this->load->view('templates/header', $data);
            $this->load->view('admin/create_course', $data);
            $this->load->view('templates/footer');
        } else {
            // Get form data
            $data = array(
                'title' => $this->input->post('title'),
                'description' => $this->input->post('description'),
                'category_id' => $this->input->post('category_id'),
                'instructor_id' => $this->input->post('instructor_id'),
                'status' => $this->input->post('status')
            );
            
            // Create course
            $course_id = $this->course_model->create_course($data);
            
            if ($course_id) {
                $this->session->set_flashdata('success', 'Course created successfully');
                redirect('admin/courses');
            } else {
                $this->session->set_flashdata('error', 'Failed to create course');
                redirect('admin/create_course');
            }
        }
    }

    public function edit_course($course_id) {
        // Get course details
        $data['course'] = $this->course_model->get_course($course_id);
        
        if (!$data['course']) {
            show_404();
        }
        
        // Get categories and instructors for dropdown
        $data['categories'] = $this->category_model->get_all_categories();
        $data['instructors'] = $this->user_model->get_users_by_role('instructor');
        
        // Form validation rules
        $this->form_validation->set_rules('title', 'Course Title', 'required');
        $this->form_validation->set_rules('instructor_id', 'Instructor', 'required');
        
        if ($this->form_validation->run() === FALSE) {
            $data['title'] = 'Edit Course';
            
            // Load views
            $this->load->view('templates/header', $data);
            $this->load->view('admin/edit_course', $data);
            $this->load->view('templates/footer');
        } else {
            // Get form data
            $update_data = array(
                'title' => $this->input->post('title'),
                'description' => $this->input->post('description'),
                'category_id' => $this->input->post('category_id'),
                'instructor_id' => $this->input->post('instructor_id'),
                'status' => $this->input->post('status')
            );
            
            // Update course
            $updated = $this->course_model->update_course($course_id, $update_data);
            
            if ($updated) {
                $this->session->set_flashdata('success', 'Course updated successfully');
                redirect('admin/courses');
            } else {
                $this->session->set_flashdata('error', 'Failed to update course');
                redirect('admin/edit_course/' . $course_id);
            }
        }
    }

    public function delete_course($course_id) {
        // Delete course
        $deleted = $this->course_model->delete_course($course_id);
        
        if ($deleted) {
            $this->session->set_flashdata('success', 'Course deleted successfully');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete course');
        }
        
        redirect('admin/courses');
    }

    // Lesson Management
    public function lessons($course_id) {
        // Get course details
        $data['course'] = $this->course_model->get_course($course_id);
        
        if (!$data['course']) {
            show_404();
        }
        
        // Get lessons for this course
        $data['lessons'] = $this->lesson_model->get_course_lessons($course_id);
        $data['title'] = 'Manage Lessons - ' . $data['course']->title;
        
        // Load views
        $this->load->view('templates/header', $data);
        $this->load->view('admin/lessons', $data);
        $this->load->view('templates/footer');
    }

    public function create_lesson($course_id) {
        // Get course details
        $data['course'] = $this->course_model->get_course($course_id);
        
        if (!$data['course']) {
            show_404();
        }
        
        // Form validation rules
        $this->form_validation->set_rules('title', 'Lesson Title', 'required');
        
        if ($this->form_validation->run() === FALSE) {
            $data['title'] = 'Create Lesson - ' . $data['course']->title;
            
            // Load views
            $this->load->view('templates/header', $data);
            $this->load->view('admin/create_lesson', $data);
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
                redirect('admin/lessons/' . $course_id);
            } else {
                $this->session->set_flashdata('error', 'Failed to create lesson');
                redirect('admin/create_lesson/' . $course_id);
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
        
        // Form validation rules
        $this->form_validation->set_rules('title', 'Lesson Title', 'required');
        
        if ($this->form_validation->run() === FALSE) {
            $data['title'] = 'Edit Lesson - ' . $data['lesson']->title;
            
            // Load views
            $this->load->view('templates/header', $data);
            $this->load->view('admin/edit_lesson', $data);
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
                redirect('admin/lessons/' . $data['lesson']->course_id);
            } else {
                $this->session->set_flashdata('error', 'Failed to update lesson');
                redirect('admin/edit_lesson/' . $lesson_id);
            }
        }
    }

    public function delete_lesson($lesson_id) {
        // Get lesson details to get course_id
        $lesson = $this->lesson_model->get_lesson($lesson_id);
        
        if (!$lesson) {
            show_404();
        }
        
        $course_id = $lesson->course_id;
        
        // Delete lesson
        $deleted = $this->lesson_model->delete_lesson($lesson_id);
        
        if ($deleted) {
            $this->session->set_flashdata('success', 'Lesson deleted successfully');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete lesson');
        }
        
        redirect('admin/lessons/' . $course_id);
    }
} 
