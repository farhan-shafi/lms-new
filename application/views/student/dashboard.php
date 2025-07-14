<!-- Welcome Section -->
<div class="bg-gradient-to-r from-indigo-700 to-blue-600 shadow-lg">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl md:text-3xl font-bold text-white">Student Dashboard</h1>
        <p class="text-indigo-100 mt-1">Welcome, <?= $this->session->userdata('full_name') ?>!</p>
    </div>
</div>

<!-- Dashboard Content -->
<div class="container mx-auto px-4 py-8">
    <!-- Stats Overview -->
    <div class="grid grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 mb-8">
        <!-- Enrolled Courses -->
        <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow p-5 border-l-4 border-blue-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-book-open text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-xs uppercase font-semibold text-gray-500">Enrolled Courses</p>
                    <p class="text-2xl font-bold text-gray-800"><?= count($courses) ?></p>
                </div>
            </div>
        </div>

        <!-- Completed Lessons -->
        <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow p-5 border-l-4 border-green-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-check-circle text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-xs uppercase font-semibold text-gray-500">Completed Lessons</p>
                    <p class="text-2xl font-bold text-gray-800">
                        <?php
                        $completed_count = 0;
                        foreach ($courses as $course) {
                            if (isset($course->completed_lessons)) {
                                $completed_count += $course->completed_lessons;
                            }
                        }
                        echo $completed_count;
                        ?>
                    </p>
                </div>
            </div>
        </div>

        <!-- Average Progress -->
        <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow p-5 border-l-4 border-yellow-500">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <i class="fas fa-chart-line text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-xs uppercase font-semibold text-gray-500">Avg Progress</p>
                    <p class="text-2xl font-bold text-gray-800">
                        <?php
                        if (count($courses) > 0) {
                            $total_progress = 0;
                            foreach ($courses as $course) {
                                $total_progress += isset($course->progress_percentage) ? $course->progress_percentage : 0;
                            }
                            echo round($total_progress / count($courses)) . '%';
                        } else {
                            echo '0%';
                        }
                        ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h3>
            <div class="space-y-3">
                <a href="<?= base_url('home/courses') ?>" class="flex items-center justify-between p-3 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition-all transform hover:scale-102 shadow-sm hover:shadow">
                    <div class="flex items-center">
                        <svg class="h-5 w-5 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <span class="text-blue-900">Browse All Courses</span>
                    </div>
                    <svg class="h-4 w-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
                <a href="<?= base_url('student/my_courses') ?>" class="flex items-center justify-between p-3 bg-green-50 text-green-700 rounded-lg hover:bg-green-100 transition-all transform hover:scale-102 shadow-sm hover:shadow">
                    <div class="flex items-center">
                        <svg class="h-5 w-5 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        <span class="text-green-900">My Enrolled Courses</span>
                    </div>
                    <svg class="h-4 w-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
                <a href="<?= base_url('student/profile') ?>" class="flex items-center justify-between p-3 bg-purple-50 text-purple-700 rounded-lg hover:bg-purple-100 transition-all transform hover:scale-102 shadow-sm hover:shadow">
                    <div class="flex items-center">
                        <svg class="h-5 w-5 text-purple-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span class="text-purple-900">Update Profile</span>
                    </div>
                    <svg class="h-4 w-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Learning Progress</h3>
            <?php if (!empty($courses)): ?>
                <div class="space-y-4">
                    <?php foreach (array_slice($courses, 0, 3) as $course): ?>
                        <div>
                            <div class="flex justify-between text-sm">
                                <span class="font-medium text-gray-700"><?= htmlspecialchars($course->title) ?></span>
                                <span class="text-gray-500"><?= isset($course->progress_percentage) ? $course->progress_percentage : 0 ?>%</span>
                            </div>
                            <div class="mt-1 w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full" style="width: <?= isset($course->progress_percentage) ? $course->progress_percentage : 0 ?>%"></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <?php if (count($courses) > 3): ?>
                        <a href="<?= base_url('student/my_courses') ?>" class="inline-block mt-2 px-4 py-2 bg-indigo-100 text-indigo-700 text-sm rounded-lg shadow-sm hover:shadow hover:bg-indigo-200 transition-all">View all courses</a>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <p class="text-gray-500 text-sm mb-4">No enrolled courses yet. Start by browsing our course catalog!</p>
                <a href="<?= base_url('home/courses') ?>" class="inline-block px-4 py-2 bg-indigo-100 text-indigo-700 text-sm rounded-lg shadow-sm hover:shadow hover:bg-indigo-200 transition-all">Browse Courses</a>
            <?php endif; ?>
        </div>
    </div>

    <!-- My Courses -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-gray-800 flex items-center">
                <i class="fas fa-graduation-cap text-indigo-600 mr-2"></i>Continue Learning
            </h2>
            <a href="<?= base_url('student/my_courses') ?>" class="bg-indigo-100 text-indigo-700 text-sm py-2.5 px-4 rounded-lg shadow-sm hover:shadow hover:bg-indigo-200 transition-all flex items-center">
                View All
            </a>
        </div>
        
        <?php if (empty($courses)): ?>
            <div class="text-center py-8">
                <p class="text-gray-600 mb-4">You haven't enrolled in any courses yet.</p>
                <a href="<?= base_url('home/courses') ?>" class="inline-block px-5 py-2.5 bg-indigo-100 text-indigo-700 font-medium rounded-lg shadow-sm hover:shadow hover:bg-indigo-200 transition-all">
                    Browse Available Courses
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
                            </div>
                        </div>
                            
                        <!-- Course Stats -->
                        <div class="p-4 bg-white">
                            <!-- Progress Bar -->
                            <div class="mb-4">
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="text-gray-600">Progress</span>
                                    <span class="text-gray-600"><?= isset($course->progress_percentage) ? $course->progress_percentage : 0 ?>%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-blue-600 h-2 rounded-full" style="width: <?= isset($course->progress_percentage) ? $course->progress_percentage : 0 ?>%"></div>
                                </div>
                            </div>
                            
                            <!-- Course Rating -->
                            <?php if (isset($course->average_rating)): ?>
                            <div class="flex items-center mb-4">
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
                            </div>
                            <?php endif; ?>
                            
                            <!-- Course Actions -->
                            <div class="border-t border-gray-200 pt-4">
                                <div class="grid grid-cols-2 gap-2">
                                    <a href="<?= base_url('student/course/' . $course->id) ?>" class="inline-flex items-center justify-center px-3 py-2 bg-blue-50 text-blue-700 text-xs font-medium rounded-lg border border-blue-200 hover:bg-blue-100 transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Continue Learning
                                    </a>
                                    <a href="<?= base_url('student/quizzes/' . $course->id) ?>" class="inline-flex items-center justify-center px-3 py-2 bg-purple-50 text-purple-700 text-xs font-medium rounded-lg border border-purple-200 hover:bg-purple-100 transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Quizzes
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
