<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Register a new user
    public function register($data) {
        // Hash the password before storing
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        
        // Insert user data
        $this->db->insert('users', $data);
        return $this->db->insert_id();
    }

    // Authenticate user
    public function login($username, $password) {
        // Check if username exists
        $this->db->where('username', $username);
        $query = $this->db->get('users');
        
        if ($query->num_rows() == 1) {
            $user = $query->row();
            
            // Verify password
            if (password_verify($password, $user->password)) {
                // Password is correct, return user data
                return $user;
            }
        }
        
        // Authentication failed
        return false;
    }

    // Get user by ID
    public function get_user($user_id) {
        $this->db->where('id', $user_id);
        $query = $this->db->get('users');
        
        if ($query->num_rows() == 1) {
            return $query->row();
        }
        
        return false;
    }

    // Get all users
    public function get_all_users() {
        $query = $this->db->get('users');
        return $query->result();
    }

    // Get users by role
    public function get_users_by_role($role) {
        $this->db->where('role', $role);
        $query = $this->db->get('users');
        return $query->result();
    }

    // Update user
    public function update_user($user_id, $data) {
        // If password is being updated, hash it
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        }
        
        $this->db->where('id', $user_id);
        $this->db->update('users', $data);
        
        return $this->db->affected_rows() > 0;
    }

    // Delete user
    public function delete_user($user_id) {
        $this->db->where('id', $user_id);
        $this->db->delete('users');
        
        return $this->db->affected_rows() > 0;
    }
    
    // Upload profile picture
    public function upload_profile_picture($user_id) {
        // Load upload library
        $this->load->library('upload');
        
        // Create upload directory if it doesn't exist
        $upload_path = FCPATH . 'uploads/profile_pictures/';
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0777, TRUE);
        }
        
        // Set upload configuration
        $config = array(
            'upload_path' => $upload_path,
            'allowed_types' => 'gif|jpg|jpeg|png',
            'max_size' => 2048, // 2MB
            'encrypt_name' => TRUE,
            'remove_spaces' => TRUE,
            'overwrite' => FALSE
        );
        
        $this->upload->initialize($config);
        
        // Perform upload
        if ($this->upload->do_upload('profile_picture')) {
            $upload_data = $this->upload->data();
            $profile_picture = $upload_data['file_name'];
            
            // Update user record with new profile picture
            $this->db->where('id', $user_id);
            $this->db->update('users', array('profile_image' => $profile_picture));
            
            return $profile_picture;
        } else {
            // For debugging
            error_log('Profile picture upload failed: ' . $this->upload->display_errors('', ''));
            error_log('Upload path: ' . realpath($upload_path));
        }
        
        return FALSE;
    }
} 
