const triggers = document.getElementsByClassName('trigger');
console.log(triggers);
let itemClicked;
for (const trigger of triggers) {
    trigger.addEventListener('click',(e) => {
        const allDivShow = document.getElementsByClassName('show');
        for (const div of allDivShow) {
                div.classList.remove('show');
        }
    })
}