const block = document.getElementById("block-message");
const titles = document.getElementsByClassName("title-message");
const mailbox = document.getElementById("mailbox");
const contents = document.getElementsByClassName("content");


mailbox.addEventListener('click', () => {
    block.classList.toggle('d-none');
});


for (let i = 0; i < titles.length; i++) {
    titles[i].addEventListener('click', () => {
        contents[i].classList.toggle('d-none');
    });
}





