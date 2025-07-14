<!-- Page Header -->
<div class="bg-white shadow rounded-lg p-4 sm:p-6 xl:p-8 mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-gray-900 mb-2"><?= $title ?></h1>
            <p class="text-sm text-gray-600">
                View student results for <span class="font-semibold"><?= $quiz->title ?></span>
            </p>
        </div>
        <div class="flex space-x-2">
            <a href="<?= base_url('instructor/quizzes/' . $course->id) ?>" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded inline-flex items-center text-sm">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Quizzes
            </a>
            <a href="<?= base_url('instructor/edit_quiz/' . $quiz->id) ?>" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded inline-flex items-center text-sm">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit Quiz
            </a>
        </div>
    </div>
</div>

<!-- Quiz Statistics -->
<div class="bg-white shadow rounded-lg p-4 sm:p-6 xl:p-8 mb-6">
    <h2 class="text-lg font-medium text-gray-900 mb-6">Quiz Statistics</h2>
    
    <?php
    // Calculate statistics
    $total_attempts = count($attempts);
    $pass_count = 0;
    $total_score = 0;
    $highest_score = 0;
    $lowest_score = 100;
    
    foreach ($attempts as $attempt) {
        $total_score += $attempt->score;
        $pass_count += ($attempt->passed) ? 1 : 0;
        $highest_score = max($highest_score, $attempt->score);
        $lowest_score = min($lowest_score, $attempt->score);
    }
    
    $average_score = $total_attempts > 0 ? round($total_score / $total_attempts, 1) : 0;
    $pass_rate = $total_attempts > 0 ? round(($pass_count / $total_attempts) * 100, 1) : 0;
    ?>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Attempts -->
        <div class="bg-gray-50 rounded-lg p-4">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-gray-200 text-gray-800">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500 font-medium">Total Attempts</p>
                    <p class="text-2xl font-bold text-gray-900"><?= $total_attempts ?></p>
                </div>
            </div>
        </div>
        
        <!-- Pass Rate -->
        <div class="bg-gray-50 rounded-lg p-4">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-800">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500 font-medium">Pass Rate</p>
                    <p class="text-2xl font-bold text-gray-900"><?= $pass_rate ?>%</p>
                </div>
            </div>
        </div>
        
        <!-- Average Score -->
        <div class="bg-gray-50 rounded-lg p-4">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-800">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500 font-medium">Average Score</p>
                    <p class="text-2xl font-bold text-gray-900"><?= $average_score ?>%</p>
                </div>
            </div>
        </div>
        
        <!-- Score Range -->
        <div class="bg-gray-50 rounded-lg p-4">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-800">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500 font-medium">Score Range</p>
                    <p class="text-2xl font-bold text-gray-900"><?= $lowest_score ?>% - <?= $highest_score ?>%</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quiz Attempts -->
<div class="bg-white shadow rounded-lg p-4 sm:p-6 xl:p-8">
    <h2 class="text-lg font-medium text-gray-900 mb-6">Student Attempts</h2>
    
    <?php if (empty($attempts)): ?>
        <div class="text-center py-8">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No attempts yet</h3>
            <p class="mt-1 text-sm text-gray-500">No students have attempted this quiz yet.</p>
        </div>
    <?php else: ?>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Attempt Date</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time Taken</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Score</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($attempts as $attempt): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-8 w-8 flex items-center justify-center bg-gray-100 rounded-full">
                                        <span class="font-medium text-gray-800"><?= substr($attempt->full_name, 0, 1) ?></span>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900"><?= $attempt->full_name ?></div>
                                        <div class="text-sm text-gray-500"><?= $attempt->username ?></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900"><?= date('M j, Y', strtotime($attempt->completed_at)) ?></div>
                                <div class="text-sm text-gray-500"><?= date('g:i A', strtotime($attempt->completed_at)) ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
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
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <?= number_format($attempt->score, 1) ?>%
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if ($attempt->passed): ?>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Passed
                                    </span>
                                <?php else: ?>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Failed
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="<?= base_url('instructor/view_attempt/' . $attempt->id) ?>" class="text-indigo-600 hover:text-indigo-900">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<!-- Export Section -->
<div class="mt-6 bg-white shadow rounded-lg p-4 sm:p-6 xl:p-8">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-medium text-gray-900">Export Results</h2>
        <div class="flex space-x-2">
            <a href="#" class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold py-2 px-4 rounded inline-flex items-center text-sm">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                </svg>
                Export CSV
            </a>
            <a href="#" class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold py-2 px-4 rounded inline-flex items-center text-sm">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                </svg>
                Export PDF
            </a>
        </div>
    </div>
    <p class="text-sm text-gray-600">Export quiz results for record keeping or further analysis.</p>
</div> 
