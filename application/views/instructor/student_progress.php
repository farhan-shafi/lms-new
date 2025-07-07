<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800"><?= $student->full_name ?>'s Progress - <?= $course->title ?></h1>
        <a href="<?= site_url('instructor/course_analytics/' . $course->id) ?>" class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded">
            <i class="fas fa-arrow-left mr-2"></i> Back to Analytics
        </a>
    </div>

    <!-- Progress Overview -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
            <div>
                <h2 class="text-xl font-semibold mb-2">Course Progress</h2>
                <div class="flex items-center">
                    <div class="w-64 bg-gray-200 rounded-full h-4">
                        <div class="bg-blue-600 h-4 rounded-full" style="width: <?= $progress['percentage'] ?>%"></div>
                    </div>
                    <span class="ml-3 text-lg font-semibold"><?= $progress['percentage'] ?>%</span>
                </div>
                <p class="text-sm text-gray-600 mt-2"><?= $progress['completed'] ?> of <?= $progress['total'] ?> lessons completed</p>
            </div>
            <div class="mt-4 md:mt-0">
                <div class="bg-blue-50 rounded-lg p-4">
                    <h3 class="text-sm font-semibold text-blue-800 mb-1">Student Information</h3>
                    <p class="text-sm"><span class="font-medium">Email:</span> <?= $student->email ?></p>
                    <p class="text-sm"><span class="font-medium">Enrolled since:</span> 
                        <?php 
                        $this->db->select('enrolled_at');
                        $this->db->where('user_id', $student->id);
                        $this->db->where('course_id', $course->id);
                        $enrollment = $this->db->get('enrollments')->row();
                        echo $enrollment ? date('M j, Y', strtotime($enrollment->enrolled_at)) : 'Unknown';
                        ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Lesson Progress -->
    <div class="bg-white rounded-lg shadow overflow-hidden mb-8">
        <div class="p-6 border-b">
            <h2 class="text-xl font-semibold">Lesson Progress</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lesson</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Completed On</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Accessed</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php if (empty($lessons)): ?>
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">No lessons available in this course</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($lessons as $lesson): 
                            // Get last accessed time
                            $this->db->select('last_accessed');
                            $this->db->where('user_id', $student->id);
                            $this->db->where('lesson_id', $lesson->id);
                            $progress_record = $this->db->get('lesson_progress')->row();
                            $last_accessed = $progress_record ? $progress_record->last_accessed : null;
                        ?>
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-8 w-8 flex items-center justify-center rounded-full bg-blue-100 text-blue-500">
                                            <span class="text-xs font-medium"><?= $lesson->sort_order ?></span>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900"><?= $lesson->title ?></p>
                                            <?php if ($lesson->video_url): ?>
                                                <p class="text-xs text-gray-500">Has video</p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php if ($lesson->is_completed): ?>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Completed
                                        </span>
                                    <?php else: ?>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                            Not Completed
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?= $lesson->completed_at ? date('M j, Y g:i A', strtotime($lesson->completed_at)) : '-' ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?= $last_accessed ? date('M j, Y g:i A', strtotime($last_accessed)) : 'Never' ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Activity Timeline -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <h2 class="text-xl font-semibold mb-4">Activity Timeline</h2>
        
        <?php
        // Get all lesson progress records for this student in this course
        $this->db->select('lesson_progress.*, lessons.title as lesson_title');
        $this->db->from('lesson_progress');
        $this->db->join('lessons', 'lessons.id = lesson_progress.lesson_id');
        $this->db->where('lesson_progress.user_id', $student->id);
        $this->db->where('lessons.course_id', $course->id);
        $this->db->order_by('lesson_progress.last_accessed', 'DESC');
        $activities = $this->db->get()->result();
        ?>
        
        <?php if (empty($activities)): ?>
            <p class="text-gray-500">No activity recorded yet.</p>
        <?php else: ?>
            <div class="relative">
                <!-- Timeline line -->
                <div class="absolute left-5 top-0 h-full w-0.5 bg-gray-200"></div>
                
                <div class="space-y-6 relative">
                    <?php foreach ($activities as $activity): ?>
                        <div class="flex items-start">
                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center z-10">
                                <i class="fas fa-book text-white"></i>
                            </div>
                            <div class="ml-4 bg-gray-50 p-4 rounded-lg shadow-sm w-full">
                                <div class="flex justify-between">
                                    <h3 class="text-sm font-medium"><?= $activity->lesson_title ?></h3>
                                    <time class="text-xs text-gray-500"><?= date('M j, Y g:i A', strtotime($activity->last_accessed)) ?></time>
                                </div>
                                <p class="text-sm text-gray-600 mt-1">
                                    <?php if ($activity->completed): ?>
                                        Marked lesson as completed
                                    <?php else: ?>
                                        Accessed lesson
                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div> 
