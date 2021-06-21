@php
    $biens = json_decode($listebiens,TRUE);
    $cptcarte = 0;
@endphp


@foreach ((array)$biens as $bien)
    <div class="element-liste">
        <div class="popup card">
            <div class="haut-de-carte card-header">
                <div class="texte-header">
                    <p>{{ $cptcarte+=1 }}. {{ $bien['distance'] }} mètres</p>
                    <p class="adresse">{{ $bien['adresse'] }}</p>
                    <p class="code-postal">{{ $bien['code_postal'] }} {{ $bien['nom_commune'] }}</p>
                </div>
                <div class="prix">
                    <p class="total">{{ preg_replace('/(?<=\d)(?=(\d{3})+$)/', ' ', $bien['valeur_fonciere']) }} €</p> <!-- format du prix changé -->
                </div>
            </div>
            <div class="millieu-de-carte card-body">
                <div class="info-gauche">
                    <div class="type-batiment">
                        <p>{{ $bien['type_local'] }}  {{ $bien['nombre_pieces_principales'] }} pièces</p>
                    </div>
                    <p>Surface : {{ $bien['surface_reelle_bati'] }} m²  </p>
                </div>
                <div class="info-droite">
                    <p>{{ preg_replace('/(?<=\d)(?=(\d{3})+$)/', ' ', $bien['z_prixm2']) }} €/m²  </p><!-- format changé -->
                @if($bien['type_local'] == "Maison")
                    <p>Terrain : {{ $bien['surface_terrain'] }} m²  </p>
                @endif
                </div>
            </div>
            <div class="bas-de-carte card-footer">
                <p>{{ $bien['nature_mutation'] }} le <strong>{{ $bien['date_mutation'] }}</strong></p>
            </div>
        </div>
    </div>
    
@endforeach

