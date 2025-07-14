<!-- Page Header -->

<div class="bg-white shadow rounded-lg p-4 sm:p-6 xl:p-8 mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-gray-900 mb-2">Course Quizzes</h1>
            <p class="text-sm text-gray-600">
                <a href="<?= base_url('student/course/' . $course->id) ?>" class="text-blue-600 hover:text-blue-800">
                    <?= $course->title ?>
                </a>
            </p>
        </div>
        <a href="<?= base_url('student/course/' . $course->id) ?>" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded inline-flex items-center text-sm">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Course
        </a>
    </div>
</div>

<!-- Quizzes List -->
<div class="bg-white shadow rounded-lg p-4 sm:p-6 xl:p-8">
    <?php if (empty($quizzes)): ?>
        <div class="text-center py-8">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No quizzes available</h3>
            <p class="mt-1 text-sm text-gray-500">This course doesn't have any quizzes yet.</p>
        </div>
    <?php else: ?>
        <div class="space-y-6">
            <?php foreach ($quizzes as $quiz): ?>
                <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition-shadow">
                    <div class="p-6">
                        <div class="flex items-start justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2"><?= $quiz->title ?></h3>
                                <?php if (!empty($quiz->description)): ?>
                                    <p class="text-gray-600 text-sm mb-4"><?= character_limiter($quiz->description, 150) ?></p>
                                <?php endif; ?>
                                
                                <div class="flex flex-wrap gap-4 text-sm text-gray-600 mb-4">
                                    <div class="flex items-center">
                                        <svg class="h-5 w-5 text-gray-400 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <span><?= isset($quiz->question_count) ? $quiz->question_count : 0 ?> Questions</span>
                                    </div>
                                    
                                    <?php if ($quiz->time_limit): ?>
                                        <div class="flex items-center">
                                            <svg class="h-5 w-5 text-gray-400 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span><?= $quiz->time_limit ?> minutes</span>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="flex items-center">
                                        <svg class="h-5 w-5 text-gray-400 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span>Pass: <?= $quiz->pass_percentage ?>%</span>
                                    </div>
                                    
                                    <?php if (isset($quiz->attempts_allowed)): ?>
                                        <div class="flex items-center">
                                            <svg class="h-5 w-5 text-gray-400 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                            </svg>
                                            <span>Attempts: <?= $quiz->attempts_allowed == -1 ? 'Unlimited' : $quiz->attempts_allowed ?></span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <?php if (!empty($quiz->attempts)): ?>
                                    <?php 
                                        $latest_attempt = $quiz->attempts[0];
                                        $is_in_progress = $latest_attempt->completed_at === null;
                                    ?>
                                    <div class="mb-4">
                                        <?php if ($is_in_progress): ?>
                                            <div class="bg-yellow-100 border border-yellow-200 rounded-md p-3">
                                                <div class="flex">
                                                    <div class="flex-shrink-0">
                                                        <svg class="h-5 w-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                                        </svg>
                                                    </div>
                                                    <div class="ml-3">
                                                        <h3 class="text-sm font-medium text-yellow-800">You have an unfinished attempt</h3>
                                                        <div class="mt-2 text-sm text-yellow-700">
                                                            <p>Started on <?= date('M j, Y g:i A', strtotime($latest_attempt->started_at)) ?></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php elseif ($quiz->has_passed): ?>
                                            <div class="bg-green-100 border border-green-200 rounded-md p-3">
                                                <div class="flex">
                                                    <div class="flex-shrink-0">
                                                        <svg class="h-5 w-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                    </div>
                                                    <div class="ml-3">
                                                        <h3 class="text-sm font-medium text-green-800">You've passed this quiz!</h3>
                                                        <div class="mt-2 text-sm text-green-700">
                                                            <p>Best score: <?= number_format($latest_attempt->score, 1) ?>%</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <div class="bg-blue-50 border border-blue-200 rounded-md p-3">
                                                <div class="flex">
                                                    <div class="flex-shrink-0">
                                                        <svg class="h-5 w-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                    </div>
                                                    <div class="ml-3">
                                                        <h3 class="text-sm font-medium text-blue-800">You've attempted this quiz</h3>
                                                        <div class="mt-2 text-sm text-blue-700">
                                                            <p>Last score: <?= number_format($latest_attempt->score, 1) ?>% (<?= $latest_attempt->passed ? 'Passed' : 'Failed' ?>)</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="ml-4">
                                <a href="<?= base_url('student/take_quiz/' . $quiz->id) ?>" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <?php if (!empty($quiz->attempts) && $quiz->has_passed): ?>
                                        Review Quiz
                                    <?php elseif (!empty($quiz->attempts) && $quiz->attempts[0]->completed_at === null): ?>
                                        Continue Quiz
                                    <?php elseif (!empty($quiz->attempts)): ?>
                                        Retake Quiz
                                    <?php else: ?>
                                        Start Quiz
                                    <?php endif; ?>
                                </a>
                            </div>
                        </div>
                        
                        <?php if (!empty($quiz->attempts)): ?>
                            <div class="mt-4 pt-4 border-t border-gray-200">
                                <h4 class="text-sm font-medium text-gray-700 mb-2">Your Attempts</h4>
                                <div class="flex flex-wrap gap-2">
                                    <?php foreach (array_slice($quiz->attempts, 0, 3) as $index => $attempt): ?>
                                        <div class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $attempt->completed_at ? ($attempt->passed ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') : 'bg-yellow-100 text-yellow-800' ?>">
                                            <?= date('M j', strtotime($attempt->started_at)) ?>: 
                                            <?php if ($attempt->completed_at): ?>
                                                <?= number_format($attempt->score, 1) ?>%
                                            <?php else: ?>
                                                In Progress
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                    
                                    <?php if (count($quiz->attempts) > 3): ?>
                                        <div class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            +<?= count($quiz->attempts) - 3 ?> more
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div> 
