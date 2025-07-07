<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Course_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Create a new course
    public function create_course($data) {
        $this->db->insert('courses', $data);
        return $this->db->insert_id();
    }

    // Get all courses (for admin)
    public function get_all_courses() {
        $this->db->select('courses.*, categories.name as category_name, users.full_name as instructor_name');
        $this->db->from('courses');
        $this->db->join('categories', 'categories.id = courses.category_id', 'left');
        $this->db->join('users', 'users.id = courses.instructor_id', 'left');
        $this->db->order_by('courses.created_at', 'DESC');
        
        $query = $this->db->get();
        return $query->result();
    }

    // Get published courses
    public function get_published_courses() {
        $this->db->select('courses.*, categories.name as category_name, users.full_name as instructor_name');
        $this->db->from('courses');
        $this->db->join('categories', 'categories.id = courses.category_id', 'left');
        $this->db->join('users', 'users.id = courses.instructor_id', 'left');
        $this->db->where('courses.status', 'published');
        $this->db->order_by('courses.created_at', 'DESC');
        
        $query = $this->db->get();
        return $query->result();
    }

    // Get courses by instructor
    public function get_instructor_courses($instructor_id) {
        $this->db->select('courses.*, categories.name as category_name');
        $this->db->from('courses');
        $this->db->join('categories', 'categories.id = courses.category_id', 'left');
        $this->db->where('courses.instructor_id', $instructor_id);
        $this->db->order_by('courses.created_at', 'DESC');
        
        $query = $this->db->get();
        return $query->result();
    }

    // Get courses by category
    public function get_courses_by_category($category_id) {
        $this->db->select('courses.*, categories.name as category_name, users.full_name as instructor_name');
        $this->db->from('courses');
        $this->db->join('categories', 'categories.id = courses.category_id', 'left');
        $this->db->join('users', 'users.id = courses.instructor_id', 'left');
        $this->db->where('courses.category_id', $category_id);
        $this->db->where('courses.status', 'published');
        $this->db->order_by('courses.created_at', 'DESC');
        
        $query = $this->db->get();
        return $query->result();
    }

    // Get course by ID
    public function get_course($course_id) {
        $this->db->select('courses.*, categories.name as category_name, users.full_name as instructor_name');
        $this->db->from('courses');
        $this->db->join('categories', 'categories.id = courses.category_id', 'left');
        $this->db->join('users', 'users.id = courses.instructor_id', 'left');
        $this->db->where('courses.id', $course_id);
        
        $query = $this->db->get();
        
        if ($query->num_rows() == 1) {
            return $query->row();
        }
        
        return false;
    }

    // Update course
    public function update_course($course_id, $data) {
        $this->db->where('id', $course_id);
        $this->db->update('courses', $data);
        
        return $this->db->affected_rows() > 0;
    }

    // Delete course
    public function delete_course($course_id) {
        $this->db->where('id', $course_id);
        $this->db->delete('courses');
        
        return $this->db->affected_rows() > 0;
    }

    // Enroll student in course
    public function enroll_student($user_id, $course_id) {
        $data = array(
            'user_id' => $user_id,
            'course_id' => $course_id
        );
        
        // Check if already enrolled
        $this->db->where($data);
        $query = $this->db->get('enrollments');
        
        if ($query->num_rows() == 0) {
            // Not enrolled yet, insert new enrollment
            $this->db->insert('enrollments', $data);
            return $this->db->insert_id();
        }
        
        return false; // Already enrolled
    }

    // Get enrolled courses for a student
    public function get_enrolled_courses($user_id) {
        $this->db->select('courses.*, categories.name as category_name, users.full_name as instructor_name');
        $this->db->from('enrollments');
        $this->db->join('courses', 'courses.id = enrollments.course_id');
        $this->db->join('categories', 'categories.id = courses.category_id', 'left');
        $this->db->join('users', 'users.id = courses.instructor_id', 'left');
        $this->db->where('enrollments.user_id', $user_id);
        $this->db->order_by('enrollments.enrolled_at', 'DESC');
        
        $query = $this->db->get();
        $courses = $query->result();
        
        // Add progress information for each course
        $this->load->model('lesson_model');
        foreach ($courses as $course) {
            $progress = $this->lesson_model->get_course_progress($user_id, $course->id);
            $course->progress_percentage = $progress['percentage'];
            $course->completed_lessons = $progress['completed'];
            $course->total_lessons = $progress['total'];
            $course->next_lesson_id = $progress['next_lesson'];
        }
        
        return $courses;
    }

    // Check if user is enrolled in a course
    public function is_enrolled($user_id, $course_id) {
        $this->db->where('user_id', $user_id);
        $this->db->where('course_id', $course_id);
        $query = $this->db->get('enrollments');
        
        return $query->num_rows() > 0;
    }

    // Get course analytics for instructor
    public function get_course_analytics($course_id) {
        // Get basic course info
        $course = $this->get_course($course_id);
        if (!$course) {
            return false;
        }

        // Get total enrollments
        $this->db->where('course_id', $course_id);
        $total_enrollments = $this->db->count_all_results('enrollments');

        // Get enrolled students with their progress
        $this->db->select('users.id, users.full_name, users.email, enrollments.enrolled_at');
        $this->db->from('enrollments');
        $this->db->join('users', 'users.id = enrollments.user_id');
        $this->db->where('enrollments.course_id', $course_id);
        $this->db->order_by('enrollments.enrolled_at', 'DESC');
        $enrolled_students = $this->db->get()->result();

        // Get total lessons for this course
        $this->db->where('course_id', $course_id);
        $total_lessons = $this->db->count_all_results('lessons');

        // Add progress data for each student
        $this->load->model('lesson_model');
        foreach ($enrolled_students as $student) {
            $progress = $this->lesson_model->get_course_progress($student->id, $course_id);
            $student->progress_percentage = $progress['percentage'];
            $student->completed_lessons = $progress['completed'];
            $student->total_lessons = $progress['total'];
            $student->last_activity = $this->get_student_last_activity($student->id, $course_id);
        }

        // Calculate overall statistics
        $total_progress = 0;
        $active_students = 0; // Students with > 0% progress
        $completed_students = 0; // Students with 100% progress

        foreach ($enrolled_students as $student) {
            $total_progress += $student->progress_percentage;
            if ($student->progress_percentage > 0) {
                $active_students++;
            }
            if ($student->progress_percentage >= 100) {
                $completed_students++;
            }
        }

        $average_progress = $total_enrollments > 0 ? round($total_progress / $total_enrollments, 1) : 0;

        return array(
            'course' => $course,
            'total_enrollments' => $total_enrollments,
            'total_lessons' => $total_lessons,
            'enrolled_students' => $enrolled_students,
            'average_progress' => $average_progress,
            'active_students' => $active_students,
            'completed_students' => $completed_students,
            'completion_rate' => $total_enrollments > 0 ? round(($completed_students / $total_enrollments) * 100, 1) : 0
        );
    }

    // Get student's last activity in a course
    public function get_student_last_activity($user_id, $course_id) {
        $this->db->select('MAX(lesson_progress.last_accessed) as last_activity');
        $this->db->from('lesson_progress');
        $this->db->join('lessons', 'lessons.id = lesson_progress.lesson_id');
        $this->db->where('lesson_progress.user_id', $user_id);
        $this->db->where('lessons.course_id', $course_id);
        $result = $this->db->get()->row();
        
        return $result ? $result->last_activity : null;
    }

    // Get instructor dashboard statistics
    public function get_instructor_stats($instructor_id) {
        // Get instructor's courses count
        $this->db->where('instructor_id', $instructor_id);
        $total_courses = $this->db->count_all_results('courses');

        // Get total enrollments across all instructor's courses
        $this->db->select('COUNT(enrollments.id) as total_enrollments');
        $this->db->from('enrollments');
        $this->db->join('courses', 'courses.id = enrollments.course_id');
        $this->db->where('courses.instructor_id', $instructor_id);
        $total_enrollments = $this->db->get()->row()->total_enrollments;

        // Get total lessons across all instructor's courses
        $this->db->select('COUNT(lessons.id) as total_lessons');
        $this->db->from('lessons');
        $this->db->join('courses', 'courses.id = lessons.course_id');
        $this->db->where('courses.instructor_id', $instructor_id);
        $total_lessons = $this->db->get()->row()->total_lessons;

        // Get recent enrollments (last 30 days)
        $this->db->select('COUNT(enrollments.id) as recent_enrollments');
        $this->db->from('enrollments');
        $this->db->join('courses', 'courses.id = enrollments.course_id');
        $this->db->where('courses.instructor_id', $instructor_id);
        $this->db->where('enrollments.enrolled_at >=', date('Y-m-d H:i:s', strtotime('-30 days')));
        $recent_enrollments = $this->db->get()->row()->recent_enrollments;

        return array(
            'total_courses' => $total_courses,
            'total_enrollments' => $total_enrollments,
            'total_lessons' => $total_lessons,
            'recent_enrollments' => $recent_enrollments
        );
    }
    
    // Upload course thumbnail
    public function upload_thumbnail($course_id) {
        // Load upload library
        $this->load->library('upload');
        
        // Create upload directory if it doesn't exist
        $upload_path = './uploads/thumbnails/';
        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0777, TRUE);
        }
        
        // Set upload configuration
        $config = array(
            'upload_path' => $upload_path,
            'allowed_types' => 'gif|jpg|jpeg|png',
            'max_size' => 2048, // 2MB
            'encrypt_name' => TRUE
        );
        
        $this->upload->initialize($config);
        
        // Perform upload
        if ($this->upload->do_upload('thumbnail')) {
            $upload_data = $this->upload->data();
            $thumbnail = $upload_data['file_name'];
            
            // Update course record with new thumbnail
            $this->db->where('id', $course_id);
            $this->db->update('courses', array('thumbnail' => $thumbnail));
            
            return $thumbnail;
        }
        
        return FALSE;
    }
} 
