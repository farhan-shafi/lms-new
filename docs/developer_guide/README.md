# LMS Developer Documentation

This developer guide provides technical documentation for the Learning Management System (LMS), including architecture, code structure, database schema, and implementation details.

## Table of Contents

- [System Architecture](#system-architecture)
- [Technology Stack](#technology-stack)
- [Directory Structure](#directory-structure)
- [Database Schema](#database-schema)
- [Core Components](#core-components)
- [Analytics & Progress Tracking Implementation](#analytics--progress-tracking-implementation)
- [API Documentation](#api-documentation)
- [Extending the System](#extending-the-system)

## System Architecture

The LMS follows the Model-View-Controller (MVC) architecture pattern using CodeIgniter 3 framework:

- **Models**: Handle data access and business logic
- **Views**: Render the user interface
- **Controllers**: Process user input and coordinate between models and views

## Technology Stack

- **Backend**: PHP 7.4+ with CodeIgniter 3 framework
- **Database**: MySQL 5.7+
- **Frontend**: HTML5, CSS3 (Tailwind CSS), JavaScript
- **Server**: Apache with mod_rewrite enabled
- **Dependencies**: Managed via Composer

## Directory Structure

The application follows CodeIgniter's standard directory structure with some customizations:

```
lms-new/
├── application/
│   ├── cache/
│   ├── config/        # Configuration files
│   ├── controllers/   # Controller classes
│   │   ├── Admin.php
│   │   ├── Auth.php
│   │   ├── Home.php
│   │   ├── Instructor.php
│   │   └── Student.php
│   ├── core/          # Core system extensions
│   ├── helpers/       # Helper functions
│   ├── hooks/         # System hooks
│   ├── language/      # Localization files
│   ├── libraries/     # Custom libraries
│   ├── logs/          # Log files
│   ├── models/        # Data models
│   │   ├── Category_model.php
│   │   ├── Course_model.php
│   │   ├── Lesson_model.php
│   │   └── User_model.php
│   ├── third_party/   # Third-party libraries
│   └── views/         # View templates
│       ├── admin/
│       ├── auth/
│       ├── home/
│       ├── instructor/
│       ├── student/
│       └── templates/
├── system/            # CodeIgniter core files
├── uploads/           # User uploaded files
│   └── thumbnails/    # Course thumbnails
└── index.php          # Application entry point
```

## Database Schema

### Core Tables

#### `users`

- `id` - Primary key
- `username` - Unique username
- `password` - Bcrypt hashed password
- `email` - User email address
- `full_name` - User's full name
- `role` - User role (admin, instructor, student)
- `created_at` - Account creation timestamp
- `updated_at` - Last update timestamp

#### `categories`

- `id` - Primary key
- `name` - Category name
- `description` - Category description
- `sort_order` - Display order
- `created_at` - Creation timestamp
- `updated_at` - Last update timestamp

#### `courses`

- `id` - Primary key
- `title` - Course title
- `description` - Course description
- `instructor_id` - Foreign key to users table
- `category_id` - Foreign key to categories table
- `thumbnail` - Path to course thumbnail image
- `status` - Course status (draft, published)
- `created_at` - Creation timestamp
- `updated_at` - Last update timestamp

#### `lessons`

- `id` - Primary key
- `course_id` - Foreign key to courses table
- `title` - Lesson title
- `content` - Lesson content (HTML)
- `video_url` - URL to video content (optional)
- `sort_order` - Display order within course
- `created_at` - Creation timestamp
- `updated_at` - Last update timestamp

### Progress Tracking Tables

#### `enrollments`

- `id` - Primary key
- `user_id` - Foreign key to users table
- `course_id` - Foreign key to courses table
- `enrolled_at` - Enrollment timestamp

#### `lesson_progress`

- `id` - Primary key
- `user_id` - Foreign key to users table
- `lesson_id` - Foreign key to lessons table
- `completed` - Boolean completion status
- `completed_at` - Completion timestamp
- `last_accessed` - Last access timestamp

## Core Components

### Authentication System

Authentication is handled by the `Auth` controller and `User_model`:

- `Auth::login()` - Handles user login
- `Auth::register()` - Handles user registration
- `Auth::logout()` - Handles user logout
- `User_model::verify_password()` - Verifies password using bcrypt

### Course Management

Course management is implemented in the `Course_model` and respective controllers:

- `Course_model::create_course()` - Creates a new course
- `Course_model::update_course()` - Updates course details
- `Course_model::delete_course()` - Deletes a course
- `Course_model::get_course()` - Retrieves course details
- `Course_model::get_instructor_courses()` - Gets courses by instructor

### Lesson Management

Lesson management is implemented in the `Lesson_model`:

- `Lesson_model::create_lesson()` - Creates a new lesson
- `Lesson_model::update_lesson()` - Updates lesson details
- `Lesson_model::delete_lesson()` - Deletes a lesson
- `Lesson_model::get_course_lessons()` - Gets lessons for a course

## Analytics & Progress Tracking Implementation

### Models

#### Course_model

**Analytics Methods:**

```php
// Get comprehensive analytics for a course
public function get_course_analytics($course_id) {
    // Implementation details for gathering course analytics
    // Returns array with enrollment stats, progress data, etc.
}

// Get student's last activity in a course
public function get_student_last_activity($user_id, $course_id) {
    // Implementation to find most recent activity timestamp
}

// Get instructor dashboard statistics
public function get_instructor_stats($instructor_id) {
    // Implementation for instructor-level statistics
    // Returns array with counts of courses, enrollments, etc.
}
```

#### Lesson_model

**Progress Tracking Methods:**

```php
// Get user's progress for a course
public function get_course_progress($user_id, $course_id) {
    // Implementation to calculate progress percentage
    // Returns array with percentage, completed lessons, etc.
}

// Check if lesson is completed by user
public function is_lesson_completed($user_id, $lesson_id) {
    // Implementation to check completion status
}

// Mark lesson as complete
public function mark_lesson_complete($user_id, $lesson_id) {
    // Implementation to mark lesson as complete
    // Updates or inserts record in lesson_progress table
}

// Mark lesson as incomplete
public function mark_lesson_incomplete($user_id, $lesson_id) {
    // Implementation to mark lesson as incomplete
}

// Toggle lesson completion status
public function toggle_lesson_completion($user_id, $lesson_id) {
    // Implementation to toggle between complete/incomplete
}

// Get lesson completion date
public function get_lesson_completion_date($user_id, $lesson_id) {
    // Implementation to retrieve completion timestamp
}
```

### Controllers

#### Instructor Controller

**Analytics Methods:**

```php
// Show course analytics dashboard
public function course_analytics($course_id) {
    // Implementation to display course analytics
    // Loads course_analytics view with data
}

// Show individual student progress
public function student_progress($course_id, $student_id) {
    // Implementation to display student progress details
    // Supports both HTML and JSON (AJAX) responses
}
```

#### Student Controller

**Progress Methods:**

```php
// Mark lesson as complete (AJAX endpoint)
public function mark_lesson_complete($lesson_id) {
    // Implementation for AJAX completion marking
    // Returns JSON response
}

// Toggle lesson completion (AJAX endpoint)
public function toggle_lesson_completion($lesson_id) {
    // Implementation for AJAX completion toggling
    // Returns JSON response
}
```

## API Documentation

### AJAX Endpoints

#### Mark Lesson Complete

- **URL**: `/student/mark_lesson_complete/{lesson_id}`
- **Method**: POST
- **Response**: JSON
  ```json
  {
  	"success": true,
  	"message": "Lesson marked as complete",
  	"completed": true
  }
  ```

#### Toggle Lesson Completion

- **URL**: `/student/toggle_lesson_completion/{lesson_id}`
- **Method**: POST
- **Response**: JSON
  ```json
  {
    "success": true,
    "message": "Lesson completion toggled",
    "completed": true|false
  }
  ```

#### Get Student Progress

- **URL**: `/instructor/student_progress/{course_id}/{student_id}`
- **Method**: GET
- **Headers**: `X-Requested-With: XMLHttpRequest`
- **Response**: JSON
  ```json
  {
  	"student": {
  		"id": 123,
  		"full_name": "John Doe",
  		"email": "john@example.com"
  	},
  	"course": {
  		"id": 456,
  		"title": "Course Title"
  	},
  	"progress": {
  		"percentage": 75,
  		"completed": 3,
  		"total": 4
  	},
  	"lessons": [
  		{
  			"id": 1,
  			"title": "Lesson 1",
  			"is_completed": true,
  			"completed_at": "2023-05-15 14:30:00"
  		}
  		// More lessons...
  	]
  }
  ```

## Extending the System

### Adding New User Roles

1. Add the new role to the `users` table schema
2. Create a controller for the new role
3. Implement role-specific views
4. Add role check to the authentication middleware

### Adding Custom Analytics

1. Add new methods to the relevant models
2. Create controller methods to process and display the data
3. Implement views to visualize the analytics

### Adding New Features

1. Plan the database schema changes if needed
2. Implement models for data access
3. Create controller methods for business logic
4. Design views for user interface
5. Add any necessary JavaScript for interactivity

---

## Development Guidelines

### Coding Standards

- Follow PSR-2 coding style for PHP
- Use meaningful variable and function names
- Document all methods with PHPDoc comments
- Keep methods focused on a single responsibility

### Security Practices

- Always validate and sanitize user input
- Use prepared statements for database queries
- Implement proper access control checks
- Hash passwords using bcrypt

### Performance Optimization

- Use database indexes for frequently queried columns
- Cache expensive database queries
- Optimize database joins in analytics queries
- Implement pagination for large data sets

---

_This developer documentation is maintained by the LMS development team. Last updated: [Current Date]_
