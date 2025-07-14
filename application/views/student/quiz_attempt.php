<!-- Quiz Header -->
<div class="bg-white shadow rounded-lg p-6 mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 mb-2"><?= $quiz->title ?></h1>
            <p class="text-gray-600">
                <a href="<?= base_url('student/course/' . $course->id) ?>" class="text-blue-600 hover:text-blue-800">
                    <?= $course->title ?>
                </a>
            </p>
        </div>
        
        <?php if ($quiz->time_limit): ?>
            <div class="bg-blue-50 border border-blue-200 rounded-lg px-4 py-2 text-center">
                <div class="text-sm text-blue-800 font-medium">Time Remaining</div>
                <div id="timer" class="text-xl font-bold text-blue-800" data-time-limit="<?= $quiz->time_limit ?>" data-started-at="<?= strtotime($attempt->started_at) ?>">
                    <?= $quiz->time_limit ?>:00
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Quiz Content -->
<div class="bg-white shadow rounded-lg p-6 mb-6">
    <form id="quiz-form" method="post" action="<?= current_url() ?>">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
        <?php if (empty($questions)): ?>
            <div class="text-center py-8">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No questions available</h3>
                <p class="mt-1 text-sm text-gray-500">This quiz doesn't have any questions yet.</p>
                <div class="mt-6">
                    <a href="<?= base_url('student/quizzes/' . $course->id) ?>" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700">
                        Back to Quizzes
                    </a>
                </div>
            </div>
        <?php else: ?>
            <div class="mb-6">
                <h2 class="text-lg font-medium text-gray-900 mb-2">Instructions</h2>
                <div class="bg-gray-50 rounded-lg p-4 text-sm text-gray-600">
                    <p>Answer all questions and click "Submit Quiz" when you're done. There are <?= count($questions) ?> questions in this quiz.</p>
                    <?php if ($quiz->time_limit): ?>
                        <p class="mt-2">You have <?= $quiz->time_limit ?> minutes to complete this quiz. The timer started when you began the quiz.</p>
                    <?php endif; ?>
                    <p class="mt-2">You need to score at least <?= $quiz->pass_percentage ?>% to pass this quiz.</p>
                </div>
            </div>
            
            <div class="space-y-8">
                <?php foreach ($questions as $index => $question): ?>
                    <div class="border border-gray-200 rounded-lg p-6" id="question-<?= $question->id ?>">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">
                                    Question <?= $index + 1 ?>
                                    <?php if ($question->points > 0): ?>
                                        <span class="text-sm text-gray-500 ml-2">(<?= $question->points ?> points)</span>
                                    <?php endif; ?>
                                </h3>
                                <div class="mt-2 prose max-w-none">
                                    <?= $question->question_text ?>
                                </div>
                            </div>
                            <div class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
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
                            </div>
                        </div>
                        
                        <?php if ($question->question_type == 'multiple_choice'): ?>
                            <div class="mt-4 space-y-4">
                                <?php foreach ($question->answers as $answer): ?>
                                    <div class="flex items-center">
                                        <input id="answer-<?= $answer->id ?>" name="question_<?= $question->id ?>" type="radio" value="<?= $answer->id ?>" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                        <label for="answer-<?= $answer->id ?>" class="ml-3 block text-sm font-medium text-gray-700">
                                            <?= $answer->answer_text ?>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php elseif ($question->question_type == 'true_false'): ?>
                            <div class="mt-4 space-y-4">
                                <div class="flex items-center">
                                    <input id="answer-<?= $question->id ?>-true" name="question_<?= $question->id ?>" type="radio" value="true" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <label for="answer-<?= $question->id ?>-true" class="ml-3 block text-sm font-medium text-gray-700">
                                        True
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input id="answer-<?= $question->id ?>-false" name="question_<?= $question->id ?>" type="radio" value="false" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <label for="answer-<?= $question->id ?>-false" class="ml-3 block text-sm font-medium text-gray-700">
                                        False
                                    </label>
                                </div>
                            </div>
                        <?php elseif ($question->question_type == 'short_answer'): ?>
                            <div class="mt-4">
                                <input type="text" name="question_<?= $question->id ?>" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Your answer">
                                <p class="mt-2 text-sm text-gray-500">Enter your answer in the text field above.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="mt-8 flex items-center justify-between">
                <a href="<?= base_url('student/take_quiz/' . $quiz->id) ?>" class="text-blue-600 hover:text-blue-800" onclick="return confirm('Are you sure you want to leave? Your progress will be saved, but the quiz will not be submitted.');">
                    Save and exit
                </a>
                <div>
                    <input type="submit" name="submit_quiz" value="Submit Quiz" class="inline-flex items-center px-6 py-3 text-base font-medium rounded-lg shadow-sm text-blue-700 bg-blue-50 hover:bg-blue-100 hover:shadow transition-all transform hover:scale-102">
                </div>
            </div>
        <?php endif; ?>
    </form>
</div>

<!-- Quiz Navigation -->
<div class="bg-white shadow rounded-lg p-4">
    <div class="flex flex-wrap gap-2">
        <?php foreach ($questions as $index => $question): ?>
            <a href="#question-<?= $question->id ?>" class="question-nav-btn inline-flex items-center justify-center h-8 w-8 rounded-full bg-gray-200 text-gray-800 text-sm font-medium hover:bg-gray-300" data-question-id="<?= $question->id ?>">
                <?= $index + 1 ?>
            </a>
        <?php endforeach; ?>
    </div>
</div>

<!-- JavaScript for Quiz -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Timer functionality
    const timerElement = document.getElementById('timer');
    if (timerElement) {
        const timeLimit = parseInt(timerElement.getAttribute('data-time-limit'));
        const startedAt = parseInt(timerElement.getAttribute('data-started-at'));
        const now = Math.floor(Date.now() / 1000);
        const elapsedMinutes = Math.floor((now - startedAt) / 60);
        const remainingMinutes = Math.max(0, timeLimit - elapsedMinutes);
        const remainingSeconds = 59 - (Math.floor((now - startedAt) % 60));
        
        let minutes = remainingMinutes;
        let seconds = remainingSeconds;
        
        if (minutes <= 0 && seconds <= 0) {
            // Time's up, auto-submit the form
            document.getElementById('quiz-form').submit();
            return;
        }
        
        // Update timer every second
        const timerInterval = setInterval(function() {
            seconds--;
            if (seconds < 0) {
                minutes--;
                seconds = 59;
            }
            
            if (minutes <= 0 && seconds <= 0) {
                clearInterval(timerInterval);
                alert('Time is up! Your quiz will be submitted automatically.');
                document.getElementById('quiz-form').submit();
            }
            
            timerElement.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            
            // Change color when time is running out
            if (minutes === 0 && seconds <= 30) {
                timerElement.classList.add('text-red-600');
                timerElement.classList.add('animate-pulse');
            }
        }, 1000);
    }
    
    // Question navigation
    const questionNavBtns = document.querySelectorAll('.question-nav-btn');
    const radioInputs = document.querySelectorAll('input[type="radio"]');
    const textInputs = document.querySelectorAll('input[type="text"]');
    
    // Mark questions as answered
    function updateQuestionStatus() {
        questionNavBtns.forEach(btn => {
            const questionId = btn.getAttribute('data-question-id');
            const questionInputs = document.querySelectorAll(`input[name="question_${questionId}"]`);
            let isAnswered = false;
            
            questionInputs.forEach(input => {
                if ((input.type === 'radio' && input.checked) || 
                    (input.type === 'text' && input.value.trim() !== '')) {
                    isAnswered = true;
                }
            });
            
            if (isAnswered) {
                btn.classList.remove('bg-gray-200');
                btn.classList.add('bg-green-500');
                btn.classList.add('text-white');
            } else {
                btn.classList.remove('bg-green-500');
                btn.classList.remove('text-white');
                btn.classList.add('bg-gray-200');
            }
        });
    }
    
    // Add event listeners to inputs
    radioInputs.forEach(input => {
        input.addEventListener('change', updateQuestionStatus);
    });
    
    textInputs.forEach(input => {
        input.addEventListener('input', updateQuestionStatus);
    });
    
    // Simple form submission
    const form = document.getElementById('quiz-form');
    form.addEventListener('submit', function(e) {
        console.log('Form submission triggered');
        const unansweredCount = document.querySelectorAll('.question-nav-btn:not(.bg-green-500)').length;
        
        if (unansweredCount > 0) {
            const confirmSubmit = confirm(`You have ${unansweredCount} unanswered question(s). Are you sure you want to submit the quiz?`);
            if (!confirmSubmit) {
                e.preventDefault();
                console.log('Form submission cancelled');
                return false;
            }
        }
        
        console.log('Form being submitted');
        return true;
    });
    
    // Initial update
    updateQuestionStatus();
});
</script> 
