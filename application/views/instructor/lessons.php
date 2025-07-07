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
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-center">
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
                <?php
                // Get enrollment count
                $this->db->where('course_id', $course->id);
                $enrollment_count = $this->db->count_all_results('enrollments');
                ?>
                <div>
                    <div class="text-2xl font-bold text-purple-600"><?= $enrollment_count ?></div>
                    <div class="text-sm text-gray-600">Enrolled Students</div>
                </div>
            </div>
        </div>
        
        <!-- Lesson Completion Stats -->
        <?php if ($enrollment_count > 0): ?>
        <div class="mt-6 p-6 bg-white border border-gray-200 rounded-lg shadow">
            <h3 class="text-lg font-semibold mb-4">Lesson Completion Statistics</h3>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lesson</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Completion Rate</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Completed By</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($lessons as $lesson): 
                            // Get completion count
                            $this->db->select('COUNT(*) as completion_count');
                            $this->db->from('lesson_progress');
                            $this->db->join('enrollments', 'enrollments.user_id = lesson_progress.user_id');
                            $this->db->where('lesson_progress.lesson_id', $lesson->id);
                            $this->db->where('enrollments.course_id', $course->id);
                            $this->db->where('lesson_progress.completed', 1);
                            $completion_count = $this->db->get()->row()->completion_count;
                            
                            $completion_rate = $enrollment_count > 0 ? round(($completion_count / $enrollment_count) * 100) : 0;
                        ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded-full mr-3">
                                            <?= $lesson->sort_order ?>
                                        </span>
                                        <span class="font-medium text-gray-900"><?= htmlspecialchars($lesson->title) ?></span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-48 bg-gray-200 rounded-full h-2.5 mr-2">
                                            <div class="bg-blue-600 h-2.5 rounded-full" style="width: <?= $completion_rate ?>%"></div>
                                        </div>
                                        <span class="text-sm font-medium text-gray-900"><?= $completion_rate ?>%</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?= $completion_count ?> of <?= $enrollment_count ?> students
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4 text-right">
                <a href="<?= base_url('instructor/course_analytics/' . $course->id) ?>" class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-800">
                    View detailed analytics
                    <svg class="ml-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                </a>
            </div>
        </div>
        <?php endif; ?>
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
