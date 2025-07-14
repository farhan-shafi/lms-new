<!-- Lesson Header -->
<div class="bg-indigo-700 text-white py-8">
    <div class="container mx-auto px-4">
        <div class="mb-4">
            <a href="<?= base_url('home/course/' . $course->id) ?>" class="text-indigo-200 hover:text-white flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Course
            </a>
        </div>
        <h1 class="text-2xl font-bold"><?= $lesson->title ?></h1>
        <p class="text-indigo-200 mt-1"><?= $course->title ?></p>
    </div>
</div>

<!-- Lesson Content -->
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col lg:flex-row">
        <!-- Main Content -->
        <div class="lg:w-2/3 lg:pr-8">
            <!-- Video (if available) -->
            <?php if (!empty($lesson->video_url)): ?>
                <div class="bg-black rounded-lg shadow-md mb-6 aspect-w-16 aspect-h-9">
                    <?php
                    // Check if it's a YouTube URL
                    if (strpos($lesson->video_url, 'youtube.com') !== false || strpos($lesson->video_url, 'youtu.be') !== false) {
                        // Extract YouTube video ID
                        preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $lesson->video_url, $matches);
                        $youtube_id = isset($matches[1]) ? $matches[1] : '';
                        
                        if ($youtube_id) {
                            echo '<iframe class="w-full h-96 rounded-lg" src="https://www.youtube.com/embed/' . $youtube_id . '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
                        } else {
                            echo '<div class="w-full h-96 bg-gray-200 flex items-center justify-center rounded-lg"><p>Invalid YouTube URL</p></div>';
                        }
                    } else {
                        // For other video sources
                        echo '<video class="w-full h-96 rounded-lg" controls><source src="' . $lesson->video_url . '" type="video/mp4">Your browser does not support the video tag.</video>';
                    }
                    ?>
                </div>
            <?php endif; ?>
            
            <!-- Lesson Content -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-2xl font-bold mb-4">Lesson Content</h2>
                <div class="prose max-w-none">
                    <?= $lesson->content ?>
                </div>
            </div>
            
            <!-- Mark as Complete Button -->
            <?php if ($this->session->userdata('role') == 'student'): ?>
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="font-bold">Lesson Progress</h3>
                            <?php if (isset($is_completed) && $is_completed): ?>
                                <p class="text-green-600 text-sm">You have completed this lesson</p>
                            <?php else: ?>
                                <p class="text-gray-600 text-sm">Mark as complete when you're done</p>
                            <?php endif; ?>
                        </div>
                        <form action="<?= base_url('student/complete_lesson/' . $lesson->id) ?>" method="post">
                            <button type="submit" class="<?= isset($is_completed) && $is_completed ? 'bg-green-600' : 'bg-indigo-600 hover:bg-indigo-700' ?> text-white font-medium py-2 px-4 rounded">
                                <?= isset($is_completed) && $is_completed ? 'Completed' : 'Mark as Complete' ?>
                            </button>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
            
            <!-- Navigation Buttons -->
            <div class="flex justify-between mt-8">
                <?php
                $current_index = 0;
                foreach ($lessons as $index => $l) {
                    if ($l->id == $lesson->id) {
                        $current_index = $index;
                        break;
                    }
                }
                
                $prev_lesson = ($current_index > 0) ? $lessons[$current_index - 1] : null;
                $next_lesson = ($current_index < count($lessons) - 1) ? $lessons[$current_index + 1] : null;
                ?>
                
                <?php if ($prev_lesson): ?>
                    <a href="<?= base_url('home/lesson/' . $course->id . '/' . $prev_lesson->id) ?>" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2 px-4 rounded flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        Previous Lesson
                    </a>
                <?php else: ?>
                    <div></div>
                <?php endif; ?>
                
                <?php if ($next_lesson): ?>
                    <a href="<?= base_url('home/lesson/' . $course->id . '/' . $next_lesson->id) ?>" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded flex items-center">
                        Next Lesson
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                <?php else: ?>
                    <a href="<?= base_url('home/course/' . $course->id) ?>" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded flex items-center">
                        Complete Course
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </a>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="lg:w-1/3 mt-8 lg:mt-0">
            <div class="bg-white rounded-lg shadow-md p-6 sticky top-6">
                <h2 class="text-xl font-bold mb-4">Course Lessons</h2>
                
                <!-- Progress Bar -->
                <?php if (isset($progress)): ?>
                    <div class="mb-4">
                        <div class="flex justify-between text-sm text-gray-600 mb-1">
                            <span>Your Progress</span>
                            <span><?= round($progress) ?>%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-indigo-600 h-2 rounded-full" style="width: <?= $progress ?>%"></div>
                        </div>
                    </div>
                <?php endif; ?>
                
                <!-- Lessons List -->
                <div class="space-y-2">
                    <?php foreach ($lessons as $index => $l): ?>
                        <a href="<?= base_url('home/lesson/' . $course->id . '/' . $l->id) ?>" 
                           class="block p-3 rounded-md <?= ($l->id == $lesson->id) ? 'bg-indigo-100 border-l-4 border-indigo-600' : 'hover:bg-gray-50' ?>">
                            <div class="flex items-center">
                                <div class="mr-3 flex-shrink-0">
                                    <?php if (isset($progress) && $this->lesson_model->is_lesson_completed($this->session->userdata('user_id'), $l->id)): ?>
                                        <span class="flex h-6 w-6 items-center justify-center rounded-full bg-green-100 text-green-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </span>
                                    <?php else: ?>
                                        <span class="flex h-6 w-6 items-center justify-center rounded-full bg-gray-100 text-gray-600">
                                            <?= $index + 1 ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium <?= ($l->id == $lesson->id) ? 'text-indigo-800' : 'text-gray-800' ?>"><?= $l->title ?></h3>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div> 
