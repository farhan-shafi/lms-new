<!-- Page Header -->
<div class="bg-white shadow rounded-lg p-4 sm:p-6 xl:p-8 mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-gray-900 mb-2"><?= $title ?></h1>
            <p class="text-sm text-gray-600">
                Student: <span class="font-semibold"><?= $attempt->full_name ?></span> (<?= $attempt->username ?>)
            </p>
        </div>
        <div class="flex space-x-2">
            <a href="<?= base_url('instructor/quiz_results/' . $quiz->id) ?>" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded inline-flex items-center text-sm">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Results
            </a>
        </div>
    </div>
</div>

<!-- Attempt Summary -->
<div class="bg-white shadow rounded-lg p-4 sm:p-6 xl:p-8 mb-6">
    <h2 class="text-lg font-medium text-gray-900 mb-6">Attempt Summary</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-gray-50 rounded-lg p-4">
            <p class="text-sm text-gray-500 font-medium">Date</p>
            <p class="text-lg font-bold text-gray-900"><?= date('M j, Y', strtotime($attempt->completed_at)) ?></p>
            <p class="text-sm text-gray-500"><?= date('g:i A', strtotime($attempt->completed_at)) ?></p>
        </div>
        
        <div class="bg-gray-50 rounded-lg p-4">
            <p class="text-sm text-gray-500 font-medium">Time Taken</p>
            <p class="text-lg font-bold text-gray-900">
                <?php
                $started = new DateTime($attempt->started_at);
                $completed = new DateTime($attempt->completed_at);
                $interval = $started->diff($completed);
                
                if ($interval->h > 0) {
                    echo $interval->format('%h hr %i min');
                } else {
                    echo $interval->format('%i min %s sec');
                }
                ?>
            </p>
        </div>
        
        <div class="bg-gray-50 rounded-lg p-4">
            <p class="text-sm text-gray-500 font-medium">Score</p>
            <p class="text-lg font-bold text-gray-900"><?= number_format($attempt->score, 1) ?>%</p>
            <p class="text-sm text-gray-500">Pass threshold: <?= $quiz->pass_percentage ?>%</p>
        </div>
        
        <div class="bg-gray-50 rounded-lg p-4">
            <p class="text-sm text-gray-500 font-medium">Result</p>
            <?php if ($attempt->passed): ?>
                <p class="text-lg font-bold text-green-600">PASSED</p>
            <?php else: ?>
                <p class="text-lg font-bold text-red-600">FAILED</p>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Progress Bar -->
    <div class="w-full bg-gray-200 rounded-full h-4 mb-2">
        <div class="bg-<?= $attempt->passed ? 'green' : 'red' ?>-600 h-4 rounded-full" style="width: <?= $attempt->score ?>%"></div>
    </div>
    <p class="text-sm text-gray-500 text-right">Score: <?= number_format($attempt->score, 1) ?>%</p>
</div>

<!-- Questions and Answers -->
<div class="bg-white shadow rounded-lg p-4 sm:p-6 xl:p-8">
    <h2 class="text-lg font-medium text-gray-900 mb-6">Questions and Answers</h2>
    
    <?php if (empty($questions)): ?>
        <div class="text-center py-8">
            <p class="text-gray-600">No questions found for this attempt.</p>
        </div>
    <?php else: ?>
        <div class="space-y-6">
            <?php foreach ($questions as $index => $question): ?>
                <div class="border border-gray-200 rounded-lg p-4">
                    <div class="flex items-start mb-4">
                        <div class="flex-shrink-0 h-8 w-8 flex items-center justify-center <?= isset($question->is_correct) && $question->is_correct ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?> rounded-full mr-4">
                            <?= $index + 1 ?>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-medium text-gray-900"><?= htmlspecialchars($question->question_text) ?></h3>
                            <p class="text-sm text-gray-500 mt-1">
                                <?= ucfirst($question->question_type) ?> · <?= $question->points ?> point<?= $question->points != 1 ? 's' : '' ?>
                                <?php if (isset($question->points_earned)): ?>
                                    · Earned: <?= $question->points_earned ?> point<?= $question->points_earned != 1 ? 's' : '' ?>
                                <?php endif; ?>
                            </p>
                        </div>
                        <div class="ml-4">
                            <?php if (isset($question->is_correct)): ?>
                                <?php if ($question->is_correct): ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <svg class="mr-1 h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Correct
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <svg class="mr-1 h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        Incorrect
                                    </span>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <?php if ($question->question_type == 'multiple_choice'): ?>
                        <div class="pl-12 space-y-2">
                            <?php foreach ($question->answers as $answer): ?>
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-5 w-5 mr-2">
                                        <?php if ($answer->id == $question->answer_id && $answer->is_correct): ?>
                                            <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        <?php elseif ($answer->id == $question->answer_id && !$answer->is_correct): ?>
                                            <svg class="h-5 w-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        <?php elseif ($answer->is_correct): ?>
                                            <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        <?php else: ?>
                                            <div class="h-5 w-5 border border-gray-300 rounded-full"></div>
                                        <?php endif; ?>
                                    </div>
                                    <span class="text-sm <?= $answer->is_correct ? 'font-medium' : '' ?> <?= $answer->id == $question->answer_id ? 'text-gray-900' : 'text-gray-600' ?>">
                                        <?= htmlspecialchars($answer->answer_text) ?>
                                        <?php if ($answer->is_correct): ?>
                                            <span class="text-xs text-green-600 ml-2">(Correct answer)</span>
                                        <?php endif; ?>
                                    </span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php elseif ($question->question_type == 'true_false'): ?>
                        <div class="pl-12 space-y-2">
                            <?php foreach ($question->answers as $answer): ?>
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-5 w-5 mr-2">
                                        <?php if ($answer->id == $question->answer_id && $answer->is_correct): ?>
                                            <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        <?php elseif ($answer->id == $question->answer_id && !$answer->is_correct): ?>
                                            <svg class="h-5 w-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        <?php elseif ($answer->is_correct): ?>
                                            <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        <?php else: ?>
                                            <div class="h-5 w-5 border border-gray-300 rounded-full"></div>
                                        <?php endif; ?>
                                    </div>
                                    <span class="text-sm <?= $answer->is_correct ? 'font-medium' : '' ?> <?= $answer->id == $question->answer_id ? 'text-gray-900' : 'text-gray-600' ?>">
                                        <?= $answer->answer_text ?>
                                        <?php if ($answer->is_correct): ?>
                                            <span class="text-xs text-green-600 ml-2">(Correct answer)</span>
                                        <?php endif; ?>
                                    </span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php elseif ($question->question_type == 'short_answer'): ?>
                        <div class="pl-12">
                            <div class="mb-2">
                                <p class="text-sm font-medium text-gray-700">Student's Answer:</p>
                                <div class="mt-1 p-2 bg-gray-50 border border-gray-200 rounded">
                                    <p class="text-sm text-gray-900"><?= htmlspecialchars($question->text_answer ?? 'No answer provided') ?></p>
                                </div>
                            </div>
                            
                            <div>
                                <p class="text-sm font-medium text-gray-700">Accepted Answers:</p>
                                <div class="mt-1 space-y-1">
                                    <?php foreach ($question->answers as $answer): ?>
                                        <p class="text-sm text-green-600"><?= htmlspecialchars($answer->answer_text) ?></p>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<!-- Feedback Section -->
<div class="mt-6 bg-white shadow rounded-lg p-4 sm:p-6 xl:p-8">
    <h2 class="text-lg font-medium text-gray-900 mb-4">Instructor Feedback</h2>
    
    <?php if ($this->session->flashdata('success')): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline"><?= $this->session->flashdata('success') ?></span>
        </div>
    <?php endif; ?>
    
    <form action="<?= base_url('instructor/view_attempt/' . $attempt->id) ?>" method="post" class="space-y-4">
        <div>
            <label for="feedback" class="block text-sm font-medium text-gray-700 mb-1">Feedback (Optional)</label>
            <textarea id="feedback" name="feedback" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Provide feedback to the student about their quiz performance..."><?= isset($attempt->feedback) ? htmlspecialchars($attempt->feedback) : '' ?></textarea>
        </div>
        
        <div class="flex justify-end">
            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Send Feedback
            </button>
        </div>
    </form>
</div> 
