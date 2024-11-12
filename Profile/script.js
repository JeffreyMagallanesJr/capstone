// Get the elements
const profilePicture = document.getElementById('profile-picture');
const pictureUpload = document.getElementById('picture-upload');
const nameInput = document.getElementById('name-input');
const saveButton = document.getElementById('save-button');

// Load saved profile picture and name from localStorage if available
window.onload = function() {
    const savedPicture = localStorage.getItem('profilePicture');
    const savedName = localStorage.getItem('profileName');
    
    // If there's a saved profile picture, set it
    if (savedPicture) {
        profilePicture.src = savedPicture;
    }
    
    // If there's a saved profile name, set it
    if (savedName) {
        nameInput.value = savedName;
    }
};

// Handle image upload
pictureUpload.addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            profilePicture.src = e.target.result;
        };
        
        reader.readAsDataURL(file);  // Convert the image to a base64 URL
    }
});

// Save changes
saveButton.addEventListener('click', function() {
    const newName = nameInput.value;
    const newPicture = profilePicture.src;
    
    // Save the new name and picture in localStorage
    localStorage.setItem('profileName', newName);
    localStorage.setItem('profilePicture', newPicture);
    
    alert("Profile updated successfully!");
});
