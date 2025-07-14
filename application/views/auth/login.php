<div class="max-w-md mx-auto bg-white rounded-xl shadow-md overflow-hidden md:max-w-lg my-10">
    <div class="md:flex">
        <div class="p-8 w-full">
            <div class="uppercase tracking-wide text-sm text-indigo-500 font-semibold mb-1">Learning Management System</div>
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Login to Your Account</h2>
            
            <?php echo validation_errors('<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">', '</div>'); ?>
            
            <?php echo form_open('auth/login'); ?>
                <div class="mb-4">
                    <label for="username" class="block text-gray-700 text-sm font-bold mb-2">Username</label>
                    <input type="text" name="username" id="username" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Enter your username" required>
                </div>
                
                <div class="mb-6">
                    <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                    <input type="password" name="password" id="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Enter your password" required>
                </div>
                
                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-indigo-50 text-indigo-700 font-medium py-2.5 px-5 rounded-lg shadow-sm hover:shadow hover:bg-indigo-100 transition-all transform hover:scale-102">
                        Login
                    </button>
                    <a class="inline-block align-baseline font-bold text-sm text-indigo-600 hover:text-indigo-800" href="<?= base_url('auth/register') ?>">
                        Don't have an account? Register
                    </a>
                </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div> 
