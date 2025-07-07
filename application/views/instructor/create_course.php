<!-- Create Course Form -->
<div class="bg-white shadow rounded-lg p-6">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Create New Course</h2>
        <p class="text-gray-600 mt-2">Fill out the form below to create a new course.</p>
    </div>

    <?= form_open('instructor/create_course', ['class' => 'space-y-6']) ?>
        
        <!-- Course Title -->
        <div>
            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Course Title *</label>
            <input type="text" 
                   id="title" 
                   name="title" 
                   value="<?= set_value('title') ?>"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                   placeholder="Enter course title"
                   required>
            <?= form_error('title', '<div class="text-red-600 text-sm mt-1">', '</div>') ?>
        </div>

        <!-- Course Description -->
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Course Description</label>
            <textarea id="description" 
                      name="description" 
                      rows="6"
                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                      placeholder="Enter course description"><?= set_value('description') ?></textarea>
            <?= form_error('description', '<div class="text-red-600 text-sm mt-1">', '</div>') ?>
        </div>

        <!-- Category -->
        <div>
            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">Category</label>
            <select id="category_id" 
                    name="category_id"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">Select a category</option>
                <?php if (!empty($categories)): ?>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category->id ?>" <?= set_select('category_id', $category->id) ?>>
                            <?= htmlspecialchars($category->name) ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
            <?= form_error('category_id', '<div class="text-red-600 text-sm mt-1">', '</div>') ?>
        </div>

        <!-- Course Status -->
        <div>
            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
            <select id="status" 
                    name="status"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                <option value="draft" <?= set_select('status', 'draft', TRUE) ?>>Draft</option>
                <option value="published" <?= set_select('status', 'published') ?>>Published</option>
            </select>
            <?= form_error('status', '<div class="text-red-600 text-sm mt-1">', '</div>') ?>
        </div>

        <!-- Form Actions -->
        <div class="flex justify-between pt-6 border-t border-gray-200">
            <a href="<?= base_url('instructor/courses') ?>" 
               class="bg-gray-300 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-400 transition-colors">
                Cancel
            </a>
            <button type="submit" 
                    class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700 transition-colors">
                <svg class="inline h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Create Course
            </button>
        </div>

    <?= form_close() ?>
</div>

<!-- Help Text -->
<div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
    <div class="flex">
        <svg class="h-5 w-5 text-blue-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <div class="ml-3">
            <h3 class="text-sm font-medium text-blue-800">Course Creation Tips</h3>
            <div class="mt-2 text-sm text-blue-700">
                <ul class="list-disc pl-5 space-y-1">
                    <li>Choose a descriptive and engaging title for your course</li>
                    <li>Write a clear description that explains what students will learn</li>
                    <li>Select the most appropriate category for better discoverability</li>
                    <li>Start with "Draft" status and publish when you're ready</li>
                    <li>After creating the course, you can add lessons and content</li>
                </ul>
            </div>
        </div>
    </div>
</div> 
