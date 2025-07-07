<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Create New User</h1>
        <a href="<?= base_url('admin/users') ?>" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            Back to Users
        </a>
    </div>

    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <?= form_open('admin/create_user', array('class' => 'space-y-6')) ?>
            
            <?php if (validation_errors()): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <?= validation_errors() ?>
                </div>
            <?php endif; ?>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="username">
                        Username
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                           id="username" name="username" type="text" placeholder="Username" value="<?= set_value('username') ?>" required>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                        Email
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                           id="email" name="email" type="email" placeholder="Email" value="<?= set_value('email') ?>" required>
                </div>
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="full_name">
                    Full Name
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                       id="full_name" name="full_name" type="text" placeholder="Full Name" value="<?= set_value('full_name') ?>" required>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                        Password
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                           id="password" name="password" type="password" placeholder="Password" required>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="confirm_password">
                        Confirm Password
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                           id="confirm_password" name="confirm_password" type="password" placeholder="Confirm Password" required>
                </div>
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="role">
                    Role
                </label>
                <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                        id="role" name="role" required>
                    <option value="">Select Role</option>
                    <option value="admin" <?= set_select('role', 'admin') ?>>Admin</option>
                    <option value="instructor" <?= set_select('role', 'instructor') ?>>Instructor</option>
                    <option value="student" <?= set_select('role', 'student') ?>>Student</option>
                </select>
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="bio">
                    Bio (Optional)
                </label>
                <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                          id="bio" name="bio" rows="4" placeholder="User bio..."><?= set_value('bio') ?></textarea>
            </div>

            <div class="flex items-center justify-between">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" 
                        type="submit">
                    Create User
                </button>
                <a href="<?= base_url('admin/users') ?>" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                    Cancel
                </a>
            </div>
        <?= form_close() ?>
    </div>
</div> 
