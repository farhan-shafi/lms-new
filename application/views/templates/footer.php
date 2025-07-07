    </main>

    <!-- Footer -->
    <footer class="bg-indigo-800 text-white py-8 mt-auto">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0">
                    <h2 class="text-xl font-bold">Learning Management System</h2>
                    <p class="text-indigo-200 mt-1">Expand your knowledge with our courses</p>
                </div>
                <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-6">
                    <a href="<?= base_url() ?>" class="hover:text-indigo-200">Home</a>
                    <a href="<?= base_url('home/courses') ?>" class="hover:text-indigo-200">Courses</a>
                    <?php if (!$this->session->userdata('logged_in')): ?>
                        <a href="<?= base_url('auth/login') ?>" class="hover:text-indigo-200">Login</a>
                        <a href="<?= base_url('auth/register') ?>" class="hover:text-indigo-200">Register</a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="border-t border-indigo-700 mt-6 pt-6 text-center text-indigo-300 text-sm">
                &copy; <?= date('Y') ?> Learning Management System. All rights reserved.
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
