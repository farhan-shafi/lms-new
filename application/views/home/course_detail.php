<!-- Course Header -->
<div class="bg-indigo-700 text-white py-12">
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row items-center">
            <div class="md:w-2/3 mb-6 md:mb-0 md:pr-8">
                <h1 class="text-3xl font-bold mb-2"><?= $course->title ?></h1>
                <div class="flex items-center text-sm mb-4">
                    <span class="bg-indigo-600 px-2 py-1 rounded mr-2"><?= $course->category_name ?? 'Uncategorized' ?></span>
                    <span>Instructor: <?= $course->instructor_name ?></span>
                </div>
                <p class="text-indigo-100"><?= $course->description ?></p>
            </div>
            <div class="md:w-1/3">
                <?php if ($course->thumbnail): ?>
                    <img src="<?= base_url('uploads/thumbnails/' . $course->thumbnail) ?>" alt="<?= $course->title ?>" class="rounded-lg shadow-lg w-full">
                <?php else: ?>
                    <div class="w-full h-48 bg-indigo-600 rounded-lg shadow-lg flex items-center justify-center">
                        <span class="text-white text-lg font-semibold"><?= $course->title ?></span>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Course Content -->
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row">
        <!-- Main Content -->
        <div class="md:w-2/3 md:pr-8">
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-2xl font-bold mb-4">About This Course</h2>
                <div class="prose max-w-none">
                    <?= $course->description ?>
                </div>
            </div>
            
            <?php if ($is_enrolled || $this->session->userdata('role') == 'admin' || $this->session->userdata('user_id') == $course->instructor_id): ?>
                <!-- Course Progress (for enrolled students) -->
                <?php if ($is_enrolled && isset($progress)): ?>
                    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                        <h2 class="text-2xl font-bold mb-4">Your Progress</h2>
                        <div class="w-full bg-gray-200 rounded-full h-4 mb-2">
                            <div class="bg-indigo-600 h-4 rounded-full" style="width: <?= $progress ?>%"></div>
                        </div>
                        <p class="text-sm text-gray-600"><?= round($progress) ?>% complete</p>
                    </div>
                <?php endif; ?>
                
                <!-- Lessons List -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-2xl font-bold mb-4">Course Lessons</h2>
                    
                    <?php if (empty($lessons)): ?>
                        <p class="text-gray-600">No lessons available for this course yet.</p>
                    <?php else: ?>
                        <div class="space-y-4">
                            <?php foreach ($lessons as $index => $lesson): ?>
                                <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <span class="text-gray-500 text-sm">Lesson <?= $index + 1 ?></span>
                                            <h3 class="font-medium"><?= $lesson->title ?></h3>
                                        </div>
                                        <a href="<?= base_url('home/lesson/' . $course->id . '/' . $lesson->id) ?>" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm py-1 px-3 rounded">
                                            View Lesson
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Sidebar -->
        <div class="md:w-1/3 mt-6 md:mt-0">
            <div class="bg-white rounded-lg shadow-md p-6 sticky top-6">
                <h2 class="text-xl font-bold mb-4">Course Information</h2>
                
                <div class="mb-6">
                    <div class="flex items-center mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        <span class="text-gray-700"><?= count($lessons) ?> Lessons</span>
                    </div>
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                        </svg>
                        <span class="text-gray-700">Free</span>
                    </div>
                </div>
                
                <?php if ($this->session->userdata('logged_in')): ?>
                    <?php if ($is_enrolled): ?>
                        <div class="bg-green-100 text-green-800 p-3 rounded-md mb-4">
                            You are enrolled in this course.
                        </div>
                        <a href="<?= base_url('home/lesson/' . $course->id . '/' . $lessons[0]->id) ?>" class="block text-center bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded w-full">
                            Continue Learning
                        </a>
                    <?php elseif ($this->session->userdata('role') == 'student'): ?>
                        <a href="<?= base_url('student/enroll/' . $course->id) ?>" class="block text-center bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded w-full">
                            Enroll Now
                        </a>
                    <?php endif; ?>
                    
                    <?php if ($this->session->userdata('role') == 'admin' || $this->session->userdata('user_id') == $course->instructor_id): ?>
                        <div class="mt-4">
                            <a href="<?= base_url(($this->session->userdata('role') == 'admin' ? 'admin' : 'instructor') . '/edit_course/' . $course->id) ?>" class="block text-center bg-yellow-500 hover:bg-yellow-600 text-white font-medium py-2 px-4 rounded w-full mb-2">
                                Edit Course
                            </a>
                            <a href="<?= base_url(($this->session->userdata('role') == 'admin' ? 'admin' : 'instructor') . '/lessons/' . $course->id) ?>" class="block text-center bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded w-full">
                                Manage Lessons
                            </a>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="bg-yellow-100 text-yellow-800 p-3 rounded-md mb-4">
                        Please login to enroll in this course.
                    </div>
                    <a href="<?= base_url('auth/login') ?>" class="block text-center bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded w-full">
                        Login to Enroll
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div> 
