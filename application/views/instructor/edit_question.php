<!-- Page Header -->
<div class="bg-white shadow rounded-lg p-4 sm:p-6 xl:p-8 mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-gray-900 mb-2"><?= $title ?></h1>
            <p class="text-sm text-gray-600">
                Edit question for <span class="font-semibold"><?= $quiz->title ?></span>
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

<!-- Edit Question Form -->
<div class="bg-white shadow rounded-lg p-4 sm:p-6 xl:p-8">
    <?php if (validation_errors()): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <?= validation_errors() ?>
        </div>
    <?php endif; ?>
    
    <?= form_open('instructor/edit_question/' . $question->id, ['id' => 'questionForm']) ?>
        <!-- Question Details -->
        <div class="mb-6">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Question Details</h2>
            
            <div class="mb-4">
                <label for="question" class="block text-sm font-medium text-gray-700 mb-1">Question Text *</label>
                <textarea name="question" id="question" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" required><?= set_value('question', $question->question) ?></textarea>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="question_type" class="block text-sm font-medium text-gray-700 mb-1">Question Type *</label>
                    <input type="text" value="<?= ucfirst(str_replace('_', ' ', $question->question_type)) ?>" class="shadow-sm bg-gray-100 block w-full sm:text-sm border-gray-300 rounded-md" readonly>
                    <input type="hidden" name="question_type" value="<?= $question->question_type ?>">
                    <p class="mt-1 text-sm text-gray-500">Question type cannot be changed after creation</p>
                </div>
                
                <div>
                    <label for="points" class="block text-sm font-medium text-gray-700 mb-1">Points *</label>
                    <input type="number" name="points" id="points" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" value="<?= set_value('points', $question->points) ?>" min="1" required>
                </div>
            </div>
            
            <div class="mt-4">
                <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-1">Sort Order</label>
                <input type="number" name="sort_order" id="sort_order" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" value="<?= set_value('sort_order', $question->sort_order) ?>" min="0">
                <p class="mt-1 text-sm text-gray-500">Determines the order of questions in the quiz (lower numbers appear first)</p>
            </div>
        </div>
        
        <?php if ($question->question_type == 'multiple_choice'): ?>
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
                <?php foreach ($answers as $key => $answer): ?>
                <div class="answer-option mb-3" data-id="<?= $answer->id ?>">
                    <div class="flex items-center">
                        <input type="checkbox" name="is_correct[<?= $key ?>]" id="is_correct_<?= $key ?>" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" <?= $answer->is_correct ? 'checked' : '' ?>>
                        <label for="is_correct_<?= $key ?>" class="ml-2 block text-sm text-gray-700">Correct answer</label>
                    </div>
                    <div class="mt-1 flex rounded-md shadow-sm">
                        <input type="hidden" name="answer_id[<?= $key ?>]" value="<?= $answer->id ?>">
                        <input type="text" name="answers[<?= $key ?>]" class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-md sm:text-sm border-gray-300" placeholder="Enter answer option" value="<?= $answer->answer_text ?>">
                        <button type="button" class="remove-option ml-2 bg-red-100 text-red-600 px-2 rounded-md hover:bg-red-200" <?= count($answers) <= 2 ? 'disabled' : '' ?>>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <p class="mt-2 text-sm text-gray-500">You must have at least two options and check at least one correct answer</p>
        </div>
        <?php elseif ($question->question_type == 'true_false'): ?>
        <!-- True/False Options -->
        <div id="trueFalseOptions" class="mb-6 border-t border-gray-200 pt-6">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Correct Answer</h2>
            
            <div class="flex items-center space-x-6">
                <?php 
                $true_is_correct = false;
                $false_is_correct = false;
                
                foreach ($answers as $answer) {
                    if ($answer->answer_text == 'True' && $answer->is_correct) {
                        $true_is_correct = true;
                    } elseif ($answer->answer_text == 'False' && $answer->is_correct) {
                        $false_is_correct = true;
                    }
                }
                ?>
                
                <div class="flex items-center">
                    <input type="radio" name="true_false" id="true_option" value="true" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300" <?= $true_is_correct ? 'checked' : '' ?>>
                    <label for="true_option" class="ml-2 block text-sm text-gray-700">True</label>
                </div>
                <div class="flex items-center">
                    <input type="radio" name="true_false" id="false_option" value="false" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300" <?= $false_is_correct ? 'checked' : '' ?>>
                    <label for="false_option" class="ml-2 block text-sm text-gray-700">False</label>
                </div>
            </div>
        </div>
        <?php elseif ($question->question_type == 'short_answer'): ?>
        <!-- Short Answer Options -->
        <div id="shortAnswerOptions" class="mb-6 border-t border-gray-200 pt-6">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Accepted Answers</h2>
            
            <div>
                <label for="correct_answers" class="block text-sm font-medium text-gray-700 mb-1">Correct Answers (comma-separated) *</label>
                <?php 
                $correct_answers = [];
                foreach ($answers as $answer) {
                    $correct_answers[] = $answer->answer_text;
                }
                ?>
                <textarea name="correct_answers" id="correct_answers" rows="2" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"><?= implode(', ', $correct_answers) ?></textarea>
                <p class="mt-1 text-sm text-gray-500">Enter all acceptable answers separated by commas (e.g., "answer1, answer2, answer3")</p>
            </div>
        </div>
        <?php endif; ?>
        
        <!-- Form Actions -->
        <div class="flex justify-between pt-6 border-t border-gray-200">
            <a href="<?= base_url('instructor/edit_quiz/' . $quiz->id) ?>" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded">
                Cancel
            </a>
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded">
                Update Question
            </button>
        </div>
    <?= form_close() ?>
</div>

<?php if ($question->question_type == 'multiple_choice'): ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const addAnswerOptionBtn = document.getElementById('addAnswerOption');
    const answerOptionsContainer = document.getElementById('answerOptionsContainer');
    
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
                <input type="hidden" name="answer_id[${optionCount}]" value="new">
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
    addAnswerOptionBtn.addEventListener('click', addAnswerOption);
    document.querySelectorAll('.remove-option').forEach(button => {
        button.addEventListener('click', removeAnswerOption);
    });
    
    // Initialize
    updateRemoveButtons();
});
</script>
<?php endif; ?> 
