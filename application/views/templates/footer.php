    </main>

    <!-- Footer -->
    <footer class="bg-indigo-800 text-white py-8 mt-auto">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="24" viewBox="0 0 640 512" class="mr-3">
                        <path fill="currentColor" d="M320 32c-8.1 0-16.1 1.4-23.7 4.1L15.8 137.4C6.3 140.9 0 149.9 0 160s6.3 19.1 15.8 22.6l57.9 20.9C57.3 229.3 48 259.8 48 291.9V320c0 28.4-10.8 57.7-22.3 80.8c-6.5 13-13.9 25.8-22.5 37.6c-3.2 4.3-4.1 9.9-2.3 15s6 8.9 11.2 10.2l64 16c4.2 1.1 8.7.3 12.4-2s6.3-6.1 7.1-10.4c8.6-42.8 4.3-81.2-2.1-108.7c-3.2-14.2-7.5-28.7-13.5-42v-24.6c0-30.2 10.2-58.7 27.9-81.5c12.9-15.5 29.6-28 49.2-35.7l157-61.7c8.2-3.2 17.5.8 20.7 9s-.8 17.5-9 20.7l-157 61.7c-12.4 4.9-23.3 12.4-32.2 21.6l159.6 57.6c7.6 2.7 15.6 4.1 23.7 4.1s16.1-1.4 23.7-4.1l280.6-101c9.5-3.4 15.8-12.5 15.8-22.6s-6.3-19.1-15.8-22.6L343.7 36.1c-7.6-2.7-15.6-4.1-23.7-4.1M128 408c0 35.3 86 72 192 72s192-36.7 192-72l-15.3-145.4L354.5 314c-11.1 4-22.8 6-34.5 6s-23.5-2-34.5-6l-142.2-51.4z"/>
                    </svg>
                    <div>
                        <h2 class="text-xl font-bold">Mentora</h2>
                        <p class="text-indigo-200 mt-1">Where learners become leaders</p>
                    </div>
                </div>
                <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-6">
                    <a href="<?= base_url() ?>" class="hover:text-indigo-200">Home</a>
                    <a href="<?= base_url('home/courses') ?>" class="hover:text-indigo-200">Courses</a>
                    <a href="<?= base_url('home/about') ?>" class="hover:text-indigo-200">About</a>
                    <a href="<?= base_url('home/contact') ?>" class="hover:text-indigo-200">Contact</a>
                    <?php if (!$this->session->userdata('logged_in')): ?>
                        <a href="<?= base_url('auth/login') ?>" class="hover:text-indigo-200">Login</a>
                        <a href="<?= base_url('auth/register') ?>" class="hover:text-indigo-200">Register</a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="border-t border-indigo-700 mt-6 pt-6 text-center text-indigo-300 text-sm">
                &copy; <?= date('Y') ?> Mentora Learning Platform. All rights reserved.
            </div>
        </div>
    </footer>

    <!-- JavaScript for Mobile Menu Toggle -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuButton = document.querySelector('[data-toggle="mobile-menu"]');
            const mobileMenu = document.getElementById('mobile-menu');
            
            if (menuButton && mobileMenu) {
                menuButton.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                });
            }
        });
    </script>
</body>
</html> 
