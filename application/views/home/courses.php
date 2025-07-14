<!-- Page Header -->
<div class="bg-indigo-700 text-white py-12">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold">All Courses</h1>
        <p class="mt-2">Browse all available courses</p>
    </div>
</div>

<!-- Courses Section -->
<div class="container mx-auto px-4 py-8">
    <!-- Filter and Search -->
    <div class="mb-8 flex flex-col md:flex-row justify-between">
        <!-- Categories Filter -->
        <div class="mb-4 md:mb-0">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="category">Filter by Category</label>
            <div class="relative">
                <select id="category-filter" class="block appearance-none w-full bg-white border border-gray-300 hover:border-gray-400 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                    <option value="">All Categories</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category->id ?>"><?= $category->name ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                </div>
            </div>
        </div>
        
        <!-- Search -->
        <div>
            <label class="block text-gray-700 text-sm font-bold mb-2" for="search">Search Courses</label>
            <input id="course-search" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Search by title...">
        </div>
    </div>
    
    <!-- Courses Grid -->
    <?php if (empty($courses)): ?>
        <div class="text-center py-16">
            <p class="text-gray-600 text-lg">No courses available yet.</p>
        </div>
    <?php else: ?>
        <div id="courses-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($courses as $course): ?>
                <div class="course-card bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300" data-category="<?= $course->category_id ?>">
                    <?php if (!empty($course->thumbnail) && file_exists(FCPATH . 'uploads/thumbnails/' . $course->thumbnail)): ?>
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
                        <a href="<?= base_url('home/course/' . $course->id) ?>" class="block text-center bg-indigo-50 text-indigo-700 font-medium py-2 px-4 rounded-lg shadow-sm hover:shadow hover:bg-indigo-100 transition-all transform hover:scale-102">
                            View Course
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<!-- JavaScript for filtering -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const categoryFilter = document.getElementById('category-filter');
        const courseSearch = document.getElementById('course-search');
        const courseCards = document.querySelectorAll('.course-card');
        
        // Filter by category
        categoryFilter.addEventListener('change', filterCourses);
        
        // Filter by search
        courseSearch.addEventListener('input', filterCourses);
        
        function filterCourses() {
            const selectedCategory = categoryFilter.value;
            const searchTerm = courseSearch.value.toLowerCase();
            
            courseCards.forEach(card => {
                const cardCategory = card.dataset.category;
                const courseTitle = card.querySelector('h3').textContent.toLowerCase();
                
                // Check if card matches both filters
                const matchesCategory = !selectedCategory || cardCategory === selectedCategory;
                const matchesSearch = !searchTerm || courseTitle.includes(searchTerm);
                
                if (matchesCategory && matchesSearch) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }
    });
</script> 
