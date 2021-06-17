@php
    $biens = json_decode($listebiens,TRUE);
    $requete = json_decode($requeteinitial, TRUE);
@endphp

<script>
//initialisation de leaflet
var mymap = L.map('mapid').setView([{{$requete['latitude']}}, {{ $requete['longitude'] }}], 13);

L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoieWNvdXN0b3UiLCJhIjoiY2twM3ozcjNxMjhvNTJ3bXBubmd0MGt6eiJ9.E-zEULLIXG-SKK9J7sFQKg', {
    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
    maxZoom: 22,
    id: 'mapbox/streets-v11',
    tileSize: 512,
    zoomOffset: -1,
    accessToken: 'your.mapbox.access.token'
}).addTo(mymap);

var cptcarte = 0;
@foreach ((array)$biens as $bien)
    cptcarte += 1;
    var description = '<div class="popup card carte">';
	    description +=	'<div class="haut-de-carte card-header">';
		description +=		'<div class="texte-header">';
		description +=			'<p>'+cptcarte+'. {{ $bien['distance'] }} mètres</p>';
		description +=			'<p class="adresse">{{ $bien['adresse'] }}</p>';
		description +=			'<p class="code-postal">{{ $bien['code_postal'] }} {{ $bien['nom_commune'] }}</p>';
		description +=		'</div>';
		description +=		'<div class="prix">';
		description +=			'<p class="total">{{ $bien['valeur_fonciere'] }} €</p>';
		description +=		'</div>';
		description +=	'</div>';
		description +=	'<div class="millieu-de-carte card-body">';
		description +=		'<div class="info-gauche">';
		description +=			'<div class="type-batiment">';
		description +=				'<p>{{ $bien['type_local'] }}  {{ $bien['nombre_pieces_principales'] }} pièces</p>';
		description +=			'</div>';
		description +=			'<p>Surface : {{ $bien['surface_reelle_bati'] }} m²  </p>';
		description +=		'</div>';
		description +=		'<div class="info-droite">';
		description +=			'<p>{{ $bien['z_prixm2'] }} €/m²  </p>';
		if("{{ $bien['type_local'] }}" == "Maison") {
			description +=		'<p>Terrain : {{ $bien['surface_terrain'] }} m²  </p>';
		}
		description +=		'</div>';
		description +=	'</div>';
		description +=	'<div class="bas-de-carte card-footer">';
		description +=		'<p>{{ $bien['nature_mutation'] }} le <strong>{{ $bien['date_mutation'] }}</strong></p>';
		description +=	'</div>';
		description +='</div>';
    var marker = L.marker([{{ $bien['latitude'] }}, {{ $bien['longitude'] }}]).addTo(mymap);
    marker.bindPopup(description);
@endforeach

</script>