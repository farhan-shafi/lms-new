<!-- Course Header -->
<div class="bg-white shadow rounded-lg overflow-hidden mb-6">
    <?php if (!empty($course->thumbnail)): ?>
        <img src="<?= base_url('uploads/thumbnails/' . $course->thumbnail) ?>" alt="<?= htmlspecialchars($course->title) ?>" class="w-full h-64 object-cover">
    <?php else: ?>
        <div class="w-full h-64 bg-gradient-to-br from-blue-500 via-purple-500 to-indigo-600 flex items-center justify-center">
            <svg class="h-24 w-24 text-white opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
        </div>
    <?php endif; ?>
    
    <div class="p-8">
        <div class="flex justify-between items-start mb-6">
            <div class="flex-1">
                <h1 class="text-4xl font-bold text-gray-900 mb-4"><?= htmlspecialchars($course->title) ?></h1>
                <p class="text-lg text-gray-600 mb-4"><?= htmlspecialchars($course->description) ?></p>
                
                <!-- Course Meta -->
                <div class="flex items-center space-x-6 text-sm text-gray-500 mb-6">
                    <div class="flex items-center">
                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Instructor: <?= htmlspecialchars($course->instructor_name ?? 'Unknown') ?>
                    </div>
                    <div class="flex items-center">
                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2h5a1 1 0 110 2h-1v14a2 2 0 01-2 2H5a2 2 0 01-2-2V6H2a1 1 0 110-2h5z"></path>
                        </svg>
                        <?= count($lessons) ?> Lessons
                    </div>
                    <div class="flex items-center">
                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Created: <?= date('M j, Y', strtotime($course->created_at)) ?>
                                </div>
        </div>
    </div>
</div>

<!-- JavaScript for lesson completion from course page -->
<script>
function toggleLessonCompletionFromCourse(lessonId) {
    const btn = document.getElementById('completion-btn-' + lessonId);
    const originalClass = btn.className;
    const originalTitle = btn.title;
    
    // Disable button and show loading state
    btn.disabled = true;
    btn.className = 'bg-gray-600 text-white px-3 py-2 rounded-md text-sm transition-colors cursor-not-allowed';
    btn.innerHTML = '<svg class="h-4 w-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
    
    // Make AJAX request
    fetch('<?= base_url("student/toggle_lesson_completion/") ?>' + lessonId, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update button based on new completion status
            if (data.completed) {
                btn.className = 'bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-md text-sm transition-colors';
                btn.title = 'Mark as incomplete';
                
                // Update completion badge in the lesson meta
                const lessonDiv = btn.closest('.border.border-gray-200');
                const metaDiv = lessonDiv.querySelector('.flex.items-center.mt-3');
                let badge = metaDiv.querySelector('.bg-green-100');
                if (!badge) {
                    badge = document.createElement('span');
                    badge.className = 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800';
                    badge.innerHTML = '<svg class="h-3 w-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Completed';
                    metaDiv.appendChild(badge);
                }
            } else {
                btn.className = 'bg-gray-400 hover:bg-gray-500 text-white px-3 py-2 rounded-md text-sm transition-colors';
                btn.title = 'Mark as complete';
                
                // Remove completion badge
                const lessonDiv = btn.closest('.border.border-gray-200');
                const badge = lessonDiv.querySelector('.bg-green-100.text-green-800');
                if (badge) {
                    badge.remove();
                }
            }
            
            btn.innerHTML = '<svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>';
            
            // Update progress bar and percentage
            if (data.progress) {
                const progressBar = document.querySelector('.bg-green-600.h-3');
                const progressText = document.querySelector('.text-green-700.font-medium');
                const completedText = progressText ? progressText.parentElement.querySelector('span') : null;
                
                if (progressBar) {
                    progressBar.style.width = data.progress.percentage + '%';
                }
                if (progressText) {
                    progressText.textContent = data.progress.percentage + '% Complete';
                }
                if (completedText) {
                    completedText.textContent = data.progress.completed + ' of <?= count($lessons) ?> lessons completed';
                }
            }
            
            // Show success notification
            showNotificationCourse(data.message, 'success');
        } else {
            // Show error message
            showNotificationCourse(data.message, 'error');
            
            // Restore button
            btn.className = originalClass;
            btn.title = originalTitle;
            btn.innerHTML = '<svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotificationCourse('An error occurred. Please try again.', 'error');
        
        // Restore button
        btn.className = originalClass;
        btn.title = originalTitle;
        btn.innerHTML = '<svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>';
    })
    .finally(() => {
        btn.disabled = false;
    });
}

function showNotificationCourse(message, type) {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 p-4 rounded-md shadow-lg z-50 ${
        type === 'success' ? 'bg-green-100 text-green-800 border border-green-200' : 'bg-red-100 text-red-800 border border-red-200'
    }`;
    notification.innerHTML = `
        <div class="flex items-center">
            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                ${type === 'success' 
                    ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>'
                    : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>'
                }
            </svg>
            <span>${message}</span>
        </div>
    `;
    
    // Add to page
    document.body.appendChild(notification);
    
    // Remove after 3 seconds
    setTimeout(() => {
        notification.remove();
    }, 3000);
}
</script>

        <!-- Enrollment Status & Progress -->
        <?php if ($is_enrolled): ?>
            <div class="bg-green-50 border border-green-200 rounded-lg p-6 mb-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center">
                        <svg class="h-6 w-6 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="text-lg font-medium text-green-900">You're enrolled in this course!</h3>
                    </div>
                    <span class="text-green-700 font-medium">
                        <?= isset($progress['percentage']) ? $progress['percentage'] : 0 ?>% Complete
                    </span>
                </div>
                
                <!-- Progress Bar -->
                <div class="w-full bg-green-200 rounded-full h-3 mb-4">
                    <div class="bg-green-600 h-3 rounded-full transition-all duration-300" 
                         style="width: <?= isset($progress['percentage']) ? $progress['percentage'] : 0 ?>%"></div>
                </div>
                
                <div class="flex justify-between text-sm text-green-700">
                    <span><?= isset($progress['completed']) ? $progress['completed'] : 0 ?> of <?= count($lessons) ?> lessons completed</span>
                    <?php if (isset($progress['next_lesson']) && $progress['next_lesson']): ?>
                        <a href="<?= base_url('student/lesson/' . $course->id . '/' . $progress['next_lesson']) ?>" 
                           class="text-green-800 hover:text-green-900 font-medium">
                            Continue Learning →
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        <?php else: ?>
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-medium text-blue-900">Ready to start learning?</h3>
                        <p class="text-blue-700 mt-1">Enroll in this course to access all lessons and track your progress.</p>
                    </div>
                    <a href="<?= base_url('home/enroll/' . $course->id) ?>" 
                       class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors font-medium">
                        Enroll Now
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Course Content -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Lessons List -->
    <div class="lg:col-span-2">
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Course Content</h2>
            
            <?php if (empty($lessons)): ?>
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2h5a1 1 0 110 2h-1v14a2 2 0 01-2 2H5a2 2 0 01-2-2V6H2a1 1 0 110-2h5z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No lessons available</h3>
                    <p class="mt-1 text-sm text-gray-500">The instructor hasn't added any lessons yet.</p>
                </div>
            <?php else: ?>
                <div class="space-y-4">
                    <?php foreach ($lessons as $index => $lesson): ?>
                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center">
                                        <!-- Lesson Number -->
                                        <span class="bg-gray-100 text-gray-800 text-sm font-medium px-3 py-1 rounded-full mr-4">
                                            <?= $lesson->sort_order ?: ($index + 1) ?>
                                        </span>
                                        
                                        <!-- Lesson Title -->
                                        <div>
                                            <h3 class="text-lg font-medium text-gray-900"><?= htmlspecialchars($lesson->title) ?></h3>
                                            <?php if (!empty($lesson->content)): ?>
                                                <p class="text-gray-600 text-sm mt-1"><?= character_limiter(strip_tags($lesson->content), 100) ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    
                                    <!-- Lesson Meta -->
                                    <div class="flex items-center mt-3 space-x-4 text-sm text-gray-500">
                                        <?php if (!empty($lesson->video_url)): ?>
                                            <span class="flex items-center">
                                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                                </svg>
                                                Video
                                            </span>
                                        <?php endif; ?>
                                        <span>Updated: <?= date('M j, Y', strtotime($lesson->updated_at)) ?></span>
                                        
                                        <!-- Completion Status -->
                                        <?php if ($is_enrolled && isset($progress['completed_lessons']) && in_array($lesson->id, $progress['completed_lessons'])): ?>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <svg class="h-3 w-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                Completed
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                
                                <!-- Action Button -->
                                <div class="ml-4 flex space-x-2">
                                    <?php if ($is_enrolled): ?>
                                        <a href="<?= base_url('student/lesson/' . $course->id . '/' . $lesson->id) ?>" 
                                           class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors text-sm">
                                            <?php if (isset($progress['completed_lessons']) && in_array($lesson->id, $progress['completed_lessons'])): ?>
                                                Review
                                            <?php else: ?>
                                                Start
                                            <?php endif; ?>
                                        </a>
                                        
                                        <!-- Quick completion toggle -->
                                        <button onclick="toggleLessonCompletionFromCourse(<?= $lesson->id ?>)" 
                                                id="completion-btn-<?= $lesson->id ?>"
                                                class="<?= (isset($progress['completed_lessons']) && in_array($lesson->id, $progress['completed_lessons'])) ? 'bg-green-600 hover:bg-green-700' : 'bg-gray-400 hover:bg-gray-500' ?> text-white px-3 py-2 rounded-md text-sm transition-colors"
                                                title="<?= (isset($progress['completed_lessons']) && in_array($lesson->id, $progress['completed_lessons'])) ? 'Mark as incomplete' : 'Mark as complete' ?>">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </button>
                                    <?php else: ?>
                                        <button class="bg-gray-300 text-gray-500 px-4 py-2 rounded-md text-sm cursor-not-allowed" disabled>
                                            Locked
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Course Stats -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Course Overview</h3>
            <div class="space-y-4">
                <div class="flex justify-between">
                    <span class="text-gray-600">Total Lessons</span>
                    <span class="font-medium"><?= count($lessons) ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Category</span>
                    <span class="font-medium"><?= htmlspecialchars($course->category_name ?? 'Uncategorized') ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Status</span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        <?= ucfirst($course->status) ?>
                    </span>
                </div>
                <?php if ($is_enrolled): ?>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Your Progress</span>
                        <span class="font-medium text-blue-600"><?= isset($progress['percentage']) ? $progress['percentage'] : 0 ?>%</span>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h3>
            <div class="space-y-3">
                <a href="<?= base_url('home/courses') ?>" class="w-full bg-gray-100 text-gray-700 text-center py-2 px-4 rounded-md hover:bg-gray-200 transition-colors">
                    Browse More Courses
                </a>
                
                <?php if ($is_enrolled): ?>
                    <a href="<?= base_url('student/my_courses') ?>" class="w-full bg-blue-100 text-blue-700 text-center py-2 px-4 rounded-md hover:bg-blue-200 transition-colors">
                        My Courses
                    </a>
                    <a href="<?= base_url('student/dashboard') ?>" class="w-full bg-green-100 text-green-700 text-center py-2 px-4 rounded-md hover:bg-green-200 transition-colors">
                        Dashboard
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Instructor Info -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">About the Instructor</h3>
            <div class="flex items-center">
                <div class="w-12 h-12 bg-gray-300 rounded-full flex items-center justify-center">
                    <svg class="h-6 w-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="font-medium text-gray-900"><?= htmlspecialchars($course->instructor_name ?? 'Unknown Instructor') ?></p>
                    <p class="text-sm text-gray-500">Course Instructor</p>
                </div>
            </div>
        </div>
    </div>
</div> 
