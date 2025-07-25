<!-- Course Management Section -->
<div class="bg-white shadow rounded-lg p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900">My Courses</h2>
        <a href="<?= base_url('instructor/create_course') ?>" class="bg-indigo-50 text-indigo-700 px-4 py-2 rounded-lg shadow-sm hover:shadow hover:bg-indigo-100 transition-all transform hover:scale-102 font-medium flex items-center">
            <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Create New Course
        </a>
    </div>

    <?php if (empty($courses)): ?>
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No courses</h3>
            <p class="mt-1 text-sm text-gray-500">Get started by creating your first course.</p>
            <div class="mt-6">
                <a href="<?= base_url('instructor/create_course') ?>" class="inline-flex items-center px-4 py-2 bg-indigo-50 text-indigo-700 shadow-sm text-sm font-medium rounded-lg hover:shadow hover:bg-indigo-100 transition-all transform hover:scale-102">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Create Course
                </a>
            </div>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($courses as $course): ?>
                <div class="bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition-shadow">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900"><?= htmlspecialchars($course->title) ?></h3>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $course->status == 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' ?>">
                                <?= ucfirst($course->status) ?>
                            </span>
                        </div>
                        
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
                        <?php else: ?>
                        <div class="flex items-center mb-3">
                            <span class="text-sm text-gray-500">No ratings yet</span>
                        </div>
                        <?php endif; ?>
                        
                        <p class="text-gray-600 text-sm mb-4 line-clamp-3"><?= character_limiter($course->description, 100) ?></p>
                        
                        <div class="text-sm text-gray-500 mb-4">
                            <p><strong>Category:</strong> <?= htmlspecialchars($course->category_name ?? 'Uncategorized') ?></p>
                            <p><strong>Created:</strong> <?= date('M j, Y', strtotime($course->created_at)) ?></p>
                        </div>
                        
                        <div class="flex space-x-2 mb-2">
                            <a href="<?= base_url('instructor/lessons/' . $course->id) ?>" class="flex-1 bg-blue-50 text-blue-700 text-center py-2 px-3 rounded-lg shadow-sm hover:shadow hover:bg-blue-100 transition-all transform hover:scale-102 text-sm font-medium">
                                Manage Lessons
                            </a>
                            <a href="<?= base_url('instructor/quizzes/' . $course->id) ?>" class="flex-1 bg-purple-50 text-purple-700 text-center py-2 px-3 rounded-lg shadow-sm hover:shadow hover:bg-purple-100 transition-all transform hover:scale-102 text-sm font-medium">
                                Manage Quizzes
                            </a>
                        </div>
                        <div class="flex space-x-2 mb-2">
                            <a href="<?= base_url('instructor/course_analytics/' . $course->id) ?>" class="flex-1 bg-green-50 text-green-700 text-center py-2 px-3 rounded-lg shadow-sm hover:shadow hover:bg-green-100 transition-all transform hover:scale-102 text-sm font-medium">
                                Analytics
                            </a>
                        </div>
                        <div class="flex space-x-2">
                            <a href="<?= base_url('instructor/edit_course/' . $course->id) ?>" class="flex-1 bg-gray-50 text-gray-700 text-center py-2 px-3 rounded-lg shadow-sm hover:shadow hover:bg-gray-100 transition-all transform hover:scale-102 text-sm font-medium">
                                Edit
                            </a>
                            <a href="<?= base_url('home/course/' . $course->id) ?>" class="flex-1 bg-indigo-50 text-indigo-700 text-center py-2 px-3 rounded-lg shadow-sm hover:shadow hover:bg-indigo-100 transition-all transform hover:scale-102 text-sm font-medium">
                                View
                            </a>
                            <a href="<?= base_url('instructor/delete_course/' . $course->id) ?>" 
                               class="bg-red-50 text-red-700 py-2 px-3 rounded-lg shadow-sm hover:shadow hover:bg-red-100 transition-all transform hover:scale-102 text-sm font-medium"
                               onclick="return confirm('Are you sure you want to delete this course? This action cannot be undone.')">
                                Delete
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div> 
