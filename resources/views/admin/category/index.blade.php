@extends('layouts.app')

@section('content')
    <h1>Catégories</h1>
    <a href="{{ route('admin.category.create') }}">Ajouter une catégorie</a>
    <ul>
        @foreach ($categories as $category)
            <li>
                <strong>{{ $category->name }}</strong> : {{ $category->description }}
                <a href="{{ route('admin.category.edit', ['category' => $category->id]) }}">Modifier</a>
                <form action="{{ route('admin.category.destroy', $category->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Supprimer</button>
                </form>
            </li>
        @endforeach
    </ul>
@endsection
