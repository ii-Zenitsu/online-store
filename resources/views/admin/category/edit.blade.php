@extends('layouts.app')

@section('content')
<h2>Modifier la catégorie</h2>

<form action="{{ route('admin.category.update', ['category' => $category->id]) }}" method="POST">
    @csrf
    @method('PUT')

    <label>Nom :</label>
    <input type="text" name="name" value="{{ $category->name }}" required>
    
    <label>Description :</label>
    <textarea name="description">{{ $category->description }}</textarea>

    <button type="submit">Mettre à jour</button>
</form>
<a href="{{ route('admin.category.index') }}">← Retour</a>
@endsection
