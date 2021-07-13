const profileInput = document.querySelector('.custom-file-input');
profileInput.addEventListener('change', (e) => {
    const fileName = profileInput.files[0].name;
    const nextSibling = e.target.nextElementSibling;
    nextSibling.innerText = fileName;
});
