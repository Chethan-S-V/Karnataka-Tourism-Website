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