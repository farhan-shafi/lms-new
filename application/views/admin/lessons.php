<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Manage Lessons</h1>
            <p class="text-gray-600">Course: <?= htmlspecialchars($course->title) ?></p>
        </div>
        <div class="flex space-x-2">
            <a href="<?= base_url('admin/create_lesson/' . $course->id) ?>" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Add New Lesson
            </a>
            <a href="<?= base_url('admin/courses') ?>" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to Courses
            </a>
        </div>
    </div>

    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <ul class="divide-y divide-gray-200">
            <?php if (!empty($lessons)): ?>
                <?php foreach ($lessons as $lesson): ?>
                    <li>
                        <div class="px-4 py-4 sm:px-6">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <span class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-green-500">
                                            <span class="text-sm font-medium leading-none text-white">
                                                <?= $lesson->sort_order ?>
                                            </span>
                                        </span>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            <?= htmlspecialchars($lesson->title) ?>
                                        </div>
                                        <?php if (!empty($lesson->video_url)): ?>
                                            <div class="text-sm text-gray-500">
                                                📹 Has video content
                                            </div>
                                        <?php endif; ?>
                                        <?php if (!empty($lesson->content)): ?>
                                            <div class="text-sm text-gray-500">
                                                📝 <?= strlen($lesson->content) ?> characters of text content
                                            </div>
                                        <?php endif; ?>
                                        <div class="text-xs text-gray-400">
                                            Created: <?= date('M j, Y', strtotime($lesson->created_at)) ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <a href="<?= base_url('admin/edit_lesson/' . $lesson->id) ?>" 
                                       class="text-indigo-600 hover:text-indigo-900 text-sm">Edit</a>
                                    <a href="<?= base_url('admin/delete_lesson/' . $lesson->id) ?>" 
                                       class="text-red-600 hover:text-red-900 text-sm"
                                       onclick="return confirm('Are you sure you want to delete this lesson?')">Delete</a>
                                </div>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li>
                    <div class="px-4 py-4 sm:px-6 text-center text-gray-500">
                        No lessons found for this course.
                        <div class="mt-2">
                            <a href="<?= base_url('admin/create_lesson/' . $course->id) ?>" class="text-blue-600 hover:text-blue-800">
                                Create the first lesson
                            </a>
                        </div>
                    </div>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</div> 
