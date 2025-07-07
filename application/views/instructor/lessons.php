<!-- Course Header -->
<div class="bg-white shadow rounded-lg p-6 mb-6">
    <div class="flex justify-between items-start">
        <div>
            <h1 class="text-3xl font-bold text-gray-900"><?= htmlspecialchars($course->title) ?></h1>
            <p class="text-gray-600 mt-2"><?= htmlspecialchars($course->description) ?></p>
            <div class="flex items-center mt-4 space-x-4">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium <?= $course->status == 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' ?>">
                    <?= ucfirst($course->status) ?>
                </span>
                <span class="text-sm text-gray-500">Course ID: <?= $course->id ?></span>
            </div>
        </div>
        <div class="space-x-3">
            <a href="<?= base_url('instructor/edit_course/' . $course->id) ?>" 
               class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700">
                Edit Course
            </a>
            <a href="<?= base_url('instructor/courses') ?>" 
               class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                Back to Courses
            </a>
        </div>
    </div>
</div>

<!-- Lessons Management Section -->
<div class="bg-white shadow rounded-lg p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Course Lessons</h2>
        <a href="<?= base_url('instructor/create_lesson/' . $course->id) ?>" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
            <svg class="inline h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Add New Lesson
        </a>
    </div>

    <?php if (empty($lessons)): ?>
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2h5a1 1 0 110 2h-1v14a2 2 0 01-2 2H5a2 2 0 01-2-2V6H2a1 1 0 110-2h5zM6 6v14h12V6H6zm3-2V2h6v2H9z"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No lessons yet</h3>
            <p class="mt-1 text-sm text-gray-500">Get started by creating your first lesson for this course.</p>
            <div class="mt-6">
                <a href="<?= base_url('instructor/create_lesson/' . $course->id) ?>" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Create First Lesson
                </a>
            </div>
        </div>
    <?php else: ?>
        <!-- Lessons List -->
        <div class="space-y-4">
            <?php foreach ($lessons as $index => $lesson): ?>
                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <div class="flex items-center">
                                <span class="bg-gray-100 text-gray-800 text-sm font-medium px-2.5 py-0.5 rounded-full mr-3">
                                    Lesson <?= $lesson->sort_order ?: ($index + 1) ?>
                                </span>
                                <h3 class="text-lg font-medium text-gray-900"><?= htmlspecialchars($lesson->title) ?></h3>
                            </div>
                            
                            <?php if (!empty($lesson->content)): ?>
                                <p class="text-gray-600 mt-2 text-sm"><?= character_limiter(strip_tags($lesson->content), 150) ?></p>
                            <?php endif; ?>
                            
                            <div class="flex items-center mt-3 space-x-4 text-sm text-gray-500">
                                <?php if (!empty($lesson->video_url)): ?>
                                    <span class="flex items-center">
                                        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1.586a1 1 0 01.707.293l1.414 1.414a1 1 0 00.707.293H15M9 10v4a6 6 0 006 6v-3"></path>
                                        </svg>
                                        Has Video
                                    </span>
                                <?php endif; ?>
                                <span>Created: <?= date('M j, Y', strtotime($lesson->created_at)) ?></span>
                                <?php if ($lesson->updated_at != $lesson->created_at): ?>
                                    <span>Updated: <?= date('M j, Y', strtotime($lesson->updated_at)) ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="flex space-x-2 ml-4">
                            <a href="<?= base_url('instructor/edit_lesson/' . $lesson->id) ?>" 
                               class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700">
                                Edit
                            </a>
                            <a href="<?= base_url('instructor/delete_lesson/' . $lesson->id) ?>" 
                               class="bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700"
                               onclick="return confirm('Are you sure you want to delete this lesson? This action cannot be undone.')">
                                Delete
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Lessons Summary -->
        <div class="mt-6 p-4 bg-gray-50 rounded-lg">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-center">
                <div>
                    <div class="text-2xl font-bold text-indigo-600"><?= count($lessons) ?></div>
                    <div class="text-sm text-gray-600">Total Lessons</div>
                </div>
                <div>
                    <div class="text-2xl font-bold text-green-600">
                        <?= array_reduce($lessons, function($count, $lesson) { return $count + (!empty($lesson->video_url) ? 1 : 0); }, 0) ?>
                    </div>
                    <div class="text-sm text-gray-600">With Videos</div>
                </div>
                <div>
                    <div class="text-2xl font-bold text-blue-600">
                        <?= array_reduce($lessons, function($count, $lesson) { return $count + (!empty($lesson->content) ? 1 : 0); }, 0) ?>
                    </div>
                    <div class="text-sm text-gray-600">With Content</div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Help Section -->
<div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
    <div class="flex">
        <svg class="h-5 w-5 text-blue-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <div class="ml-3">
            <h3 class="text-sm font-medium text-blue-800">Lesson Management Tips</h3>
            <div class="mt-2 text-sm text-blue-700">
                <ul class="list-disc pl-5 space-y-1">
                    <li>Use clear, descriptive titles for your lessons</li>
                    <li>Organize lessons in logical order using sort numbers</li>
                    <li>Include both video content and written material when possible</li>
                    <li>Keep lessons focused on specific learning objectives</li>
                    <li>Preview your course from the student perspective before publishing</li>
                </ul>
            </div>
        </div>
    </div>
</div> 
