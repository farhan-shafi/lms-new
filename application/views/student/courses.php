<!-- Page Header -->
<div class="bg-white shadow rounded-lg p-6 mb-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Browse Courses</h1>
            <p class="text-gray-600 mt-2">Discover and enroll in courses that match your learning goals.</p>
        </div>
        <div class="text-right">
            <p class="text-2xl font-bold text-blue-600"><?= count($courses) ?></p>
            <p class="text-sm text-gray-500">Available Courses</p>
        </div>
    </div>
</div>

<!-- Filter Section -->
<div class="bg-white shadow rounded-lg p-6 mb-6">
    <h2 class="text-lg font-medium text-gray-900 mb-4">Filter Courses</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Category Filter -->
        <div>
            <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Category</label>
            <select id="category" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">All Categories</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category->id ?>"><?= htmlspecialchars($category->name) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Search -->
        <div>
            <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search</label>
            <input type="text" 
                   id="search" 
                   placeholder="Search courses..."
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <!-- Sort -->
        <div>
            <label for="sort" class="block text-sm font-medium text-gray-700 mb-2">Sort By</label>
            <select id="sort" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="newest">Newest First</option>
                <option value="oldest">Oldest First</option>
                <option value="title">Title A-Z</option>
                <option value="title_desc">Title Z-A</option>
            </select>
        </div>
    </div>
</div>

<!-- Courses Grid -->
<div class="bg-white shadow rounded-lg p-6">
    <h2 class="text-2xl font-bold text-gray-900 mb-6">Available Courses</h2>

    <?php if (empty($courses)): ?>
        <div class="text-center py-16">
            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
            <h3 class="mt-4 text-lg font-medium text-gray-900">No courses available</h3>
            <p class="mt-2 text-gray-500">Check back later for new courses!</p>
        </div>
    <?php else: ?>
        <div id="courses-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($courses as $course): ?>
                <div class="course-card bg-white border border-gray-200 rounded-xl overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1" 
                     data-category="<?= $course->category_id ?>" 
                     data-title="<?= strtolower(htmlspecialchars($course->title)) ?>"
                     data-created="<?= strtotime($course->created_at) ?>">
                    
                    <!-- Course Image -->
                    <?php if (!empty($course->thumbnail)): ?>
                        <img src="<?= base_url('uploads/thumbnails/' . $course->thumbnail) ?>" 
                             alt="<?= htmlspecialchars($course->title) ?>" 
                             class="w-full h-48 object-cover">
                    <?php else: ?>
                        <div class="w-full h-48 bg-gradient-to-br from-blue-500 via-purple-500 to-indigo-600 flex items-center justify-center">
                            <svg class="h-20 w-20 text-white opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                    <?php endif; ?>
                    
                    <div class="p-6">
                        <!-- Course Category -->
                        <div class="mb-3">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                <?= htmlspecialchars($course->category_name ?? 'Uncategorized') ?>
                            </span>
                        </div>
                        
                        <!-- Course Title -->
                        <h3 class="text-xl font-bold text-gray-900 mb-3"><?= htmlspecialchars($course->title) ?></h3>
                        
                        <!-- Course Description -->
                        <p class="text-gray-600 text-sm mb-4 leading-relaxed"><?= character_limiter($course->description, 120) ?></p>
                        
                        <!-- Course Info -->
                        <div class="flex items-center justify-between text-sm text-gray-500 mb-6">
                            <span class="flex items-center">
                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <?= htmlspecialchars($course->instructor_name ?? 'Unknown') ?>
                            </span>
                            <span class="flex items-center">
                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2h5a1 1 0 110 2h-1v14a2 2 0 01-2 2H5a2 2 0 01-2-2V6H2a1 1 0 110-2h5z"></path>
                                </svg>
                                <?= isset($course->lesson_count) ? $course->lesson_count : '0' ?> lessons
                            </span>
                        </div>
                        
                        <!-- Course Meta -->
                        <div class="flex items-center justify-between text-xs text-gray-400 mb-4">
                            <span>Created: <?= date('M j, Y', strtotime($course->created_at)) ?></span>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <?= ucfirst($course->status) ?>
                            </span>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="space-y-3">
                            <a href="<?= base_url('student/course/' . $course->id) ?>" 
                               class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white text-center py-3 px-4 rounded-lg font-medium hover:from-blue-700 hover:to-blue-800 transition-all duration-200 transform hover:scale-105">
                                View Course Details
                            </a>
                            
                            <?php if (isset($course->is_enrolled) && $course->is_enrolled): ?>
                                <div class="w-full bg-green-100 text-green-800 text-center py-2 px-4 rounded-lg text-sm font-medium">
                                    <svg class="inline h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Already Enrolled
                                </div>
                            <?php else: ?>
                                <a href="<?= base_url('home/enroll/' . $course->id) ?>" 
                                   class="w-full bg-green-600 text-white text-center py-2 px-4 rounded-lg text-sm font-medium hover:bg-green-700 transition-colors">
                                    Enroll Now
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<!-- JavaScript for filtering -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const categoryFilter = document.getElementById('category');
    const searchInput = document.getElementById('search');
    const sortSelect = document.getElementById('sort');
    const coursesGrid = document.getElementById('courses-grid');
    const courseCards = document.querySelectorAll('.course-card');

    // Filter and search functionality
    function filterCourses() {
        const selectedCategory = categoryFilter.value;
        const searchTerm = searchInput.value.toLowerCase();
        const sortBy = sortSelect.value;

        let visibleCards = [];

        courseCards.forEach(card => {
            const cardCategory = card.dataset.category;
            const cardTitle = card.dataset.title;
            
            // Check category filter
            const categoryMatch = !selectedCategory || cardCategory === selectedCategory;
            
            // Check search term
            const searchMatch = !searchTerm || cardTitle.includes(searchTerm);
            
            if (categoryMatch && searchMatch) {
                card.style.display = 'block';
                visibleCards.push(card);
            } else {
                card.style.display = 'none';
            }
        });

        // Sort visible cards
        if (visibleCards.length > 0) {
            visibleCards.sort((a, b) => {
                switch (sortBy) {
                    case 'newest':
                        return parseInt(b.dataset.created) - parseInt(a.dataset.created);
                    case 'oldest':
                        return parseInt(a.dataset.created) - parseInt(b.dataset.created);
                    case 'title':
                        return a.dataset.title.localeCompare(b.dataset.title);
                    case 'title_desc':
                        return b.dataset.title.localeCompare(a.dataset.title);
                    default:
                        return 0;
                }
            });

            // Reorder cards in DOM
            visibleCards.forEach(card => {
                coursesGrid.appendChild(card);
            });
        }
    }

    // Add event listeners
    categoryFilter.addEventListener('change', filterCourses);
    searchInput.addEventListener('input', filterCourses);
    sortSelect.addEventListener('change', filterCourses);
});
</script>

<!-- Quick Navigation -->
<div class="mt-8 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-lg p-6">
    <div class="flex">
        <svg class="h-6 w-6 text-blue-600 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
        </svg>
        <div>
            <h3 class="text-lg font-medium text-blue-900 mb-2">Ready to Start Learning?</h3>
            <div class="text-blue-800 text-sm space-y-2">
                <p>• <strong>Explore:</strong> Browse through our course catalog to find topics that interest you</p>
                <p>• <strong>Enroll:</strong> Click "Enroll Now" on any course that catches your attention</p>
                <p>• <strong>Learn:</strong> Access video lessons, reading materials, and interactive content</p>
                <p>• <strong>Progress:</strong> Track your learning progress and earn completion certificates</p>
            </div>
            <div class="mt-4 flex space-x-4">
                <a href="<?= base_url('student/my_courses') ?>" class="text-blue-700 hover:text-blue-900 font-medium">
                    View My Enrolled Courses →
                </a>
                <a href="<?= base_url('student/dashboard') ?>" class="text-blue-700 hover:text-blue-900 font-medium">
                    Go to Dashboard →
                </a>
            </div>
        </div>
    </div>
</div> 
