<!-- Page Header -->
<div class="bg-white shadow rounded-lg p-4 sm:p-6 xl:p-8 mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-gray-900 mb-2"><?= $title ?></h1>
            <p class="text-sm text-gray-600">
                Add a question to <span class="font-semibold"><?= $quiz->title ?></span>
            </p>
        </div>
        <a href="<?= base_url('instructor/edit_quiz/' . $quiz->id) ?>" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded inline-flex items-center text-sm">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Quiz
        </a>
    </div>
</div>

<!-- Add Question Form -->
<div class="bg-white shadow rounded-lg p-4 sm:p-6 xl:p-8">
    <?php if (validation_errors()): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <?= validation_errors() ?>
        </div>
    <?php endif; ?>
    
    <?= form_open('instructor/add_question/' . $quiz->id, ['id' => 'questionForm']) ?>
        <!-- Question Details -->
        <div class="mb-6">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Question Details</h2>
            
            <div class="mb-4">
                <label for="question" class="block text-sm font-medium text-gray-700 mb-1">Question Text *</label>
                <textarea name="question" id="question" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" required><?= set_value('question') ?></textarea>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="question_type" class="block text-sm font-medium text-gray-700 mb-1">Question Type *</label>
                    <select name="question_type" id="question_type" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                        <option value="multiple_choice" <?= set_select('question_type', 'multiple_choice', true) ?>>Multiple Choice</option>
                        <option value="true_false" <?= set_select('question_type', 'true_false') ?>>True/False</option>
                        <option value="short_answer" <?= set_select('question_type', 'short_answer') ?>>Short Answer</option>
                    </select>
                </div>
                
                <div>
                    <label for="points" class="block text-sm font-medium text-gray-700 mb-1">Points *</label>
                    <input type="number" name="points" id="points" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" value="<?= set_value('points', 1) ?>" min="1" required>
                </div>
            </div>
            
            <div class="mt-4">
                <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-1">Sort Order</label>
                <input type="number" name="sort_order" id="sort_order" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" value="<?= set_value('sort_order', 0) ?>" min="0">
                <p class="mt-1 text-sm text-gray-500">Optional: Determines the order of questions in the quiz (lower numbers appear first)</p>
            </div>
        </div>
        
        <!-- Multiple Choice Options -->
        <div id="multipleChoiceOptions" class="mb-6 border-t border-gray-200 pt-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-medium text-gray-900">Answer Options</h2>
                <button type="button" id="addAnswerOption" class="bg-green-600 hover:bg-green-700 text-white text-xs py-1 px-2 rounded inline-flex items-center">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Add Option
                </button>
            </div>
            
            <div id="answerOptionsContainer">
                <!-- Initial answer options will be added here -->
                <div class="answer-option mb-3">
                    <div class="flex items-center">
                        <input type="checkbox" name="is_correct[0]" id="is_correct_0" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" <?= set_checkbox('is_correct[0]', '1') ?>>
                        <label for="is_correct_0" class="ml-2 block text-sm text-gray-700">Correct answer</label>
                    </div>
                    <div class="mt-1 flex rounded-md shadow-sm">
                        <input type="text" name="answers[0]" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300" placeholder="Enter answer option" value="<?= set_value('answers[0]') ?>">
                        <button type="button" class="remove-option ml-2 bg-red-100 text-red-600 px-2 rounded-md hover:bg-red-200" disabled>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="answer-option mb-3">
                    <div class="flex items-center">
                        <input type="checkbox" name="is_correct[1]" id="is_correct_1" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" <?= set_checkbox('is_correct[1]', '1') ?>>
                        <label for="is_correct_1" class="ml-2 block text-sm text-gray-700">Correct answer</label>
                    </div>
                    <div class="mt-1 flex rounded-md shadow-sm">
                        <input type="text" name="answers[1]" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300" placeholder="Enter answer option" value="<?= set_value('answers[1]') ?>">
                        <button type="button" class="remove-option ml-2 bg-red-100 text-red-600 px-2 rounded-md hover:bg-red-200" disabled>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            
            <p class="mt-2 text-sm text-gray-500">Add at least two options and check the correct answer(s)</p>
        </div>
        
        <!-- True/False Options -->
        <div id="trueFalseOptions" class="mb-6 border-t border-gray-200 pt-6 hidden">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Correct Answer</h2>
            
            <div class="flex items-center space-x-6">
                <div class="flex items-center">
                    <input type="radio" name="true_false" id="true_option" value="true" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300" <?= set_radio('true_false', 'true', true) ?>>
                    <label for="true_option" class="ml-2 block text-sm text-gray-700">True</label>
                </div>
                <div class="flex items-center">
                    <input type="radio" name="true_false" id="false_option" value="false" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300" <?= set_radio('true_false', 'false') ?>>
                    <label for="false_option" class="ml-2 block text-sm text-gray-700">False</label>
                </div>
            </div>
        </div>
        
        <!-- Short Answer Options -->
        <div id="shortAnswerOptions" class="mb-6 border-t border-gray-200 pt-6 hidden">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Accepted Answers</h2>
            
            <div>
                <label for="correct_answers" class="block text-sm font-medium text-gray-700 mb-1">Correct Answers (comma-separated) *</label>
                <textarea name="correct_answers" id="correct_answers" rows="2" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"><?= set_value('correct_answers') ?></textarea>
                <p class="mt-1 text-sm text-gray-500">Enter all acceptable answers separated by commas (e.g., "answer1, answer2, answer3")</p>
            </div>
        </div>
        
        <!-- Form Actions -->
        <div class="flex justify-between pt-6 border-t border-gray-200">
            <a href="<?= base_url('instructor/edit_quiz/' . $quiz->id) ?>" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded">
                Cancel
            </a>
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded">
                Add Question
            </button>
        </div>
    <?= form_close() ?>
</div>

<!-- Question Type Tips -->
<div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4 sm:p-6">
    <div class="flex items-start">
        <div class="flex-shrink-0">
            <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <div class="ml-3">
            <h3 class="text-sm font-medium text-blue-800">Question Type Tips</h3>
            <div class="mt-2 text-sm text-blue-700">
                <dl class="space-y-3">
                    <div>
                        <dt class="font-medium">Multiple Choice</dt>
                        <dd class="pl-3">Best for questions with specific options. You can mark one or more options as correct.</dd>
                    </div>
                    <div>
                        <dt class="font-medium">True/False</dt>
                        <dd class="pl-3">Use for statements that are either true or false.</dd>
                    </div>
                    <div>
                        <dt class="font-medium">Short Answer</dt>
                        <dd class="pl-3">For questions where students type their answer. Provide all acceptable variations of the correct answer.</dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const questionTypeSelect = document.getElementById('question_type');
    const multipleChoiceOptions = document.getElementById('multipleChoiceOptions');
    const trueFalseOptions = document.getElementById('trueFalseOptions');
    const shortAnswerOptions = document.getElementById('shortAnswerOptions');
    const addAnswerOptionBtn = document.getElementById('addAnswerOption');
    const answerOptionsContainer = document.getElementById('answerOptionsContainer');
    
    // Show/hide answer options based on question type
    function toggleAnswerOptions() {
        const questionType = questionTypeSelect.value;
        
        multipleChoiceOptions.classList.add('hidden');
        trueFalseOptions.classList.add('hidden');
        shortAnswerOptions.classList.add('hidden');
        
        if (questionType === 'multiple_choice') {
            multipleChoiceOptions.classList.remove('hidden');
        } else if (questionType === 'true_false') {
            trueFalseOptions.classList.remove('hidden');
        } else if (questionType === 'short_answer') {
            shortAnswerOptions.classList.remove('hidden');
        }
    }
    
    // Add new answer option
    function addAnswerOption() {
        const optionCount = document.querySelectorAll('.answer-option').length;
        const newOption = document.createElement('div');
        newOption.className = 'answer-option mb-3';
        newOption.innerHTML = `
            <div class="flex items-center">
                <input type="checkbox" name="is_correct[${optionCount}]" id="is_correct_${optionCount}" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                <label for="is_correct_${optionCount}" class="ml-2 block text-sm text-gray-700">Correct answer</label>
            </div>
            <div class="mt-1 flex rounded-md shadow-sm">
                <input type="text" name="answers[${optionCount}]" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300" placeholder="Enter answer option">
                <button type="button" class="remove-option ml-2 bg-red-100 text-red-600 px-2 rounded-md hover:bg-red-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        `;
        
        answerOptionsContainer.appendChild(newOption);
        
        // Enable remove buttons if there are more than 2 options
        updateRemoveButtons();
        
        // Add event listener to the new remove button
        newOption.querySelector('.remove-option').addEventListener('click', removeAnswerOption);
    }
    
    // Remove answer option
    function removeAnswerOption() {
        this.closest('.answer-option').remove();
        updateRemoveButtons();
    }
    
    // Update remove buttons (disable if only 2 options remain)
    function updateRemoveButtons() {
        const removeButtons = document.querySelectorAll('.remove-option');
        const optionCount = document.querySelectorAll('.answer-option').length;
        
        removeButtons.forEach(button => {
            if (optionCount <= 2) {
                button.disabled = true;
                button.classList.add('cursor-not-allowed', 'opacity-50');
            } else {
                button.disabled = false;
                button.classList.remove('cursor-not-allowed', 'opacity-50');
            }
        });
    }
    
    // Event listeners
    questionTypeSelect.addEventListener('change', toggleAnswerOptions);
    addAnswerOptionBtn.addEventListener('click', addAnswerOption);
    document.querySelectorAll('.remove-option').forEach(button => {
        button.addEventListener('click', removeAnswerOption);
    });
    
    // Initialize
    toggleAnswerOptions();
    updateRemoveButtons();
});
</script> 
