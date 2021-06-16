const profileInput = document.getElementById('user_avatar_imageFile_file');
profileInput.addEventListener('change', (e) => {
    const fileName = profileInput.files[0].name;
    const nextSibling = e.target.nextElementSibling;
    nextSibling.innerText = fileName;
});
