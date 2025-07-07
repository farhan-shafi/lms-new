<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">User Profile</h1>
        <div class="space-x-2">
            <a href="<?= base_url('admin/edit_user/' . $user->id) ?>" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Edit User
            </a>
            <a href="<?= base_url('admin/users') ?>" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to Users
            </a>
        </div>
    </div>

    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="md:flex">
            <!-- User Profile Image -->
            <div class="md:w-1/3 bg-gray-100 p-8 text-center">
                <?php if (!empty($user->profile_image) && file_exists(FCPATH . 'uploads/profile_pictures/' . $user->profile_image)): ?>
                    <div class="w-40 h-40 rounded-full overflow-hidden mx-auto mb-4">
                        <img src="<?= base_url('uploads/profile_pictures/' . $user->profile_image) ?>" alt="Profile picture" class="w-full h-full object-cover">
                    </div>
                <?php else: ?>
                    <div class="w-40 h-40 rounded-full bg-gray-300 flex items-center justify-center mx-auto mb-4">
                        <span class="text-4xl font-bold text-gray-600"><?= strtoupper(substr($user->full_name, 0, 1)) ?></span>
                    </div>
                <?php endif; ?>
                
                <h2 class="text-2xl font-bold text-gray-800"><?= htmlspecialchars($user->full_name) ?></h2>
                
                <div class="mt-2">
                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
                        <?php if ($user->role == 'admin'): ?>
                            bg-red-100 text-red-800
                        <?php elseif ($user->role == 'instructor'): ?>
                            bg-blue-100 text-blue-800
                        <?php else: ?>
                            bg-green-100 text-green-800
                        <?php endif; ?>">
                        <?= ucfirst($user->role) ?>
                    </span>
                </div>
            </div>
            
            <!-- User Details -->
            <div class="md:w-2/3 p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-gray-500 text-sm font-semibold">Username</h3>
                        <p class="text-gray-800"><?= htmlspecialchars($user->username) ?></p>
                    </div>
                    
                    <div>
                        <h3 class="text-gray-500 text-sm font-semibold">Email</h3>
                        <p class="text-gray-800"><?= htmlspecialchars($user->email) ?></p>
                    </div>
                    
                    <div>
                        <h3 class="text-gray-500 text-sm font-semibold">Member Since</h3>
                        <p class="text-gray-800"><?= isset($user->created_at) ? date('F j, Y', strtotime($user->created_at)) : 'N/A' ?></p>
                    </div>
                    
                    <div>
                        <h3 class="text-gray-500 text-sm font-semibold">Last Updated</h3>
                        <p class="text-gray-800"><?= isset($user->updated_at) ? date('F j, Y', strtotime($user->updated_at)) : 'N/A' ?></p>
                    </div>
                </div>
                
                <?php if (!empty($user->bio)): ?>
                    <div class="mt-6">
                        <h3 class="text-gray-500 text-sm font-semibold">Bio</h3>
                        <div class="mt-2 text-gray-800">
                            <?= nl2br(htmlspecialchars($user->bio)) ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Instructor-specific information -->
    <?php if ($user->role == 'instructor' && isset($courses) && isset($stats)): ?>
        <div class="mt-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Instructor Statistics</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="text-3xl font-bold text-indigo-600"><?= $stats['total_courses'] ?></div>
                    <div class="text-gray-500 mt-1">Total Courses</div>
                </div>
                
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="text-3xl font-bold text-indigo-600"><?= $stats['total_enrollments'] ?></div>
                    <div class="text-gray-500 mt-1">Total Enrollments</div>
                </div>
                
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="text-3xl font-bold text-indigo-600"><?= $stats['total_lessons'] ?></div>
                    <div class="text-gray-500 mt-1">Total Lessons</div>
                </div>
                
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="text-3xl font-bold text-indigo-600"><?= $stats['recent_enrollments'] ?></div>
                    <div class="text-gray-500 mt-1">Recent Enrollments (30 days)</div>
                </div>
            </div>
            
            <?php if (!empty($courses)): ?>
                <h3 class="text-xl font-semibold text-gray-800 mb-3">Courses (<?= count($courses) ?>)</h3>
                <div class="bg-white shadow overflow-hidden sm:rounded-md">
                    <ul class="divide-y divide-gray-200">
                        <?php foreach ($courses as $course): ?>
                            <li>
                                <a href="<?= base_url('admin/edit_course/' . $course->id) ?>" class="block hover:bg-gray-50">
                                    <div class="flex items-center px-4 py-4 sm:px-6">
                                        <div class="min-w-0 flex-1 flex items-center">
                                            <div class="flex-shrink-0">
                                                <?php if (!empty($course->thumbnail) && file_exists(FCPATH . 'uploads/thumbnails/' . $course->thumbnail)): ?>
                                                    <img class="h-12 w-12 rounded-md object-cover" src="<?= base_url('uploads/thumbnails/' . $course->thumbnail) ?>" alt="">
                                                <?php else: ?>
                                                    <div class="h-12 w-12 rounded-md bg-indigo-100 flex items-center justify-center">
                                                        <span class="text-indigo-600 font-medium"><?= strtoupper(substr($course->title, 0, 1)) ?></span>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="min-w-0 flex-1 px-4">
                                                <div>
                                                    <p class="text-sm font-medium text-indigo-600 truncate"><?= htmlspecialchars($course->title) ?></p>
                                                    <p class="mt-1 flex items-center text-sm text-gray-500">
                                                        <span class="truncate"><?= $course->category_name ?? 'Uncategorized' ?></span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $course->status == 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' ?>">
                                                <?= ucfirst($course->status) ?>
                                            </span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php else: ?>
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <p class="text-gray-500">This instructor hasn't created any courses yet.</p>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    
    <!-- Student-specific information -->
    <?php if ($user->role == 'student' && isset($enrolled_courses)): ?>
        <div class="mt-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Student Information</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="text-3xl font-bold text-indigo-600"><?= count($enrolled_courses) ?></div>
                    <div class="text-gray-500 mt-1">Enrolled Courses</div>
                </div>
            </div>
            
            <?php if (!empty($enrolled_courses)): ?>
                <h3 class="text-xl font-semibold text-gray-800 mb-3">Enrolled Courses</h3>
                <div class="bg-white shadow overflow-hidden sm:rounded-md">
                    <ul class="divide-y divide-gray-200">
                        <?php foreach ($enrolled_courses as $course): ?>
                            <li>
                                <a href="<?= base_url('admin/edit_course/' . $course->id) ?>" class="block hover:bg-gray-50">
                                    <div class="flex items-center px-4 py-4 sm:px-6">
                                        <div class="min-w-0 flex-1 flex items-center">
                                            <div class="flex-shrink-0">
                                                <?php if (!empty($course->thumbnail) && file_exists(FCPATH . 'uploads/thumbnails/' . $course->thumbnail)): ?>
                                                    <img class="h-12 w-12 rounded-md object-cover" src="<?= base_url('uploads/thumbnails/' . $course->thumbnail) ?>" alt="">
                                                <?php else: ?>
                                                    <div class="h-12 w-12 rounded-md bg-indigo-100 flex items-center justify-center">
                                                        <span class="text-indigo-600 font-medium"><?= strtoupper(substr($course->title, 0, 1)) ?></span>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="min-w-0 flex-1 px-4">
                                                <div>
                                                    <p class="text-sm font-medium text-indigo-600 truncate"><?= htmlspecialchars($course->title) ?></p>
                                                    <div class="mt-1 flex items-center">
                                                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                                                            <div class="bg-blue-600 h-2.5 rounded-full" style="width: <?= isset($course->progress_percentage) ? $course->progress_percentage : 0 ?>%"></div>
                                                        </div>
                                                        <span class="ml-2 text-xs text-gray-500"><?= isset($course->progress_percentage) ? round($course->progress_percentage) : 0 ?>%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php else: ?>
                <div class="bg-white rounded-lg shadow p-6 text-center">
                    <p class="text-gray-500">This student hasn't enrolled in any courses yet.</p>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div> 
