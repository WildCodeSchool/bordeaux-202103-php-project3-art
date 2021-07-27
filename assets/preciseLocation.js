import L from 'leaflet';
import 'devbridge-autocomplete';

const lonInput = document.getElementById('localisation_longitude');
const latInput = document.getElementById('localisation_latitude');
let marker = [];

let currentMarker;

delete L.Icon.Default.prototype._getIconUrl;
L.Icon.Default.mergeOptions({
    iconRetinaUrl: require('leaflet/dist/images/marker-icon-2x.png'),
    iconUrl: require('leaflet/dist/images/marker-icon.png'),
    shadowUrl: require('leaflet/dist/images/marker-shadow.png'),
});

require('leaflet-easybutton');
require('@ansur/leaflet-pulse-icon');

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

map.on('click', onMapClick);
function onMapClick(e)
{
    const { lat } = e.latlng;
    const lon = e.latlng.lng;

    currentMarker = L.marker([lat, lon], { icon: CCursor });
    marker.push(currentMarker);
    for(let i = 0; i < marker.length ;i++) {
        map.removeLayer(marker[i]);
    }
    currentMarker.addTo(map);
    lonInput.value = lon;
    latInput.value = lat;
}
const modalLauncher = document.getElementById('modal-launcher');
modalLauncher.addEventListener('click', () => {
    setTimeout(() => map.invalidateSize(), 200);
});
