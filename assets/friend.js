document.querySelector('#friend').addEventListener('click', addToFriends);

const textFriend = document.getElementById('text-friend');

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
            textFriend.innerHTML = 'Ajouté.e à mes contacts favoris !';
        } else {
            friendIcon.classList.remove('fas');
            friendIcon.classList.add('far');
            textFriend.innerHTML = "Ajouter à mes contacts favoris";
        }
    });
}
