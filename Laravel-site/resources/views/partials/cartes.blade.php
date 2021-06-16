@php
    $biens = json_decode($listebiens,TRUE);
@endphp

<script>
@foreach ((array)$biens as $bien)
        
@endforeach
</script>

