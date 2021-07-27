

const artists = document.getElementsByClassName('artist');
for (const artist of artists) {
    artist.addEventListener('click',(e) => {
        const target = document.getElementById(artist.dataset.target);
        const showedElements = document.getElementsByClassName('show');
        let showLink = 'link0';
        if (showedElements[0]){
            showLink = showedElements[0].dataset.link;
            showedElements[0].classList.add('hidden');
            showedElements[0].classList.remove('show');
        }
        if (target.dataset.link !== showLink) {
            target.classList.add('show');
            target.classList.remove('hidden');
        }





    })
}