mapboxgl.accessToken = 'pk.eyJ1IjoieWNvdXN0b3UiLCJhIjoiY2twM3ozcjNxMjhvNTJ3bXBubmd0MGt6eiJ9.E-zEULLIXG-SKK9J7sFQKg';

//conversion du json en geoJson pour correspondre aux attentes de Mapbox
var geojson = {
  type: "FeatureCollection",
  features: [],
};

for (i = 0; i < data.length; i++) {
    geojson.features.push({
	    "type": "Feature",
	    "geometry": {
	        "type": "Point",
	        "coordinates": [data[i].longitude, data[i].latitude]
	    },
	    "properties": {
		    "id_mutation": data[i].id_mutation,
		    "date_mutation": data[i].date_mutation,
		    "annee_mutation": data[i].annee_mutation,
		    "nature_mutation": data[i].nature_mutation,
		    "valeur_fonciere": data[i].valeur_fonciere,
		    "adresse": data[i].adresse,
		    "code_postal": data[i].code_postal,
		    "code_commune": data[i].code_commune,
		    "nom_commune": data[i].nom_commune,
		    "id_parcelle": data[i].id_parcelle,
		    "type_local": data[i].type_local,
		    "surface_reelle_bati": data[i].surface_reelle_bati,
		    "nombre_pieces_principales": data[i].nombre_pieces_principales,
		    "surface_terrain": data[i].surface_terrain,
		    "z_prixm2": data[i].z_prixm2,
		    "geom": data[i].geom,
		    "distance": data[i].distance,
		    "latitude": data[i].latitude,
		    "longitude": data[i].longitude
	    }
    });
}
console.log(geojson);

var coordonees = [];
coordonees = [requete.longitude, requete.latitude];

//créées la carte
var map = new mapboxgl.Map({
    container: 'map',
    style: 'mapbox://styles/mapbox/streets-v11',
    center: coordonees,
    zoom: 15
});

// //Créées un point qui pulse (point créée d'après MapBox)
// var size = 200;
// var pulsingDot = {
//     width: size,
//     height: size,
//     data: new Uint8Array(size * size * 4),

//     // When the layer is added to the map,
//     // get the rendering context for the map canvas.
//     onAdd: function () {
//         var canvas = document.createElement('canvas');
//         canvas.width = this.width;
//         canvas.height = this.height;
//         this.context = canvas.getContext('2d');
//     },

//     // Call once before every frame where the icon will be used.
//     render: function () {
//         var duration = 1000;
//         var t = (performance.now() % duration) / duration;

//         var radius = (size / 2) * 0.3;
//         var outerRadius = (size / 2) * 0.7 * t + radius;
//         var context = this.context;

//         // Draw the outer circle.
//         context.clearRect(0, 0, this.width, this.height);
//         context.beginPath();
//         context.arc(
//             this.width / 2,
//             this.height / 2,
//             outerRadius,
//             0,
//             Math.PI * 2
//         );
//         context.fillStyle = 'rgba(255, 200, 200,' + (1 - t) + ')';
//         context.fill();

//         // Draw the inner circle.
//         context.beginPath();
//         context.arc(
//             this.width / 2,
//             this.height / 2,
//             radius,
//             0,
//             Math.PI * 2
//         );
//         context.fillStyle = 'rgba(255, 100, 100, 1)';
//         context.strokeStyle = 'white';
//         context.lineWidth = 2 + 4 * (1 - t);
//         context.fill();
//         context.stroke();

//         // Update this image's data with data from the canvas.
//         this.data = context.getImageData(
//             0,
//             0,
//             this.width,
//             this.height
//         ).data;

//         // Continuously repaint the map, resulting
//         // in the smooth animation of the dot.
//         map.triggerRepaint();

//         // Return `true` to let the map know that the image was updated.
//         return true;
//     }
// };

// //ajoute des points
// map.on('load', function () {

//     map.addImage('pulsing-dot', pulsingDot, { pixelRatio: 2 });

//     //ajoute les coordonées du point central
//     map.addSource('localisation', {
//         'type': 'geojson',
//         'data': {
//             'type': 'FeatureCollection',
//             'features': [
//                 {
//                     'type': 'Feature',
//                     'geometry': {
//                         'type': 'Point',
//                         'coordinates': coordonees
//                     },
//                     'properties': {
//                         'title': 'Localisation'
//                     }
//                 }]
//         }
//     });

//     map.addLayer({
//         'id': 'localisation',
//         'type': 'symbol',
//         'source': 'localisation',
//         'layout': {
//             'icon-image': 'pulsing-dot'
//         }
//     });

//     // quand l'utillisateur clique sur le point central, affiche un popup
//     map.on('click', 'localisation', function (e) {
//         var description = '<div class="popup card carte">';
//         description += '<div class="haut-de-carte card-header">';
//         description += '<div class="texte-header">';
//         description += '<p class="adresse">' + data.Adresse + '</p>';
//         description += '</div>';
//         description += '</div>';
//         description += '</div>';



//         new mapboxgl.Popup()
//             .setLngLat(coordonees)
//             .setHTML(description)
//             .addTo(map);
//     });

//     //donne les coordonées des points
//     map.addSource('places', {
//         'type': 'geojson',
//         'data': geojson
//     });

//     // ajoute le style du point.
//     map.addLayer({
//         'id': 'places',
//         'type': 'circle',
//         'source': 'places',
//         'paint': {
//             'circle-color': '#4264fb',
//             'circle-radius': 6,
//             'circle-stroke-width': 2,
//             'circle-stroke-color': '#ffffff'
//         }
//     });

//     // quand l'utillisateur clique sur un point, affiche un popup
//     map.on('click', 'places', function (e) {
//         var coordinates = e.features[0].geometry.coordinates.slice();
//         var description = '<div class="popup card carte">';
//         description += '<div class="haut-de-carte card-header">';
//         description += '<div class="texte-header">';
//         description += '<p>' + "NOMBRE!" + '. ' + e.features[0].properties.distance + ' mètres</p>';
//         description += '<p class="adresse">' + e.features[0].properties.adresse + '</p>';
//         description += '<p class="code-postal">' + e.features[0].properties.code_postal + ' ' + e.features[0].properties.nom_commune + '</p>';
//         description += '</div>';
//         description += '<div class="prix">';
//         description += '<p class="total">' + e.features[0].properties.valeur_fonciere + ' €</p>';
//         description += '</div>';
//         description += '</div>';
//         description += '<div class="millieu-de-carte card-body">';
//         description += '<div class="info-gauche">';
//         description += '<div class="type-batiment">';
//         description += '<p>' + e.features[0].properties.type_local + '  ' + e.features[0].properties.nombre_pieces_principales + ' pièces</p>';
//         description += '</div>';
//         description += '<p>Surface : ' + e.features[0].properties.surface_reelle_bati + ' m²  </p>';
//         description += '</div>';
//         description += '<div class="info-droite">';
//         description += '<p>' + e.features[0].properties.z_prixm2 + ' €/m²  </p>';
//         if (e.features[0].properties.type_local == "Maison") {
//             description += '<p>Terrain : ' + e.features[0].properties.surface_terrain + ' m²  </p>';
//         }
//         description += '</div>';
//         description += '</div>';
//         description += '<div class="bas-de-carte card-footer">';
//         description += '<p>' + e.features[0].properties.nature_mutation + ' le <strong>' + e.features[0].properties.date_mutation + '</strong></p>';
//         description += '</div>';
//         description += '</div>';

//         // assure le bon affichage du popup meme avec un écran zoomé
//         while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
//             coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
//         }

//         new mapboxgl.Popup()
//             .setLngLat(coordinates)
//             .setHTML(description)
//             .addTo(map);
//     });

//     // change le curseur en pointeur quand il survole un point.
//     map.on('mouseenter', 'places', function () {
//         map.getCanvas().style.cursor = 'pointer';
//     });

//     // enlève le popup.
//     map.on('mouseleave', 'places', function () {
//         map.getCanvas().style.cursor = '';
//     });

//     // change le curseur en pointeur quand il survole un point.
//     map.on('mouseenter', 'places', function () {
//         map.getCanvas().style.cursor = 'pointer';
//     });

//     // enlève le popup.
//     map.on('mouseleave', 'places', function () {
//         map.getCanvas().style.cursor = '';
//     });
// });
