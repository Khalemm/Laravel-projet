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
    var code_postal = 0;
    var nom_commune = 0;
    //pour les propriétés dans la requete...
    for (const property in resultatJSON["context"]) {
        var propriété = resultatJSON["context"][property]["id"];
        const found = propriété.match(/[a-z]*/);
        //si c'est un code postal :
        if(found[0] == "postcode") {
            code_postal = resultatJSON["context"][property]["text"];
        }
        //si c'est un arrondissement/lieu-dit :
        if(found[0] == "locality") {
            nom_commune = resultatJSON["context"][property]["text"];
        }
        //si lieu-dit/arrondissement pas trouvé et que c'est un lieu :
        if(found[0] == "place" && nom_commune == 0) {
            nom_commune = resultatJSON["context"][property]["text"];
        }
    }
    var adresse = resultatJSON["place_name"];

    document.getElementById('latitude').setAttribute('value', latitude);

    document.getElementById('longitude').setAttribute('value', longitude);

    document.getElementById('code_postal').setAttribute('value', code_postal);

    document.getElementById('nom_commune').setAttribute('value', nom_commune);

    document.getElementById('adresse').setAttribute('value', adresse);

    console.log(resultatJSON);

}); 
