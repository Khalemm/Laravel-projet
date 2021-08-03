@php
    //données nécessaires (liste des biens et requete de l'url)
    $biens = json_decode($listebiens,TRUE);
    $cptcarte = 0;
    $urls = DB::select("SELECT format_url FROM map_access");
@endphp


@foreach ((array)$biens as $bien)
    <div class="element-liste">
        <div class="popup card liste">
            <div class="haut-de-carte card-header">
                <div class="texte-header">
                    <p><b class="border-num rounded-circle">{{ $cptcarte+=1 }}</b>&#160;&#160; {{ $bien['distance'] }} mètres</p>
                    <p class="adresse">{{ $bien['adresse'] }}</p>
                    <p class="code-postal">{{ $bien['code_postal'] }} {{ str_replace(" Arrondissement","",$bien['nom_commune']) }}</p>
                </div>
                <div class="prix">
                    <p class="total">{{ preg_replace('/(?<=\d)(?=(\d{3})+$)/', ' ', $bien['valeur_fonciere']) }} €</p> <!-- format du prix changé -->
                    <p>
                        <a class="btn btn-outline-primary rounded-circle" href="{{str_replace("((longitude))",$bien['longitude'],str_replace("((latitude))",$bien['latitude'],$urls[1]->format_url))}}" target="_blank">M</a>
                        <a class="btn btn-outline-primary rounded-circle" href="{{str_replace("((longitude))",$bien['longitude'],str_replace("((latitude))",$bien['latitude'],$urls[0]->format_url))}}" target="_blank">V</a>
                        <a class="btn btn-outline-primary rounded-circle" href="{{str_replace("((longitude))",$bien['longitude'],str_replace("((latitude))",$bien['latitude'],$urls[2]->format_url))}}" target="_blank">S</a>
                    </p>
                    
                </div>
            </div>
            <div class="millieu-de-carte card-body">
                <div class="info-gauche">
                    <div class="type-batiment">
                        <p>{{ $bien['type_local'] }}  {{ $bien['nombre_pieces_principales'] }} pièces</p>
                    </div>
                    <p>Surface : {{ $bien['surface_reelle_bati'] }} m²  </p>
                    <p>{{ $bien['nature_mutation'] }} le {{ date_format(new DateTime($bien['date_mutation']), 'd/m/Y') }}</p>
                </div>
                <div class="info-droite">
                    <p>{{ preg_replace('/(?<=\d)(?=(\d{3})+$)/', ' ', $bien['z_prixm2']) }} € /m²  </p><!-- format changé -->
                @if($bien['type_local'] == "Maison")
                    <p>Terrain : {{ $bien['surface_terrain'] }} m²  </p>
                @endif
                </div>
            </div>
        </div>
    </div>
    
@endforeach

