@extends('layouts.app')
@section('titre')
Users
@endsection
@section('contenu')

<h1>Liste de users :</h1>
    @if ($users->count() > 0)
        @foreach($users as $user)
            <h2><a href="{{ route('users', ['id' => $user->id ]) }}">{{ $user->name }}</a></h2>
        @endforeach
    @else
        <span>Aucun user en base de données</span>
    @endif
@endsection