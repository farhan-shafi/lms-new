-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 08, 2025 at 06:25 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lms_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Web Development', 'Learn modern web development technologies including HTML, CSS, JavaScript, and frameworks', '2025-07-07 15:35:14', '2025-07-07 15:35:14'),
(2, 'Mobile Development', 'Mobile app development for iOS and Android platforms', '2025-07-07 15:35:14', '2025-07-07 15:35:14'),
(3, 'Data Science', 'Data analysis, machine learning, and artificial intelligence courses', '2025-07-07 15:35:14', '2025-07-07 15:35:14'),
(4, 'Cybersecurity', 'Information security, ethical hacking, and cybersecurity fundamentals', '2025-07-07 15:35:14', '2025-07-07 15:35:14'),
(5, 'Cloud Computing', 'AWS, Azure, Google Cloud, and cloud architecture courses', '2025-07-07 15:35:14', '2025-07-07 15:35:14'),
(6, 'Programming Languages', 'Learn various programming languages from beginner to advanced level', '2025-07-07 15:35:14', '2025-07-07 15:35:14'),
(7, 'Design', 'UI/UX design, graphic design, and digital art courses', '2025-07-07 15:35:14', '2025-07-07 15:35:14'),
(8, 'Business & Marketing', 'Digital marketing, entrepreneurship, and business development', '2025-07-07 15:35:14', '2025-07-07 15:35:14'),
(9, 'DevOps', 'DevOps practices, CI/CD, containerization, and infrastructure automation', '2025-07-07 15:35:14', '2025-07-07 15:35:14');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `instructor_id` int(11) NOT NULL,
  `status` enum('draft','published') DEFAULT 'draft',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `title`, `description`, `thumbnail`, `category_id`, `instructor_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Complete HTML & CSS Course', 'Learn HTML and CSS from scratch to build beautiful, responsive websites. Perfect for beginners who want to start their web development journey.', NULL, 1, 2, 'published', '2025-07-07 15:35:14', '2025-07-07 15:35:14'),
(2, 'JavaScript Fundamentals', 'Master the fundamentals of JavaScript programming including variables, functions, objects, and DOM manipulation.', NULL, 1, 2, 'published', '2025-07-07 15:35:14', '2025-07-07 15:35:14'),
(3, 'React.js for Beginners', 'Build modern web applications with React.js. Learn components, state management, hooks, and routing.', NULL, 1, 2, 'published', '2025-07-07 15:35:14', '2025-07-07 15:35:14'),
(4, 'Python Programming Basics', 'Introduction to Python programming covering syntax, data structures, functions, and object-oriented programming.', '5c65f57a97ddbad62e983efe1b5f63aa.jpeg', 6, 3, 'published', '2025-07-07 15:35:14', '2025-07-07 21:28:32'),
(5, 'Data Analysis with Python', 'Learn data analysis using Python libraries like Pandas, NumPy, and Matplotlib. Perfect for aspiring data scientists.', NULL, 3, 3, 'published', '2025-07-07 15:35:14', '2025-07-07 15:35:14'),
(6, 'Machine Learning Fundamentals', 'Introduction to machine learning concepts, algorithms, and practical implementation using Python and scikit-learn.', NULL, 3, 3, 'published', '2025-07-07 15:35:14', '2025-07-07 15:35:14'),
(7, 'iOS App Development with Swift', 'Build native iOS applications using Swift and Xcode. Learn UIKit, Core Data, and App Store deployment.', NULL, 2, 4, 'published', '2025-07-07 15:35:14', '2025-07-07 15:35:14'),
(8, 'Flutter Mobile Development', 'Create cross-platform mobile apps with Flutter and Dart. Build for both iOS and Android with a single codebase.', NULL, 2, 4, 'published', '2025-07-07 15:35:14', '2025-07-07 15:35:14'),
(9, 'UI/UX Design Principles', 'Learn the fundamentals of user interface and user experience design. Create intuitive and beautiful digital experiences.', NULL, 7, 4, 'published', '2025-07-07 15:35:14', '2025-07-07 15:35:14'),
(10, 'Cybersecurity Basics', 'Introduction to cybersecurity concepts, threats, and defense strategies. Learn to protect digital assets.', NULL, 4, 5, 'published', '2025-07-07 15:35:14', '2025-07-07 15:35:14'),
(11, 'Ethical Hacking Course', 'Learn ethical hacking techniques and penetration testing. Understand vulnerabilities and how to secure systems.', NULL, 4, 5, 'draft', '2025-07-07 15:35:14', '2025-07-07 15:35:14'),
(12, 'AWS Cloud Fundamentals', 'Introduction to Amazon Web Services (AWS) cloud computing platform. Learn core services and cloud architecture.', NULL, 5, 2, 'published', '2025-07-07 15:35:14', '2025-07-07 15:35:14'),
(13, 'Digital Marketing Mastery', 'Complete guide to digital marketing including SEO, social media marketing, email marketing, and analytics.', NULL, 8, 4, 'published', '2025-07-07 15:35:14', '2025-07-07 15:35:14'),
(14, 'DevOps with Docker & Kubernetes', 'Learn containerization with Docker and orchestration with Kubernetes. Implement CI/CD pipelines.', NULL, 9, 2, 'draft', '2025-07-07 15:35:14', '2025-07-07 15:35:14');

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE `enrollments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `enrolled_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enrollments`
--

INSERT INTO `enrollments` (`id`, `user_id`, `course_id`, `enrolled_at`) VALUES
(1, 6, 1, '2025-07-07 15:35:14'),
(2, 6, 2, '2025-07-07 15:35:14'),
(3, 7, 4, '2025-07-07 15:35:14'),
(4, 7, 5, '2025-07-07 15:35:14'),
(5, 8, 1, '2025-07-07 15:35:14'),
(6, 8, 13, '2025-07-07 15:35:14'),
(7, 9, 1, '2025-07-07 16:12:41'),
(8, 9, 2, '2025-07-07 16:17:56');

-- --------------------------------------------------------

--
-- Table structure for table `lessons`
--

CREATE TABLE `lessons` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `content` text DEFAULT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `sort_order` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lessons`
--

INSERT INTO `lessons` (`id`, `course_id`, `title`, `content`, `video_url`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 1, 'Introduction to HTML', 'Learn the basics of HTML (HyperText Markup Language), the foundation of all web pages. In this lesson, we will cover the structure of HTML documents, basic tags, and how to create your first webpage.', 'https://www.youtube.com/watch?v=UB1O30fR-EE', 1, '2025-07-07 15:35:14', '2025-07-07 15:35:14'),
(2, 1, 'HTML Elements and Tags', 'Dive deeper into HTML elements and tags. Learn about headings, paragraphs, links, images, and lists. Understand the difference between block and inline elements.', '', 2, '2025-07-07 15:35:14', '2025-07-07 15:35:14'),
(3, 1, 'Introduction to CSS', 'Cascading Style Sheets (CSS) control the appearance and layout of HTML elements. Learn CSS syntax, selectors, and how to apply styles to your web pages.', 'https://www.youtube.com/watch?v=yfoY53QXEnI', 3, '2025-07-07 15:35:14', '2025-07-07 15:35:14'),
(4, 1, 'CSS Layout and Positioning', 'Master CSS layout techniques including the box model, flexbox, and CSS Grid. Learn how to create responsive layouts that work on all devices.', '', 4, '2025-07-07 15:35:14', '2025-07-07 15:35:14'),
(5, 1, 'Building Your First Website', 'Put everything together and build a complete responsive website using HTML and CSS. Apply best practices and modern techniques.', '', 5, '2025-07-07 15:35:14', '2025-07-07 15:35:14'),
(6, 2, 'JavaScript Basics', 'Introduction to JavaScript programming language. Learn about variables, data types, and basic syntax. Understand how JavaScript runs in the browser.', 'https://www.youtube.com/watch?v=hdI2bqOjy3c', 1, '2025-07-07 15:35:14', '2025-07-07 15:35:14'),
(7, 2, 'Functions and Scope', 'Learn how to create and use functions in JavaScript. Understand function scope, parameters, return values, and arrow functions.', '', 2, '2025-07-07 15:35:14', '2025-07-07 15:35:14'),
(8, 2, 'Objects and Arrays', 'Master JavaScript objects and arrays. Learn how to store and manipulate data using these fundamental data structures.', '', 3, '2025-07-07 15:35:14', '2025-07-07 15:35:14'),
(9, 2, 'DOM Manipulation', 'Learn how to interact with HTML elements using JavaScript. Understand the Document Object Model (DOM) and how to create dynamic web pages.', '', 4, '2025-07-07 15:35:14', '2025-07-07 15:35:14'),
(10, 2, 'Event Handling', 'Handle user interactions like clicks, form submissions, and keyboard input. Create interactive web applications with event listeners.', '', 5, '2025-07-07 15:35:14', '2025-07-07 15:35:14'),
(11, 4, 'Python Installation and Setup', 'Get started with Python programming. Learn how to install Python, set up your development environment, and write your first Python program.', 'https://www.youtube.com/watch?v=YYXdXT2l-Gg', 1, '2025-07-07 15:35:14', '2025-07-07 15:35:14'),
(12, 4, 'Variables and Data Types', 'Understanding Python variables, numbers, strings, booleans, and basic data types. Learn how to work with different types of data in Python.', '', 2, '2025-07-07 15:35:14', '2025-07-07 15:35:14'),
(13, 4, 'Control Structures', 'Learn about conditional statements (if, elif, else) and loops (for, while) in Python. Control the flow of your programs.', '', 3, '2025-07-07 15:35:14', '2025-07-07 15:35:14'),
(14, 4, 'Functions in Python', 'Create reusable code with Python functions. Learn about parameters, return values, and scope in Python functions.', '', 4, '2025-07-07 15:35:14', '2025-07-07 15:35:14'),
(15, 4, 'Python Data Structures', 'Master Python lists, tuples, dictionaries, and sets. Learn when and how to use each data structure effectively.', '', 5, '2025-07-07 15:35:14', '2025-07-07 15:35:14'),
(16, 5, 'Introduction to Data Analysis', 'Overview of data analysis and its importance in decision making. Learn about the data analysis process and tools used in the field.', '', 1, '2025-07-07 15:35:14', '2025-07-07 15:35:14'),
(17, 5, 'Working with Pandas', 'Introduction to Pandas library for data manipulation and analysis. Learn how to load, clean, and transform data using Pandas DataFrames.', '', 2, '2025-07-07 15:35:14', '2025-07-07 15:35:14'),
(18, 5, 'Data Visualization with Matplotlib', 'Create stunning visualizations using Matplotlib. Learn how to create charts, graphs, and plots to represent your data insights.', '', 3, '2025-07-07 15:35:14', '2025-07-07 15:35:14'),
(19, 5, 'Statistical Analysis', 'Perform statistical analysis on your datasets. Learn about descriptive statistics, correlation, and hypothesis testing.', '', 4, '2025-07-07 15:35:14', '2025-07-07 15:35:14');

-- --------------------------------------------------------

--
-- Table structure for table `lesson_progress`
--

CREATE TABLE `lesson_progress` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `completed` tinyint(1) DEFAULT 0,
  `last_accessed` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lesson_progress`
--

INSERT INTO `lesson_progress` (`id`, `user_id`, `lesson_id`, `completed`, `last_accessed`) VALUES
(1, 6, 1, 1, '2025-07-07 15:35:14'),
(2, 6, 2, 1, '2025-07-07 15:35:14'),
(3, 6, 3, 0, '2025-07-07 15:35:14'),
(4, 7, 14, 1, '2025-07-07 15:35:14'),
(5, 7, 15, 1, '2025-07-07 15:35:14'),
(6, 8, 1, 1, '2025-07-07 15:35:14'),
(7, 1, 1, 1, '2025-07-07 12:40:28'),
(8, 1, 2, 1, '2025-07-07 12:44:15'),
(9, 9, 1, 1, '2025-07-07 13:17:43'),
(10, 9, 2, 1, '2025-07-07 13:15:03'),
(11, 9, 3, 1, '2025-07-07 13:14:18'),
(12, 9, 4, 1, '2025-07-07 13:14:20'),
(13, 9, 5, 1, '2025-07-07 13:14:21'),
(14, 9, 6, 1, '2025-07-07 13:18:27'),
(15, 9, 7, 1, '2025-07-07 13:18:47'),
(16, 9, 8, 1, '2025-07-07 13:18:37'),
(17, 9, 9, 0, '2025-07-07 13:19:25');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','instructor','student') NOT NULL DEFAULT 'student',
  `full_name` varchar(150) NOT NULL,
  `bio` text DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `full_name`, `bio`, `profile_image`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@lms.com', '$2y$10$LKry.ARXPS14sTEZD48YyekYYmyO9CLKEwL0a90JIBQqoltSp87ei', 'admin', 'Administrator', '', NULL, '2025-07-07 15:04:53', '2025-07-07 18:33:31'),
(2, 'farhanshafi', 'a@gmail.com', '$2y$10$5JuXDeoKSN6WBdhvitBlgOJfPoLeDkrZwwNtDAH3Fzgzg/QgXBsKO', 'student', 'Farhan Shafi', NULL, NULL, '2025-07-07 15:15:04', '2025-07-07 15:15:04'),
(3, 'sarim', 'sarim@gmail.com', '$2y$10$rs2vVK0uXjXtzgHJEyGckO3Cq9VA0vmvEnXoAQSlkZTH6UCQbDg76', 'instructor', 'Sarim Mehmood', 'Sarim shapatar teacher', '856003d7c5ee48b4133bb90a427245aa.png', '2025-07-07 15:32:20', '2025-07-07 21:30:38'),
(4, 'john_instructor', 'john@lms.com', '$2y$10$LKry.ARXPS14sTEZD48YyekYYmyO9CLKEwL0a90JIBQqoltSp87ei', 'instructor', 'John Smith', 'Experienced web developer with 10+ years in the industry', NULL, '2025-07-07 15:35:14', '2025-07-07 15:35:14'),
(5, 'sarah_instructor', 'sarah@lms.com', '$2y$10$LKry.ARXPS14sTEZD48YyekYYmyO9CLKEwL0a90JIBQqoltSp87ei', 'instructor', 'Sarah Johnson', 'Data scientist and machine learning expert', NULL, '2025-07-07 15:35:14', '2025-07-07 15:35:14'),
(6, 'mike_instructor', 'mike@lms.com', '$2y$10$LKry.ARXPS14sTEZD48YyekYYmyO9CLKEwL0a90JIBQqoltSp87ei', 'instructor', 'Mike Wilson', 'Mobile app developer and UI/UX designer', NULL, '2025-07-07 15:35:14', '2025-07-07 15:35:14'),
(7, 'emma_instructor', 'emma@lms.com', '$2y$10$LKry.ARXPS14sTEZD48YyekYYmyO9CLKEwL0a90JIBQqoltSp87ei', 'instructor', 'Emma Davis', 'Cybersecurity specialist and ethical hacker', NULL, '2025-07-07 15:35:14', '2025-07-07 15:35:14'),
(8, 'alice_student', 'alice@student.com', '$2y$10$LKry.ARXPS14sTEZD48YyekYYmyO9CLKEwL0a90JIBQqoltSp87ei', 'student', 'Alice Brown', 'Computer science student interested in web development', NULL, '2025-07-07 15:35:14', '2025-07-07 15:35:14'),
(9, 'bob_student', 'bob@student.com', '$2y$10$LKry.ARXPS14sTEZD48YyekYYmyO9CLKEwL0a90JIBQqoltSp87ei', 'student', 'Bob Martinez', 'Aspiring data scientist with a background in mathematics', '787a86c3cbccc7f39341499a6654e753.png', '2025-07-07 15:35:14', '2025-07-07 21:31:14'),
(10, 'carol_student', 'carol@student.com', '$2y$10$LKry.ARXPS14sTEZD48YyekYYmyO9CLKEwL0a90JIBQqoltSp87ei', 'student', 'Carol White', 'Marketing professional looking to learn digital skills', NULL, '2025-07-07 15:35:14', '2025-07-07 15:35:14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `instructor_id` (`instructor_id`);

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`course_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `lesson_progress`
--
ALTER TABLE `lesson_progress`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`lesson_id`),
  ADD KEY `lesson_id` (`lesson_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `lessons`
--
ALTER TABLE `lessons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `lesson_progress`
--
ALTER TABLE `lesson_progress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `courses_ibfk_2` FOREIGN KEY (`instructor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `enrollments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `enrollments_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lessons`
--
ALTER TABLE `lessons`
  ADD CONSTRAINT `lessons_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `lesson_progress`
--
ALTER TABLE `lesson_progress`
  ADD CONSTRAINT `lesson_progress_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `lesson_progress_ibfk_2` FOREIGN KEY (`lesson_id`) REFERENCES `lessons` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
