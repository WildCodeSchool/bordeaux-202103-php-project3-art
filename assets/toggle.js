// const triggers = document.getElementsByClassName('trigger');
// let itemClicked;
// for (const trigger of triggers) {
//     trigger.addEventListener('click' , (e) => {
//         const allDivShow = document.getElementsByClassName('show'); for (const div of allDivShow) {
//             div.classList.remove('show');
//         }
//     })
// }

const artists = document.getElementsByClassName('artist');
console.log(artists);
for (const artist of artists) {
    artist.addEventListener('click',(e) => {
        console.log(artist.dataset.target);
        const target = document.getElementById(artist.dataset.target);
        console.log(target);
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