document.querySelector('#friend').addEventListener('click', addToFriends);

function addToFriends(event) {

    event.preventDefault();

    let friendLink = event.currentTarget;
    let link = friendLink.href;

    fetch(link)
        .then(res => res.json())
        .then(function (res){
        let friendIcon = friendLink.firstElementChild;
        if (res.isFriend) {
            friendIcon.classList.remove('far');
            friendIcon.classList.add('fas');
        } else {
            friendIcon.classList.remove('fas');
            friendIcon.classList.add('far');
        }
    });
}
