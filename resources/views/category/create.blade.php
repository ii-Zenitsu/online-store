@extends('layouts.app')

@section('content')
<h2>Ajouter une catégorie</h2>

<form action="{{ route('categories.store') }}" method="POST">
    @csrf
    <label>Nom :</label>
    <input type="text" name="name" required>
    
    <label>Description :</label>
    <textarea name="description"></textarea>

    <button type="submit">Ajouter</button>
</form>
<a href="{{ route('categories.index') }}">← Retour</a>
@endsection
