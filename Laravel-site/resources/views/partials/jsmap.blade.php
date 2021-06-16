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

@foreach ((array)$biens as $bien)
    console.log( "{{ $bien['adresse'] }}" );
    var marker = L.marker([{{ $bien['latitude'] }}, {{ $bien['longitude'] }}]).addTo(mymap);
    marker.bindPopup("{{ $bien['adresse'] }}");
@endforeach

</script>