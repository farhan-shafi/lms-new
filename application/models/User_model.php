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
} 
