<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

// Default controller
$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Auth routes
$route['login'] = 'auth/login';
$route['register'] = 'auth/register';
$route['logout'] = 'auth/logout';

// Home routes
$route['courses'] = 'home/courses';
$route['course/(:num)'] = 'home/course/$1';
$route['lesson/(:num)/(:num)'] = 'home/lesson/$1/$2';
$route['category/(:num)'] = 'home/category/$1';

// Admin routes
$route['admin'] = 'admin/index';
$route['admin/dashboard'] = 'admin/dashboard';
$route['admin/users'] = 'admin/users';
$route['admin/create_user'] = 'admin/create_user';
$route['admin/edit_user/(:num)'] = 'admin/edit_user/$1';
$route['admin/delete_user/(:num)'] = 'admin/delete_user/$1';
$route['admin/categories'] = 'admin/categories';
$route['admin/create_category'] = 'admin/create_category';
$route['admin/edit_category/(:num)'] = 'admin/edit_category/$1';
$route['admin/delete_category/(:num)'] = 'admin/delete_category/$1';
$route['admin/courses'] = 'admin/courses';
$route['admin/create_course'] = 'admin/create_course';
$route['admin/edit_course/(:num)'] = 'admin/edit_course/$1';
$route['admin/delete_course/(:num)'] = 'admin/delete_course/$1';
$route['admin/lessons/(:num)'] = 'admin/lessons/$1';
$route['admin/create_lesson/(:num)'] = 'admin/create_lesson/$1';
$route['admin/edit_lesson/(:num)'] = 'admin/edit_lesson/$1';
$route['admin/delete_lesson/(:num)'] = 'admin/delete_lesson/$1';

// Instructor routes
$route['instructor'] = 'instructor/index';
$route['instructor/dashboard'] = 'instructor/dashboard';
$route['instructor/courses'] = 'instructor/courses';
$route['instructor/create_course'] = 'instructor/create_course';
$route['instructor/edit_course/(:num)'] = 'instructor/edit_course/$1';
$route['instructor/delete_course/(:num)'] = 'instructor/delete_course/$1';
$route['instructor/lessons/(:num)'] = 'instructor/lessons/$1';
$route['instructor/create_lesson/(:num)'] = 'instructor/create_lesson/$1';
$route['instructor/edit_lesson/(:num)'] = 'instructor/edit_lesson/$1';
$route['instructor/delete_lesson/(:num)'] = 'instructor/delete_lesson/$1';

// Student routes
$route['student'] = 'student/index';
$route['student/dashboard'] = 'student/dashboard';
$route['student/courses'] = 'student/courses';
$route['student/my_courses'] = 'student/my_courses';
$route['student/course/(:num)'] = 'student/course/$1';
$route['student/lesson/(:num)/(:num)'] = 'student/lesson/$1/$2';
$route['student/enroll/(:num)'] = 'student/enroll/$1';
$route['student/profile'] = 'student/profile';
$route['student/edit_profile'] = 'student/edit_profile';

// Student quiz routes
$route['student/quizzes/(:num)'] = 'student/quizzes/$1';
$route['student/take_quiz/(:num)'] = 'student/take_quiz/$1';
$route['student/quiz_attempt/(:num)'] = 'student/quiz_attempt/$1';
$route['student/quiz_result/(:num)'] = 'student/quiz_result/$1';
$route['student/rate_course/(:num)'] = 'student/rate_course/$1';
