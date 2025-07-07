<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Edit Category</h1>
        <a href="<?= base_url('admin/categories') ?>" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
            Back to Categories
        </a>
    </div>

    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <?= form_open('admin/edit_category/' . $category->id, array('class' => 'space-y-6')) ?>
            
            <?php if (validation_errors()): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <?= validation_errors() ?>
                </div>
            <?php endif; ?>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                    Category Name
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                       id="name" name="name" type="text" placeholder="Category Name" 
                       value="<?= set_value('name', $category->name) ?>" required>
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
                    Description (Optional)
                </label>
                <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                          id="description" name="description" rows="4" placeholder="Category description..."><?= set_value('description', $category->description) ?></textarea>
            </div>

            <div class="flex items-center justify-between">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" 
                        type="submit">
                    Update Category
                </button>
                <a href="<?= base_url('admin/categories') ?>" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                    Cancel
                </a>
            </div>
        <?= form_close() ?>
    </div>
</div> 
