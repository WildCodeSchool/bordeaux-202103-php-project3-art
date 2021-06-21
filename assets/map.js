import L from 'leaflet';
import 'devbridge-autocomplete';

console.log('Propiétés de L', L);

const artistCards = document.getElementsByClassName('artist-card');

delete L.Icon.Default.prototype._getIconUrl;
L.Icon.Default.mergeOptions({
    iconRetinaUrl: require('leaflet/dist/images/marker-icon-2x.png'),
    iconUrl: require('leaflet/dist/images/marker-icon.png'),
    shadowUrl: require('leaflet/dist/images/marker-shadow.png'),
});

require('leaflet-easybutton');
require('@ansur/leaflet-pulse-icon');

const moveCursor = L.icon({
    iconUrl: '/uploads/images/cursors/cursor-Cmove.png',

    iconSize: [40, 40],
    iconAnchor: [20, 40],
    popupAnchor: [0, -20],
});
const visuCursor = L.icon({
    iconUrl: '/uploads/images/cursors/cursor-Cvisu.png',

    iconSize: [40, 40],
    iconAnchor: [20, 40],
    popupAnchor: [0, -20],
});
const lettersCursor = L.icon({
    iconUrl: '/uploads/images/cursors/cursor-Cletters.png',

    iconSize: [40, 40],
    iconAnchor: [20, 40],
    popupAnchor: [0, -20],
});
const musicCursor = L.icon({
    iconUrl: '/uploads/images/cursors/cursor-Cmusic.png',

    iconSize: [40, 40],
    iconAnchor: [20, 40],
    popupAnchor: [0, -20],
});
const CCursor = L.icon({
    iconUrl: '/uploads/images/cursors/cursor-C.png',

    iconSize: [40, 40],
    iconAnchor: [20, 40],
    popupAnchor: [0, -20],
});
const map = L.map('map').setView([46, -0.57918], 7);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
}).addTo(map);
for (const artistCard of artistCards) {
    switch (artistCard.dataset.color) {
    case 'move':
        L.marker([artistCard.dataset.latitude, artistCard.dataset.longitude], { icon: moveCursor }).addTo(map).bindPopup(artistCard.innerHTML);
        break;
    case 'visu':
        L.marker([artistCard.dataset.latitude, artistCard.dataset.longitude], { icon: visuCursor }).addTo(map).bindPopup(artistCard.innerHTML);
        break;
    case 'letters':
        L.marker([artistCard.dataset.latitude, artistCard.dataset.longitude], { icon: lettersCursor }).addTo(map).bindPopup(artistCard.innerHTML);
        break;
    case 'music':
        L.marker([artistCard.dataset.latitude, artistCard.dataset.longitude], { icon: musicCursor }).addTo(map).bindPopup(artistCard.innerHTML);
        break;
    default:
        L.marker([artistCard.dataset.latitude, artistCard.dataset.longitude], { icon: CCursor }).addTo(map).bindPopup(artistCard.innerHTML);
        break;
    }
}
