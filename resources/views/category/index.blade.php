@extends('layouts.app')

@section('content')
    <h1>Catégories</h1>
    <a href="{{ route('categories.create') }}">Ajouter une catégorie</a>
    <ul>
        @foreach ($categories as $category)
            <li>
                <strong>{{ $category->name }}</strong> : {{ $category->description }}
                <a href="{{ route('categories.edit', $category->id) }}">Modifier</a>
                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Supprimer</button>
                </form>
            </li>
        @endforeach
    </ul>
@endsection
