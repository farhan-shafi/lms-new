<!-- Page Header -->
<div class="bg-white shadow rounded-lg p-4 sm:p-6 xl:p-8 mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-gray-900 mb-2"><?= $title ?></h1>
            <p class="text-sm text-gray-600">
                Your results for <span class="font-semibold"><?= $quiz->title ?></span>
            </p>
        </div>
        <div class="flex space-x-2">
            <a href="<?= base_url('student/quizzes/' . $course->id) ?>" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded inline-flex items-center text-sm">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Quizzes
            </a>
        </div>
    </div>
</div>

<!-- Result Summary -->
<div class="bg-white shadow rounded-lg p-4 sm:p-6 xl:p-8 mb-6">
    <div class="text-center py-6">
        <?php if ($attempt->passed): ?>
            <div class="mx-auto h-24 w-24 flex items-center justify-center rounded-full bg-green-100 text-green-600 mb-4">
                <svg class="h-16 w-16" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-green-600 mb-2">Congratulations!</h2>
            <p class="text-lg text-gray-700 mb-4">You passed the quiz with a score of <span class="font-bold"><?= number_format($attempt->score, 1) ?>%</span></p>
        <?php else: ?>
            <div class="mx-auto h-24 w-24 flex items-center justify-center rounded-full bg-red-100 text-red-600 mb-4">
                <svg class="h-16 w-16" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-red-600 mb-2">Not Quite There</h2>
            <p class="text-lg text-gray-700 mb-4">You scored <span class="font-bold"><?= number_format($attempt->score, 1) ?>%</span>. The passing score is <?= $quiz->pass_percentage ?>%.</p>
        <?php endif; ?>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-gray-50 rounded-lg p-4">
            <p class="text-sm text-gray-500 font-medium">Your Score</p>
            <p class="text-2xl font-bold <?= $attempt->passed ? 'text-green-600' : 'text-red-600' ?>"><?= number_format($attempt->score, 1) ?>%</p>
            <p class="text-sm text-gray-500">Pass threshold: <?= $quiz->pass_percentage ?>%</p>
        </div>
        
        <div class="bg-gray-50 rounded-lg p-4">
            <p class="text-sm text-gray-500 font-medium">Time Taken</p>
            <p class="text-2xl font-bold text-gray-900">
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
            <p class="text-sm text-gray-500 font-medium">Completed On</p>
            <p class="text-2xl font-bold text-gray-900"><?= date('M j, Y', strtotime($attempt->completed_at)) ?></p>
            <p class="text-sm text-gray-500"><?= date('g:i A', strtotime($attempt->completed_at)) ?></p>
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
    <h2 class="text-lg font-medium text-gray-900 mb-6">Your Answers</h2>
    
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
                            <?php if (isset($question->answers) && is_array($question->answers)): ?>
                                <?php foreach ($question->answers as $answer): ?>
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-5 w-5 mr-2">
                                            <?php if (isset($question->answer_id) && $answer->id == $question->answer_id && $answer->is_correct): ?>
                                                <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            <?php elseif (isset($question->answer_id) && $answer->id == $question->answer_id && !$answer->is_correct): ?>
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
                                        <span class="text-sm <?= $answer->is_correct ? 'font-medium' : '' ?> <?= isset($question->answer_id) && $answer->id == $question->answer_id ? 'text-gray-900' : 'text-gray-600' ?>">
                                            <?= htmlspecialchars($answer->answer_text) ?>
                                            <?php if ($answer->is_correct): ?>
                                                <span class="text-xs text-green-600 ml-2">(Correct answer)</span>
                                            <?php endif; ?>
                                        </span>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    <?php elseif ($question->question_type == 'true_false'): ?>
                        <div class="pl-12 space-y-2">
                            <?php if (isset($question->answers) && is_array($question->answers)): ?>
                                <?php foreach ($question->answers as $answer): ?>
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-5 w-5 mr-2">
                                            <?php if (isset($question->answer_id) && $answer->id == $question->answer_id && $answer->is_correct): ?>
                                                <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            <?php elseif (isset($question->answer_id) && $answer->id == $question->answer_id && !$answer->is_correct): ?>
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
                                        <span class="text-sm <?= $answer->is_correct ? 'font-medium' : '' ?> <?= isset($question->answer_id) && $answer->id == $question->answer_id ? 'text-gray-900' : 'text-gray-600' ?>">
                                            <?= $answer->answer_text ?>
                                            <?php if ($answer->is_correct): ?>
                                                <span class="text-xs text-green-600 ml-2">(Correct answer)</span>
                                            <?php endif; ?>
                                        </span>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    <?php elseif ($question->question_type == 'short_answer'): ?>
                        <div class="pl-12">
                            <div class="mb-2">
                                <p class="text-sm font-medium text-gray-700">Your Answer:</p>
                                <div class="mt-1 p-2 bg-gray-50 border border-gray-200 rounded">
                                    <p class="text-sm text-gray-900"><?= htmlspecialchars($question->text_answer ?? 'No answer provided') ?></p>
                                </div>
                            </div>
                            
                            <div>
                                <p class="text-sm font-medium text-gray-700">Accepted Answers:</p>
                                <div class="mt-1 space-y-1">
                                    <?php if (isset($question->answers) && is_array($question->answers)): ?>
                                        <?php foreach ($question->answers as $answer): ?>
                                            <p class="text-sm text-green-600"><?= htmlspecialchars($answer->answer_text) ?></p>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<!-- Action Buttons -->
<div class="mt-6 flex justify-between">
    <a href="<?= base_url('student/quizzes/' . $course->id) ?>" class="bg-gray-50 text-gray-700 font-medium py-2 px-4 rounded-lg shadow-sm hover:shadow hover:bg-gray-100 transition-all transform hover:scale-102 inline-flex items-center">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Back to Quizzes
    </a>
    
    <a href="<?= base_url('student/take_quiz/' . $quiz->id) ?>" class="bg-blue-50 text-blue-700 font-medium py-2 px-4 rounded-lg shadow-sm hover:shadow hover:bg-blue-100 transition-all transform hover:scale-102 inline-flex items-center">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
        </svg>
        Take Quiz Again
    </a>
</div> 
