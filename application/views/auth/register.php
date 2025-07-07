<div class="max-w-md mx-auto bg-white rounded-xl shadow-md overflow-hidden md:max-w-lg my-10">
    <div class="md:flex">
        <div class="p-8 w-full">
            <div class="uppercase tracking-wide text-sm text-indigo-500 font-semibold mb-1">Learning Management System</div>
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Create an Account</h2>
            
            <?php echo validation_errors('<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">', '</div>'); ?>
            
            <?php echo form_open_multipart('auth/register'); ?>
                <div class="mb-4">
                    <label for="username" class="block text-gray-700 text-sm font-bold mb-2">Username</label>
                    <input type="text" name="username" id="username" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Choose a username" value="<?= set_value('username') ?>" required>
                </div>
                
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                    <input type="email" name="email" id="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Enter your email" value="<?= set_value('email') ?>" required>
                </div>
                
                <div class="mb-4">
                    <label for="full_name" class="block text-gray-700 text-sm font-bold mb-2">Full Name</label>
                    <input type="text" name="full_name" id="full_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Enter your full name" value="<?= set_value('full_name') ?>" required>
                </div>
                
                <div class="mb-4">
                    <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                    <input type="password" name="password" id="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Choose a password" required>
                    <p class="text-gray-600 text-xs mt-1">Password must be at least 6 characters long</p>
                </div>
                
                <div class="mb-6">
                    <label for="confirm_password" class="block text-gray-700 text-sm font-bold mb-2">Confirm Password</label>
                    <input type="password" name="confirm_password" id="confirm_password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Confirm your password" required>
                </div>
                
                <div class="mb-6">
                    <label for="profile_picture" class="block text-gray-700 text-sm font-bold mb-2">Profile Picture (Optional)</label>
                    <input type="file" name="profile_picture" id="profile_picture" class="w-full" accept="image/*">
                    <p class="text-gray-600 text-xs mt-1">Upload a profile picture (JPG, PNG, GIF, max 2MB)</p>
                </div>
                
                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Register
                    </button>
                    <a class="inline-block align-baseline font-bold text-sm text-indigo-600 hover:text-indigo-800" href="<?= base_url('auth/login') ?>">
                        Already have an account? Login
                    </a>
                </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div> 
