<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800"><?= $analytics['course']->title ?> - Analytics</h1>
        <a href="<?= site_url('instructor/courses') ?>" class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded">
            <i class="fas fa-arrow-left mr-2"></i> Back to Courses
        </a>
    </div>

    <!-- Overview Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Enrollments -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-500">
                    <i class="fas fa-users text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500 uppercase font-semibold">Total Enrollments</p>
                    <p class="text-2xl font-bold"><?= $analytics['total_enrollments'] ?></p>
                </div>
            </div>
        </div>

        <!-- Average Progress -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-500">
                    <i class="fas fa-chart-line text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500 uppercase font-semibold">Average Progress</p>
                    <p class="text-2xl font-bold"><?= $analytics['average_progress'] ?>%</p>
                </div>
            </div>
        </div>

        <!-- Active Students -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-500">
                    <i class="fas fa-user-clock text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500 uppercase font-semibold">Active Students</p>
                    <p class="text-2xl font-bold"><?= $analytics['active_students'] ?> <span class="text-sm font-normal text-gray-500">(<?= $analytics['total_enrollments'] > 0 ? round(($analytics['active_students'] / $analytics['total_enrollments']) * 100) : 0 ?>%)</span></p>
                </div>
            </div>
        </div>

        <!-- Completion Rate -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-500">
                    <i class="fas fa-award text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500 uppercase font-semibold">Completion Rate</p>
                    <p class="text-2xl font-bold"><?= $analytics['completion_rate'] ?>%</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Progress Chart -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <h2 class="text-xl font-semibold mb-4">Course Progress Distribution</h2>
        <div class="h-64 flex items-end justify-around">
            <?php
            // Define progress ranges
            $ranges = [
                '0%' => 0,
                '1-25%' => 0,
                '26-50%' => 0,
                '51-75%' => 0,
                '76-99%' => 0,
                '100%' => 0
            ];
            
            // Count students in each range
            foreach ($analytics['enrolled_students'] as $student) {
                if ($student->progress_percentage == 0) {
                    $ranges['0%']++;
                } elseif ($student->progress_percentage <= 25) {
                    $ranges['1-25%']++;
                } elseif ($student->progress_percentage <= 50) {
                    $ranges['26-50%']++;
                } elseif ($student->progress_percentage <= 75) {
                    $ranges['51-75%']++;
                } elseif ($student->progress_percentage < 100) {
                    $ranges['76-99%']++;
                } else {
                    $ranges['100%']++;
                }
            }
            
            // Colors for each range
            $colors = [
                '0%' => 'bg-gray-300',
                '1-25%' => 'bg-red-400',
                '26-50%' => 'bg-orange-400',
                '51-75%' => 'bg-yellow-400',
                '76-99%' => 'bg-blue-400',
                '100%' => 'bg-green-500'
            ];
            
            // Maximum value for scaling
            $max = max($ranges) > 0 ? max($ranges) : 1;
            
            foreach ($ranges as $label => $count) {
                $height = ($count / $max) * 100;
                if ($height < 10 && $count > 0) $height = 10; // Minimum visible height
                $color = $colors[$label];
            ?>
                <div class="text-center mx-2">
                    <div class="flex flex-col items-center">
                        <span class="text-sm font-semibold mb-1"><?= $count ?></span>
                        <div class="<?= $color ?> rounded-t w-16" style="height: <?= $height ?>%"></div>
                        <span class="text-xs mt-2"><?= $label ?></span>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <!-- Enrolled Students Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden mb-8">
        <div class="p-6 border-b">
            <h2 class="text-xl font-semibold">Enrolled Students (<?= count($analytics['enrolled_students']) ?>)</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Enrolled On</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Progress</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Activity</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php if (empty($analytics['enrolled_students'])): ?>
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">No students enrolled yet</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($analytics['enrolled_students'] as $student): ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                                <span class="text-gray-600 font-bold"><?= substr($student->full_name, 0, 1) ?></span>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900"><?= $student->full_name ?></div>
                                            <div class="text-sm text-gray-500"><?= $student->email ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?= date('M j, Y', strtotime($student->enrolled_at)) ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-32 bg-gray-200 rounded-full h-2.5">
                                            <div class="bg-blue-600 h-2.5 rounded-full" style="width: <?= $student->progress_percentage ?>%"></div>
                                        </div>
                                        <span class="ml-2 text-sm text-gray-600"><?= $student->progress_percentage ?>%</span>
                                    </div>
                                    <div class="text-xs text-gray-500 mt-1">
                                        <?= $student->completed_lessons ?> of <?= $student->total_lessons ?> lessons completed
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?= $student->last_activity ? date('M j, Y g:i A', strtotime($student->last_activity)) : 'Never' ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <button 
                                        class="text-blue-600 hover:text-blue-900 view-progress-btn"
                                        data-student-id="<?= $student->id ?>"
                                        data-course-id="<?= $analytics['course']->id ?>">
                                        View Details
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Student Progress Modal -->
<div id="progressModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center pb-3 border-b">
            <h3 class="text-lg font-semibold text-gray-800" id="modalTitle">Student Progress</h3>
            <button id="closeModal" class="text-gray-400 hover:text-gray-500">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div id="modalContent" class="mt-4 max-h-96 overflow-y-auto">
            <div class="flex justify-center">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-500"></div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('progressModal');
    const modalTitle = document.getElementById('modalTitle');
    const modalContent = document.getElementById('modalContent');
    const closeModal = document.getElementById('closeModal');
    
    // Close modal when clicking the close button
    closeModal.addEventListener('click', function() {
        modal.classList.add('hidden');
    });
    
    // Close modal when clicking outside
    window.addEventListener('click', function(event) {
        if (event.target === modal) {
            modal.classList.add('hidden');
        }
    });
    
    // View student progress details
    document.querySelectorAll('.view-progress-btn').forEach(button => {
        button.addEventListener('click', function() {
            const studentId = this.getAttribute('data-student-id');
            const courseId = this.getAttribute('data-course-id');
            
            // Show loading state
            modal.classList.remove('hidden');
            modalContent.innerHTML = '<div class="flex justify-center"><div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-500"></div></div>';
            
            // Fetch student progress data
            fetch(`<?= site_url('instructor/student_progress/') ?>${courseId}/${studentId}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                modalTitle.textContent = `${data.student.full_name}'s Progress`;
                
                let content = `
                    <div class="mb-4">
                        <div class="flex items-center mb-2">
                            <div class="w-full bg-gray-200 rounded-full h-4">
                                <div class="bg-blue-600 h-4 rounded-full" style="width: ${data.progress.percentage}%"></div>
                            </div>
                            <span class="ml-2 text-lg font-semibold">${data.progress.percentage}%</span>
                        </div>
                        <p class="text-sm text-gray-600">${data.progress.completed} of ${data.progress.total} lessons completed</p>
                    </div>
                    
                    <div class="border-t pt-4">
                        <h4 class="font-semibold mb-2">Lesson Progress</h4>
                        <ul class="divide-y divide-gray-200">
                `;
                
                data.lessons.forEach(lesson => {
                    const isCompleted = lesson.is_completed;
                    const completedDate = lesson.completed_at ? new Date(lesson.completed_at).toLocaleDateString() : null;
                    
                    content += `
                        <li class="py-3">
                            <div class="flex items-center">
                                <div class="mr-3">
                                    ${isCompleted ? 
                                        '<span class="flex items-center justify-center w-6 h-6 bg-green-100 text-green-500 rounded-full"><i class="fas fa-check"></i></span>' : 
                                        '<span class="flex items-center justify-center w-6 h-6 bg-gray-100 text-gray-400 rounded-full"><i class="fas fa-circle"></i></span>'
                                    }
                                </div>
                                <div class="flex-1">
                                    <p class="font-medium">${lesson.title}</p>
                                    ${isCompleted ? 
                                        `<p class="text-xs text-gray-500">Completed on ${completedDate}</p>` : 
                                        '<p class="text-xs text-gray-500">Not completed yet</p>'
                                    }
                                </div>
                            </div>
                        </li>
                    `;
                });
                
                content += `
                        </ul>
                    </div>
                `;
                
                modalContent.innerHTML = content;
            })
            .catch(error => {
                console.error('Error fetching student progress:', error);
                modalContent.innerHTML = '<p class="text-red-500">Error loading progress data. Please try again.</p>';
            });
        });
    });
});
</script> 
