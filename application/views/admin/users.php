<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Manage Users</h1>
        <a href="<?= base_url('admin/create_user') ?>" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Add New User
        </a>
    </div>

    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <ul class="divide-y divide-gray-200">
            <?php if (!empty($users)): ?>
                <?php foreach ($users as $user): ?>
                    <li>
                        <div class="px-4 py-4 sm:px-6">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <span class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-gray-500">
                                            <span class="text-sm font-medium leading-none text-white">
                                                <?= strtoupper(substr($user->full_name, 0, 1)) ?>
                                            </span>
                                        </span>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            <?= htmlspecialchars($user->full_name) ?>
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            <?= htmlspecialchars($user->email) ?>
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            Username: <?= htmlspecialchars($user->username) ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        <?php if ($user->role == 'admin'): ?>
                                            bg-red-100 text-red-800
                                        <?php elseif ($user->role == 'instructor'): ?>
                                            bg-blue-100 text-blue-800
                                        <?php else: ?>
                                            bg-green-100 text-green-800
                                        <?php endif; ?>">
                                        <?= ucfirst($user->role) ?>
                                    </span>
                                    <a href="<?= base_url('admin/view_user/' . $user->id) ?>" 
                                       class="text-blue-600 hover:text-blue-900 text-sm">View</a>
                                    <a href="<?= base_url('admin/edit_user/' . $user->id) ?>" 
                                       class="text-indigo-600 hover:text-indigo-900 text-sm">Edit</a>
                                    <?php if ($user->id != $this->session->userdata('user_id')): ?>
                                        <a href="<?= base_url('admin/delete_user/' . $user->id) ?>" 
                                           class="text-red-600 hover:text-red-900 text-sm"
                                           onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li>
                    <div class="px-4 py-4 sm:px-6 text-center text-gray-500">
                        No users found.
                    </div>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</div> 
