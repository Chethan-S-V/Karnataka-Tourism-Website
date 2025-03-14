 // Toggle dropdown menu on profile image click
 const profileImage = document.getElementById('profileImage');
 const dropdownMenu = document.getElementById('dropdownMenu');

 profileImage.addEventListener('click', () => {
     dropdownMenu.classList.toggle('active');
 });

 // Close the dropdown when clicking outside
 document.addEventListener('click', (event) => {
     if (!profileImage.contains(event.target) && !dropdownMenu.contains(event.target)) {
         dropdownMenu.classList.remove('active');
     }
 });

 // JavaScript for Image Slider
const slider = document.querySelector('.slider');
const slides = document.querySelectorAll('.slide');
const prevBtn = document.querySelector('.prev-btn');
const nextBtn = document.querySelector('.next-btn');

let currentIndex = 0;

// Function to move to the next slide
function nextSlide() {
    currentIndex = (currentIndex + 1) % slides.length;
    updateSlider();
}

// Function to move to the previous slide
function prevSlide() {
    currentIndex = (currentIndex - 1 + slides.length) % slides.length;
    updateSlider();
}

// Function to update the slider position
function updateSlider() {
    slider.style.transform = `translateX(-${currentIndex * 100}%)`;
}

// Event listeners for navigation buttons
nextBtn.addEventListener('click', nextSlide);
prevBtn.addEventListener('click', prevSlide);

// Optional: Auto-slide functionality
setInterval(nextSlide, 5000); // Change slide every 5 seconds
