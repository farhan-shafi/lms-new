<!-- Admin Dashboard -->
<div class="bg-gray-100 min-h-screen">
    <!-- Dashboard Header -->
    <div class="bg-gradient-to-r from-indigo-700 to-blue-600 shadow-lg">
        <div class="container mx-auto px-4 py-8">
            <h1 class="text-2xl md:text-3xl font-bold text-white">Admin Dashboard</h1>
            <p class="text-indigo-100 mt-1">Welcome, <?= $this->session->userdata('full_name') ?>!</p>
        </div>
    </div>
    
    <!-- Dashboard Content -->
    <div class="container mx-auto px-4 py-8">
        <!-- Stats Overview -->
        <div class="grid grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 mb-8">
            <!-- Users Card -->
            <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow p-5 border-l-4 border-indigo-500">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-indigo-100 text-indigo-600">
                        <i class="fas fa-users text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-xs uppercase font-semibold text-gray-500">Total Users</p>
                        <p class="text-2xl font-bold text-gray-800"><?= $user_count ?></p>
                    </div>
                </div>
                <div class="mt-4 pl-16">
                    <a href="<?= base_url('admin/users') ?>" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium flex items-center group">
                        <span class="group-hover:underline">View All Users</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline ml-1 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
            
            <!-- Courses Card -->
            <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow p-5 border-l-4 border-green-500">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-600">
                        <i class="fas fa-book-open text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-xs uppercase font-semibold text-gray-500">Total Courses</p>
                        <p class="text-2xl font-bold text-gray-800"><?= $course_count ?></p>
                    </div>
                </div>
                <div class="mt-4 pl-16">
                    <a href="<?= base_url('admin/courses') ?>" class="text-green-600 hover:text-green-800 text-sm font-medium flex items-center group">
                        <span class="group-hover:underline">View All Courses</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline ml-1 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
            
            <!-- Categories Card -->
            <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow p-5 border-l-4 border-yellow-500">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                        <i class="fas fa-tag text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-xs uppercase font-semibold text-gray-500">Total Categories</p>
                        <p class="text-2xl font-bold text-gray-800"><?= $category_count ?></p>
                    </div>
                </div>
                <div class="mt-4 pl-16">
                    <a href="<?= base_url('admin/categories') ?>" class="text-yellow-600 hover:text-yellow-800 text-sm font-medium flex items-center group">
                        <span class="group-hover:underline">View All Categories</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline ml-1 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-8">
            <h2 class="text-xl font-bold text-gray-800 mb-5 flex items-center">
                <i class="fas fa-bolt text-amber-500 mr-2"></i>Quick Actions
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="<?= base_url('admin/create_user') ?>" class="flex items-center justify-center bg-indigo-50 text-indigo-700 rounded-lg p-4 transition-all transform hover:scale-102 shadow-sm hover:shadow hover:bg-indigo-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                    <span class="text-base font-medium">Add New User</span>
                </a>
                <a href="<?= base_url('admin/create_course') ?>" class="flex items-center justify-center bg-green-50 text-green-700 rounded-lg p-4 transition-all transform hover:scale-102 shadow-sm hover:shadow hover:bg-green-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    <span class="text-base font-medium">Create Course</span>
                </a>
                <a href="<?= base_url('admin/create_category') ?>" class="flex items-center justify-center bg-yellow-50 text-yellow-700 rounded-lg p-4 transition-all transform hover:scale-102 shadow-sm hover:shadow hover:bg-yellow-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                    <span class="text-base font-medium">Add Category</span>
                </a>
                <a href="<?= base_url('home') ?>" class="flex items-center justify-center bg-gray-50 text-gray-700 rounded-lg p-4 transition-all transform hover:scale-102 shadow-sm hover:shadow hover:bg-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span class="text-base font-medium">View Frontend</span>
                </a>
            </div>
        </div>
        
        <!-- Recent Users -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-gray-800 flex items-center">
                    <i class="fas fa-user-circle text-indigo-600 mr-2"></i>Recent Users
                </h2>
                <a href="<?= base_url('admin/users') ?>" class="bg-indigo-50 text-indigo-700 text-sm py-2.5 px-4 rounded-lg shadow-sm hover:shadow hover:bg-indigo-100 transition-all flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-indigo-600 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    View All Users
                </a>
            </div>
            
            <?php
            // Get recent users
            $this->db->order_by('created_at', 'DESC');
            $this->db->limit(5);
            $recent_users = $this->db->get('users')->result();
            ?>
            
            <?php if (empty($recent_users)): ?>
                <div class="text-center py-8">
                    <p class="text-gray-600">No users found in the system.</p>
                </div>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="py-2 px-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                <th class="py-2 px-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="py-2 px-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                                <th class="py-2 px-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined</th>
                                <th class="py-2 px-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <?php foreach ($recent_users as $user): ?>
                                <tr>
                                    <td class="py-3 px-3">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-8 w-8">
                                                <?php if (!empty($user->profile_picture)): ?>
                                                    <img class="h-8 w-8 rounded-full" src="<?= base_url('uploads/profile_pictures/' . $user->profile_picture) ?>" alt="<?= $user->full_name ?>">
                                                <?php else: ?>
                                                    <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center">
                                                        <span class="text-indigo-600 font-medium text-sm"><?= substr($user->full_name, 0, 1) ?></span>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-gray-900"><?= $user->full_name ?></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 px-3 text-sm text-gray-500"><?= $user->email ?></td>
                                    <td class="py-3 px-3">
                                        <?php if ($user->role == 'admin'): ?>
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Admin</span>
                                        <?php elseif ($user->role == 'instructor'): ?>
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Instructor</span>
                                        <?php else: ?>
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Student</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="py-3 px-3 text-sm text-gray-500"><?= date('M d, Y', strtotime($user->created_at)) ?></td>
                                    <td class="py-3 px-3 text-sm">
                                        <a href="<?= base_url('admin/view_user/' . $user->id) ?>" class="inline-flex items-center px-2.5 py-1.5 bg-blue-50 text-blue-700 text-xs font-medium rounded border border-blue-200 hover:bg-blue-100 transition-all mr-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            View
                                        </a>
                                        <a href="<?= base_url('admin/edit_user/' . $user->id) ?>" class="inline-flex items-center px-2.5 py-1.5 bg-green-50 text-green-700 text-xs font-medium rounded border border-green-200 hover:bg-green-100 transition-all">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Edit
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div> 
