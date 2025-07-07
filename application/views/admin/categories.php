<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Manage Categories</h1>
        <a href="<?= base_url('admin/create_category') ?>" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Add New Category
        </a>
    </div>

    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <ul class="divide-y divide-gray-200">
            <?php if (!empty($categories)): ?>
                <?php foreach ($categories as $category): ?>
                    <li>
                        <div class="px-4 py-4 sm:px-6">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <span class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-indigo-500">
                                            <span class="text-sm font-medium leading-none text-white">
                                                <?= strtoupper(substr($category->name, 0, 1)) ?>
                                            </span>
                                        </span>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            <?= htmlspecialchars($category->name) ?>
                                        </div>
                                        <?php if (!empty($category->description)): ?>
                                            <div class="text-sm text-gray-500">
                                                <?= htmlspecialchars($category->description) ?>
                                            </div>
                                        <?php endif; ?>
                                        <div class="text-xs text-gray-400">
                                            Created: <?= date('M j, Y', strtotime($category->created_at)) ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <a href="<?= base_url('admin/edit_category/' . $category->id) ?>" 
                                       class="text-indigo-600 hover:text-indigo-900 text-sm">Edit</a>
                                    <a href="<?= base_url('admin/delete_category/' . $category->id) ?>" 
                                       class="text-red-600 hover:text-red-900 text-sm"
                                       onclick="return confirm('Are you sure you want to delete this category?')">Delete</a>
                                </div>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li>
                    <div class="px-4 py-4 sm:px-6 text-center text-gray-500">
                        No categories found.
                    </div>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</div> 
