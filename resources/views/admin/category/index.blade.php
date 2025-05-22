@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Gestion des Catégories</h1>

    <a href="{{ route('admin.category.create') }}" class="btn btn-success mb-3">
        Ajouter une catégorie
    </a>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th>Nom</th>
                <th>Description</th>
                <th style="width: 200px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
            <tr>
                <td>{{ $category->name }}</td>
                <td>{{ $category->description ?: '-' }}</td>
                <td>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.category.edit', ['category' => $category->id]) }}" class="btn btn-outline-primary btn-sm">
                            Modifier
                        </a>
                        <form action="{{ route('admin.category.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer cette catégorie ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                Supprimer
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
