<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Manage Courses</h1>
        <a href="<?= base_url('admin/create_course') ?>" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Add New Course
        </a>
    </div>

    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <ul class="divide-y divide-gray-200">
            <?php if (!empty($courses)): ?>
                <?php foreach ($courses as $course): ?>
                    <li>
                        <div class="px-4 py-4 sm:px-6">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <?php if (!empty($course->thumbnail)): ?>
                                            <img class="h-10 w-10 rounded-full object-cover" src="<?= base_url('uploads/thumbnails/' . $course->thumbnail) ?>" alt="">
                                        <?php else: ?>
                                            <span class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-purple-500">
                                                <span class="text-sm font-medium leading-none text-white">
                                                    <?= strtoupper(substr($course->title, 0, 1)) ?>
                                                </span>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            <?= htmlspecialchars($course->title) ?>
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            Instructor: <?= htmlspecialchars($course->instructor_name) ?>
                                        </div>
                                        <?php if (!empty($course->category_name)): ?>
                                            <div class="text-sm text-gray-500">
                                                Category: <?= htmlspecialchars($course->category_name) ?>
                                            </div>
                                        <?php endif; ?>
                                        <div class="text-xs text-gray-400">
                                            Created: <?= date('M j, Y', strtotime($course->created_at)) ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        <?php if ($course->status == 'published'): ?>
                                            bg-green-100 text-green-800
                                        <?php else: ?>
                                            bg-yellow-100 text-yellow-800
                                        <?php endif; ?>">
                                        <?= ucfirst($course->status) ?>
                                    </span>
                                    <a href="<?= base_url('admin/lessons/' . $course->id) ?>" 
                                       class="text-purple-600 hover:text-purple-900 text-sm">Lessons</a>
                                    <a href="<?= base_url('admin/edit_course/' . $course->id) ?>" 
                                       class="text-indigo-600 hover:text-indigo-900 text-sm">Edit</a>
                                    <a href="<?= base_url('admin/delete_course/' . $course->id) ?>" 
                                       class="text-red-600 hover:text-red-900 text-sm"
                                       onclick="return confirm('Are you sure you want to delete this course?')">Delete</a>
                                </div>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li>
                    <div class="px-4 py-4 sm:px-6 text-center text-gray-500">
                        No courses found.
                    </div>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</div> 
