<!-- Edit Profile Header -->
<div class="bg-white shadow rounded-lg p-6 mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Edit Profile</h1>
            <p class="text-gray-600 mt-2">Update your personal information and account settings.</p>
        </div>
        <a href="<?= base_url('student/profile') ?>" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 transition-colors">
            <svg class="inline h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Profile
        </a>
    </div>
</div>

<!-- Edit Form -->
<div class="bg-white shadow rounded-lg p-6">
    <?= form_open_multipart('student/edit_profile', ['class' => 'space-y-6']) ?>
        
        <!-- Personal Information Section -->
        <div>
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Personal Information</h2>
            
            <!-- Full Name -->
            <div class="mb-6">
                <label for="full_name" class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
                <input type="text" 
                       id="full_name" 
                       name="full_name" 
                       value="<?= set_value('full_name', $user->full_name) ?>"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                       placeholder="Enter your full name"
                       required>
                <?= form_error('full_name', '<div class="text-red-600 text-sm mt-1">', '</div>') ?>
            </div>

            <!-- Email -->
            <div class="mb-6">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address *</label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       value="<?= set_value('email', $user->email) ?>"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                       placeholder="Enter your email address"
                       required>
                <?= form_error('email', '<div class="text-red-600 text-sm mt-1">', '</div>') ?>
            </div>

            <!-- Bio -->
            <div class="mb-6">
                <label for="bio" class="block text-sm font-medium text-gray-700 mb-2">Bio</label>
                <textarea id="bio" 
                          name="bio" 
                          rows="4"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                          placeholder="Tell us about yourself..."><?= set_value('bio', $user->bio) ?></textarea>
                <p class="text-sm text-gray-500 mt-1">Optional: Share a brief description about yourself and your learning goals.</p>
                <?= form_error('bio', '<div class="text-red-600 text-sm mt-1">', '</div>') ?>
            </div>
            
            <!-- Profile Picture -->
            <div class="mb-6">
                <label for="profile_picture" class="block text-sm font-medium text-gray-700 mb-2">Profile Picture</label>
                <div class="flex items-start space-x-4">
                    <?php if (!empty($user->profile_image) && file_exists(FCPATH . 'uploads/profile_pictures/' . $user->profile_image)): ?>
                        <div class="flex-shrink-0">
                            <img src="<?= base_url('uploads/profile_pictures/' . $user->profile_image) ?>" alt="Current profile picture" class="h-24 w-24 object-cover rounded-full">
                        </div>
                    <?php endif; ?>
                    <div class="flex-grow">
                        <input type="file" 
                               id="profile_picture" 
                               name="profile_picture" 
                               class="w-full"
                               accept="image/*">
                        <p class="text-sm text-gray-500 mt-1">Upload a new profile picture (JPG, PNG, GIF, max 2MB)</p>
                        <?php if (!empty($user->profile_picture)): ?>
                            <p class="text-sm text-gray-500 mt-1">Leave empty to keep current picture</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Account Information (Read-only) -->
        <div class="border-t border-gray-200 pt-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Account Information</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Username (Read-only) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                    <div class="bg-gray-50 p-3 rounded-md border">
                        <p class="text-gray-900"><?= htmlspecialchars($user->username) ?></p>
                        <p class="text-xs text-gray-500 mt-1">Username cannot be changed</p>
                    </div>
                </div>

                <!-- Role (Read-only) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Account Type</label>
                    <div class="bg-gray-50 p-3 rounded-md border">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            <?= ucfirst($user->role) ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Password Section -->
        <div class="border-t border-gray-200 pt-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Change Password</h2>
            <p class="text-sm text-gray-600 mb-4">Leave password fields empty if you don't want to change your password.</p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- New Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                    <input type="password" 
                           id="password" 
                           name="password" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Enter new password">
                    <p class="text-xs text-gray-500 mt-1">Minimum 6 characters</p>
                    <?= form_error('password', '<div class="text-red-600 text-sm mt-1">', '</div>') ?>
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-2">Confirm New Password</label>
                    <input type="password" 
                           id="confirm_password" 
                           name="confirm_password" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Confirm new password">
                    <?= form_error('confirm_password', '<div class="text-red-600 text-sm mt-1">', '</div>') ?>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex justify-between pt-6 border-t border-gray-200">
            <a href="<?= base_url('student/profile') ?>" 
               class="bg-gray-300 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-400 transition-colors">
                Cancel
            </a>
            <button type="submit" 
                    class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition-colors">
                <svg class="inline h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Update Profile
            </button>
        </div>

    <?= form_close() ?>
</div>

<!-- Account Information -->
<div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-6">
    <div class="flex">
        <svg class="h-5 w-5 text-blue-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <div class="ml-3">
            <h3 class="text-sm font-medium text-blue-800">Account Information</h3>
            <div class="mt-2 text-sm text-blue-700">
                <ul class="list-disc pl-5 space-y-1">
                    <li><strong>Account Created:</strong> <?= date('F j, Y', strtotime($user->created_at)) ?></li>
                    <li><strong>Last Updated:</strong> <?= date('F j, Y g:i A', strtotime($user->updated_at)) ?></li>
                    <li><strong>User ID:</strong> <?= $user->id ?></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Security Tips -->
<div class="mt-4 bg-yellow-50 border border-yellow-200 rounded-lg p-6">
    <div class="flex">
        <svg class="h-5 w-5 text-yellow-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
        </svg>
        <div class="ml-3">
            <h3 class="text-sm font-medium text-yellow-800">Security Tips</h3>
            <div class="mt-2 text-sm text-yellow-700">
                <ul class="list-disc pl-5 space-y-1">
                    <li>Use a strong password with at least 8 characters</li>
                    <li>Include a mix of uppercase, lowercase, numbers, and symbols</li>
                    <li>Don't share your login credentials with anyone</li>
                    <li>Log out when using shared computers</li>
                    <li>Keep your email address up to date for account recovery</li>
                </ul>
            </div>
        </div>
    </div>
</div> 
