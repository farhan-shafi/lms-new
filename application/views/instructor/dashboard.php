<!-- Instructor Dashboard -->
<div class="bg-gray-100 min-h-screen">
    <!-- Dashboard Header -->
    <div class="bg-white shadow-md">
        <div class="container mx-auto px-4 py-6">
            <h1 class="text-2xl font-bold text-gray-800">Instructor Dashboard</h1>
            <p class="text-gray-600">Welcome, <?= $this->session->userdata('full_name') ?>!</p>
        </div>
    </div>
    
    <!-- Dashboard Content -->
    <div class="container mx-auto px-4 py-8">
        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Courses -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-500">
                        <i class="fas fa-book-open text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500 uppercase font-semibold">Total Courses</p>
                        <p class="text-2xl font-bold"><?= $stats['total_courses'] ?></p>
                    </div>
                </div>
            </div>

            <!-- Total Enrollments -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-500">
                        <i class="fas fa-users text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500 uppercase font-semibold">Total Enrollments</p>
                        <p class="text-2xl font-bold"><?= $stats['total_enrollments'] ?></p>
                    </div>
                </div>
            </div>

            <!-- Total Lessons -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-500">
                        <i class="fas fa-list-alt text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500 uppercase font-semibold">Total Lessons</p>
                        <p class="text-2xl font-bold"><?= $stats['total_lessons'] ?></p>
                    </div>
                </div>
            </div>

            <!-- Recent Enrollments -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100 text-purple-500">
                        <i class="fas fa-user-plus text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500 uppercase font-semibold">Recent Enrollments</p>
                        <p class="text-2xl font-bold"><?= $stats['recent_enrollments'] ?> <span class="text-sm font-normal text-gray-500">(30 days)</span></p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-xl font-bold mb-4">Quick Actions</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="<?= base_url('instructor/create_course') ?>" class="bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg p-4 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    Create New Course
                </a>
                <a href="<?= base_url('instructor/courses') ?>" class="bg-green-600 hover:bg-green-700 text-white rounded-lg p-4 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Manage My Courses
                </a>
                <a href="<?= base_url('home') ?>" class="bg-gray-600 hover:bg-gray-700 text-white rounded-lg p-4 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    View Frontend
                </a>
            </div>
        </div>
        
        <!-- My Courses -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold">My Courses</h2>
                <a href="<?= base_url('instructor/create_course') ?>" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm py-2 px-4 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Create Course
                </a>
            </div>
            
            <?php if (empty($courses)): ?>
                <div class="text-center py-8">
                    <p class="text-gray-600">You haven't created any courses yet.</p>
                    <a href="<?= base_url('instructor/create_course') ?>" class="inline-block mt-4 bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded">
                        Create Your First Course
                    </a>
                </div>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Enrollments</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lessons</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($courses as $course): ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <?php if ($course->thumbnail): ?>
                                                    <img class="h-10 w-10 rounded-full object-cover" src="<?= base_url('uploads/thumbnails/' . $course->thumbnail) ?>" alt="<?= $course->title ?>">
                                                <?php else: ?>
                                                    <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                                        <span class="text-indigo-500 font-bold"><?= substr($course->title, 0, 1) ?></span>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900"><?= $course->title ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900"><?= $course->category_name ?? 'Uncategorized' ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $course->status == 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' ?>">
                                            <?= ucfirst($course->status) ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?php 
                                        // Count enrollments
                                        $this->db->where('course_id', $course->id);
                                        $enrollment_count = $this->db->count_all_results('enrollments');
                                        ?>
                                        <span class="font-medium"><?= $enrollment_count ?></span>
                                        <a href="<?= base_url('instructor/course_analytics/' . $course->id) ?>" class="ml-2 text-xs text-blue-600 hover:text-blue-800">
                                            View Details
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <a href="<?= base_url('instructor/lessons/' . $course->id) ?>" class="text-indigo-600 hover:text-indigo-900">
                                            Manage Lessons
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="<?= base_url('home/course/' . $course->id) ?>" class="text-blue-600 hover:text-blue-900 mr-3">View</a>
                                        <a href="<?= base_url('instructor/course_analytics/' . $course->id) ?>" class="text-green-600 hover:text-green-900 mr-3">Analytics</a>
                                        <a href="<?= base_url('instructor/edit_course/' . $course->id) ?>" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                        <a href="<?= base_url('instructor/delete_course/' . $course->id) ?>" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this course?')">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div> 
