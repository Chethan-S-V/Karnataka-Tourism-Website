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







//Images slider Start//
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
// Image Slider End//








//Video with autoplay and volume on/off //
const video = document.getElementById('myVideo');
    const muteButton = document.getElementById('muteButton');

    // Intersection Observer to detect visibility
    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                video.play(); // Play when in view
            } else {
                video.pause(); // Pause when out of view
            }
        });
    }, { threshold: 0.5 }); // 50% visibility required

    observer.observe(video);

    // Mute/Unmute functionality
    muteButton.addEventListener('click', () => {
        video.muted = !video.muted;
        muteButton.innerHTML = video.muted 
            ? '<i class="fas fa-volume-mute"></i>' 
            : '<i class="fas fa-volume-up"></i>';
    });
    // Video End//


    // document.querySelectorAll('.social-icons a').forEach(link => {
    //     link.addEventListener('click', () => {
    //       console.log(`Navigating to: ${link.href}`);
    //     });
    //   });
