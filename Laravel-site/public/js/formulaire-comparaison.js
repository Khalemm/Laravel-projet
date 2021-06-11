mapboxgl.accessToken = 'pk.eyJ1IjoieWNvdXN0b3UiLCJhIjoiY2twM3ozcjNxMjhvNTJ3bXBubmd0MGt6eiJ9.E-zEULLIXG-SKK9J7sFQKg';
// initialise le géocodeur
var geocoder = new MapboxGeocoder({
    accessToken: mapboxgl.accessToken,
    countries: 'fr'  
});
// ajoute la barre de recherche
geocoder.addTo('#geocoder');

// obtention des données GPS du géocodeur.
geocoder.on('result', function (e) {
	var resultatJSON = JSON.stringify(e.result,null,5);
	resultatJSON = JSON.parse(resultatJSON);
	var latitude = resultatJSON["center"][1];
	var longitude = resultatJSON["center"][0];
	var code_postal = resultatJSON["context"][1]["text"];
	var nom_commune = resultatJSON["context"][2]["text"];
    var adresse = resultatJSON["place_name"];

    document.getElementById('latitude').setAttribute('value', latitude);

    document.getElementById('longitude').setAttribute('value', longitude);

    document.getElementById('code_postal').setAttribute('value', code_postal);

    document.getElementById('nom_commune').setAttribute('value', nom_commune);

    document.getElementById('adresse').setAttribute('value', adresse);

    console.log(resultatJSON);

}); 
