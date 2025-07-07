<!-- Course Context -->
<div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-6">
    <div class="flex items-center">
        <svg class="h-5 w-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
        </svg>
        <span class="text-sm text-gray-600">Editing lesson in:</span>
        <span class="font-medium text-gray-900 ml-2"><?= htmlspecialchars($course->title) ?></span>
    </div>
</div>

<!-- Edit Lesson Form -->
<div class="bg-white shadow rounded-lg p-6">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Edit Lesson</h2>
        <p class="text-gray-600 mt-2">Update the lesson content and settings below.</p>
    </div>

    <?= form_open('instructor/edit_lesson/' . $lesson->id, ['class' => 'space-y-6']) ?>
        
        <!-- Lesson Title -->
        <div>
            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Lesson Title *</label>
            <input type="text" 
                   id="title" 
                   name="title" 
                   value="<?= set_value('title', $lesson->title) ?>"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                   placeholder="Enter lesson title"
                   required>
            <?= form_error('title', '<div class="text-red-600 text-sm mt-1">', '</div>') ?>
        </div>

        <!-- Sort Order -->
        <div>
            <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">Lesson Order</label>
            <input type="number" 
                   id="sort_order" 
                   name="sort_order" 
                   value="<?= set_value('sort_order', $lesson->sort_order) ?>"
                   min="1"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                   placeholder="Enter lesson order (e.g., 1, 2, 3...)">
            <p class="text-sm text-gray-500 mt-1">Determines the order this lesson appears in the course.</p>
            <?= form_error('sort_order', '<div class="text-red-600 text-sm mt-1">', '</div>') ?>
        </div>

        <!-- Video URL -->
        <div>
            <label for="video_url" class="block text-sm font-medium text-gray-700 mb-2">Video URL</label>
            <input type="url" 
                   id="video_url" 
                   name="video_url" 
                   value="<?= set_value('video_url', $lesson->video_url) ?>"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                   placeholder="https://youtube.com/watch?v=... or https://vimeo.com/...">
            <p class="text-sm text-gray-500 mt-1">Optional: Add a YouTube, Vimeo, or other video URL for this lesson.</p>
            <?= form_error('video_url', '<div class="text-red-600 text-sm mt-1">', '</div>') ?>
        </div>

        <!-- Lesson Content -->
        <div>
            <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Lesson Content</label>
            <textarea id="content" 
                      name="content" 
                      rows="12"
                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                      placeholder="Enter the lesson content, instructions, notes, or description..."><?= set_value('content', $lesson->content) ?></textarea>
            <p class="text-sm text-gray-500 mt-1">Write the main content for this lesson. You can include instructions, explanations, exercises, or any other learning material.</p>
            <?= form_error('content', '<div class="text-red-600 text-sm mt-1">', '</div>') ?>
        </div>

        <!-- Lesson Information -->
        <div class="bg-gray-50 p-4 rounded-lg">
            <h3 class="text-sm font-medium text-gray-700 mb-2">Lesson Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
                <div>
                    <strong>Lesson ID:</strong> <?= $lesson->id ?>
                </div>
                <div>
                    <strong>Course:</strong> <?= htmlspecialchars($course->title) ?>
                </div>
                <div>
                    <strong>Created:</strong> <?= date('M j, Y g:i A', strtotime($lesson->created_at)) ?>
                </div>
                <div>
                    <strong>Last Updated:</strong> <?= date('M j, Y g:i A', strtotime($lesson->updated_at)) ?>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex justify-between pt-6 border-t border-gray-200">
            <div class="space-x-3">
                <a href="<?= base_url('instructor/lessons/' . $course->id) ?>" 
                   class="bg-gray-300 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-400 transition-colors">
                    Cancel
                </a>
                <?php if (!empty($lesson->video_url)): ?>
                    <a href="<?= $lesson->video_url ?>" 
                       target="_blank"
                       class="bg-green-600 text-white px-6 py-2 rounded-md hover:bg-green-700 transition-colors">
                        Preview Video
                    </a>
                <?php endif; ?>
            </div>
            <button type="submit" 
                    class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700 transition-colors">
                <svg class="inline h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Update Lesson
            </button>
        </div>

    <?= form_close() ?>
</div>

<!-- Current Content Preview -->
<?php if (!empty($lesson->content)): ?>
<div class="mt-6 bg-white shadow rounded-lg p-6">
    <h3 class="text-lg font-medium text-gray-900 mb-4">Current Content Preview</h3>
    <div class="prose max-w-none text-gray-700 bg-gray-50 p-4 rounded-lg">
        <?= nl2br(htmlspecialchars($lesson->content)) ?>
    </div>
</div>
<?php endif; ?>

<!-- Current Video Preview -->
<?php if (!empty($lesson->video_url)): ?>
<div class="mt-6 bg-white shadow rounded-lg p-6">
    <h3 class="text-lg font-medium text-gray-900 mb-4">Current Video</h3>
    <div class="bg-gray-100 p-4 rounded-lg">
        <div class="flex items-center">
            <svg class="h-5 w-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
            </svg>
            <a href="<?= $lesson->video_url ?>" target="_blank" class="text-indigo-600 hover:text-indigo-800 break-all">
                <?= htmlspecialchars($lesson->video_url) ?>
            </a>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Editing Tips -->
<div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
    <div class="flex">
        <svg class="h-5 w-5 text-blue-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <div class="ml-3">
            <h3 class="text-sm font-medium text-blue-800">Editing Tips</h3>
            <div class="mt-2 text-sm text-blue-700">
                <ul class="list-disc pl-5 space-y-1">
                    <li>Changes are saved immediately when you click "Update Lesson"</li>
                    <li>Use the preview sections to see your current content</li>
                    <li>Test video URLs to ensure they work correctly</li>
                    <li>Consider the lesson order when making changes to ensure logical flow</li>
                    <li>If the course is published, changes will be visible to enrolled students immediately</li>
                </ul>
            </div>
        </div>
    </div>
</div> 
