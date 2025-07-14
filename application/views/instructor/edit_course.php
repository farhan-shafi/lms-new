<!-- Edit Course Form -->
<div class="bg-white shadow rounded-lg p-6">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Edit Course</h2>
        <p class="text-gray-600 mt-2">Update the course information below.</p>
    </div>

    <?= form_open_multipart('instructor/edit_course/' . $course->id, ['class' => 'space-y-6']) ?>
        
        <!-- Course Title -->
        <div>
            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Course Title *</label>
            <input type="text" 
                   id="title" 
                   name="title" 
                   value="<?= set_value('title', $course->title) ?>"
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
                      placeholder="Enter course description"><?= set_value('description', $course->description) ?></textarea>
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
                        <option value="<?= $category->id ?>" <?= set_select('category_id', $category->id, ($category->id == $course->category_id)) ?>>
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
                <option value="draft" <?= set_select('status', 'draft', ($course->status == 'draft')) ?>>Draft</option>
                <option value="published" <?= set_select('status', 'published', ($course->status == 'published')) ?>>Published</option>
            </select>
            <?= form_error('status', '<div class="text-red-600 text-sm mt-1">', '</div>') ?>
        </div>
        
        <!-- Course Thumbnail -->
        <div>
            <label for="thumbnail" class="block text-sm font-medium text-gray-700 mb-2">Course Thumbnail</label>
            <div class="flex items-start space-x-4">
                                    <?php if (!empty($course->thumbnail) && file_exists(FCPATH . 'uploads/thumbnails/' . $course->thumbnail)): ?>
                        <div class="flex-shrink-0">
                            <img src="<?= base_url('uploads/thumbnails/' . $course->thumbnail) ?>" alt="Current thumbnail" class="h-32 w-56 object-cover rounded">
                        </div>
                    <?php endif; ?>
                <div class="flex-grow">
                    <input type="file" 
                           id="thumbnail" 
                           name="thumbnail" 
                           class="w-full"
                           accept="image/*">
                    <p class="text-sm text-gray-500 mt-1">Upload a new thumbnail image (JPG, PNG, GIF, max 2MB)</p>
                    <p class="text-sm text-gray-500 mt-1">Recommended size: 1280x720 pixels (16:9 ratio)</p>
                    <?php if (!empty($course->thumbnail)): ?>
                        <p class="text-sm text-gray-500 mt-1">Leave empty to keep current thumbnail</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Course Information -->
        <div class="bg-gray-50 p-4 rounded-lg">
            <h3 class="text-sm font-medium text-gray-700 mb-2">Course Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
                <div>
                    <strong>Course ID:</strong> <?= $course->id ?>
                </div>
                <div>
                    <strong>Created:</strong> <?= date('M j, Y g:i A', strtotime($course->created_at)) ?>
                </div>
                <div>
                    <strong>Last Updated:</strong> <?= date('M j, Y g:i A', strtotime($course->updated_at)) ?>
                </div>
                <div>
                    <strong>Current Status:</strong> 
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $course->status == 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' ?>">
                        <?= ucfirst($course->status) ?>
                    </span>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex justify-between pt-6 border-t border-gray-200">
            <div class="space-x-3">
                <a href="<?= base_url('instructor/courses') ?>" 
                   class="bg-gray-50 text-gray-700 px-6 py-2 rounded-lg shadow-sm hover:shadow hover:bg-gray-100 transition-all transform hover:scale-102">
                    Cancel
                </a>
                <a href="<?= base_url('instructor/lessons/' . $course->id) ?>" 
                   class="bg-blue-50 text-blue-700 px-6 py-2 rounded-lg shadow-sm hover:shadow hover:bg-blue-100 transition-all transform hover:scale-102">
                    Manage Lessons
                </a>
            </div>
            <button type="submit" 
                    class="bg-indigo-50 text-indigo-700 px-6 py-2 rounded-lg shadow-sm hover:shadow hover:bg-indigo-100 transition-all transform hover:scale-102">
                <svg class="inline h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Update Course
            </button>
        </div>

    <?= form_close() ?>
</div>

<!-- Warning for Published Courses -->
<?php if ($course->status == 'published'): ?>
<div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
    <div class="flex">
        <svg class="h-5 w-5 text-yellow-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
        </svg>
        <div class="ml-3">
            <h3 class="text-sm font-medium text-yellow-800">Published Course Warning</h3>
            <div class="mt-2 text-sm text-yellow-700">
                <p>This course is currently published and visible to students. Any changes you make will be immediately visible to enrolled students.</p>
            </div>
        </div>
    </div>
</div>
<?php endif; ?> 
