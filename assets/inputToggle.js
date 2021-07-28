const support = document.getElementById('artwork_media_support');
const inputUrl = document.getElementById('artwork_media_url');
const inputImage = document.getElementById('artwork_media_imageArtwork_imageFile_file');
const imageLabel = document.getElementsByClassName('custom-file-label')[0];
const urlLabel = document.getElementById('labelUrl');
const inputSelect = document.getElementById('artwork_media_support');
if (inputSelect.value === 'video'){
    inputUrl.classList.toggle('d-none');
    inputImage.classList.toggle('d-none');
    imageLabel.classList.toggle('d-none');
    urlLabel.classList.toggle('d-none');
}
support.addEventListener('change',() => {
    inputUrl.classList.toggle('d-none');
    inputImage.classList.toggle('d-none');
    imageLabel.classList.toggle('d-none');
    urlLabel.classList.toggle('d-none');
});