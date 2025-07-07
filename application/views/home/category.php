<!-- Page Header -->
<div class="bg-indigo-700 text-white py-12">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold"><?= $category->name ?></h1>
        <p class="mt-2"><?= $category->description ?></p>
    </div>
</div>

<!-- Category Courses Section -->
<div class="container mx-auto px-4 py-8">
    <!-- Categories Navigation -->
    <div class="mb-8">
        <h2 class="text-lg font-semibold mb-4">Browse Categories</h2>
        <div class="flex flex-wrap gap-2">
            <a href="<?= base_url('home/courses') ?>" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-full text-sm">
                All Courses
            </a>
            <?php foreach ($categories as $cat): ?>
                <a href="<?= base_url('home/category/' . $cat->id) ?>" 
                   class="px-4 py-2 rounded-full text-sm <?= ($cat->id == $category->id) ? 'bg-indigo-600 text-white' : 'bg-gray-200 hover:bg-gray-300' ?>">
                    <?= $cat->name ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    
    <!-- Courses Grid -->
    <?php if (empty($courses)): ?>
        <div class="text-center py-16">
            <p class="text-gray-600 text-lg">No courses available in this category yet.</p>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($courses as $course): ?>
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    <?php if ($course->thumbnail): ?>
                        <img src="<?= base_url('uploads/thumbnails/' . $course->thumbnail) ?>" alt="<?= $course->title ?>" class="w-full h-48 object-cover">
                    <?php else: ?>
                        <div class="w-full h-48 bg-indigo-100 flex items-center justify-center">
                            <span class="text-indigo-500 text-lg font-semibold"><?= $course->title ?></span>
                        </div>
                    <?php endif; ?>
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-xs font-semibold text-indigo-600 uppercase tracking-wide"><?= $course->category_name ?? 'Uncategorized' ?></span>
                            <span class="text-xs text-gray-500">By <?= $course->instructor_name ?></span>
                        </div>
                        <h3 class="text-xl font-bold mb-2 text-gray-800"><?= $course->title ?></h3>
                        <p class="text-gray-600 mb-4 line-clamp-2"><?= character_limiter($course->description, 100) ?></p>
                        <a href="<?= base_url('home/course/' . $course->id) ?>" class="block text-center bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded">
                            View Course
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div> 
