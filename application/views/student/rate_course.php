<!-- Page Header -->
<div class="bg-white shadow rounded-lg p-4 sm:p-6 xl:p-8 mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-gray-900 mb-2"><?= $title ?></h1>
            <p class="text-sm text-gray-600">
                Share your feedback about <span class="font-semibold"><?= $course->title ?></span>
            </p>
        </div>
        <a href="<?= base_url('student/course/' . $course->id) ?>" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded inline-flex items-center text-sm">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Course
        </a>
    </div>
</div>

<!-- Rating Form -->
<div class="bg-white shadow rounded-lg p-4 sm:p-6 xl:p-8">
    <?= form_open('student/rate_course/' . $course->id, ['class' => 'space-y-6']) ?>
        
        <!-- Rating Section -->
        <div>
            <h2 class="text-lg font-medium text-gray-900 mb-4">Your Rating</h2>
            
            <!-- Star Rating -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-3">How would you rate this course? *</label>
                <div class="flex items-center space-x-1">
                    <?php for ($i = 5; $i >= 1; $i--): ?>
                        <label class="cursor-pointer">
                            <input type="radio" 
                                   name="rating" 
                                   value="<?= $i ?>" 
                                   class="sr-only" 
                                   <?= (isset($rating) && $rating->rating == $i) ? 'checked' : ((!isset($rating) && $i == 5) ? 'checked' : '') ?>>
                            <svg class="w-8 h-8 <?= (isset($rating) && $rating->rating >= $i) ? 'text-yellow-400' : 'text-gray-300' ?> hover:text-yellow-400 transition-colors star-<?= $i ?>" 
                                 fill="currentColor" 
                                 stroke="currentColor" 
                                 viewBox="0 0 24 24" 
                                 xmlns="http://www.w3.org/2000/svg"
                                 onclick="setRating(<?= $i ?>)">
                                <path stroke-linecap="round" 
                                      stroke-linejoin="round" 
                                      stroke-width="2" 
                                      d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z">
                                </path>
                            </svg>
                        </label>
                    <?php endfor; ?>
                </div>
                <div class="mt-2 text-sm font-medium rating-text">
                    <?php
                        $rating_text = [
                            1 => 'Poor',
                            2 => 'Fair',
                            3 => 'Good',
                            4 => 'Very Good',
                            5 => 'Excellent'
                        ];
                        $current_rating = isset($rating) ? $rating->rating : 5;
                        echo $rating_text[$current_rating];
                    ?>
                </div>
                <?= form_error('rating', '<div class="text-red-600 text-sm mt-1">', '</div>') ?>
            </div>
            
            <!-- Review -->
            <div class="mb-6">
                <label for="review" class="block text-sm font-medium text-gray-700 mb-2">Your Review</label>
                <textarea id="review" 
                          name="review" 
                          rows="5"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                          placeholder="Share your experience with this course..."><?= isset($rating) ? $rating->review : set_value('review') ?></textarea>
                <p class="text-sm text-gray-500 mt-1">Optional: Share your thoughts about the course content, instructor, and overall experience</p>
            </div>
        </div>
        
        <!-- Form Actions -->
        <div class="flex justify-between pt-6 border-t border-gray-200">
            <a href="<?= base_url('student/course/' . $course->id) ?>" 
               class="bg-gray-300 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-400 transition-colors">
                Cancel
            </a>
            <button type="submit" 
                    class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition-colors">
                <svg class="inline h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                Submit Rating
            </button>
        </div>
        
    <?= form_close() ?>
</div>

<!-- Rating Guidelines -->
<div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4 sm:p-6">
    <div class="flex items-start">
        <div class="flex-shrink-0">
            <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <div class="ml-3">
            <h3 class="text-sm font-medium text-blue-800">Rating Guidelines</h3>
            <div class="mt-2 text-sm text-blue-700">
                <ul class="list-disc pl-5 space-y-1">
                    <li><strong>5 stars (Excellent):</strong> Outstanding course that exceeded expectations</li>
                    <li><strong>4 stars (Very Good):</strong> High-quality course with minor areas for improvement</li>
                    <li><strong>3 stars (Good):</strong> Solid course that meets expectations</li>
                    <li><strong>2 stars (Fair):</strong> Course has significant issues that affected learning</li>
                    <li><strong>1 star (Poor):</strong> Course did not meet basic standards</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
    function setRating(rating) {
        // Update hidden input value
        document.querySelector('input[name="rating"][value="' + rating + '"]').checked = true;
        
        // Update star colors
        for (let i = 1; i <= 5; i++) {
            const star = document.querySelector('.star-' + i);
            if (i <= rating) {
                star.classList.remove('text-gray-300');
                star.classList.add('text-yellow-400');
            } else {
                star.classList.remove('text-yellow-400');
                star.classList.add('text-gray-300');
            }
        }
        
        // Update rating text
        const ratingTexts = {
            1: 'Poor',
            2: 'Fair',
            3: 'Good',
            4: 'Very Good',
            5: 'Excellent'
        };
        
        document.querySelector('.rating-text').textContent = ratingTexts[rating];
    }
</script> 
