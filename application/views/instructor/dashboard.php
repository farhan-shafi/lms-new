<!-- Instructor Dashboard -->
<div class="bg-gray-100 min-h-screen">
    <!-- Dashboard Header -->
    <div class="bg-gradient-to-r from-indigo-800 to-purple-800 shadow-lg rounded-xl">
        <div class="container mx-auto px-4 py-8">
            <h1 class="text-2xl md:text-3xl font-bold text-white">Instructor Dashboard</h1>
            <p class="text-indigo-100 mt-1">Welcome, <?= $this->session->userdata('full_name') ?>!</p>
        </div>
    </div>
    
    <!-- Dashboard Content -->
    <div class="container mx-auto px-4 py-8">
        <!-- Stats Overview -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-8">
            <!-- Total Courses -->
            <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow p-5 border-l-4 border-blue-500">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                        <i class="fas fa-book-open text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-xs uppercase font-semibold text-gray-500">Total Courses</p>
                        <p class="text-2xl font-bold text-gray-800"><?= $stats['total_courses'] ?></p>
                    </div>
                </div>
            </div>

            <!-- Total Enrollments -->
            <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow p-5 border-l-4 border-green-500">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-600">
                        <i class="fas fa-users text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-xs uppercase font-semibold text-gray-500">Total Enrollments</p>
                        <p class="text-2xl font-bold text-gray-800"><?= $stats['total_enrollments'] ?></p>
                    </div>
                </div>
            </div>

            <!-- Total Lessons -->
            <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow p-5 border-l-4 border-yellow-500">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                        <i class="fas fa-list-alt text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-xs uppercase font-semibold text-gray-500">Total Lessons</p>
                        <p class="text-2xl font-bold text-gray-800"><?= $stats['total_lessons'] ?></p>
                    </div>
                </div>
            </div>

            <!-- Recent Enrollments -->
            <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow p-5 border-l-4 border-purple-500">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                        <i class="fas fa-user-plus text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-xs uppercase font-semibold text-gray-500">Recent Enrollments</p>
                        <p class="text-2xl font-bold text-gray-800"><?= $stats['recent_enrollments'] ?> <span class="text-xs font-normal text-gray-500">(30 days)</span></p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-8">
            <h2 class="text-xl font-bold text-gray-800 mb-5 flex items-center">
                <i class="fas fa-bolt text-amber-500 mr-2"></i>Quick Actions
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <a href="<?= base_url('instructor/create_course') ?>" class="flex items-center justify-center bg-indigo-50 text-indigo-700 rounded-lg p-4 transition-all transform hover:scale-102 shadow-sm hover:shadow hover:bg-indigo-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    <span class="text-base font-medium">Create New Course</span>
                </a>
                <a href="<?= base_url('instructor/courses') ?>" class="flex items-center justify-center bg-green-50 text-green-700 rounded-lg p-4 transition-all transform hover:scale-102 shadow-sm hover:shadow hover:bg-green-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <span class="text-base font-medium">Manage My Courses</span>
                </a>
                <a href="<?= base_url('home') ?>" class="flex items-center justify-center bg-gray-50 text-gray-700 rounded-lg p-4 transition-all transform hover:scale-102 shadow-sm hover:shadow hover:bg-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span class="text-base font-medium">View Frontend</span>
                </a>
            </div>
        </div>
        
        <!-- My Courses -->
        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-gray-800 flex items-center">
                    <i class="fas fa-graduation-cap text-indigo-600 mr-2"></i>My Courses
                </h2>
                <a href="<?= base_url('instructor/create_course') ?>" class="bg-indigo-50 text-indigo-700 text-sm py-2.5 px-4 rounded-lg shadow-sm hover:shadow hover:bg-indigo-100 transition-all flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-600 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Create Course
                </a>
            </div>
            
            <?php if (empty($courses)): ?>
                <div class="text-center py-8">
                    <p class="text-gray-600 mb-4">You haven't created any courses yet.</p>
                    <a href="<?= base_url('instructor/create_course') ?>" class="inline-block px-5 py-2.5 bg-indigo-50 text-indigo-700 font-medium rounded-lg shadow-sm hover:shadow hover:bg-indigo-100 transition-all">
                        Create Your First Course
                    </a>
                </div>
            <?php else: ?>
                <!-- Card Layout for All Screen Sizes -->
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                    <?php foreach ($courses as $course): ?>
                        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden hover:shadow-md transition-shadow">
                            <!-- Course Header with Gradient Background -->
                            <div class="bg-gradient-to-r from-indigo-50 to-blue-50 p-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-14 w-14">
                                        <?php if (!empty($course->thumbnail) && file_exists(FCPATH . 'uploads/thumbnails/' . $course->thumbnail)): ?>
                                            <img class="h-14 w-14 rounded-lg object-cover shadow-sm" src="<?= base_url('uploads/thumbnails/' . $course->thumbnail) ?>" alt="<?= $course->title ?>">
                                        <?php else: ?>
                                            <div class="h-14 w-14 rounded-lg bg-gradient-to-br from-indigo-100 to-indigo-200 flex items-center justify-center shadow-sm">
                                                <span class="text-indigo-600 font-bold text-xl"><?= substr($course->title, 0, 1) ?></span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <h3 class="text-lg font-bold text-gray-900 line-clamp-1"><?= $course->title ?></h3>
                                        <p class="text-sm text-gray-600"><?= $course->category_name ?? 'Uncategorized' ?></p>
                                    </div>
                                    <?php if($course->status == 'published'): ?>
                                        <span class="px-3 py-1 inline-flex items-center text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 border border-green-200">
                                            <span class="w-1.5 h-1.5 bg-green-600 rounded-full mr-1.5"></span>
                                            Published
                                        </span>
                                    <?php else: ?>
                                        <span class="px-3 py-1 inline-flex items-center text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 border border-yellow-200">
                                            <span class="w-1.5 h-1.5 bg-yellow-500 rounded-full mr-1.5"></span>
                                            Draft
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                                
                            <!-- Course Stats -->
                            <div class="p-4 bg-white">
                                <div class="grid grid-cols-2 gap-4 mb-4">
                                    <div class="bg-gray-50 rounded-lg p-3">
                                        <p class="text-xs text-gray-500 font-medium mb-1">Rating</p>
                                        <?php if (isset($course->average_rating)): ?>
                                        <div class="flex items-center">
                                            <div class="flex">
                                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                                    <?php if ($i <= round($course->average_rating)): ?>
                                                        <svg class="h-4 w-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                        </svg>
                                                    <?php else: ?>
                                                        <svg class="h-4 w-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                        </svg>
                                                    <?php endif; ?>
                                                <?php endfor; ?>
                                            </div>
                                            <span class="ml-2 text-sm font-medium text-gray-700"><?= number_format($course->average_rating, 1) ?></span>
                                            <span class="ml-1 text-xs text-gray-500">(<?= $course->rating_count ?? 0 ?>)</span>
                                        </div>
                                        <?php else: ?>
                                        <span class="text-sm text-gray-500 italic">No ratings yet</span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="bg-gray-50 rounded-lg p-3">
                                        <p class="text-xs text-gray-500 font-medium mb-1">Enrollments</p>
                                        <?php 
                                        // Count enrollments
                                        $this->db->where('course_id', $course->id);
                                        $enrollment_count = $this->db->count_all_results('enrollments');
                                        ?>
                                        <div class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                            <p class="text-sm font-medium text-gray-800"><?= $enrollment_count ?> students</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Course Management -->
                                <div class="border-t border-gray-200 pt-4">
                                    <div class="flex flex-wrap gap-2 mb-4">
                                        <a href="<?= base_url('instructor/lessons/' . $course->id) ?>" class="inline-flex items-center px-3 py-1.5 bg-indigo-50 text-indigo-700 text-xs font-medium rounded-lg border border-indigo-200 hover:bg-indigo-100 transition-all">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            Lessons
                                        </a>
                                        <a href="<?= base_url('instructor/quizzes/' . $course->id) ?>" class="inline-flex items-center px-3 py-1.5 bg-purple-50 text-purple-700 text-xs font-medium rounded-lg border border-purple-200 hover:bg-purple-100 transition-all">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Quizzes
                                        </a>
                                        <a href="<?= base_url('instructor/course_analytics/' . $course->id) ?>" class="inline-flex items-center px-3 py-1.5 bg-green-50 text-green-700 text-xs font-medium rounded-lg border border-green-200 hover:bg-green-100 transition-all">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                            </svg>
                                            Analytics
                                        </a>
                                    </div>
                                    <div class="grid grid-cols-3 gap-2">
                                        <a href="<?= base_url('home/course/' . $course->id) ?>" class="inline-flex items-center justify-center px-3 py-2 bg-blue-50 text-blue-700 text-xs font-medium rounded-lg border border-blue-200 hover:bg-blue-100 transition-all">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            View
                                        </a>
                                        <a href="<?= base_url('instructor/edit_course/' . $course->id) ?>" class="inline-flex items-center justify-center px-3 py-2 bg-indigo-50 text-indigo-700 text-xs font-medium rounded-lg border border-indigo-200 hover:bg-indigo-100 transition-all">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Edit
                                        </a>
                                        <a href="<?= base_url('instructor/delete_course/' . $course->id) ?>" class="inline-flex items-center justify-center px-3 py-2 bg-red-50 text-red-700 text-xs font-medium rounded-lg border border-red-200 hover:bg-red-100 transition-all" onclick="return confirm('Are you sure you want to delete this course?')">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Delete
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <?php if(count($courses) > 6): ?>
                <div class="mt-8 text-center">
                    <a href="<?= base_url('instructor/courses') ?>" class="inline-flex items-center px-5 py-2.5 bg-indigo-50 text-indigo-700 text-sm font-medium rounded-lg border border-indigo-200 hover:bg-indigo-100 shadow-sm hover:shadow transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                        </svg>
                        View All Courses
                    </a>
                </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div> 
