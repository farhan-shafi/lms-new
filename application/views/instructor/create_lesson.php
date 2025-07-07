<!-- Course Context -->
<div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-6">
    <div class="flex items-center">
        <svg class="h-5 w-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
        </svg>
        <span class="text-sm text-gray-600">Creating lesson for:</span>
        <span class="font-medium text-gray-900 ml-2"><?= htmlspecialchars($course->title) ?></span>
    </div>
</div>

<!-- Create Lesson Form -->
<div class="bg-white shadow rounded-lg p-6">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Create New Lesson</h2>
        <p class="text-gray-600 mt-2">Add a new lesson to your course with content and media.</p>
    </div>

    <?= form_open('instructor/create_lesson/' . $course->id, ['class' => 'space-y-6']) ?>
        
        <!-- Lesson Title -->
        <div>
            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Lesson Title *</label>
            <input type="text" 
                   id="title" 
                   name="title" 
                   value="<?= set_value('title') ?>"
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
                   value="<?= set_value('sort_order', '1') ?>"
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
                   value="<?= set_value('video_url') ?>"
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
                      placeholder="Enter the lesson content, instructions, notes, or description..."><?= set_value('content') ?></textarea>
            <p class="text-sm text-gray-500 mt-1">Write the main content for this lesson. You can include instructions, explanations, exercises, or any other learning material.</p>
            <?= form_error('content', '<div class="text-red-600 text-sm mt-1">', '</div>') ?>
        </div>

        <!-- Form Actions -->
        <div class="flex justify-between pt-6 border-t border-gray-200">
            <a href="<?= base_url('instructor/lessons/' . $course->id) ?>" 
               class="bg-gray-300 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-400 transition-colors">
                Cancel
            </a>
            <button type="submit" 
                    class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700 transition-colors">
                <svg class="inline h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Create Lesson
            </button>
        </div>

    <?= form_close() ?>
</div>

<!-- Content Creation Tips -->
<div class="mt-6 bg-green-50 border border-green-200 rounded-lg p-4">
    <div class="flex">
        <svg class="h-5 w-5 text-green-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
        </svg>
        <div class="ml-3">
            <h3 class="text-sm font-medium text-green-800">Lesson Creation Tips</h3>
            <div class="mt-2 text-sm text-green-700">
                <ul class="list-disc pl-5 space-y-1">
                    <li><strong>Clear Learning Objectives:</strong> Start each lesson with what students will learn</li>
                    <li><strong>Logical Sequencing:</strong> Use sort order to arrange lessons in a logical progression</li>
                    <li><strong>Mixed Media:</strong> Combine video and text content for better engagement</li>
                    <li><strong>Practical Examples:</strong> Include real-world examples and exercises</li>
                    <li><strong>Bite-sized Content:</strong> Keep lessons focused and digestible (10-20 minutes)</li>
                    <li><strong>Call to Action:</strong> End with next steps or practice assignments</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Video URL Help -->
<div class="mt-4 bg-blue-50 border border-blue-200 rounded-lg p-4">
    <div class="flex">
        <svg class="h-5 w-5 text-blue-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
        </svg>
        <div class="ml-3">
            <h3 class="text-sm font-medium text-blue-800">Supported Video Platforms</h3>
            <div class="mt-2 text-sm text-blue-700">
                <p>You can embed videos from popular platforms:</p>
                <ul class="list-disc pl-5 mt-1 space-y-1">
                    <li><strong>YouTube:</strong> https://youtube.com/watch?v=VIDEO_ID</li>
                    <li><strong>Vimeo:</strong> https://vimeo.com/VIDEO_ID</li>
                    <li><strong>Direct URLs:</strong> Links to .mp4, .webm, or other video files</li>
                </ul>
            </div>
        </div>
    </div>
</div> 
