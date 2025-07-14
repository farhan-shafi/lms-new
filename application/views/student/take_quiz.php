<!-- Quiz Header -->
<div class="bg-white shadow rounded-lg p-6 mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 mb-2"><?= $quiz->title ?></h1>
            <p class="text-gray-600">
                <a href="<?= base_url('student/course/' . $course->id) ?>" class="text-blue-600 hover:text-blue-800">
                    <?= $course->title ?>
                </a>
                <span class="mx-2">›</span>
                <a href="<?= base_url('student/quizzes/' . $course->id) ?>" class="text-blue-600 hover:text-blue-800">
                    Quizzes
                </a>
            </p>
        </div>
        <a href="<?= base_url('student/quizzes/' . $course->id) ?>" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2 px-4 rounded inline-flex items-center text-sm">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Quizzes
        </a>
    </div>
</div>

<!-- Quiz Info -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Content -->
    <div class="lg:col-span-2">
        <div class="bg-white shadow rounded-lg p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Quiz Information</h2>
            
            <?php if (!empty($quiz->description)): ?>
                <div class="prose max-w-none mb-6">
                    <?= $quiz->description ?>
                </div>
            <?php endif; ?>
            
            <div class="border-t border-gray-200 pt-4 mt-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Quiz Details</h3>
                        <div class="mt-2 space-y-2">
                            <div class="flex items-center text-sm">
                                <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span class="text-gray-900">Created: <?= date('M j, Y', strtotime($quiz->created_at)) ?></span>
                            </div>
                            
                            <?php 
                                $this->load->model('quiz_model');
                                $questions_count = count($this->quiz_model->get_quiz_questions($quiz->id));
                            ?>
                            <div class="flex items-center text-sm">
                                <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span class="text-gray-900"><?= $questions_count ?> Questions</span>
                            </div>
                            
                            <?php if ($quiz->time_limit): ?>
                                <div class="flex items-center text-sm">
                                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-gray-900">Time Limit: <?= $quiz->time_limit ?> minutes</span>
                                </div>
                            <?php endif; ?>
                            
                            <div class="flex items-center text-sm">
                                <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-gray-900">Passing Score: <?= $quiz->pass_percentage ?>%</span>
                            </div>
                            
                            <?php if (isset($quiz->attempts_allowed) && $quiz->attempts_allowed): ?>
                                <div class="flex items-center text-sm">
                                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                    <span class="text-gray-900">Attempts Allowed: <?= $quiz->attempts_allowed == -1 ? 'Unlimited' : $quiz->attempts_allowed ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Your Progress</h3>
                        <div class="mt-2">
                            <?php if (empty($attempts)): ?>
                                <p class="text-sm text-gray-600">You haven't attempted this quiz yet.</p>
                            <?php else: ?>
                                <p class="text-sm text-gray-600 mb-2">You've attempted this quiz <?= count($attempts) ?> time(s).</p>
                                <?php if ($has_passed): ?>
                                    <div class="bg-green-100 border border-green-200 rounded-md p-3 mb-3">
                                        <div class="flex">
                                            <div class="flex-shrink-0">
                                                <svg class="h-5 w-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </div>
                                            <div class="ml-3">
                                                <h3 class="text-sm font-medium text-green-800">You've passed this quiz!</h3>
                                                <div class="mt-2 text-sm text-green-700">
                                                    <p>Your highest score: <?= number_format($attempts[0]->score, 1) ?>%</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Start Quiz Button -->
            <div class="mt-6">
                <?php if ($is_in_progress): ?>
                    <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4 mb-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">You have an unfinished attempt</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>You started this quiz on <?= date('M j, Y g:i A', strtotime($latest_attempt->started_at)) ?> but haven't completed it yet.</p>
                                </div>
                                <div class="mt-4">
                                    <form method="post" action="<?= base_url('student/quiz_attempt/' . $latest_attempt->id) ?>">
                                        <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                                        <button type="submit" name="resume_quiz" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                            Resume Quiz
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <?php if (isset($quiz->attempts_allowed) && $quiz->attempts_allowed != -1 && count($attempts) >= $quiz->attempts_allowed): ?>
                        <div class="bg-red-50 border border-red-200 rounded-md p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800">Maximum attempts reached</h3>
                                    <div class="mt-2 text-sm text-red-700">
                                        <p>You've used all your allowed attempts for this quiz.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <form method="post" action="<?= base_url('student/quiz_attempt/' . $quiz->id) ?>">
                            <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                            <button type="submit" name="start_quiz" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <?php if (empty($attempts)): ?>
                                    <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                    Start Quiz
                                <?php else: ?>
                                    <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                    Attempt Quiz Again
                                <?php endif; ?>
                            </button>
                        </form>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Sidebar -->
    <div class="lg:col-span-1">
        <!-- Previous Attempts -->
        <div class="bg-white shadow rounded-lg p-6 mb-6">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Your Attempts</h2>
            
            <?php if (empty($attempts)): ?>
                <p class="text-sm text-gray-600">You haven't attempted this quiz yet.</p>
            <?php else: ?>
                <div class="space-y-4">
                    <?php foreach ($attempts as $attempt): ?>
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm text-gray-600">
                                    <?= date('M j, Y g:i A', strtotime($attempt->started_at)) ?>
                                </span>
                                <?php if ($attempt->completed_at): ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $attempt->passed ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                                        <?= $attempt->passed ? 'Passed' : 'Failed' ?>
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        In Progress
                                    </span>
                                <?php endif; ?>
                            </div>
                            
                            <?php if ($attempt->completed_at): ?>
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <svg class="h-5 w-5 text-gray-400 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                        </svg>
                                        <span class="text-sm font-medium text-gray-900">Score: <?= number_format($attempt->score, 1) ?>%</span>
                                    </div>
                                    <a href="<?= base_url('student/quiz_result/' . $attempt->id) ?>" class="text-blue-600 hover:text-blue-800 text-sm">
                                        View Results
                                    </a>
                                </div>
                            <?php else: ?>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Not completed</span>
                                    <form method="post" action="<?= base_url('student/quiz_attempt/' . $attempt->id) ?>">
                                        <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                                        <input type="hidden" name="resume_attempt_id" value="<?= $attempt->id ?>">
                                        <button type="submit" name="resume_quiz" class="text-blue-600 hover:text-blue-800 text-sm">
                                            Resume
                                        </button>
                                    </form>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Quiz Tips -->
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Quiz Tips</h2>
            <ul class="space-y-2 text-sm text-gray-600">
                <li class="flex items-start">
                    <svg class="h-5 w-5 text-blue-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Read each question carefully before answering.</span>
                </li>
                <li class="flex items-start">
                    <svg class="h-5 w-5 text-blue-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Make sure to submit your answers before the time limit expires.</span>
                </li>
                <li class="flex items-start">
                    <svg class="h-5 w-5 text-blue-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>You need to score at least <?= $quiz->pass_percentage ?>% to pass this quiz.</span>
                </li>
                <li class="flex items-start">
                    <svg class="h-5 w-5 text-blue-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Your highest score will be recorded for course completion.</span>
                </li>
            </ul>
        </div>
    </div>
</div> 
