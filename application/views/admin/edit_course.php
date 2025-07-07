<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Edit Course</h1>
        <a href="<?= base_url('admin/courses') ?>" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            Back to Courses
        </a>
    </div>

    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <?= form_open('admin/edit_course/' . $course->id, array('class' => 'space-y-6')) ?>
            
            <?php if (validation_errors()): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <?= validation_errors() ?>
                </div>
            <?php endif; ?>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="title">
                    Course Title
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                       id="title" name="title" type="text" placeholder="Course Title" 
                       value="<?= set_value('title', $course->title) ?>" required>
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
                    Description
                </label>
                <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                          id="description" name="description" rows="4" placeholder="Course description..."><?= set_value('description', $course->description) ?></textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="category_id">
                        Category
                    </label>
                    <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                            id="category_id" name="category_id">
                        <option value="">Select Category</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category->id ?>" <?= ($course->category_id == $category->id) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($category->name) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="instructor_id">
                        Instructor
                    </label>
                    <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                            id="instructor_id" name="instructor_id" required>
                        <option value="">Select Instructor</option>
                        <?php foreach ($instructors as $instructor): ?>
                            <option value="<?= $instructor->id ?>" <?= ($course->instructor_id == $instructor->id) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($instructor->full_name) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="status">
                    Status
                </label>
                <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                        id="status" name="status" required>
                    <option value="draft" <?= ($course->status == 'draft') ? 'selected' : '' ?>>Draft</option>
                    <option value="published" <?= ($course->status == 'published') ? 'selected' : '' ?>>Published</option>
                </select>
            </div>

            <div class="flex items-center justify-between">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" 
                        type="submit">
                    Update Course
                </button>
                <a href="<?= base_url('admin/courses') ?>" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                    Cancel
                </a>
            </div>
        <?= form_close() ?>
    </div>
</div> 
