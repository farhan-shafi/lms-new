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

<!-- Quizzes Grid -->
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
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($quizzes as $quiz): ?>
                <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 flex flex-col h-full">
                    <!-- Card Header with Gradient Background -->
                    <div class="p-5 bg-gradient-to-r from-blue-500 to-indigo-600 text-white">
                        <h3 class="text-lg font-bold mb-1 truncate"><?= $quiz->title ?></h3>
                        <?php if (isset($quiz->question_count)): ?>
                            <div class="flex items-center text-blue-100 text-sm">
                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <?= isset($quiz->question_count) ? $quiz->question_count : 0 ?> Questions
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Card Body -->
                    <div class="p-5 flex-grow">
                        <?php if (!empty($quiz->description)): ?>
                            <p class="text-gray-600 text-sm mb-4"><?= character_limiter($quiz->description, 100) ?></p>
                        <?php endif; ?>
                        
                        <!-- Quiz Details -->
                        <div class="grid grid-cols-2 gap-3 text-xs text-gray-600 mb-4">
                            <?php if ($quiz->time_limit): ?>
                                <div class="flex items-center">
                                    <svg class="h-4 w-4 text-gray-400 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span><?= $quiz->time_limit ?> min</span>
                                </div>
                            <?php endif; ?>
                            
                            <div class="flex items-center">
                                <svg class="h-4 w-4 text-gray-400 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Pass: <?= $quiz->pass_percentage ?>%</span>
                            </div>
                            
                            <?php if (isset($quiz->attempts_allowed)): ?>
                                <div class="flex items-center">
                                    <svg class="h-4 w-4 text-gray-400 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                    <span><?= $quiz->attempts_allowed == -1 ? 'Unlimited' : $quiz->attempts_allowed . ' tries' ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Quiz Status -->
                        <?php if (!empty($quiz->attempts)): ?>
                            <?php 
                                $latest_attempt = $quiz->attempts[0];
                                $is_in_progress = $latest_attempt->completed_at === null;
                            ?>
                            
                            <?php if ($is_in_progress): ?>
                                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-3 rounded-md mb-4">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-yellow-800">Attempt in progress</p>
                                            <p class="text-xs text-yellow-700 mt-1">Started <?= date('M j, g:i A', strtotime($latest_attempt->started_at)) ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php elseif ($quiz->has_passed): ?>
                                <div class="bg-green-50 border-l-4 border-green-400 p-3 rounded-md mb-4">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-green-800">Quiz passed!</p>
                                            <p class="text-xs text-green-700 mt-1">Best score: <?= number_format($latest_attempt->score, 1) ?>%</p>
                                        </div>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="bg-blue-50 border-l-4 border-blue-400 p-3 rounded-md mb-4">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-blue-800">Previous attempt</p>
                                            <p class="text-xs text-blue-700 mt-1">Score: <?= number_format($latest_attempt->score, 1) ?>% (<?= $latest_attempt->passed ? 'Passed' : 'Failed' ?>)</p>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Attempt History -->
                            <?php if (count($quiz->attempts) > 1): ?>
                                <div class="flex flex-wrap gap-1 mb-4">
                                    <?php foreach (array_slice($quiz->attempts, 0, 3) as $index => $attempt): ?>
                                        <div class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium <?= $attempt->completed_at ? ($attempt->passed ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') : 'bg-yellow-100 text-yellow-800' ?>">
                                            <?= date('M j', strtotime($attempt->started_at)) ?>: 
                                            <?php if ($attempt->completed_at): ?>
                                                <?= number_format($attempt->score, 1) ?>%
                                            <?php else: ?>
                                                In Progress
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                    
                                    <?php if (count($quiz->attempts) > 3): ?>
                                        <div class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            +<?= count($quiz->attempts) - 3 ?> more
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Card Footer -->
                    <div class="p-4 bg-gray-50 border-t border-gray-100">
                        <a href="<?= base_url('student/take_quiz/' . $quiz->id) ?>" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                            <?php if (!empty($quiz->attempts) && $quiz->has_passed): ?>
                                <svg class="h-4 w-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                Review Quiz
                            <?php elseif (!empty($quiz->attempts) && $quiz->attempts[0]->completed_at === null): ?>
                                <svg class="h-4 w-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Continue Quiz
                            <?php elseif (!empty($quiz->attempts)): ?>
                                <svg class="h-4 w-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                Retake Quiz
                            <?php else: ?>
                                <svg class="h-4 w-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Start Quiz
                            <?php endif; ?>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div> 
