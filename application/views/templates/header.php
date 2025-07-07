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
                </div>
                
                <!-- User Menu -->
                <div class="flex items-center space-x-4">
                    <?php if ($this->session->userdata('logged_in')): ?>
                        <!-- Mobile menu button -->
                        <button id="mobile-menu-button" class="md:hidden text-white hover:text-indigo-200 focus:outline-none">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                        
                        <!-- Desktop User Dropdown -->
                        <div class="relative">
                            <button id="user-menu-button" class="flex items-center space-x-1 hover:text-indigo-200 focus:outline-none" aria-expanded="false" aria-haspopup="true">
                                <span><?= $this->session->userdata('full_name') ?></span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transform transition-transform duration-200" id="dropdown-arrow" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div id="user-dropdown" class="absolute right-0 mt-2 w-56 bg-white rounded-md shadow-lg py-1 z-50 hidden">
                                <!-- Dashboard Links -->
                                <?php if ($this->session->userdata('role') == 'admin'): ?>
                                    <a href="<?= base_url('admin/dashboard') ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <svg class="inline h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                        </svg>
                                        Admin Dashboard
                                    </a>
                                <?php elseif ($this->session->userdata('role') == 'instructor'): ?>
                                    <a href="<?= base_url('instructor/dashboard') ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <svg class="inline h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                        Instructor Dashboard
                                    </a>
                                <?php elseif ($this->session->userdata('role') == 'student'): ?>
                                    <a href="<?= base_url('student/dashboard') ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <svg class="inline h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                        </svg>
                                        My Dashboard
                                    </a>
                                    <a href="<?= base_url('student/my_courses') ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <svg class="inline h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                        My Courses
                                    </a>
                                    <hr class="my-1">
                                    <a href="<?= base_url('student/profile') ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <svg class="inline h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        Profile
                                    </a>
                                <?php endif; ?>
                                <hr class="my-1">
                                <a href="<?= base_url('auth/logout') ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <svg class="inline h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    Logout
                                </a>
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
                    <a href="<?= base_url('student/profile') ?>" class="block px-3 py-2 text-white hover:bg-indigo-600 rounded-md">Profile</a>
                <?php endif; ?>
                <hr class="border-indigo-500 my-2">
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

    <!-- JavaScript for dropdowns -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // User dropdown functionality
            const userMenuButton = document.getElementById('user-menu-button');
            const userDropdown = document.getElementById('user-dropdown');
            const dropdownArrow = document.getElementById('dropdown-arrow');
            
            if (userMenuButton && userDropdown) {
                // Toggle dropdown on button click
                userMenuButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    const isOpen = !userDropdown.classList.contains('hidden');
                    
                    if (isOpen) {
                        userDropdown.classList.add('hidden');
                        dropdownArrow.style.transform = 'rotate(0deg)';
                        userMenuButton.setAttribute('aria-expanded', 'false');
                    } else {
                        userDropdown.classList.remove('hidden');
                        dropdownArrow.style.transform = 'rotate(180deg)';
                        userMenuButton.setAttribute('aria-expanded', 'true');
                    }
                });
                
                // Close dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    if (!userMenuButton.contains(e.target) && !userDropdown.contains(e.target)) {
                        userDropdown.classList.add('hidden');
                        dropdownArrow.style.transform = 'rotate(0deg)';
                        userMenuButton.setAttribute('aria-expanded', 'false');
                    }
                });
                
                // Close dropdown when pressing escape
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape') {
                        userDropdown.classList.add('hidden');
                        dropdownArrow.style.transform = 'rotate(0deg)';
                        userMenuButton.setAttribute('aria-expanded', 'false');
                    }
                });
            }
            
            // Mobile menu functionality
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            
            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    mobileMenu.classList.toggle('hidden');
                });
                
                // Close mobile menu when clicking outside
                document.addEventListener('click', function(e) {
                    if (!mobileMenuButton.contains(e.target) && !mobileMenu.contains(e.target)) {
                        mobileMenu.classList.add('hidden');
                    }
                });
            }
        });
    </script>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-6 flex-grow"> 
