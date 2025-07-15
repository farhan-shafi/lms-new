<!-- Hero Section -->
<section class="bg-gradient-to-r from-indigo-800 to-purple-800 text-white py-20 rounded-t-xl">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-6">About Mentora</h1>
            <p class="text-xl text-indigo-100">Empowering learners worldwide with quality education and skills development.</p>
        </div>
    </div>
</section>

<!-- Our Story Section -->
<section class="py-16 bg-white rounded-b-xl">
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row items-center gap-12">
            <div class="md:w-1/2">
                <img src="<?= base_url('uploads/images/about-team.jpg') ?>" alt="Our Story" class="rounded-lg">
            </div>
            <div class="md:w-1/2">
                <h2 class="text-3xl font-bold mb-6 text-gray-800">Our Story</h2>
                <p class="text-gray-600 mb-4">
                    Mentora was founded in 2020 with a simple mission: to make quality education accessible to everyone, everywhere. 
                    What started as a small collection of programming courses has grown into a comprehensive learning platform 
                    serving thousands of students across the globe.
                </p>
                <p class="text-gray-600 mb-4">
                    Our team of dedicated educators and technology experts work tirelessly to create engaging, 
                    practical courses that help students acquire valuable skills and advance their careers.
                </p>
                <p class="text-gray-600">
                    We believe that education is a powerful tool for change, and we're committed to helping 
                    our students transform their lives through learning.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Our Mission Section -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center mb-12">
            <h2 class="text-3xl font-bold mb-6 text-gray-800">Our Mission</h2>
            <p class="text-xl text-gray-600">
                To provide accessible, high-quality education that empowers individuals to achieve their full potential.
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
            <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300">
                <div class="bg-indigo-100 w-16 h-16 rounded-full flex items-center justify-center mb-6 mx-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-3 text-center">Accessibility</h3>
                <p class="text-gray-600 text-center">
                    Making education accessible to everyone regardless of location or background.
                </p>
            </div>
            
            <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300">
                <div class="bg-indigo-100 w-16 h-16 rounded-full flex items-center justify-center mb-6 mx-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-3 text-center">Quality</h3>
                <p class="text-gray-600 text-center">
                    Delivering high-quality content created by industry experts and experienced educators.
                </p>
            </div>
            
            <div class="bg-white p-8 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300">
                <div class="bg-indigo-100 w-16 h-16 rounded-full flex items-center justify-center mb-6 mx-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-3 text-center">Innovation</h3>
                <p class="text-gray-600 text-center">
                    Continuously improving our platform and courses to provide the best learning experience.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Our Team Section -->
<section class="py-16 bg-white rounded-xl">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center mb-12">
            <h2 class="text-3xl font-bold mb-6 text-gray-800">Meet Our Team</h2>
            <p class="text-xl text-gray-600">
                The passionate educators and experts behind Mentora's success.
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-5xl mx-auto">
            <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 text-center">
                <div class="w-32 h-32 rounded-full overflow-hidden mx-auto mb-4">
                    <img src="<?= base_url('uploads/images/farhan.jpg') ?>"  alt="Farhan Shafi" class="w-full h-full object-top object-cover">
                </div>
                <h3 class="text-xl font-bold mb-1">Farhan Shafi</h3>
                <p class="text-indigo-600 mb-3">Developer</p>
            </div>
            
            <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 text-center">
                <div class="w-32 h-32 rounded-full overflow-hidden mx-auto mb-4">
                    <img src="<?= base_url('uploads/images/sarim.jpeg') ?>"  alt="Sarim Mehmood" class="w-full h-full object-center object-cover">
                </div>
                <h3 class="text-xl font-bold mb-1">Sarim Mehmood</h3>
				<p class="text-indigo-600 mb-3">Developer</p>

            </div>
        </div>
    </div>
</section>

<!-- Our Values Section -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <h2 class="text-3xl font-bold mb-10 text-center text-gray-800">Our Core Values</h2>
            
            <div class="space-y-8">
                <div class="flex flex-col md:flex-row gap-6 items-start">
                    <div class="bg-indigo-100 w-16 h-16 rounded-full flex items-center justify-center flex-shrink-0 md:mt-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold mb-2 text-gray-800">Community</h3>
                        <p class="text-gray-600">
                            We foster a supportive community where students can connect, collaborate, and learn from each other. 
                            Our forums, study groups, and networking events create opportunities for meaningful interactions.
                        </p>
                    </div>
                </div>
                
                <div class="flex flex-col md:flex-row gap-6 items-start">
                    <div class="bg-indigo-100 w-16 h-16 rounded-full flex items-center justify-center flex-shrink-0 md:mt-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold mb-2 text-gray-800">Growth Mindset</h3>
                        <p class="text-gray-600">
                            We believe in the power of continuous learning and improvement. Our platform encourages students to 
                            embrace challenges, persist through obstacles, and view effort as a path to mastery.
                        </p>
                    </div>
                </div>
                
                <div class="flex flex-col md:flex-row gap-6 items-start">
                    <div class="bg-indigo-100 w-16 h-16 rounded-full flex items-center justify-center flex-shrink-0 md:mt-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold mb-2 text-gray-800">Adaptability</h3>
                        <p class="text-gray-600">
                            In a rapidly changing world, we prepare our students to adapt and thrive. Our curriculum is regularly 
                            updated to reflect industry trends and emerging technologies.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Join Us Section -->
<section class="py-20 bg-gradient-to-r from-indigo-800 to-purple-800 text-white rounded-xl">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-6">Join Our Learning Community</h2>
        <p class="text-xl mb-8 max-w-3xl mx-auto">
            Be part of a global community of learners and start your journey toward mastering new skills and achieving your goals.
        </p>
        <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-6">
            <a href="<?= base_url('home/courses') ?>" class="bg-white text-indigo-700 hover:bg-indigo-100 font-medium py-4 px-10 rounded-lg shadow-lg hover:shadow-xl transition-all transform hover:scale-105">
                Explore Courses
            </a>
            <?php if (!$this->session->userdata('logged_in')): ?>
                <a href="<?= base_url('auth/register') ?>" class="bg-transparent hover:bg-indigo-700 text-white font-medium py-4 px-10 rounded-lg border-2 border-white hover:shadow-lg transition-all transform hover:scale-105">
                    Join For Free
                </a>
            <?php endif; ?>
        </div>
    </div>
</section> 
