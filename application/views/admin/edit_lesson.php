<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Edit Lesson</h1>
            <p class="text-gray-600">Course: <?= htmlspecialchars($course->title) ?></p>
        </div>
        <a href="<?= base_url('admin/lessons/' . $course->id) ?>" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            Back to Lessons
        </a>
    </div>

    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <?= form_open('admin/edit_lesson/' . $lesson->id, array('class' => 'space-y-6')) ?>
            
            <?php if (validation_errors()): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <?= validation_errors() ?>
                </div>
            <?php endif; ?>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="title">
                    Lesson Title
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                       id="title" name="title" type="text" placeholder="Lesson Title" 
                       value="<?= set_value('title', $lesson->title) ?>" required>
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="content">
                    Lesson Content
                </label>
                <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                          id="content" name="content" rows="8" placeholder="Lesson content..."><?= set_value('content', $lesson->content) ?></textarea>
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="video_url">
                    Video URL (Optional)
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                       id="video_url" name="video_url" type="url" placeholder="https://www.youtube.com/watch?v=..." 
                       value="<?= set_value('video_url', $lesson->video_url) ?>">
                <p class="text-sm text-gray-600 mt-1">YouTube, Vimeo, or direct video file URLs are supported</p>
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="sort_order">
                    Sort Order
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                       id="sort_order" name="sort_order" type="number" placeholder="0" 
                       value="<?= set_value('sort_order', $lesson->sort_order) ?>" min="0">
                <p class="text-sm text-gray-600 mt-1">Lower numbers appear first</p>
            </div>

            <div class="flex items-center justify-between">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" 
                        type="submit">
                    Update Lesson
                </button>
                <a href="<?= base_url('admin/lessons/' . $course->id) ?>" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                    Cancel
                </a>
            </div>
        <?= form_close() ?>
    </div>
</div> 
