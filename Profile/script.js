// Get elements
const profilePicture = document.getElementById('profile-picture');
const pictureUpload = document.getElementById('picture-upload');
const uploadButton = document.getElementById('upload-button');
const nameInput = document.getElementById('name-input');
const saveButton = document.getElementById('save-button');

// Add event listeners
uploadButton.addEventListener('click', () => {
    pictureUpload.click();
});

pictureUpload.addEventListener('change', (e) => {
    const file = e.target.files[0];
    const reader = new FileReader();
    reader.onload = () => {
        profilePicture.src = reader.result;
    };
    reader.readAsDataURL(file);
});

saveButton.addEventListener('click', () => {
    const name = nameInput.value;
    const pictureSrc = profilePicture.src;
    // Save changes to local storage or other client-side storage
    localStorage.setItem('userName', name);
    localStorage.setItem('userPicture', pictureSrc);
    alert('Changes saved!');
});

// Load saved data from local storage
const savedName = localStorage.getItem('userName');
const savedPicture = localStorage.getItem('userPicture');

if (savedName) {
    nameInput.value = savedName;
}
if (savedPicture) {
    profilePicture.src = savedPicture;
}