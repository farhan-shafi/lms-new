<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('form_validation');
    }

    public function index() {
        // If already logged in, redirect to dashboard
        if ($this->session->userdata('user_id')) {
            redirect($this->_get_role_dashboard());
        }
        
        // Default to login page
        $this->login();
    }

    public function login() {
        // If already logged in, redirect to dashboard
        if ($this->session->userdata('user_id')) {
            redirect($this->_get_role_dashboard());
        }
        
        // Form validation rules
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        
        if ($this->form_validation->run() === FALSE) {
            // Load login view
            $data['title'] = 'Login';
            $this->load->view('templates/header', $data);
            $this->load->view('auth/login');
            $this->load->view('templates/footer');
        } else {
            // Get form data
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            
            // Attempt login
            $user = $this->user_model->login($username, $password);
            
            if ($user) {
                // Set session data
                $user_data = array(
                    'user_id' => $user->id,
                    'username' => $user->username,
                    'email' => $user->email,
                    'role' => $user->role,
                    'full_name' => $user->full_name,
                    'logged_in' => TRUE
                );
                
                $this->session->set_userdata($user_data);
                
                // Redirect to appropriate dashboard based on role
                redirect($this->_get_role_dashboard());
            } else {
                // Login failed
                $this->session->set_flashdata('error', 'Invalid username or password');
                redirect('auth/login');
            }
        }
    }

    public function register() {
        // If already logged in, redirect to dashboard
        if ($this->session->userdata('user_id')) {
            redirect($this->_get_role_dashboard());
        }
        
        // Form validation rules
        $this->form_validation->set_rules('username', 'Username', 'required|is_unique[users.username]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');
        $this->form_validation->set_rules('full_name', 'Full Name', 'required');
        
        if ($this->form_validation->run() === FALSE) {
            // Load register view
            $data['title'] = 'Register';
            $this->load->view('templates/header', $data);
            $this->load->view('auth/register');
            $this->load->view('templates/footer');
        } else {
            // Get form data
            $data = array(
                'username' => $this->input->post('username'),
                'email' => $this->input->post('email'),
                'password' => $this->input->post('password'),
                'full_name' => $this->input->post('full_name'),
                'role' => 'student' // Default role for new users
            );
            
            // Register user
            $user_id = $this->user_model->register($data);
            
            if ($user_id) {
                // Registration successful
                $this->session->set_flashdata('success', 'Registration successful. You can now login.');
                redirect('auth/login');
            } else {
                // Registration failed
                $this->session->set_flashdata('error', 'Registration failed. Please try again.');
                redirect('auth/register');
            }
        }
    }

    public function logout() {
        // Unset user session data
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role');
        $this->session->unset_userdata('full_name');
        $this->session->unset_userdata('logged_in');
        
        // Destroy session
        $this->session->sess_destroy();
        
        // Redirect to login page
        redirect('auth/login');
    }

    // Helper method to get dashboard URL based on role
    private function _get_role_dashboard() {
        $role = $this->session->userdata('role');
        
        switch ($role) {
            case 'admin':
                return 'admin/dashboard';
            case 'instructor':
                return 'instructor/dashboard';
            case 'student':
            default:
                return 'student/dashboard';
        }
    }
} 
