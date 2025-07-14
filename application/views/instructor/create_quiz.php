<!-- Page Header -->
<div class="bg-white shadow rounded-lg p-4 sm:p-6 xl:p-8 mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-gray-900 mb-2"><?= $title ?></h1>
            <p class="text-sm text-gray-600">
                Create a new quiz for <span class="font-semibold"><?= $course->title ?></span>
            </p>
        </div>
        <a href="<?= base_url('instructor/quizzes/' . $course->id) ?>" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded inline-flex items-center text-sm">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Quizzes
        </a>
    </div>
</div>

<!-- Create Quiz Form -->
<div class="bg-white shadow rounded-lg p-4 sm:p-6 xl:p-8">
    <?= form_open('instructor/create_quiz/' . $course->id, ['class' => 'space-y-6']) ?>
        
        <!-- Quiz Information -->
        <div>
            <h2 class="text-lg font-medium text-gray-900 mb-4">Quiz Information</h2>
            
            <!-- Quiz Title -->
            <div class="mb-6">
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Quiz Title *</label>
                <input type="text" 
                       id="title" 
                       name="title" 
                       value="<?= set_value('title') ?>"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                       placeholder="Enter quiz title"
                       required>
                <?= form_error('title', '<div class="text-red-600 text-sm mt-1">', '</div>') ?>
            </div>
            
            <!-- Quiz Description -->
            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea id="description" 
                          name="description" 
                          rows="3"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                          placeholder="Enter quiz description"><?= set_value('description') ?></textarea>
                <p class="text-sm text-gray-500 mt-1">Optional: Provide instructions or information about this quiz</p>
            </div>
            
            <!-- Associated Lesson -->
            <div class="mb-6">
                <label for="lesson_id" class="block text-sm font-medium text-gray-700 mb-2">Associated Lesson</label>
                <select id="lesson_id" 
                        name="lesson_id"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                    <option value="">None (Course-level quiz)</option>
                    <?php foreach ($lessons as $lesson): ?>
                        <option value="<?= $lesson->id ?>" <?= set_select('lesson_id', $lesson->id) ?>>
                            <?= $lesson->title ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <p class="text-sm text-gray-500 mt-1">Optional: Associate this quiz with a specific lesson</p>
            </div>
        </div>
        
        <!-- Quiz Settings -->
        <div class="border-t border-gray-200 pt-6">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Quiz Settings</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Time Limit -->
                <div>
                    <label for="time_limit" class="block text-sm font-medium text-gray-700 mb-2">Time Limit (minutes)</label>
                    <input type="number" 
                           id="time_limit" 
                           name="time_limit" 
                           value="<?= set_value('time_limit') ?>"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                           placeholder="Leave empty for no limit"
                           min="1">
                    <p class="text-sm text-gray-500 mt-1">Optional: Set a time limit for completing the quiz</p>
                </div>
                
                <!-- Pass Percentage -->
                <div>
                    <label for="pass_percentage" class="block text-sm font-medium text-gray-700 mb-2">Pass Percentage *</label>
                    <input type="number" 
                           id="pass_percentage" 
                           name="pass_percentage" 
                           value="<?= set_value('pass_percentage', 70) ?>"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                           placeholder="Enter pass percentage"
                           min="1"
                           max="100"
                           required>
                    <p class="text-sm text-gray-500 mt-1">Percentage score required to pass the quiz</p>
                    <?= form_error('pass_percentage', '<div class="text-red-600 text-sm mt-1">', '</div>') ?>
                </div>
            </div>
            
            <!-- Quiz Status -->
            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Quiz Status</label>
                <div class="flex items-center space-x-6">
                    <div class="flex items-center">
                        <input type="radio" 
                               id="status_draft" 
                               name="status" 
                               value="draft"
                               <?= set_radio('status', 'draft', true) ?>
                               class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                        <label for="status_draft" class="ml-2 block text-sm text-gray-700">
                            Draft
                        </label>
                    </div>
                    <div class="flex items-center">
                        <input type="radio" 
                               id="status_published" 
                               name="status" 
                               value="published"
                               <?= set_radio('status', 'published') ?>
                               class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                        <label for="status_published" class="ml-2 block text-sm text-gray-700">
                            Published
                        </label>
                    </div>
                </div>
                <p class="text-sm text-gray-500 mt-1">Draft quizzes are not visible to students</p>
            </div>
        </div>
        
        <!-- Form Actions -->
        <div class="flex justify-between pt-6 border-t border-gray-200">
            <a href="<?= base_url('instructor/quizzes/' . $course->id) ?>" 
               class="bg-gray-300 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-400 transition-colors">
                Cancel
            </a>
            <button type="submit" 
                    class="bg-purple-600 text-white px-6 py-2 rounded-md hover:bg-purple-700 transition-colors">
                <svg class="inline h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Create Quiz
            </button>
        </div>
        
    <?= form_close() ?>
</div>

<!-- Help Section -->
<div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4 sm:p-6">
    <div class="flex items-start">
        <div class="flex-shrink-0">
            <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <div class="ml-3">
            <h3 class="text-sm font-medium text-blue-800">Quiz Creation Tips</h3>
            <div class="mt-2 text-sm text-blue-700">
                <ul class="list-disc pl-5 space-y-1">
                    <li>After creating the quiz, you'll be able to add questions</li>
                    <li>You can create multiple-choice, true/false, and short answer questions</li>
                    <li>Consider setting a time limit for timed assessments</li>
                    <li>Keep the quiz in draft mode until it's ready for students</li>
                    <li>You can edit the quiz settings and questions at any time</li>
                </ul>
            </div>
        </div>
    </div>
</div> 
