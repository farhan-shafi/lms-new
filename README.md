# Learning Management System (LMS)

A simple Learning Management System built with CodeIgniter 3 and Tailwind CSS.

## Features

### User Roles

- **Admin**: Manage everything (users, categories, courses, lessons)
- **Instructor**: Create and manage courses and lessons
- **Student**: Register, login, and access courses

### Course Management

- Create courses with title, description, category
- Add multiple lessons to courses
- Lessons can include text content and embedded videos

### Student Features

- Browse and enroll in courses
- Track progress through courses
- Mark lessons as completed

## Setup Instructions

### Requirements

- PHP 7.3 or higher
- MySQL 5.7 or higher
- Web server (Apache/Nginx)

### Installation Steps

1. **Clone the repository**

   ```
   git clone <repository-url>
   cd lms-new
   ```

2. **Set up the database**

   - Create a MySQL database
   - Import the `lms_schema.sql` file to create the tables and initial admin user

3. **Configure database connection**

   - Open `application/config/database.php`
   - Update the database connection details:
     ```php
     $db['default'] = array(
         'dsn'	=> '',
         'hostname' => 'localhost',
         'username' => 'your_db_username',
         'password' => 'your_db_password',
         'database' => 'lms_db',
         // ... other settings
     );
     ```

4. **Configure base URL**

   - Open `application/config/config.php`
   - Set your base URL:
     ```php
     $config['base_url'] = 'http://localhost/lms-new/';
     ```

5. **Set up file permissions**

   - Make sure the `uploads` directory is writable:
     ```
     mkdir uploads
     mkdir uploads/thumbnails
     chmod -R 755 uploads
     ```

6. **Access the LMS**
   - Open your browser and navigate to your base URL
   - Login with default admin credentials:
     - Username: `admin`
     - Password: `admin123`

## Directory Structure

```
lms-new/
├── application/
│   ├── controllers/
│   │   ├── Admin.php
│   │   ├── Auth.php
│   │   ├── Home.php
│   │   ├── Instructor.php
│   │   └── Student.php
│   ├── models/
│   │   ├── Category_model.php
│   │   ├── Course_model.php
│   │   ├── Lesson_model.php
│   │   └── User_model.php
│   └── views/
│       ├── admin/
│       ├── auth/
│       ├── home/
│       ├── instructor/
│       ├── student/
│       └── templates/
└── system/
```

## Technologies Used

- **Backend**: CodeIgniter 3 (PHP MVC Framework)
- **Database**: MySQL
- **Frontend**: Tailwind CSS
- **JavaScript**: Vanilla JS for interactive features

## License

This project is open-source and available under the MIT License.
