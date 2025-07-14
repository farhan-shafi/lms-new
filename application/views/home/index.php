<!-- Hero Section -->
<section class="bg-indigo-700 text-white py-16">
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row items-center">
            <div class="md:w-1/2 mb-8 md:mb-0">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Expand Your Knowledge</h1>
                <p class="text-xl mb-6">Access quality courses and improve your skills with our Learning Management System.</p>
                <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-4">
                    <a href="<?= base_url('home/courses') ?>" class="bg-white text-indigo-700 hover:bg-indigo-100 font-bold py-3 px-6 rounded-lg text-center">
                        Browse Courses
                    </a>
                    <?php if (!$this->session->userdata('logged_in')): ?>
                        <a href="<?= base_url('auth/register') ?>" class="bg-indigo-600 hover:bg-indigo-800 text-white font-bold py-3 px-6 rounded-lg border border-white text-center">
                            Sign Up Now
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="md:w-1/2">
                <img src="https://source.unsplash.com/random/600x400/?education" alt="Education" class="rounded-lg shadow-lg">
            </div>
        </div>
    </div>
</section>

<!-- Featured Courses Section -->
<section class="py-12">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold mb-8 text-center">Featured Courses</h2>
        
        <?php if (empty($courses)): ?>
            <div class="text-center py-8">
                <p class="text-gray-600 text-lg">No courses available yet.</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach (array_slice($courses, 0, 6) as $course): ?>
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
                            <!-- Course Rating -->
                            <?php if (isset($course->average_rating)): ?>
                            <div class="flex items-center mb-2">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <?php if ($i <= round($course->average_rating)): ?>
                                        <svg class="h-4 w-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                    <?php else: ?>
                                        <svg class="h-4 w-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                    <?php endif; ?>
                                <?php endfor; ?>
                                <span class="ml-1 text-sm text-gray-600"><?= number_format($course->average_rating, 1) ?> (<?= $course->rating_count ?? 0 ?> reviews)</span>
                            </div>
                            <?php else: ?>
                            <div class="flex items-center mb-2">
                                <span class="text-sm text-gray-500">No ratings yet</span>
                            </div>
                            <?php endif; ?>
                            <p class="text-gray-600 mb-4 line-clamp-2"><?= character_limiter($course->description, 100) ?></p>
                            <a href="<?= base_url('home/course/' . $course->id) ?>" class="block text-center bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded">
                                View Course
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <?php if (count($courses) > 6): ?>
                <div class="text-center mt-8">
                    <a href="<?= base_url('home/courses') ?>" class="inline-block bg-indigo-100 hover:bg-indigo-200 text-indigo-700 font-medium py-2 px-6 rounded-lg">
                        View All Courses
                    </a>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</section>

<!-- Categories Section -->
<section class="py-12 bg-gray-50">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold mb-8 text-center">Browse by Category</h2>
        
        <?php if (empty($categories)): ?>
            <div class="text-center py-8">
                <p class="text-gray-600 text-lg">No categories available yet.</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                <?php foreach ($categories as $category): ?>
                    <a href="<?= base_url('home/category/' . $category->id) ?>" class="bg-white p-6 rounded-lg shadow hover:shadow-md transition-shadow duration-300 text-center">
                        <h3 class="text-lg font-semibold text-indigo-700"><?= $category->name ?></h3>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Call to Action Section -->
<section class="py-16 bg-indigo-600 text-white">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold mb-4">Ready to Start Learning?</h2>
        <p class="text-xl mb-8 max-w-2xl mx-auto">Join our learning platform today and get access to all courses.</p>
        <?php if (!$this->session->userdata('logged_in')): ?>
            <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                <a href="<?= base_url('auth/register') ?>" class="bg-white text-indigo-700 hover:bg-indigo-100 font-bold py-3 px-8 rounded-lg">
                    Sign Up Now
                </a>
                <a href="<?= base_url('auth/login') ?>" class="bg-transparent hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-lg border border-white">
                    Login
                </a>
            </div>
        <?php else: ?>
            <a href="<?= base_url('home/courses') ?>" class="bg-white text-indigo-700 hover:bg-indigo-100 font-bold py-3 px-8 rounded-lg">
                Browse All Courses
            </a>
        <?php endif; ?>
    </div>
</section> 
