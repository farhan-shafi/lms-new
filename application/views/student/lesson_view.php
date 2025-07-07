<!-- Breadcrumb Navigation -->
<div class="bg-white shadow-sm border-b border-gray-200 px-6 py-4 mb-6">
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-2">
            <li>
                <a href="<?= base_url('student/dashboard') ?>" class="text-gray-500 hover:text-gray-700">Dashboard</a>
            </li>
            <li>
                <svg class="h-4 w-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
            </li>
            <li>
                <a href="<?= base_url('student/course/' . $course->id) ?>" class="text-gray-500 hover:text-gray-700"><?= htmlspecialchars($course->title) ?></a>
            </li>
            <li>
                <svg class="h-4 w-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
            </li>
            <li>
                <span class="text-gray-900 font-medium"><?= htmlspecialchars($lesson->title) ?></span>
            </li>
        </ol>
    </nav>
</div>

<!-- Main Content -->
<div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
    <!-- Lesson Content -->
    <div class="lg:col-span-3">
        <!-- Lesson Header -->
        <div class="bg-white shadow rounded-lg p-6 mb-6">
            <div class="flex justify-between items-start mb-4">
                <div class="flex-1">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2"><?= htmlspecialchars($lesson->title) ?></h1>
                    <div class="flex items-center space-x-4 text-sm text-gray-500">
                        <span>Course: <?= htmlspecialchars($course->title) ?></span>
                        <span>•</span>
                        <span>Updated: <?= date('M j, Y', strtotime($lesson->updated_at)) ?></span>
                        <?php if ($is_completed): ?>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <svg class="h-3 w-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Completed
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Lesson Actions -->
                <div class="flex space-x-3">
                    <a href="<?= base_url('student/course/' . $course->id) ?>" 
                       class="bg-gray-100 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-200 transition-colors">
                        Back to Course
                    </a>
                                        <button onclick="toggleLessonCompletion()" 
                            id="completion-btn"
                            class="<?= $is_completed ? 'bg-yellow-600 hover:bg-yellow-700' : 'bg-green-600 hover:bg-green-700' ?> text-white px-4 py-2 rounded-md transition-colors">
                        <?= $is_completed ? 'Mark as Incomplete' : 'Mark as Complete' ?>
                    </button>
                </div>
            </div>
            
            <!-- Progress Bar for Course -->
            <div class="mb-4">
                <div class="flex justify-between text-sm mb-1">
                    <span class="text-gray-600">Course Progress</span>
                    <span class="text-gray-600"><?= isset($progress['percentage']) ? $progress['percentage'] : 0 ?>%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-blue-600 h-2 rounded-full" style="width: <?= isset($progress['percentage']) ? $progress['percentage'] : 0 ?>%"></div>
                </div>
            </div>
        </div>

        <!-- Video Content -->
        <?php if (!empty($lesson->video_url)): ?>
            <div class="bg-white shadow rounded-lg p-6 mb-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Video Lesson</h2>
                <div class="aspect-w-16 aspect-h-9 bg-gray-100 rounded-lg overflow-hidden">
                    <?php
                    // Handle different video URL formats
                    $video_embed_url = '';
                    if (strpos($lesson->video_url, 'youtube.com/watch?v=') !== false) {
                        $video_id = explode('v=', $lesson->video_url)[1];
                        $video_embed_url = "https://www.youtube.com/embed/" . $video_id;
                    } elseif (strpos($lesson->video_url, 'youtu.be/') !== false) {
                        $video_id = explode('youtu.be/', $lesson->video_url)[1];
                        $video_embed_url = "https://www.youtube.com/embed/" . $video_id;
                    } elseif (strpos($lesson->video_url, 'vimeo.com/') !== false) {
                        $video_id = explode('vimeo.com/', $lesson->video_url)[1];
                        $video_embed_url = "https://player.vimeo.com/video/" . $video_id;
                    } else {
                        $video_embed_url = $lesson->video_url;
                    }
                    ?>
                    
                    <?php if ($video_embed_url): ?>
                        <iframe 
                            src="<?= $video_embed_url ?>" 
                            frameborder="0" 
                            allowfullscreen
                            class="w-full h-96">
                        </iframe>
                    <?php else: ?>
                        <div class="flex items-center justify-center h-96 bg-gray-100">
                            <div class="text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                </svg>
                                <p class="mt-2 text-sm text-gray-500">Video not available</p>
                                <a href="<?= htmlspecialchars($lesson->video_url) ?>" target="_blank" class="text-blue-600 hover:text-blue-800">
                                    Open video link
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Lesson Content -->
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Lesson Content</h2>
            
            <?php if (!empty($lesson->content)): ?>
                <div class="prose prose-lg max-w-none">
                    <?= $lesson->content ?>
                </div>
            <?php else: ?>
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No content available</h3>
                    <p class="mt-1 text-sm text-gray-500">The instructor hasn't added content for this lesson yet.</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Lesson Navigation -->
        <div class="bg-white shadow rounded-lg p-6 mt-6">
            <div class="flex justify-between items-center">
                <?php
                // Find previous and next lessons
                $current_index = -1;
                foreach ($lessons as $index => $l) {
                    if ($l->id == $lesson->id) {
                        $current_index = $index;
                        break;
                    }
                }
                $prev_lesson = ($current_index > 0) ? $lessons[$current_index - 1] : null;
                $next_lesson = ($current_index < count($lessons) - 1) ? $lessons[$current_index + 1] : null;
                ?>
                
                <div class="flex-1">
                    <?php if ($prev_lesson): ?>
                        <a href="<?= base_url('student/lesson/' . $course->id . '/' . $prev_lesson->id) ?>" 
                           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                            Previous: <?= htmlspecialchars($prev_lesson->title) ?>
                        </a>
                    <?php endif; ?>
                </div>
                
                <div class="text-center px-4">
                    <span class="text-sm text-gray-500">
                        Lesson <?= $current_index + 1 ?> of <?= count($lessons) ?>
                    </span>
                </div>
                
                <div class="flex-1 text-right">
                    <?php if ($next_lesson): ?>
                        <a href="<?= base_url('student/lesson/' . $course->id . '/' . $next_lesson->id) ?>" 
                           class="inline-flex items-center px-4 py-2 border border-transparent rounded-md text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                            Next: <?= htmlspecialchars($next_lesson->title) ?>
                            <svg class="h-4 w-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    <?php else: ?>
                        <div class="inline-flex items-center px-4 py-2 border border-green-300 rounded-md text-sm font-medium text-green-700 bg-green-50">
                            <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Course Complete!
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Course Lessons -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Course Lessons</h3>
            <div class="space-y-2 max-h-96 overflow-y-auto">
                <?php foreach ($lessons as $index => $l): ?>
                    <div class="<?= ($l->id == $lesson->id) ? 'bg-blue-50 border-blue-200' : 'border-gray-200' ?> border rounded-lg p-3">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <div class="flex items-center">
                                    <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2 py-1 rounded-full mr-2">
                                        <?= $l->sort_order ?: ($index + 1) ?>
                                    </span>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-900 truncate"><?= htmlspecialchars($l->title) ?></h4>
                                        <?php if (!empty($l->video_url)): ?>
                                            <span class="text-xs text-gray-500">Video</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="ml-2 flex items-center">
                                <?php if (isset($progress['completed_lessons']) && in_array($l->id, $progress['completed_lessons'])): ?>
                                    <svg class="h-4 w-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                <?php endif; ?>
                                
                                <?php if ($l->id != $lesson->id): ?>
                                    <a href="<?= base_url('student/lesson/' . $course->id . '/' . $l->id) ?>" 
                                       class="ml-2 text-blue-600 hover:text-blue-800 text-xs">
                                        View
                                    </a>
                                <?php else: ?>
                                    <span class="ml-2 text-blue-600 text-xs font-medium">Current</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Lesson Info -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Lesson Info</h3>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-600">Lesson Number</span>
                    <span class="font-medium"><?= $current_index + 1 ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Total Lessons</span>
                    <span class="font-medium"><?= count($lessons) ?></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Course Progress</span>
                    <span class="font-medium"><?= isset($progress['percentage']) ? $progress['percentage'] : 0 ?>%</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Status</span>
                    <span class="font-medium <?= $is_completed ? 'text-green-600' : 'text-yellow-600' ?>">
                        <?= $is_completed ? 'Completed' : 'In Progress' ?>
                    </span>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h3>
            <div class="space-y-3">
                <a href="<?= base_url('student/course/' . $course->id) ?>" 
                   class="w-full bg-blue-100 text-blue-700 text-center py-2 px-4 rounded-md hover:bg-blue-200 transition-colors">
                    Back to Course
                </a>
                <a href="<?= base_url('student/my_courses') ?>" 
                   class="w-full bg-gray-100 text-gray-700 text-center py-2 px-4 rounded-md hover:bg-gray-200 transition-colors">
                    My Courses
                </a>
                <a href="<?= base_url('student/dashboard') ?>" 
                   class="w-full bg-green-100 text-green-700 text-center py-2 px-4 rounded-md hover:bg-green-200 transition-colors">
                    Dashboard
                </a>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for lesson completion functionality -->
<script>
function toggleLessonCompletion() {
    const btn = document.getElementById('completion-btn');
    const originalText = btn.textContent;
    
    // Disable button and show loading state
    btn.disabled = true;
    btn.textContent = 'Loading...';
    btn.className = 'bg-gray-600 text-white px-4 py-2 rounded-md transition-colors cursor-not-allowed';
    
    // Make AJAX request
    fetch('<?= base_url("student/toggle_lesson_completion/" . $lesson->id) ?>', {
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
                btn.textContent = 'Mark as Incomplete';
                btn.className = 'bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-md transition-colors';
                
                // Add completed badge to lesson header if not exists
                const lessonHeader = document.querySelector('.text-3xl.font-bold.text-gray-900').parentElement;
                if (!lessonHeader.querySelector('.bg-green-100')) {
                    const badge = document.createElement('span');
                    badge.className = 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800';
                    badge.innerHTML = '<svg class="h-3 w-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Completed';
                    lessonHeader.appendChild(badge);
                }
            } else {
                btn.textContent = 'Mark as Complete';
                btn.className = 'bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md transition-colors';
                
                // Remove completed badge if exists
                const badge = document.querySelector('.bg-green-100.text-green-800');
                if (badge) {
                    badge.remove();
                }
            }
            
            // Update progress bar
            if (data.progress) {
                const progressBar = document.querySelector('.bg-blue-600.h-2');
                const progressText = document.querySelector('.text-gray-600');
                if (progressBar && progressText) {
                    progressBar.style.width = data.progress.percentage + '%';
                    progressText.textContent = data.progress.percentage + '%';
                }
            }
            
            // Show success message
            showNotification(data.message, 'success');
        } else {
            // Show error message
            showNotification(data.message, 'error');
            
            // Restore button
            btn.textContent = originalText;
            btn.className = '<?= $is_completed ? "bg-yellow-600 hover:bg-yellow-700" : "bg-green-600 hover:bg-green-700" ?> text-white px-4 py-2 rounded-md transition-colors';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('An error occurred. Please try again.', 'error');
        
        // Restore button
        btn.textContent = originalText;
        btn.className = '<?= $is_completed ? "bg-yellow-600 hover:bg-yellow-700" : "bg-green-600 hover:bg-green-700" ?> text-white px-4 py-2 rounded-md transition-colors';
    })
    .finally(() => {
        btn.disabled = false;
    });
}

function showNotification(message, type) {
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
