@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Ajouter une catégorie</h2>

    <form action="{{ route('admin.category.store') }}" method="POST" class="w-50">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Nom :</label>
            <input 
                type="text" 
                id="name" 
                name="name" 
                value="{{ old('name') }}" 
                class="form-control @error('name') is-invalid @enderror" 
                required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description :</label>
            <textarea 
                id="description" 
                name="description" 
                class="form-control @error('description') is-invalid @enderror" 
                rows="4">{{ old('description') }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">Ajouter</button>
        <a href="{{ route('admin.category.index') }}" class="btn btn-secondary ms-2">← Retour</a>
    </form>
</div>
@endsection
