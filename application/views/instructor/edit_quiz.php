<!-- Page Header -->
<div class="bg-white shadow rounded-lg p-4 sm:p-6 xl:p-8 mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-gray-900 mb-2"><?= $title ?></h1>
            <p class="text-sm text-gray-600">
                Edit quiz for <span class="font-semibold"><?= $course->title ?></span>
            </p>
        </div>
        <div class="flex space-x-2">
            <a href="<?= base_url('instructor/quizzes/' . $course->id) ?>" class="bg-gray-50 text-gray-700 font-medium py-2 px-4 rounded-lg shadow-sm hover:shadow hover:bg-gray-100 transition-all transform hover:scale-102 inline-flex items-center text-sm">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Quizzes
            </a>
            <a href="<?= base_url('instructor/quiz_results/' . $quiz->id) ?>" class="bg-blue-50 text-blue-700 font-medium py-2 px-4 rounded-lg shadow-sm hover:shadow hover:bg-blue-100 transition-all transform hover:scale-102 inline-flex items-center text-sm">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                View Results
            </a>
        </div>
    </div>
</div>

<!-- Quiz Edit Form -->
<div class="bg-white shadow rounded-lg p-4 sm:p-6 xl:p-8 mb-6">
    <h2 class="text-lg font-medium text-gray-900 mb-4">Quiz Details</h2>
    
    <?php if (validation_errors()): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <?= validation_errors() ?>
        </div>
    <?php endif; ?>
    
    <?= form_open('instructor/edit_quiz/' . $quiz->id) ?>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Quiz Title *</label>
                <input type="text" name="title" id="title" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" value="<?= set_value('title', $quiz->title) ?>" required>
            </div>
            
            <div>
                <label for="lesson_id" class="block text-sm font-medium text-gray-700 mb-1">Associated Lesson (Optional)</label>
                <select name="lesson_id" id="lesson_id" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                    <option value="">None</option>
                    <?php foreach ($lessons as $lesson): ?>
                        <option value="<?= $lesson->id ?>" <?= set_select('lesson_id', $lesson->id, ($quiz->lesson_id == $lesson->id)) ?>><?= $lesson->title ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div>
                <label for="pass_percentage" class="block text-sm font-medium text-gray-700 mb-1">Pass Percentage *</label>
                <div class="mt-1 flex rounded-md shadow-sm">
                    <input type="number" name="pass_percentage" id="pass_percentage" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-l-md sm:text-sm border-gray-300" value="<?= set_value('pass_percentage', $quiz->pass_percentage) ?>" min="1" max="100" required>
                    <span class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">%</span>
                </div>
            </div>
            
            <div>
                <label for="time_limit" class="block text-sm font-medium text-gray-700 mb-1">Time Limit (Optional)</label>
                <div class="mt-1 flex rounded-md shadow-sm">
                    <input type="number" name="time_limit" id="time_limit" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-l-md sm:text-sm border-gray-300" value="<?= set_value('time_limit', $quiz->time_limit) ?>" min="0">
                    <span class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">minutes</span>
                </div>
                <p class="mt-1 text-sm text-gray-500">Leave empty for no time limit</p>
            </div>
            
            <div class="lg:col-span-2">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" id="description" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"><?= set_value('description', $quiz->description) ?></textarea>
            </div>
            
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" id="status" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                    <option value="draft" <?= set_select('status', 'draft', ($quiz->status == 'draft')) ?>>Draft</option>
                    <option value="published" <?= set_select('status', 'published', ($quiz->status == 'published')) ?>>Published</option>
                </select>
            </div>
        </div>
        
        <div class="mt-6">
            <button type="submit" class="inline-flex justify-center py-2 px-4 shadow-sm text-sm font-medium rounded-lg text-indigo-700 bg-indigo-50 hover:bg-indigo-100 hover:shadow transition-all transform hover:scale-102">
                Update Quiz
            </button>
        </div>
    <?= form_close() ?>
</div>

<!-- Questions List -->
<div class="bg-white shadow rounded-lg p-4 sm:p-6 xl:p-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-lg font-medium text-gray-900">Quiz Questions</h2>
        <a href="<?= base_url('instructor/add_question/' . $quiz->id) ?>" class="bg-green-50 text-green-700 font-medium py-2 px-4 rounded-lg shadow-sm hover:shadow hover:bg-green-100 transition-all transform hover:scale-102 inline-flex items-center text-sm">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Add Question
        </a>
    </div>
    
    <?php if (empty($questions)): ?>
        <div class="text-center py-8">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No questions found</h3>
            <p class="mt-1 text-sm text-gray-500">Get started by adding your first question.</p>
            <div class="mt-6">
                <a href="<?= base_url('instructor/add_question/' . $quiz->id) ?>" class="inline-flex items-center px-4 py-2 shadow-sm text-sm font-medium rounded-lg text-green-700 bg-green-50 hover:bg-green-100 hover:shadow transition-all transform hover:scale-102">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Add Question
                </a>
            </div>
        </div>
    <?php else: ?>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Question</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Points</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($questions as $index => $question): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-8 w-8 flex items-center justify-center bg-blue-100 text-blue-800 rounded-full">
                                        <?= $index + 1 ?>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            <?= htmlspecialchars(character_limiter($question->question, 100)) ?>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    <?php 
                                    switch($question->question_type) {
                                        case 'multiple_choice':
                                            echo 'bg-blue-100 text-blue-800';
                                            break;
                                        case 'true_false':
                                            echo 'bg-green-100 text-green-800';
                                            break;
                                        case 'short_answer':
                                            echo 'bg-purple-100 text-purple-800';
                                            break;
                                        default:
                                            echo 'bg-gray-100 text-gray-800';
                                    }
                                    ?>">
                                    <?php 
                                    switch($question->question_type) {
                                        case 'multiple_choice':
                                            echo 'Multiple Choice';
                                            break;
                                        case 'true_false':
                                            echo 'True/False';
                                            break;
                                        case 'short_answer':
                                            echo 'Short Answer';
                                            break;
                                        default:
                                            echo ucfirst($question->question_type);
                                    }
                                    ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= $question->points ?> point<?= $question->points != 1 ? 's' : '' ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-2">
                                    <a href="<?= base_url('instructor/edit_question/' . $question->id) ?>" class="text-indigo-600 hover:text-indigo-900">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    <a href="<?= base_url('instructor/delete_question/' . $question->id) ?>" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this question? This action cannot be undone.')">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<!-- Quiz Tips -->
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
                    <li>Create a mix of question types for better assessment</li>
                    <li>Set an appropriate pass percentage based on difficulty</li>
                    <li>Add at least 5 questions for a comprehensive quiz</li>
                    <li>Use clear and concise language in your questions</li>
                    <li>Publish the quiz only when it's ready for students</li>
                </ul>
            </div>
        </div>
    </div>
</div> 
