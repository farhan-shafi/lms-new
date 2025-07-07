<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : 'Learning Management System' ?></title>
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Custom Styles -->
    <style>
        /* Custom styles if needed */
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
    <!-- Navigation -->
    <nav class="bg-indigo-600 text-white shadow-lg">
        <div class="container mx-auto px-4 py-3">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <a href="<?= base_url() ?>" class="text-xl font-bold">LMS</a>
                
                <!-- Main Navigation -->
                <div class="hidden md:flex space-x-6">
                    <a href="<?= base_url() ?>" class="hover:text-indigo-200">Home</a>
                    <a href="<?= base_url('home/courses') ?>" class="hover:text-indigo-200">Courses</a>
                    <?php if ($this->session->userdata('logged_in')): ?>
                        <?php if ($this->session->userdata('role') == 'admin'): ?>
                            <a href="<?= base_url('admin/dashboard') ?>" class="hover:text-indigo-200">Admin Dashboard</a>
                        <?php elseif ($this->session->userdata('role') == 'instructor'): ?>
                            <a href="<?= base_url('instructor/dashboard') ?>" class="hover:text-indigo-200">Instructor Dashboard</a>
                        <?php elseif ($this->session->userdata('role') == 'student'): ?>
                            <a href="<?= base_url('student/dashboard') ?>" class="hover:text-indigo-200">My Dashboard</a>
                            <a href="<?= base_url('student/my_courses') ?>" class="hover:text-indigo-200">My Courses</a>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
                
                <!-- User Menu -->
                <div class="flex items-center space-x-4">
                    <?php if ($this->session->userdata('logged_in')): ?>
                        <div class="relative group">
                            <button class="flex items-center space-x-1 focus:outline-none">
                                <span><?= $this->session->userdata('full_name') ?></span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 hidden group-hover:block">
                                <?php if ($this->session->userdata('role') == 'student'): ?>
                                    <a href="<?= base_url('student/profile') ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                                <?php endif; ?>
                                <a href="<?= base_url('auth/logout') ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</a>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="<?= base_url('auth/login') ?>" class="bg-white text-indigo-600 px-4 py-2 rounded-md font-medium hover:bg-indigo-50">Login</a>
                        <a href="<?= base_url('auth/register') ?>" class="bg-indigo-700 text-white px-4 py-2 rounded-md font-medium hover:bg-indigo-800">Register</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile Navigation Menu (Hidden by default) -->
    <div class="md:hidden bg-indigo-700 hidden" id="mobile-menu">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <a href="<?= base_url() ?>" class="block px-3 py-2 text-white hover:bg-indigo-600 rounded-md">Home</a>
            <a href="<?= base_url('home/courses') ?>" class="block px-3 py-2 text-white hover:bg-indigo-600 rounded-md">Courses</a>
            <?php if ($this->session->userdata('logged_in')): ?>
                <?php if ($this->session->userdata('role') == 'admin'): ?>
                    <a href="<?= base_url('admin/dashboard') ?>" class="block px-3 py-2 text-white hover:bg-indigo-600 rounded-md">Admin Dashboard</a>
                <?php elseif ($this->session->userdata('role') == 'instructor'): ?>
                    <a href="<?= base_url('instructor/dashboard') ?>" class="block px-3 py-2 text-white hover:bg-indigo-600 rounded-md">Instructor Dashboard</a>
                <?php elseif ($this->session->userdata('role') == 'student'): ?>
                    <a href="<?= base_url('student/dashboard') ?>" class="block px-3 py-2 text-white hover:bg-indigo-600 rounded-md">My Dashboard</a>
                    <a href="<?= base_url('student/my_courses') ?>" class="block px-3 py-2 text-white hover:bg-indigo-600 rounded-md">My Courses</a>
                <?php endif; ?>
                <a href="<?= base_url('auth/logout') ?>" class="block px-3 py-2 text-white hover:bg-indigo-600 rounded-md">Logout</a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Flash Messages -->
    <?php if ($this->session->flashdata('success')): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 container mx-auto mt-4" role="alert">
            <span class="block sm:inline"><?= $this->session->flashdata('success') ?></span>
        </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 container mx-auto mt-4" role="alert">
            <span class="block sm:inline"><?= $this->session->flashdata('error') ?></span>
        </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('info')): ?>
        <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative mb-4 container mx-auto mt-4" role="alert">
            <span class="block sm:inline"><?= $this->session->flashdata('info') ?></span>
        </div>
    <?php endif; ?>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-6 flex-grow"> 
