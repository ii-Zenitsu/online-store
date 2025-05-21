@extends('layouts.app')

@section('content')
<h2>Ajouter une catégorie</h2>

<form action="{{ route('admin.category.store') }}" method="POST">
    @csrf
    <label>Nom :</label>
    <input type="text" name="name" required>
    
    <label>Description :</label>
    <textarea name="description"></textarea>

    <button type="submit">Ajouter</button>
</form>
<a href="{{ route('admin.category.index') }}">← Retour</a>
@endsection
