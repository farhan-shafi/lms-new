<!-- Hero Section with Video Background -->
<section class="relative overflow-hidden bg-gradient-to-r from-indigo-800 to-purple-800 text-white rounded-xl">
    <!-- Video Background with Overlay -->
    <div class="absolute inset-0 bg-black opacity-30 rounded-xl"></div>
    
    <div class="container mx-auto px-4 py-24 relative z-10">
        <div class="flex flex-col md:flex-row items-center">
            <div class="md:w-1/2 mb-12 md:mb-0">
                <h1 class="text-5xl md:text-6xl font-bold mb-6 leading-tight">
                    Transform Your Future with <span class="text-yellow-300">Mentora</span>
                </h1>
                <p class="text-xl mb-8 text-indigo-100 max-w-lg">
                    Access high-quality courses taught by industry experts and elevate your skills in a supportive learning environment.
                </p>
                <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="<?= base_url('home/courses') ?>" class="bg-white text-indigo-800 hover:bg-indigo-100 font-bold py-4 px-8 rounded-lg text-center transition duration-300 transform hover:scale-105 shadow-lg">
                        Explore Courses
                    </a>
                    <?php if (!$this->session->userdata('logged_in')): ?>
                        <a href="<?= base_url('auth/register') ?>" class="bg-transparent hover:bg-indigo-700 text-white font-bold py-4 px-8 rounded-lg border-2 border-white text-center transition duration-300 transform hover:scale-105">
                            Join For Free
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="md:w-1/2 flex justify-center">
                <img src="<?= base_url('uploads/images/hero-education.jpg') ?>" alt="Education" class="rounded-lg">
            </div>
        </div>
    </div>
</section>


<!-- Featured Courses Section -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Featured Courses</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Discover our most popular courses and start your learning journey today.</p>
        </div>
        
        <?php if (empty($courses)): ?>
            <div class="text-center py-8">
                <p class="text-gray-600 text-lg">No courses available yet.</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach (array_slice($courses, 0, 6) as $course): ?>
                    <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300 transform hover:scale-[1.02]">
                        <?php if ($course->thumbnail): ?>
                            <img src="<?= base_url('uploads/thumbnails/' . $course->thumbnail) ?>" alt="<?= $course->title ?>" class="w-full h-48 object-cover">
                        <?php else: ?>
                            <div class="w-full h-48 bg-gradient-to-r from-indigo-500 to-purple-500 flex items-center justify-center">
                                <span class="text-white text-lg font-semibold"><?= $course->title ?></span>
                            </div>
                        <?php endif; ?>
                        <div class="p-6">
                            <div class="flex justify-between items-center mb-2">
                                <span class="px-3 py-1 bg-indigo-100 text-indigo-800 text-xs font-semibold rounded-full"><?= $course->category_name ?? 'Uncategorized' ?></span>
                                <span class="text-xs text-gray-500">By <?= $course->instructor_name ?></span>
                            </div>
                            <h3 class="text-xl font-bold mb-2 text-gray-800"><?= $course->title ?></h3>
                            <!-- Course Rating -->
                            <?php if (isset($course->average_rating)): ?>
                            <div class="flex items-center mb-2">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <?php if ($i <= round($course->average_rating)): ?>
                                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                    <?php else: ?>
                                        <svg class="h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                    <?php endif; ?>
                                <?php endfor; ?>
                                <span class="ml-2 text-sm text-gray-600"><?= number_format($course->average_rating, 1) ?> (<?= $course->rating_count ?? 0 ?> reviews)</span>
                            </div>
                            <?php else: ?>
                            <div class="flex items-center mb-2">
                                <span class="text-sm text-gray-500">No ratings yet</span>
                            </div>
                            <?php endif; ?>
                            <p class="text-gray-600 mb-4 line-clamp-2"><?= character_limiter($course->description, 100) ?></p>
                            <a href="<?= base_url('home/course/' . $course->id) ?>" class="block text-center bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg transition duration-300">
                                View Course
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <?php if (count($courses) > 6): ?>
                <div class="text-center mt-12">
                    <a href="<?= base_url('home/courses') ?>" class="inline-block bg-indigo-100 text-indigo-700 font-medium py-3 px-8 rounded-lg shadow-sm hover:shadow hover:bg-indigo-200 transition-all transform hover:scale-105">
                        View All Courses
                    </a>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</section>

<!-- Categories Section -->
<section class="py-16 bg-white rounded-xl">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Browse by Category</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Find the perfect course by exploring our diverse categories.</p>
        </div>
        
        <?php if (empty($categories)): ?>
            <div class="text-center py-8">
                <p class="text-gray-600 text-lg">No categories available yet.</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <?php foreach ($categories as $category): ?>
                    <a href="<?= base_url('home/category/' . $category->id) ?>" class="group">
                        <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 text-center group-hover:bg-gradient-to-br group-hover:from-indigo-100 group-hover:to-indigo-200 h-full flex items-center justify-center">
                            <h3 class="text-lg font-semibold text-indigo-700 group-hover:text-indigo-800"><?= $category->name ?></h3>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Features Section -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Why Choose Mentora?</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Our platform offers everything you need to succeed in your learning journey.</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300">
                <div class="bg-indigo-100 w-16 h-16 rounded-full flex items-center justify-center mb-6 mx-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-3 text-center">Expert Instructors</h3>
                <p class="text-gray-600 text-center">Learn from industry professionals with years of experience in their fields.</p>
            </div>
            
            <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300">
                <div class="bg-indigo-100 w-16 h-16 rounded-full flex items-center justify-center mb-6 mx-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-3 text-center">Self-Paced Learning</h3>
                <p class="text-gray-600 text-center">Study at your own pace with lifetime access to course materials.</p>
            </div>
            
            <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300">
                <div class="bg-indigo-100 w-16 h-16 rounded-full flex items-center justify-center mb-6 mx-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-3 text-center">Interactive Content</h3>
                <p class="text-gray-600 text-center">Engage with quizzes, assignments, and hands-on projects to reinforce learning.</p>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="py-16 bg-indigo-50 rounded-t-xl">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">What Our Students Say</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Hear from our community of learners about their experience with Mentora.</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300">
                <div class="flex items-center mb-4">
                    <div class="bg-indigo-100 w-12 h-12 rounded-full flex items-center justify-center mr-4">
                        <span class="text-indigo-700 font-bold text-xl">S</span>
                    </div>
                    <div>
                        <h4 class="font-bold">Sarah Johnson</h4>
                        <p class="text-gray-600 text-sm">Web Development Student</p>
                    </div>
                </div>
                <div class="flex mb-4">
                    <?php for ($i = 0; $i < 5; $i++): ?>
                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                    <?php endfor; ?>
                </div>
                <p class="text-gray-600">"The courses on Mentora helped me transition from a complete beginner to a confident web developer in just a few months. The instructors are amazing!"</p>
            </div>
            
            <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300">
                <div class="flex items-center mb-4">
                    <div class="bg-indigo-100 w-12 h-12 rounded-full flex items-center justify-center mr-4">
                        <span class="text-indigo-700 font-bold text-xl">M</span>
                    </div>
                    <div>
                        <h4 class="font-bold">Michael Chen</h4>
                        <p class="text-gray-600 text-sm">Data Science Student</p>
                    </div>
                </div>
                <div class="flex mb-4">
                    <?php for ($i = 0; $i < 5; $i++): ?>
                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                    <?php endfor; ?>
                </div>
                <p class="text-gray-600">"The data science courses are comprehensive and up-to-date with the latest industry trends. I landed my dream job thanks to the skills I gained here."</p>
            </div>
            
            <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300">
                <div class="flex items-center mb-4">
                    <div class="bg-indigo-100 w-12 h-12 rounded-full flex items-center justify-center mr-4">
                        <span class="text-indigo-700 font-bold text-xl">A</span>
                    </div>
                    <div>
                        <h4 class="font-bold">Aisha Patel</h4>
                        <p class="text-gray-600 text-sm">Digital Marketing Student</p>
                    </div>
                </div>
                <div class="flex mb-4">
                    <?php for ($i = 0; $i < 5; $i++): ?>
                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                    <?php endfor; ?>
                </div>
                <p class="text-gray-600">"The practical approach to digital marketing has been invaluable. I've been able to immediately apply what I've learned to grow my business."</p>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action Section -->
<section class="py-20 bg-gradient-to-r from-indigo-800 to-purple-800 text-white rounded-b-xl">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-6">Ready to Start Your Learning Journey?</h2>
        <p class="text-xl mb-8 max-w-3xl mx-auto">Join thousands of students already learning on Mentora. Start your journey today and unlock your full potential.</p>
        <?php if (!$this->session->userdata('logged_in')): ?>
            <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-6">
                <a href="<?= base_url('auth/register') ?>" class="bg-white text-indigo-700 hover:bg-indigo-100 font-medium py-4 px-10 rounded-lg shadow-lg hover:shadow-xl transition-all transform hover:scale-105">
                    Sign Up Now
                </a>
                <a href="<?= base_url('auth/login') ?>" class="bg-transparent hover:bg-indigo-700 text-white font-medium py-4 px-10 rounded-lg border-2 border-white hover:shadow-lg transition-all transform hover:scale-105">
                    Login
                </a>
            </div>
        <?php else: ?>
            <a href="<?= base_url('home/courses') ?>" class="bg-white text-indigo-700 hover:bg-indigo-100 font-medium py-4 px-10 rounded-lg shadow-lg hover:shadow-xl transition-all transform hover:scale-105">
                Explore All Courses
            </a>
        <?php endif; ?>
    </div>
</section>
