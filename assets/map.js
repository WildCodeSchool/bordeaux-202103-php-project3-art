const artistCards = document.getElementsByClassName('artist-card');
let moveCursor = L.icon({
    iconUrl: '/uploads/images/cursors/cursor-Cmove.png',

    iconSize:     [40, 40], // size of the icon
    iconAnchor:   [20, 40], // point of the icon which will correspond to marker's location
    popupAnchor:  [0, -20] // point from which the popup should open relative to the iconAnchor
});
let visuCursor = L.icon({
    iconUrl: '/uploads/images/cursors/cursor-Cvisu.png',

    iconSize:     [40, 40], // size of the icon
    iconAnchor:   [20, 40], // point of the icon which will correspond to marker's location
    popupAnchor:  [0, -20] // point from which the popup should open relative to the iconAnchor
});
let lettersCursor = L.icon({
    iconUrl: '/uploads/images/cursors/cursor-Cletters.png',

    iconSize:     [40, 40], // size of the icon
    iconAnchor:   [20, 40], // point of the icon which will correspond to marker's location
    popupAnchor:  [0, -20] // point from which the popup should open relative to the iconAnchor
});
let musicCursor = L.icon({
    iconUrl: '/uploads/images/cursors/cursor-Cmusic.png',

    iconSize:     [40, 40], // size of the icon
    iconAnchor:   [20, 40], // point of the icon which will correspond to marker's location
    popupAnchor:  [0, -20] // point from which the popup should open relative to the iconAnchor
});
let CCursor = L.icon({
    iconUrl: '/uploads/images/cursors/cursor-C.png',

    iconSize:     [40, 40], // size of the icon
    iconAnchor:   [20, 40], // point of the icon which will correspond to marker's location
    popupAnchor:  [0, -20] // point from which the popup should open relative to the iconAnchor
});
let map = L.map('map').setView([46, -0.57918], 7);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);
for (const artistCard of artistCards) {
    switch (artistCard.dataset.color) {
        case 'move':
            L.marker([artistCard.dataset.latitude, artistCard.dataset.longitude],{icon:moveCursor}).addTo(map).bindPopup(artistCard.innerHTML);
        break;
        case 'visu':
            L.marker([artistCard.dataset.latitude, artistCard.dataset.longitude],{icon:visuCursor}).addTo(map).bindPopup(artistCard.innerHTML);
        break;
        case 'letters':
            L.marker([artistCard.dataset.latitude, artistCard.dataset.longitude],{icon:lettersCursor}).addTo(map).bindPopup(artistCard.innerHTML);
        break;
        case 'music':
            L.marker([artistCard.dataset.latitude, artistCard.dataset.longitude],{icon:musicCursor}).addTo(map).bindPopup(artistCard.innerHTML);
        break;
        default :
            L.marker([artistCard.dataset.latitude, artistCard.dataset.longitude],{icon:CCursor}).addTo(map).bindPopup(artistCard.innerHTML);
        break;

    }
}
