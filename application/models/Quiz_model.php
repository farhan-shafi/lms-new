<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Quiz_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Quiz Management

    // Create a new quiz
    public function create_quiz($data) {
        $this->db->insert('quizzes', $data);
        return $this->db->insert_id();
    }

    // Get quiz by ID
    public function get_quiz($quiz_id) {
        $this->db->where('id', $quiz_id);
        $query = $this->db->get('quizzes');
        
        if ($query->num_rows() == 1) {
            return $query->row();
        }
        
        return false;
    }

    // Get quizzes by course ID
    public function get_course_quizzes($course_id) {
        $this->db->where('course_id', $course_id);
        $this->db->order_by('created_at', 'ASC');
        $query = $this->db->get('quizzes');
        
        return $query->result();
    }

    // Get quiz by lesson ID
    public function get_lesson_quiz($lesson_id) {
        $this->db->where('lesson_id', $lesson_id);
        $query = $this->db->get('quizzes');
        
        if ($query->num_rows() == 1) {
            return $query->row();
        }
        
        return false;
    }

    // Update quiz
    public function update_quiz($quiz_id, $data) {
        $this->db->where('id', $quiz_id);
        $this->db->update('quizzes', $data);
        
        return $this->db->affected_rows() > 0;
    }

    // Delete quiz
    public function delete_quiz($quiz_id) {
        $this->db->where('id', $quiz_id);
        $this->db->delete('quizzes');
        
        return $this->db->affected_rows() > 0;
    }

    // Question Management

    // Create a new question
    public function create_question($data) {
        $this->db->insert('quiz_questions', $data);
        return $this->db->insert_id();
    }

    // Get question by ID
    public function get_question($question_id) {
        $this->db->where('id', $question_id);
        $query = $this->db->get('quiz_questions');
        
        if ($query->num_rows() == 1) {
            return $query->row();
        }
        
        return false;
    }

    // Get questions by quiz ID
    public function get_quiz_questions($quiz_id) {
        $this->db->where('quiz_id', $quiz_id);
        $this->db->order_by('sort_order', 'ASC');
        $query = $this->db->get('quiz_questions');
        
        return $query->result();
    }

    // Update question
    public function update_question($question_id, $data) {
        $this->db->where('id', $question_id);
        $this->db->update('quiz_questions', $data);
        
        return $this->db->affected_rows() > 0;
    }

    // Delete question
    public function delete_question($question_id) {
        $this->db->where('id', $question_id);
        $this->db->delete('quiz_questions');
        
        return $this->db->affected_rows() > 0;
    }

    // Answer Management

    // Create a new answer
    public function create_answer($data) {
        $this->db->insert('quiz_answers', $data);
        return $this->db->insert_id();
    }

    // Get answer by ID
    public function get_answer($answer_id) {
        $this->db->where('id', $answer_id);
        $query = $this->db->get('quiz_answers');
        
        if ($query->num_rows() == 1) {
            return $query->row();
        }
        
        return false;
    }

    // Get answers by question ID
    public function get_question_answers($question_id) {
        $this->db->where('question_id', $question_id);
        $this->db->order_by('sort_order', 'ASC');
        $query = $this->db->get('quiz_answers');
        
        return $query->result();
    }

    // Update answer
    public function update_answer($answer_id, $data) {
        $this->db->where('id', $answer_id);
        $this->db->update('quiz_answers', $data);
        
        return $this->db->affected_rows() > 0;
    }

    // Delete answer
    public function delete_answer($answer_id) {
        $this->db->where('id', $answer_id);
        $this->db->delete('quiz_answers');
        
        return $this->db->affected_rows() > 0;
    }

    // Quiz Attempts

    // Start a new quiz attempt
    public function start_quiz_attempt($data) {
        $this->db->insert('quiz_attempts', $data);
        return $this->db->insert_id();
    }

    // Get quiz attempt by ID
    public function get_quiz_attempt($attempt_id) {
        $this->db->where('id', $attempt_id);
        $query = $this->db->get('quiz_attempts');
        
        if ($query->num_rows() == 1) {
            return $query->row();
        }
        
        return false;
    }

    // Get user's attempts for a quiz
    public function get_user_quiz_attempts($user_id, $quiz_id) {
        $this->db->where('user_id', $user_id);
        $this->db->where('quiz_id', $quiz_id);
        $this->db->order_by('started_at', 'DESC');
        $query = $this->db->get('quiz_attempts');
        
        return $query->result();
    }

    // Get user's latest attempt for a quiz
    public function get_user_latest_attempt($user_id, $quiz_id) {
        $this->db->where('user_id', $user_id);
        $this->db->where('quiz_id', $quiz_id);
        $this->db->order_by('started_at', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('quiz_attempts');
        
        if ($query->num_rows() == 1) {
            return $query->row();
        }
        
        return false;
    }

    // Check if user has passed a quiz
    public function has_user_passed_quiz($user_id, $quiz_id) {
        $this->db->where('user_id', $user_id);
        $this->db->where('quiz_id', $quiz_id);
        $this->db->where('passed', 1);
        $query = $this->db->get('quiz_attempts');
        
        return $query->num_rows() > 0;
    }

    // Update quiz attempt
    public function update_quiz_attempt($attempt_id, $data) {
        $this->db->where('id', $attempt_id);
        $this->db->update('quiz_attempts', $data);
        
        return $this->db->affected_rows() > 0;
    }

    // Complete quiz attempt
    public function complete_quiz_attempt($attempt_id, $score, $passed) {
        $data = array(
            'score' => $score,
            'passed' => $passed ? 1 : 0,
            'completed_at' => date('Y-m-d H:i:s')
        );
        
        return $this->update_quiz_attempt($attempt_id, $data);
    }

    // Save quiz attempt answer
    public function save_attempt_answer($data) {
        $this->db->insert('quiz_attempt_answers', $data);
        return $this->db->insert_id();
    }

    // Get answers for a quiz attempt
    public function get_attempt_answers($attempt_id) {
        $this->db->where('attempt_id', $attempt_id);
        $query = $this->db->get('quiz_attempt_answers');
        
        return $query->result();
    }

    // Calculate quiz score
    public function calculate_quiz_score($attempt_id) {
        // Get all answers for this attempt
        $this->db->select('SUM(points_earned) as total_points');
        $this->db->where('attempt_id', $attempt_id);
        $query = $this->db->get('quiz_attempt_answers');
        $points_earned = $query->row()->total_points;
        
        // Get quiz information
        $attempt = $this->get_quiz_attempt($attempt_id);
        $quiz = $this->get_quiz($attempt->quiz_id);
        
        // Get total possible points
        $this->db->select('SUM(points) as total_possible');
        $this->db->where('quiz_id', $quiz->id);
        $query = $this->db->get('quiz_questions');
        $total_possible = $query->row()->total_possible;
        
        if ($total_possible == 0) {
            return 0;
        }
        
        // Calculate score as percentage
        $score = ($points_earned / $total_possible) * 100;
        
        // Check if passed
        $passed = $score >= $quiz->pass_percentage;
        
        // Update the attempt
        $this->complete_quiz_attempt($attempt_id, $score, $passed);
        
        return array(
            'score' => $score,
            'passed' => $passed,
            'pass_percentage' => $quiz->pass_percentage
        );
    }
} 
