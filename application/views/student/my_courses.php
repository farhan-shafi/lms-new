<!-- Page Header -->
<div class="bg-white shadow rounded-lg p-6 mb-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">My Courses</h1>
            <p class="text-gray-600 mt-2">Continue your learning journey with your enrolled courses.</p>
        </div>
        <div class="text-right">
            <p class="text-2xl font-bold text-blue-600"><?= count($courses) ?></p>
            <p class="text-sm text-gray-500">Enrolled Courses</p>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <a href="<?= base_url('home/courses') ?>" class="bg-blue-50 text-blue-700 p-6 rounded-lg shadow-sm hover:shadow hover:bg-blue-100 transition-all transform hover:scale-102">
        <div class="flex items-center">
            <svg class="h-8 w-8 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            <div>
                <h3 class="font-semibold">Explore Courses</h3>
                <p class="text-blue-500 text-sm">Find new courses to enroll</p>
            </div>
        </div>
    </a>

    <a href="<?= base_url('student/profile') ?>" class="bg-purple-50 text-purple-700 p-6 rounded-lg shadow-sm hover:shadow hover:bg-purple-100 transition-all transform hover:scale-102">
        <div class="flex items-center">
            <svg class="h-8 w-8 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
            <div>
                <h3 class="font-semibold">My Profile</h3>
                <p class="text-purple-500 text-sm">Update your information</p>
            </div>
        </div>
    </a>

    <a href="<?= base_url('student/dashboard') ?>" class="bg-green-50 text-green-700 p-6 rounded-lg shadow-sm hover:shadow hover:bg-green-100 transition-all transform hover:scale-102">
        <div class="flex items-center">
            <svg class="h-8 w-8 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
            </svg>
            <div>
                <h3 class="font-semibold">Dashboard</h3>
                <p class="text-green-500 text-sm">View learning overview</p>
            </div>
        </div>
    </a>
</div>

<!-- Courses Grid -->
<div class="bg-white shadow rounded-lg p-6">
    <h2 class="text-2xl font-bold text-gray-900 mb-6">Your Enrolled Courses</h2>

    <?php if (empty($courses)): ?>
        <div class="text-center py-16">
            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
            <h3 class="mt-4 text-lg font-medium text-gray-900">No enrolled courses yet</h3>
            <p class="mt-2 text-gray-500">You haven't enrolled in any courses. Start your learning journey today!</p>
            <div class="mt-8">
                <a href="<?= base_url('home/courses') ?>" class="inline-flex items-center px-6 py-3 shadow-sm text-base font-medium rounded-lg text-blue-700 bg-blue-50 hover:bg-blue-100 hover:shadow transition-all transform hover:scale-102">
                    <svg class="-ml-1 mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Browse All Courses
                </a>
            </div>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($courses as $course): ?>
                <div class="bg-white border border-gray-200 rounded-xl overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <!-- Course Image -->
                    <?php if (!empty($course->thumbnail)): ?>
                        <img src="<?= base_url('uploads/thumbnails/' . $course->thumbnail) ?>" 
                             alt="<?= htmlspecialchars($course->title) ?>" 
                             class="w-full h-48 object-cover">
                    <?php else: ?>
                        <div class="w-full h-48 bg-gradient-to-br from-blue-500 via-purple-500 to-indigo-600 flex items-center justify-center">
                            <svg class="h-20 w-20 text-white opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                    <?php endif; ?>
                    
                    <div class="p-6">
                        <!-- Course Title -->
                        <h3 class="text-xl font-bold text-gray-900 mb-3"><?= htmlspecialchars($course->title) ?></h3>
                        
                        <!-- Course Rating -->
                        <?php if (isset($course->average_rating)): ?>
                        <div class="flex items-center mb-3">
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
                            <span class="ml-1 text-sm text-gray-600"><?= number_format($course->average_rating, 1) ?> (<?= $course->rating_count ?? 0 ?> reviews)</span>
                        </div>
                        <?php endif; ?>
                        
                        <!-- Course Description -->
                        <p class="text-gray-600 text-sm mb-4 leading-relaxed"><?= character_limiter($course->description, 120) ?></p>
                        
                        <!-- Course Info -->
                        <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                            <span class="flex items-center">
                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <?= htmlspecialchars($course->instructor_name ?? 'Instructor') ?>
                            </span>
                            <span class="flex items-center">
                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2h5a1 1 0 110 2h-1v14a2 2 0 01-2 2H5a2 2 0 01-2-2V6H2a1 1 0 110-2h5z"></path>
                                </svg>
                                <?= isset($course->total_lessons) ? $course->total_lessons : '0' ?> lessons
                            </span>
                        </div>
                        
                        <!-- Progress Section -->
                        <div class="mb-6">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-medium text-gray-700">Progress</span>
                                <span class="text-sm font-semibold text-blue-600"><?= isset($course->progress_percentage) ? $course->progress_percentage : 0 ?>%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-3 rounded-full transition-all duration-300" 
                                     style="width: <?= isset($course->progress_percentage) ? $course->progress_percentage : 0 ?>%"></div>
                            </div>
                            <?php if (isset($course->completed_lessons) && isset($course->total_lessons)): ?>
                                <p class="text-xs text-gray-500 mt-1">
                                    <?= $course->completed_lessons ?> of <?= $course->total_lessons ?> lessons completed
                                </p>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="space-y-3">
                            <a href="<?= base_url('student/course/' . $course->id) ?>" 
                               class="w-full bg-blue-50 text-blue-700 text-center py-3 px-4 rounded-lg font-medium shadow-sm hover:shadow hover:bg-blue-100 transition-all transform hover:scale-102">
                                <?php if (isset($course->progress_percentage) && $course->progress_percentage > 0): ?>
                                    Continue Learning
                                <?php else: ?>
                                    Start Course
                                <?php endif; ?>
                            </a>
                            
                            <?php if (isset($course->next_lesson_id) && $course->next_lesson_id): ?>
                                <a href="<?= base_url('student/lesson/' . $course->id . '/' . $course->next_lesson_id) ?>" 
                                   class="w-full bg-gray-50 text-gray-700 text-center  ml-2 py-3 px-4 rounded-lg text-sm font-medium shadow-sm hover:shadow hover:bg-gray-100 transition-all transform hover:scale-102">
                                    Resume Next Lesson
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<!-- Learning Tips -->
<div class="mt-8 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-lg p-6">
    <div class="flex">
        <svg class="h-6 w-6 text-blue-600 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
        </svg>
        <div>
            <h3 class="text-lg font-medium text-blue-900 mb-2">Learning Tips</h3>
            <div class="text-blue-800 text-sm space-y-2">
                <p>• <strong>Set a Schedule:</strong> Dedicate specific times for learning to maintain consistency</p>
                <p>• <strong>Take Notes:</strong> Write down key concepts to reinforce your understanding</p>
                <p>• <strong>Practice Regularly:</strong> Apply what you learn through exercises and projects</p>
                <p>• <strong>Ask Questions:</strong> Don't hesitate to reach out for help when needed</p>
                <p>• <strong>Track Progress:</strong> Monitor your advancement to stay motivated</p>
            </div>
        </div>
    </div>
</div> 
