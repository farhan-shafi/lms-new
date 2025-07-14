<!-- Profile Header -->
<div class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg p-8 mb-8">
    <div class="flex items-center">
        <div class="flex-shrink-0">
            <?php if (!empty($user->profile_image) && file_exists(FCPATH . 'uploads/profile_pictures/' . $user->profile_image)): ?>
                <div class="w-20 h-20 rounded-full overflow-hidden">
                    <img src="<?= base_url('uploads/profile_pictures/' . $user->profile_image) ?>" alt="Profile picture" class="w-full h-full object-cover">
                </div>
            <?php else: ?>
                <div class="w-20 h-20 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                    <svg class="h-12 w-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
            <?php endif; ?>
        </div>
        <div class="ml-6">
            <h1 class="text-3xl font-bold"><?= htmlspecialchars($user->full_name) ?></h1>
            <p class="text-blue-100 text-lg">Student</p>
            <p class="text-blue-200 text-sm mt-1">Member since <?= date('F Y', strtotime($user->created_at)) ?></p>
        </div>
    </div>
</div>

<!-- Profile Content -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Personal Information -->
    <div class="lg:col-span-2">
        <div class="bg-white shadow rounded-lg p-6 mb-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-900">Personal Information</h2>
                <a href="<?= base_url('student/edit_profile') ?>" class="bg-blue-50 text-blue-700 px-4 py-2 rounded-lg shadow-sm hover:shadow hover:bg-blue-100 transition-all transform hover:scale-102">
                    <svg class="inline h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit Profile
                </a>
            </div>

            <div class="space-y-6">
                <!-- Full Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                    <div class="bg-gray-50 p-3 rounded-md">
                        <p class="text-gray-900"><?= htmlspecialchars($user->full_name) ?></p>
                    </div>
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                    <div class="bg-gray-50 p-3 rounded-md">
                        <p class="text-gray-900"><?= htmlspecialchars($user->email) ?></p>
                    </div>
                </div>

                <!-- Username -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                    <div class="bg-gray-50 p-3 rounded-md">
                        <p class="text-gray-900"><?= htmlspecialchars($user->username) ?></p>
                    </div>
                </div>

                <!-- Bio -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Bio</label>
                    <div class="bg-gray-50 p-3 rounded-md min-h-[100px]">
                        <?php if (!empty($user->bio)): ?>
                            <p class="text-gray-900"><?= nl2br(htmlspecialchars($user->bio)) ?></p>
                        <?php else: ?>
                            <p class="text-gray-500 italic">No bio added yet. Click "Edit Profile" to add one.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Account Details -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                        <div class="bg-gray-50 p-3 rounded-md">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                <?= ucfirst($user->role) ?>
                            </span>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Member Since</label>
                        <div class="bg-gray-50 p-3 rounded-md">
                            <p class="text-gray-900"><?= date('F j, Y', strtotime($user->created_at)) ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats & Actions -->
    <div class="space-y-6">
        <!-- Quick Stats -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Learning Stats</h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Enrolled Courses</span>
                    <span class="text-2xl font-bold text-blue-600">
                        <?php
                        // Get enrolled courses count - would need to be passed from controller
                        echo isset($stats['enrolled_courses']) ? $stats['enrolled_courses'] : '0';
                        ?>
                    </span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Completed Lessons</span>
                    <span class="text-2xl font-bold text-green-600">
                        <?php
                        echo isset($stats['completed_lessons']) ? $stats['completed_lessons'] : '0';
                        ?>
                    </span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Learning Hours</span>
                    <span class="text-2xl font-bold text-purple-600">
                        <?php
                        echo isset($stats['learning_hours']) ? $stats['learning_hours'] : '0';
                        ?>
                    </span>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h3>
            <div class="space-y-3">
                <a href="<?= base_url('student/my_courses') ?>" class="flex items-center p-3 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                    <svg class="h-5 w-5 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    <span class="text-blue-900">My Courses</span>
                </a>
                
                <a href="<?= base_url('home/courses') ?>" class="flex items-center p-3 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                    <svg class="h-5 w-5 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <span class="text-green-900">Browse Courses</span>
                </a>
                
                <a href="<?= base_url('student/dashboard') ?>" class="flex items-center p-3 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                    <svg class="h-5 w-5 text-purple-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    <span class="text-purple-900">Dashboard</span>
                </a>
            </div>
        </div>

        <!-- Account Security -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Account Security</h3>
            <div class="space-y-3">
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center">
                        <svg class="h-5 w-5 text-gray-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        <span class="text-sm text-gray-700">Password</span>
                    </div>
                    <a href="<?= base_url('student/edit_profile') ?>" class="text-blue-600 hover:text-blue-800 text-sm">Change</a>
                </div>
                
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center">
                        <svg class="h-5 w-5 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-sm text-gray-700">Account Status</span>
                    </div>
                    <span class="text-sm text-green-600 font-medium">Active</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Activity Feed (Optional - would need implementation) -->
<div class="mt-8 bg-white shadow rounded-lg p-6">
    <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Activity</h3>
    <div class="text-center py-8">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v1a2 2 0 002 2h2m0-4v6m2-6h2a2 2 0 012 2v1a2 2 0 01-2 2h-2m-2-4v6m6-10V4a2 2 0 00-2-2H6a2 2 0 00-2 2v4a2 2 0 002 2h12a2 2 0 002-2z"></path>
        </svg>
        <h4 class="mt-2 text-sm font-medium text-gray-900">No recent activity</h4>
        <p class="mt-1 text-sm text-gray-500">Start learning to see your activity here!</p>
    </div>
</div> 
