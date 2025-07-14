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
        
        // Get instructor statistics
        $data['stats'] = $this->course_model->get_instructor_stats($instructor_id);
        
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
                // Upload thumbnail if provided
                if (!empty($_FILES['thumbnail']['name'])) {
                    // Debug information
                    error_log('Attempting to upload thumbnail for course ID: ' . $course_id);
                    error_log('File info: ' . print_r($_FILES['thumbnail'], true));
                    
                    // Load upload library
                    $this->load->library('upload');
                    
                    $uploaded = $this->course_model->upload_thumbnail($course_id);
                    
                    if (!$uploaded) {
                        $error = $this->upload->display_errors('', '');
                        $this->session->set_flashdata('warning', 'Course created successfully, but thumbnail could not be uploaded: ' . $error);
                        error_log('Thumbnail upload failed: ' . $error);
                    } else {
                        $this->session->set_flashdata('success', 'Course and thumbnail created successfully.');
                    }
                }
                
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
            
            // Upload thumbnail if provided
            if (!empty($_FILES['thumbnail']['name'])) {
                // Debug information
                error_log('Attempting to upload thumbnail for course ID: ' . $course_id);
                error_log('File info: ' . print_r($_FILES['thumbnail'], true));
                
                // Load upload library
                $this->load->library('upload');
                
                $uploaded = $this->course_model->upload_thumbnail($course_id);
                
                if (!$uploaded) {
                    $error = $this->upload->display_errors('', '');
                    $this->session->set_flashdata('warning', 'Course updated successfully, but thumbnail could not be uploaded: ' . $error);
                    error_log('Thumbnail upload failed: ' . $error);
                } else {
                    $this->session->set_flashdata('success', 'Course and thumbnail updated successfully.');
                }
            }
            
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

    // Course Analytics
    public function course_analytics($course_id) {
        // Get course analytics
        $data['analytics'] = $this->course_model->get_course_analytics($course_id);
        
        if (!$data['analytics']) {
            show_404();
        }
        
        // Check if the instructor owns this course
        if ($data['analytics']['course']->instructor_id != $this->session->userdata('user_id')) {
            $this->session->set_flashdata('error', 'You do not have permission to view analytics for this course');
            redirect('instructor/courses');
        }
        
        $data['title'] = 'Course Analytics - ' . $data['analytics']['course']->title;
        
        // Load views
        $this->load->view('templates/header', $data);
        $this->load->view('instructor/course_analytics', $data);
        $this->load->view('templates/footer');
    }

    // Student Progress Details (AJAX)
    public function student_progress($course_id, $student_id) {
        // Verify instructor ownership
        $course = $this->course_model->get_course($course_id);
        if (!$course || $course->instructor_id != $this->session->userdata('user_id')) {
            show_404();
        }

        // Get detailed student progress
        $progress = $this->lesson_model->get_course_progress($student_id, $course_id);
        $lessons = $this->lesson_model->get_course_lessons($course_id);
        
        // Get lesson completion details
        foreach ($lessons as $lesson) {
            $lesson->is_completed = $this->lesson_model->is_lesson_completed($student_id, $lesson->id);
            $lesson->completed_at = $this->lesson_model->get_lesson_completion_date($student_id, $lesson->id);
        }

        $data = array(
            'course' => $course,
            'progress' => $progress,
            'lessons' => $lessons,
            'student' => $this->user_model->get_user($student_id)
        );

        // Return JSON for AJAX requests
        if ($this->input->is_ajax_request()) {
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($data));
        } else {
            $data['title'] = 'Student Progress - ' . $course->title;
            $this->load->view('templates/header', $data);
            $this->load->view('instructor/student_progress', $data);
            $this->load->view('templates/footer');
        }
    }

    // Profile Management
    public function profile() {
        $instructor_id = $this->session->userdata('user_id');
        $data['user'] = $this->user_model->get_user($instructor_id);
        $data['title'] = 'My Profile';
        
        // Get instructor statistics
        $data['stats'] = $this->course_model->get_instructor_stats($instructor_id);
        
        // Load views
        $this->load->view('templates/header', $data);
        $this->load->view('instructor/profile', $data);
        $this->load->view('templates/footer');
    }

    public function edit_profile() {
        $instructor_id = $this->session->userdata('user_id');
        $data['user'] = $this->user_model->get_user($instructor_id);
        
        // Form validation rules
        $this->form_validation->set_rules('full_name', 'Full Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        
        if ($this->form_validation->run() === FALSE) {
            $data['title'] = 'Edit Profile';
            
            // Load views
            $this->load->view('templates/header', $data);
            $this->load->view('instructor/edit_profile', $data);
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
            $updated = $this->user_model->update_user($instructor_id, $update_data);
            $profile_updated = true;
            
            // Upload profile picture if provided
            if (!empty($_FILES['profile_picture']['name'])) {
                // Load upload library
                $this->load->library('upload');
                
                $uploaded = $this->user_model->upload_profile_picture($instructor_id);
                
                if (!$uploaded) {
                    $this->session->set_flashdata('warning', 'Profile updated, but profile picture could not be uploaded: ' . $this->upload->display_errors('', ''));
                    $profile_updated = false;
                } else {
                    // Get updated user data to refresh session
                    $updated_user = $this->user_model->get_user($instructor_id);
                    if ($updated_user) {
                        // Update profile image in session
                        $this->session->set_userdata('profile_image', $updated_user->profile_image);
                    }
                }
            }
            
            if ($updated || $profile_updated) {
                // Update session data
                $this->session->set_userdata('full_name', $update_data['full_name']);
                $this->session->set_userdata('email', $update_data['email']);
                
                $this->session->set_flashdata('success', 'Profile updated successfully');
                redirect('instructor/profile');
            } else {
                $this->session->set_flashdata('error', 'Failed to update profile. No changes were made.');
                redirect('instructor/edit_profile');
            }
        }
    }

    // Quiz Management
    
    public function quizzes($course_id) {
        // Get course details
        $course = $this->course_model->get_course($course_id);
        
        if (!$course) {
            show_404();
        }
        
        // Check if the instructor owns this course
        if ($course->instructor_id != $this->session->userdata('user_id')) {
            $this->session->set_flashdata('error', 'You do not have permission to manage quizzes for this course');
            redirect('instructor/courses');
        }
        
        // Load Quiz model
        $this->load->model('quiz_model');
        
        // Get quizzes for this course
        $data['quizzes'] = $this->quiz_model->get_course_quizzes($course_id);
        $data['course'] = $course;
        $data['title'] = 'Manage Quizzes - ' . $course->title;
        
        // Load views
        $this->load->view('templates/header', $data);
        $this->load->view('instructor/quizzes', $data);
        $this->load->view('templates/footer');
    }
    
    public function create_quiz($course_id) {
        // Get course details
        $course = $this->course_model->get_course($course_id);
        
        if (!$course) {
            show_404();
        }
        
        // Check if the instructor owns this course
        if ($course->instructor_id != $this->session->userdata('user_id')) {
            $this->session->set_flashdata('error', 'You do not have permission to create quizzes for this course');
            redirect('instructor/courses');
        }
        
        // Load Quiz model
        $this->load->model('quiz_model');
        
        // Get lessons for dropdown
        $data['lessons'] = $this->lesson_model->get_course_lessons($course_id);
        $data['course'] = $course;
        
        // Form validation rules
        $this->form_validation->set_rules('title', 'Quiz Title', 'required');
        $this->form_validation->set_rules('pass_percentage', 'Pass Percentage', 'required|numeric|greater_than[0]|less_than_equal_to[100]');
        
        if ($this->form_validation->run() === FALSE) {
            $data['title'] = 'Create Quiz - ' . $course->title;
            
            // Load views
            $this->load->view('templates/header', $data);
            $this->load->view('instructor/create_quiz', $data);
            $this->load->view('templates/footer');
        } else {
            // Get form data
            $quiz_data = array(
                'course_id' => $course_id,
                'lesson_id' => $this->input->post('lesson_id'),
                'title' => $this->input->post('title'),
                'description' => $this->input->post('description'),
                'time_limit' => $this->input->post('time_limit'),
                'pass_percentage' => $this->input->post('pass_percentage'),
                'status' => $this->input->post('status')
            );
            
            // Create quiz
            $quiz_id = $this->quiz_model->create_quiz($quiz_data);
            
            if ($quiz_id) {
                $this->session->set_flashdata('success', 'Quiz created successfully. Now add questions to your quiz.');
                redirect('instructor/edit_quiz/' . $quiz_id);
            } else {
                $this->session->set_flashdata('error', 'Failed to create quiz');
                redirect('instructor/create_quiz/' . $course_id);
            }
        }
    }
    
    public function edit_quiz($quiz_id) {
        // Load Quiz model
        $this->load->model('quiz_model');
        
        // Get quiz details
        $data['quiz'] = $this->quiz_model->get_quiz($quiz_id);
        
        if (!$data['quiz']) {
            show_404();
        }
        
        // Get course details
        $data['course'] = $this->course_model->get_course($data['quiz']->course_id);
        
        // Check if the instructor owns this course
        if ($data['course']->instructor_id != $this->session->userdata('user_id')) {
            $this->session->set_flashdata('error', 'You do not have permission to edit this quiz');
            redirect('instructor/courses');
        }
        
        // Get lessons for dropdown
        $data['lessons'] = $this->lesson_model->get_course_lessons($data['quiz']->course_id);
        
        // Get questions for this quiz
        $data['questions'] = $this->quiz_model->get_quiz_questions($quiz_id);
        
        // Form validation rules
        $this->form_validation->set_rules('title', 'Quiz Title', 'required');
        $this->form_validation->set_rules('pass_percentage', 'Pass Percentage', 'required|numeric|greater_than[0]|less_than_equal_to[100]');
        
        if ($this->form_validation->run() === FALSE) {
            $data['title'] = 'Edit Quiz - ' . $data['quiz']->title;
            
            // Load views
            $this->load->view('templates/header', $data);
            $this->load->view('instructor/edit_quiz', $data);
            $this->load->view('templates/footer');
        } else {
            // Get form data
            $quiz_data = array(
                'lesson_id' => $this->input->post('lesson_id'),
                'title' => $this->input->post('title'),
                'description' => $this->input->post('description'),
                'time_limit' => $this->input->post('time_limit'),
                'pass_percentage' => $this->input->post('pass_percentage'),
                'status' => $this->input->post('status')
            );
            
            // Update quiz
            $updated = $this->quiz_model->update_quiz($quiz_id, $quiz_data);
            
            if ($updated) {
                $this->session->set_flashdata('success', 'Quiz updated successfully');
                redirect('instructor/quizzes/' . $data['quiz']->course_id);
            } else {
                $this->session->set_flashdata('error', 'Failed to update quiz');
                redirect('instructor/edit_quiz/' . $quiz_id);
            }
        }
    }
    
    public function delete_quiz($quiz_id) {
        // Load Quiz model
        $this->load->model('quiz_model');
        
        // Get quiz details
        $quiz = $this->quiz_model->get_quiz($quiz_id);
        
        if (!$quiz) {
            show_404();
        }
        
        // Get course details
        $course = $this->course_model->get_course($quiz->course_id);
        
        // Check if the instructor owns this course
        if ($course->instructor_id != $this->session->userdata('user_id')) {
            $this->session->set_flashdata('error', 'You do not have permission to delete this quiz');
            redirect('instructor/courses');
        }
        
        // Delete quiz
        $deleted = $this->quiz_model->delete_quiz($quiz_id);
        
        if ($deleted) {
            $this->session->set_flashdata('success', 'Quiz deleted successfully');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete quiz');
        }
        
        redirect('instructor/quizzes/' . $quiz->course_id);
    }
    
    // Question Management
    
    public function add_question($quiz_id) {
        // Load Quiz model
        $this->load->model('quiz_model');
        
        // Get quiz details
        $quiz = $this->quiz_model->get_quiz($quiz_id);
        
        if (!$quiz) {
            show_404();
        }
        
        // Get course details
        $course = $this->course_model->get_course($quiz->course_id);
        
        // Check if the instructor owns this course
        if ($course->instructor_id != $this->session->userdata('user_id')) {
            $this->session->set_flashdata('error', 'You do not have permission to add questions to this quiz');
            redirect('instructor/courses');
        }
        
        // Form validation rules
        $this->form_validation->set_rules('question', 'Question', 'required');
        $this->form_validation->set_rules('question_type', 'Question Type', 'required');
        $this->form_validation->set_rules('points', 'Points', 'required|numeric|greater_than[0]');
        
        if ($this->form_validation->run() === FALSE) {
            $data['quiz'] = $quiz;
            $data['course'] = $course;
            $data['title'] = 'Add Question - ' . $quiz->title;
            
            // Load views
            $this->load->view('templates/header', $data);
            $this->load->view('instructor/add_question', $data);
            $this->load->view('templates/footer');
        } else {
            // Get form data
            $question_data = array(
                'quiz_id' => $quiz_id,
                'question' => $this->input->post('question'),
                'question_type' => $this->input->post('question_type'),
                'points' => $this->input->post('points'),
                'sort_order' => $this->input->post('sort_order')
            );
            
            // Create question
            $question_id = $this->quiz_model->create_question($question_data);
            
            if ($question_id) {
                // Process answers based on question type
                $question_type = $this->input->post('question_type');
                
                if ($question_type == 'multiple_choice') {
                    $answers = $this->input->post('answers');
                    $is_correct = $this->input->post('is_correct');
                    
                    foreach ($answers as $key => $answer_text) {
                        if (trim($answer_text) !== '') {
                            $answer_data = array(
                                'question_id' => $question_id,
                                'answer_text' => $answer_text,
                                'is_correct' => isset($is_correct[$key]) ? 1 : 0,
                                'sort_order' => $key
                            );
                            
                            $this->quiz_model->create_answer($answer_data);
                        }
                    }
                } elseif ($question_type == 'true_false') {
                    // Create True answer
                    $true_answer = array(
                        'question_id' => $question_id,
                        'answer_text' => 'True',
                        'is_correct' => $this->input->post('true_false') === 'true' ? 1 : 0,
                        'sort_order' => 0
                    );
                    $this->quiz_model->create_answer($true_answer);
                    
                    // Create False answer
                    $false_answer = array(
                        'question_id' => $question_id,
                        'answer_text' => 'False',
                        'is_correct' => $this->input->post('true_false') === 'false' ? 1 : 0,
                        'sort_order' => 1
                    );
                    $this->quiz_model->create_answer($false_answer);
                } elseif ($question_type == 'short_answer') {
                    $correct_answers = $this->input->post('correct_answers');
                    $correct_answers = explode(',', $correct_answers);
                    
                    foreach ($correct_answers as $key => $answer) {
                        $answer = trim($answer);
                        if ($answer !== '') {
                            $answer_data = array(
                                'question_id' => $question_id,
                                'answer_text' => $answer,
                                'is_correct' => 1,
                                'sort_order' => $key
                            );
                            
                            $this->quiz_model->create_answer($answer_data);
                        }
                    }
                }
                
                $this->session->set_flashdata('success', 'Question added successfully');
                redirect('instructor/edit_quiz/' . $quiz_id);
            } else {
                $this->session->set_flashdata('error', 'Failed to add question');
                redirect('instructor/add_question/' . $quiz_id);
            }
        }
    }
    
    public function edit_question($question_id) {
        // Load Quiz model
        $this->load->model('quiz_model');
        
        // Get question details
        $data['question'] = $this->quiz_model->get_question($question_id);
        
        if (!$data['question']) {
            show_404();
        }
        
        // Get quiz details
        $data['quiz'] = $this->quiz_model->get_quiz($data['question']->quiz_id);
        
        // Get course details
        $data['course'] = $this->course_model->get_course($data['quiz']->course_id);
        
        // Check if the instructor owns this course
        if ($data['course']->instructor_id != $this->session->userdata('user_id')) {
            $this->session->set_flashdata('error', 'You do not have permission to edit this question');
            redirect('instructor/courses');
        }
        
        // Get answers for this question
        $data['answers'] = $this->quiz_model->get_question_answers($question_id);
        
        // Form validation rules
        $this->form_validation->set_rules('question', 'Question', 'required');
        $this->form_validation->set_rules('points', 'Points', 'required|numeric|greater_than[0]');
        
        if ($this->form_validation->run() === FALSE) {
            $data['title'] = 'Edit Question';
            
            // Load views
            $this->load->view('templates/header', $data);
            $this->load->view('instructor/edit_question', $data);
            $this->load->view('templates/footer');
        } else {
            // Get form data
            $question_data = array(
                'question' => $this->input->post('question'),
                'points' => $this->input->post('points'),
                'sort_order' => $this->input->post('sort_order')
            );
            
            // Update question
            $updated = $this->quiz_model->update_question($question_id, $question_data);
            
            // Process answers based on question type
            $question_type = $data['question']->question_type;
            
            if ($question_type == 'multiple_choice') {
                // Delete existing answers
                foreach ($data['answers'] as $answer) {
                    $this->quiz_model->delete_answer($answer->id);
                }
                
                // Add new answers
                $answers = $this->input->post('answers');
                $is_correct = $this->input->post('is_correct');
                
                foreach ($answers as $key => $answer_text) {
                    if (trim($answer_text) !== '') {
                        $answer_data = array(
                            'question_id' => $question_id,
                            'answer_text' => $answer_text,
                            'is_correct' => isset($is_correct[$key]) ? 1 : 0,
                            'sort_order' => $key
                        );
                        
                        $this->quiz_model->create_answer($answer_data);
                    }
                }
            } elseif ($question_type == 'true_false') {
                // Update true/false answers
                foreach ($data['answers'] as $answer) {
                    $is_correct = 0;
                    
                    if (($answer->answer_text == 'True' && $this->input->post('true_false') === 'true') ||
                        ($answer->answer_text == 'False' && $this->input->post('true_false') === 'false')) {
                        $is_correct = 1;
                    }
                    
                    $this->quiz_model->update_answer($answer->id, array('is_correct' => $is_correct));
                }
            } elseif ($question_type == 'short_answer') {
                // Delete existing answers
                foreach ($data['answers'] as $answer) {
                    $this->quiz_model->delete_answer($answer->id);
                }
                
                // Add new answers
                $correct_answers = $this->input->post('correct_answers');
                $correct_answers = explode(',', $correct_answers);
                
                foreach ($correct_answers as $key => $answer) {
                    $answer = trim($answer);
                    if ($answer !== '') {
                        $answer_data = array(
                            'question_id' => $question_id,
                            'answer_text' => $answer,
                            'is_correct' => 1,
                            'sort_order' => $key
                        );
                        
                        $this->quiz_model->create_answer($answer_data);
                    }
                }
            }
            
            if ($updated) {
                $this->session->set_flashdata('success', 'Question updated successfully');
                redirect('instructor/edit_quiz/' . $data['question']->quiz_id);
            } else {
                $this->session->set_flashdata('error', 'Failed to update question');
                redirect('instructor/edit_question/' . $question_id);
            }
        }
    }
    
    public function delete_question($question_id) {
        // Load Quiz model
        $this->load->model('quiz_model');
        
        // Get question details
        $question = $this->quiz_model->get_question($question_id);
        
        if (!$question) {
            show_404();
        }
        
        // Get quiz details
        $quiz = $this->quiz_model->get_quiz($question->quiz_id);
        
        // Get course details
        $course = $this->course_model->get_course($quiz->course_id);
        
        // Check if the instructor owns this course
        if ($course->instructor_id != $this->session->userdata('user_id')) {
            $this->session->set_flashdata('error', 'You do not have permission to delete this question');
            redirect('instructor/courses');
        }
        
        // Delete question
        $deleted = $this->quiz_model->delete_question($question_id);
        
        if ($deleted) {
            $this->session->set_flashdata('success', 'Question deleted successfully');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete question');
        }
        
        redirect('instructor/edit_quiz/' . $question->quiz_id);
    }
    
    // Quiz Results
    
    public function quiz_results($quiz_id) {
        // Load Quiz model
        $this->load->model('quiz_model');
        
        // Get quiz details
        $data['quiz'] = $this->quiz_model->get_quiz($quiz_id);
        
        if (!$data['quiz']) {
            show_404();
        }
        
        // Get course details
        $data['course'] = $this->course_model->get_course($data['quiz']->course_id);
        
        // Check if the instructor owns this course
        if ($data['course']->instructor_id != $this->session->userdata('user_id')) {
            $this->session->set_flashdata('error', 'You do not have permission to view results for this quiz');
            redirect('instructor/courses');
        }
        
        // Get all attempts for this quiz
        $this->db->select('quiz_attempts.*, users.username, users.full_name');
        $this->db->from('quiz_attempts');
        $this->db->join('users', 'users.id = quiz_attempts.user_id');
        $this->db->where('quiz_attempts.quiz_id', $quiz_id);
        $this->db->where('quiz_attempts.completed_at IS NOT NULL');
        $this->db->order_by('quiz_attempts.completed_at', 'DESC');
        $query = $this->db->get();
        $data['attempts'] = $query->result();
        
        $data['title'] = 'Quiz Results - ' . $data['quiz']->title;
        
        // Load views
        $this->load->view('templates/header', $data);
        $this->load->view('instructor/quiz_results', $data);
        $this->load->view('templates/footer');
    }
    
    public function view_attempt($attempt_id) {
        // Load Quiz model
        $this->load->model('quiz_model');
        
        // Get attempt details
        $this->db->select('quiz_attempts.*, users.username, users.full_name');
        $this->db->from('quiz_attempts');
        $this->db->join('users', 'users.id = quiz_attempts.user_id');
        $this->db->where('quiz_attempts.id', $attempt_id);
        $query = $this->db->get();
        
        if ($query->num_rows() == 0) {
            show_404();
        }
        
        $data['attempt'] = $query->row();
        
        // Get quiz details
        $data['quiz'] = $this->quiz_model->get_quiz($data['attempt']->quiz_id);
        
        // Get course details
        $data['course'] = $this->course_model->get_course($data['quiz']->course_id);
        
        // Check if the instructor owns this course
        if ($data['course']->instructor_id != $this->session->userdata('user_id')) {
            $this->session->set_flashdata('error', 'You do not have permission to view this attempt');
            redirect('instructor/courses');
        }
        
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
        
        $data['title'] = 'View Attempt - ' . $data['quiz']->title;
        
        // Load views
        $this->load->view('templates/header', $data);
        $this->load->view('instructor/view_attempt', $data);
        $this->load->view('templates/footer');
    }

    // Course Ratings
    
    public function course_ratings($course_id) {
        // Get course details
        $data['course'] = $this->course_model->get_course($course_id);
        
        if (!$data['course']) {
            show_404();
        }
        
        // Check if the instructor owns this course
        if ($data['course']->instructor_id != $this->session->userdata('user_id')) {
            $this->session->set_flashdata('error', 'You do not have permission to view ratings for this course');
            redirect('instructor/courses');
        }
        
        // Load Rating model
        $this->load->model('rating_model');
        
        // Get ratings for this course
        $data['ratings'] = $this->rating_model->get_course_ratings($course_id);
        
        // Get rating statistics
        $data['stats'] = $this->rating_model->get_course_rating_stats($course_id);
        
        $data['title'] = 'Course Ratings - ' . $data['course']->title;
        
        // Load views
        $this->load->view('templates/header', $data);
        $this->load->view('instructor/course_ratings', $data);
        $this->load->view('templates/footer');
    }
} 
