<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('course_model');
        $this->load->model('category_model');
        $this->load->model('lesson_model');
        $this->load->model('rating_model');
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
                'bio' => $this->input->post('bio'),
                'updated_at' => date('Y-m-d H:i:s')
            );
            
            // If password is provided, update it
            if ($this->input->post('password') && $this->input->post('password') != '') {
                $update_data['password'] = $this->input->post('password');
            }
            
            // Update user
            $updated = $this->user_model->update_user($student_id, $update_data);
            $profile_updated = true;
            
            // Upload profile picture if provided
            if (!empty($_FILES['profile_picture']['name'])) {
                // Load upload library
                $this->load->library('upload');
                
                // Debug information
                error_log('Attempting to upload profile picture for user ID: ' . $student_id);
                error_log('File info: ' . print_r($_FILES['profile_picture'], true));
                
                $uploaded = $this->user_model->upload_profile_picture($student_id);
                
                if (!$uploaded) {
                    $this->load->library('upload');
                    $error = $this->upload->display_errors('', '');
                    $this->session->set_flashdata('warning', 'Profile updated, but profile picture could not be uploaded: ' . $error);
                    error_log('Profile picture upload failed: ' . $error);
                    $profile_updated = false;
                } else {
                    // Get updated user data to refresh session
                    $updated_user = $this->user_model->get_user($student_id);
                    if ($updated_user) {
                        // Update profile image in session
                        $this->session->set_userdata('profile_image', $updated_user->profile_image);
                    }
                    
                    $this->session->set_flashdata('success', 'Profile and profile picture updated successfully.');
                    $profile_updated = true;
                }
            }
            
            if ($updated || $profile_updated) {
                // Update session data
                $this->session->set_userdata('full_name', $update_data['full_name']);
                $this->session->set_userdata('email', $update_data['email']);
                
                $this->session->set_flashdata('success', 'Profile updated successfully');
                redirect('student/profile');
            } else {
                $this->session->set_flashdata('error', 'Failed to update profile. No changes were made.');
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

    // Quiz Taking
    
    public function quizzes($course_id) {
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
        
        // Check if student is enrolled
        $student_id = $this->session->userdata('user_id');
        $is_enrolled = $this->course_model->is_enrolled($student_id, $course_id);
        
        if (!$is_enrolled) {
            $this->session->set_flashdata('error', 'You need to enroll in this course to access quizzes');
            redirect('student/course/' . $course_id);
        }
        
        // Load Quiz model
        $this->load->model('quiz_model');
        
        // Get quizzes for this course
        $data['quizzes'] = $this->quiz_model->get_course_quizzes($course_id);
        
        // Get attempt information for each quiz
        foreach ($data['quizzes'] as $quiz) {
            $quiz->attempts = $this->quiz_model->get_user_quiz_attempts($student_id, $quiz->id);
            $quiz->has_passed = $this->quiz_model->has_user_passed_quiz($student_id, $quiz->id);
            
            // Get question count for each quiz
            $questions = $this->quiz_model->get_quiz_questions($quiz->id);
            $quiz->question_count = count($questions);
        }
        
        $data['title'] = 'Course Quizzes - ' . $data['course']->title;
        
        // Load views
        $this->load->view('templates/header', $data);
        $this->load->view('student/quizzes', $data);
        $this->load->view('templates/footer');
    }
    
    public function take_quiz($quiz_id) {
        // Load Quiz model
        $this->load->model('quiz_model');
        
        // Get quiz details
        $data['quiz'] = $this->quiz_model->get_quiz($quiz_id);
        
        if (!$data['quiz']) {
            show_404();
        }
        
        // Set default value for attempts_allowed if not present
        if (!isset($data['quiz']->attempts_allowed)) {
            $data['quiz']->attempts_allowed = -1; // Unlimited attempts by default
        }
        
        // Get course details
        $data['course'] = $this->course_model->get_course($data['quiz']->course_id);
        
        // Check if course is published
        if ($data['course']->status != 'published') {
            $this->session->set_flashdata('error', 'This course is not available');
            redirect('student/courses');
        }
        
        // Check if quiz is published
        if ($data['quiz']->status != 'published') {
            $this->session->set_flashdata('error', 'This quiz is not available');
            redirect('student/quizzes/' . $data['quiz']->course_id);
        }
        
        // Check if student is enrolled
        $student_id = $this->session->userdata('user_id');
        $is_enrolled = $this->course_model->is_enrolled($student_id, $data['quiz']->course_id);
        
        if (!$is_enrolled) {
            $this->session->set_flashdata('error', 'You need to enroll in this course to take quizzes');
            redirect('student/course/' . $data['quiz']->course_id);
        }
        
        // Check if quiz has questions
        $questions = $this->quiz_model->get_quiz_questions($quiz_id);
        if (empty($questions)) {
            $this->session->set_flashdata('error', 'This quiz has no questions yet');
            redirect('student/quizzes/' . $data['quiz']->course_id);
        }
        
        // Check if student has already passed this quiz
        $has_passed = $this->quiz_model->has_user_passed_quiz($student_id, $quiz_id);
        $data['has_passed'] = $has_passed;
        
        // Get previous attempts
        $data['attempts'] = $this->quiz_model->get_user_quiz_attempts($student_id, $quiz_id);
        
        // Check if student is currently taking the quiz
        $latest_attempt = $this->quiz_model->get_user_latest_attempt($student_id, $quiz_id);
        $data['latest_attempt'] = $latest_attempt;
        
        $is_in_progress = $latest_attempt && $latest_attempt->completed_at === null;
        $data['is_in_progress'] = $is_in_progress;
        
        if ($this->input->post('start_quiz')) {
            // Start a new quiz attempt
            $attempt_data = array(
                'quiz_id' => $quiz_id,
                'user_id' => $student_id
            );
            
            $attempt_id = $this->quiz_model->start_quiz_attempt($attempt_data);
            
            if ($attempt_id) {
                redirect('student/quiz_attempt/' . $attempt_id);
            } else {
                $this->session->set_flashdata('error', 'Failed to start quiz');
                redirect('student/take_quiz/' . $quiz_id);
            }
        } elseif ($this->input->post('resume_quiz') && $is_in_progress) {
            redirect('student/quiz_attempt/' . $latest_attempt->id);
        }
        
        $data['title'] = 'Take Quiz - ' . $data['quiz']->title;
        
        // Load views
        $this->load->view('templates/header', $data);
        $this->load->view('student/take_quiz', $data);
        $this->load->view('templates/footer');
    }
    
    public function quiz_attempt($attempt_id) {
        // Load Quiz model
        $this->load->model('quiz_model');
        
        // Get attempt details
        $data['attempt'] = $this->quiz_model->get_quiz_attempt($attempt_id);
        
        if (!$data['attempt']) {
            show_404();
        }
        
        // Check if this is the student's attempt
        if ($data['attempt']->user_id != $this->session->userdata('user_id')) {
            $this->session->set_flashdata('error', 'You do not have permission to view this attempt');
            redirect('student/dashboard');
        }
        
        // Check if attempt is already completed
        if ($data['attempt']->completed_at !== null) {
            redirect('student/quiz_result/' . $attempt_id);
        }
        
        // Get quiz details
        $data['quiz'] = $this->quiz_model->get_quiz($data['attempt']->quiz_id);
        
        // Get course details
        $data['course'] = $this->course_model->get_course($data['quiz']->course_id);
        
        // Get questions for this quiz
        $data['questions'] = $this->quiz_model->get_quiz_questions($data['quiz']->id);
        
        // Get answers for each question
        foreach ($data['questions'] as $question) {
            $question->answers = $this->quiz_model->get_question_answers($question->id);
            
            // Shuffle multiple choice answers
            if ($question->question_type == 'multiple_choice') {
                shuffle($question->answers);
            }
        }
        
        // Handle quiz submission
        if ($this->input->post('submit_quiz')) {
            $total_points = 0;
            $total_possible = 0;
            
            foreach ($data['questions'] as $question) {
                $total_possible += $question->points;
                $points_earned = 0;
                $is_correct = false;
                
                if ($question->question_type == 'multiple_choice') {
                    $selected_answer_id = $this->input->post('question_' . $question->id);
                    
                    if ($selected_answer_id) {
                        foreach ($question->answers as $answer) {
                            if ($answer->id == $selected_answer_id && $answer->is_correct) {
                                $points_earned = $question->points;
                                $is_correct = true;
                                break;
                            }
                        }
                    }
                    
                    // Save answer
                    $answer_data = array(
                        'attempt_id' => $attempt_id,
                        'question_id' => $question->id,
                        'answer_id' => $selected_answer_id,
                        'is_correct' => $is_correct ? 1 : 0,
                        'points_earned' => $points_earned
                    );
                    
                    $this->quiz_model->save_attempt_answer($answer_data);
                } elseif ($question->question_type == 'true_false') {
                    $selected_answer = $this->input->post('question_' . $question->id);
                    
                    if ($selected_answer) {
                        foreach ($question->answers as $answer) {
                            if (($answer->answer_text == 'True' && $selected_answer == 'true' && $answer->is_correct) ||
                                ($answer->answer_text == 'False' && $selected_answer == 'false' && $answer->is_correct)) {
                                $points_earned = $question->points;
                                $is_correct = true;
                                break;
                            }
                        }
                    }
                    
                    // Save answer
                    $answer_data = array(
                        'attempt_id' => $attempt_id,
                        'question_id' => $question->id,
                        'text_answer' => $selected_answer,
                        'is_correct' => $is_correct ? 1 : 0,
                        'points_earned' => $points_earned
                    );
                    
                    $this->quiz_model->save_attempt_answer($answer_data);
                } elseif ($question->question_type == 'short_answer') {
                    $text_answer = $this->input->post('question_' . $question->id);
                    
                    if ($text_answer) {
                        $text_answer = trim(strtolower($text_answer));
                        
                        foreach ($question->answers as $answer) {
                            $correct_answer = trim(strtolower($answer->answer_text));
                            if ($text_answer == $correct_answer) {
                                $points_earned = $question->points;
                                $is_correct = true;
                                break;
                            }
                        }
                    }
                    
                    // Save answer
                    $answer_data = array(
                        'attempt_id' => $attempt_id,
                        'question_id' => $question->id,
                        'text_answer' => $text_answer,
                        'is_correct' => $is_correct ? 1 : 0,
                        'points_earned' => $points_earned
                    );
                    
                    $this->quiz_model->save_attempt_answer($answer_data);
                }
                
                $total_points += $points_earned;
            }
            
            // Calculate score
            $score = ($total_points / $total_possible) * 100;
            $passed = $score >= $data['quiz']->pass_percentage;
            
            // Complete the attempt
            $this->quiz_model->complete_quiz_attempt($attempt_id, $score, $passed);
            
            redirect('student/quiz_result/' . $attempt_id);
        }
        
        $data['title'] = 'Quiz: ' . $data['quiz']->title;
        
        // Load views
        $this->load->view('templates/header', $data);
        $this->load->view('student/quiz_attempt', $data);
        $this->load->view('templates/footer');
    }
    
    public function quiz_result($attempt_id) {
        // Load Quiz model
        $this->load->model('quiz_model');
        
        // Get attempt details
        $data['attempt'] = $this->quiz_model->get_quiz_attempt($attempt_id);
        
        if (!$data['attempt']) {
            show_404();
        }
        
        // Check if this is the student's attempt
        if ($data['attempt']->user_id != $this->session->userdata('user_id')) {
            $this->session->set_flashdata('error', 'You do not have permission to view this attempt');
            redirect('student/dashboard');
        }
        
        // Get quiz details
        $data['quiz'] = $this->quiz_model->get_quiz($data['attempt']->quiz_id);
        
        // Get course details
        $data['course'] = $this->course_model->get_course($data['quiz']->course_id);
        
        // Get questions and answers
        $this->db->select('quiz_questions.*, quiz_attempt_answers.text_answer, quiz_attempt_answers.is_correct, quiz_attempt_answers.points_earned, quiz_attempt_answers.answer_id');
        $this->db->from('quiz_questions');
        $this->db->join('quiz_attempt_answers', 'quiz_attempt_answers.question_id = quiz_questions.id AND quiz_attempt_answers.attempt_id = ' . $attempt_id, 'left');
        $this->db->where('quiz_questions.quiz_id', $data['quiz']->id);
        $this->db->order_by('quiz_questions.sort_order', 'ASC');
        $query = $this->db->get();
        $data['questions'] = $query->result();
        
        // Get answers for each question
        foreach ($data['questions'] as $question) {
            $question->answers = $this->quiz_model->get_question_answers($question->id);
        }
        
        $data['title'] = 'Quiz Results - ' . $data['quiz']->title;
        
        // Load views
        $this->load->view('templates/header', $data);
        $this->load->view('student/quiz_result', $data);
        $this->load->view('templates/footer');
    }

    // Course Rating
    
    public function rate_course($course_id) {
        // Check if student is enrolled
        $student_id = $this->session->userdata('user_id');
        $is_enrolled = $this->course_model->is_enrolled($student_id, $course_id);
        
        if (!$is_enrolled) {
            $this->session->set_flashdata('error', 'You need to enroll in this course to rate it');
            redirect('student/course/' . $course_id);
        }
        
        // Get course details
        $data['course'] = $this->course_model->get_course($course_id);
        
        if (!$data['course']) {
            show_404();
        }
        
        // Load Rating model
        $this->load->model('rating_model');
        
        // Load form validation library
        $this->load->library('form_validation');
        
        // Get existing rating
        $data['rating'] = $this->rating_model->get_user_course_rating($student_id, $course_id);
        
        // Form validation rules
        $this->form_validation->set_rules('rating', 'Rating', 'required|numeric|greater_than[0]|less_than_equal_to[5]');
        
        if ($this->form_validation->run() === FALSE) {
            $data['title'] = 'Rate Course - ' . $data['course']->title;
            
            // Load views
            $this->load->view('templates/header', $data);
            $this->load->view('student/rate_course', $data);
            $this->load->view('templates/footer');
        } else {
            // Get form data
            $rating_data = array(
                'course_id' => $course_id,
                'user_id' => $student_id,
                'rating' => $this->input->post('rating'),
                'review' => $this->input->post('review')
            );
            
            // Save rating
            $result = $this->rating_model->rate_course($rating_data);
            
            if ($result) {
                $this->session->set_flashdata('success', 'Thank you for rating this course!');
            } else {
                $this->session->set_flashdata('error', 'Failed to save your rating');
            }
            
            redirect('student/course/' . $course_id);
        }
    }
} 
