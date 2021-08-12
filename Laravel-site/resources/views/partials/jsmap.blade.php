@php
	//données nécessaires (liste des biens,requete de l'utillisateur et requete de l'url)
    $biens = json_decode($listebiens,TRUE);
    $requete = json_decode($requeteinitial, TRUE);
	$urls = DB::select("SELECT format_url FROM map_access");
@endphp

<script>
//initialisation de leaflet avec la lon/lat de l'adresse demandé par l'utillisateur
var mymap = L.map('mapid').setView([{{$requete['latitude']}}, {{ $requete['longitude'] }}], 17);

L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoieWNvdXN0b3UiLCJhIjoiY2twM3ozcjNxMjhvNTJ3bXBubmd0MGt6eiJ9.E-zEULLIXG-SKK9J7sFQKg', {
    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
    maxZoom: 22,
    id: 'mapbox/streets-v11',
    tileSize: 512,
    zoomOffset: -1,
    accessToken: 'your.mapbox.access.token'
}).addTo(mymap);

var cptcarte = 0;
//bour tout les biens, vas crééer le popup correspondant simillaire aux cartes
@foreach ((array)$biens as $bien)
    cptcarte += 1;
    var description = '<div class="popup card carte">';
	    description +=	'<div class="haut-de-carte card-header">';
		description +=		'<div class="texte-header">';
		description +=			'<p><b class="border-num rounded-circle">'+cptcarte+'</b>&#160;&#160; {{ $bien['distance'] }} mètres</p>';
		description +=			'<p class="adresse">{{ $bien['adresse'] }}</p>';
		description +=			'<p class="code-postal">{{ $bien['code_postal'] }} {{ str_replace(" Arrondissement","",$bien['nom_commune']) }}</p>';
		description +=		'</div>';
		description +=		'<div class="prix">';
		description +=			'<p class="total">{{ preg_replace('/(?<=\d)(?=(\d{3})+$)/', ' ', $bien['valeur_fonciere']) }} €</p>'; // format du prix changé
		description +=			'<p>';
		description +=				'<a class="btn btn-outline-primary rounded-circle" href="{{str_replace("((longitude))",$bien['longitude'],str_replace("((latitude))",$bien['latitude'],$urls[0]->format_url))}}" target="_blank">V</a> ';
		description +=				'<a class="btn btn-outline-primary rounded-circle" href="{{str_replace("((longitude))",$bien['longitude'],str_replace("((latitude))",$bien['latitude'],$urls[1]->format_url))}}" target="_blank">M</a> ';
		description +=				'<a class="btn btn-outline-primary rounded-circle" href="{{str_replace("((longitude))",$bien['longitude'],str_replace("((latitude))",$bien['latitude'],$urls[2]->format_url))}}" target="_blank">S</a>';
		description +=			'</p>';
		description +=		'</div>';
		description +=	'</div>';
		description +=	'<div class="millieu-de-carte card-body">';
		description +=		'<div class="info-gauche">';
		description +=			'<div class="type-batiment">';
		description +=				'<p>{{ $bien['type_local'] }}  {{ $bien['nombre_pieces_principales'] }} pièces</p>';
		description +=			'</div>';
		description +=			'<p>Surface : {{ $bien['surface_reelle_bati'] }} m²  </p>';
		description +=          '<p>{{ $bien['nature_mutation'] }} le {{ date_format(new DateTime($bien['date_mutation']), 'd/m/Y') }}</p>';
		description +=		'</div>';
		description +=		'<div class="info-droite">';
		description +=			'<p>{{ preg_replace('/(?<=\d)(?=(\d{3})+$)/', ' ', $bien['z_prixm2']) }} € /m²  </p>'; // format changé
		//si c'est une maison, rajoute la surface du terrain
		if("{{ $bien['type_local'] }}" == "Maison") {
			description +=		'<p>Terrain : {{ $bien['surface_terrain'] }} m²  </p>';
		}
		description +=		'</div>';
		description +=	'</div>';
		description +='</div>';
	//vas affecter le popup créée avec le marqueur correspondant
    var marker = L.marker([{{ $bien['latitude'] }}, {{ $bien['longitude'] }}]).addTo(mymap);
    marker.bindPopup(description);
@endforeach

</script>