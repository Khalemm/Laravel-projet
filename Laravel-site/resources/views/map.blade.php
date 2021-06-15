@extends('layouts.entete-pied')
@section('titre')
Résultat
@endsection

@section('scripts')
<!-- mapbox -->
<link href="https://api.mapbox.com/mapbox-gl-js/v2.2.0/mapbox-gl.css" rel="stylesheet">
<script src="https://api.mapbox.com/mapbox-gl-js/v2.2.0/mapbox-gl.js"></script>
@endsection

@section('contenu')
<!-- mapbox style et plugin -->
<script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.7.0/mapbox-gl-geocoder.min.js"></script>
<link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.7.0/mapbox-gl-geocoder.css" type="text/css">
<script src="https://cdn.jsdelivr.net/npm/es6-promise@4/dist/es6-promise.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/es6-promise@4/dist/es6-promise.auto.min.js"></script>

<div class="page">
    <div class="row">
      <!-- map et cards -->
      <div class="col-8">
        <div class="row mapbox-carte">
          <div id="map"></div>
        </div>
        
        <div class="row defilement-cartes" id="test">
          <div id="requete"></div>
        </div>
      </div>
      <!-- analyse des biens -->
      <div class="analyse-biens col-4">
          <h2>analyse des biens</h2>
      </div>
      
    </div>
</div>
@endsection

@section('scripts-pied')



<script type="text/javascript">
    var data = <?php echo json_encode(session('res')) ?>;
    var requete = <?php echo json_encode(session('req')) ?>;
</script>

<script type="text/javascript" src="{{ asset('js/carte-resultat.js') }}"></script>
@endsection