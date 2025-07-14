<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rating_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Create or update a course rating
    public function rate_course($data) {
        // Check if user has already rated this course
        $this->db->where('user_id', $data['user_id']);
        $this->db->where('course_id', $data['course_id']);
        $query = $this->db->get('course_ratings');
        
        if ($query->num_rows() > 0) {
            // Update existing rating
            $existing_rating = $query->row();
            $this->db->where('id', $existing_rating->id);
            $this->db->update('course_ratings', $data);
            $result = $this->db->affected_rows() > 0;
        } else {
            // Create new rating
            $this->db->insert('course_ratings', $data);
            $result = $this->db->insert_id() > 0;
        }
        
        // Update course average rating
        if ($result) {
            $this->update_course_average_rating($data['course_id']);
        }
        
        return $result;
    }

    // Get rating by user and course
    public function get_user_course_rating($user_id, $course_id) {
        $this->db->where('user_id', $user_id);
        $this->db->where('course_id', $course_id);
        $query = $this->db->get('course_ratings');
        
        if ($query->num_rows() == 1) {
            return $query->row();
        }
        
        // Return an empty object with default values instead of false
        $empty_rating = new stdClass();
        $empty_rating->id = null;
        $empty_rating->course_id = $course_id;
        $empty_rating->user_id = $user_id;
        $empty_rating->rating = 5; // Default to 5 stars
        $empty_rating->review = '';
        $empty_rating->created_at = null;
        $empty_rating->updated_at = null;
        
        return $empty_rating;
    }

    // Get all ratings for a course
    public function get_course_ratings($course_id, $limit = null, $offset = 0) {
        $this->db->select('course_ratings.*, users.username, users.full_name, users.profile_image');
        $this->db->from('course_ratings');
        $this->db->join('users', 'users.id = course_ratings.user_id');
        $this->db->where('course_id', $course_id);
        $this->db->order_by('course_ratings.created_at', 'DESC');
        
        if ($limit !== null) {
            $this->db->limit($limit, $offset);
        }
        
        $query = $this->db->get();
        return $query->result();
    }

    // Get course rating statistics
    public function get_course_rating_stats($course_id) {
        // Get average rating
        $this->db->select('AVG(rating) as average, COUNT(*) as count');
        $this->db->where('course_id', $course_id);
        $query = $this->db->get('course_ratings');
        $stats = $query->row();
        
        // Get rating distribution
        $distribution = array();
        for ($i = 5; $i >= 1; $i--) {
            $this->db->where('course_id', $course_id);
            $this->db->where('rating', $i);
            $count = $this->db->count_all_results('course_ratings');
            
            $distribution[$i] = $count;
        }
        
        return array(
            'average' => $stats->average ? round($stats->average, 2) : 0,
            'count' => $stats->count ? $stats->count : 0,
            'distribution' => $distribution
        );
    }

    // Delete a rating
    public function delete_rating($rating_id) {
        // Get course ID before deleting
        $this->db->select('course_id');
        $this->db->where('id', $rating_id);
        $query = $this->db->get('course_ratings');
        
        if ($query->num_rows() == 0) {
            return false;
        }
        
        $course_id = $query->row()->course_id;
        
        // Delete the rating
        $this->db->where('id', $rating_id);
        $this->db->delete('course_ratings');
        $result = $this->db->affected_rows() > 0;
        
        // Update course average rating
        if ($result) {
            $this->update_course_average_rating($course_id);
        }
        
        return $result;
    }

    // Update course average rating
    private function update_course_average_rating($course_id) {
        // Calculate average rating
        $this->db->select('AVG(rating) as average, COUNT(*) as count');
        $this->db->where('course_id', $course_id);
        $query = $this->db->get('course_ratings');
        $stats = $query->row();
        
        // Update course table
        $this->db->where('id', $course_id);
        $this->db->update('courses', array(
            'average_rating' => $stats->average ? round($stats->average, 2) : NULL,
            'rating_count' => $stats->count ? $stats->count : 0
        ));
        
        return $this->db->affected_rows() > 0;
    }

    // Get top rated courses
    public function get_top_rated_courses($limit = 5) {
        $this->db->select('courses.*, categories.name as category_name, users.full_name as instructor_name');
        $this->db->from('courses');
        $this->db->join('categories', 'categories.id = courses.category_id', 'left');
        $this->db->join('users', 'users.id = courses.instructor_id', 'left');
        $this->db->where('courses.status', 'published');
        $this->db->where('courses.average_rating IS NOT NULL');
        $this->db->order_by('courses.average_rating', 'DESC');
        $this->db->limit($limit);
        
        $query = $this->db->get();
        return $query->result();
    }
} 
