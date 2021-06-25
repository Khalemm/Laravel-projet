@component('mail::message')
# Introduction

Bonjour {{ $data['name'] }}, vous venez de créer un compte chez nous, elle sera prochainement activée.

@component('mail::button', ['url' => $url])
Cliquez ici
@endcomponent

Merci,<br>
{{ config('app.name') }}
@endcomponent
