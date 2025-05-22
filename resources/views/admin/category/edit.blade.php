@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Modifier la catégorie</h2>

    <form action="{{ route('admin.category.update', ['category' => $category->id]) }}" method="POST" class="w-50">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nom :</label>
            <input 
                type="text" 
                id="name" 
                name="name" 
                value="{{ old('name', $category->name) }}" 
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
                rows="4">{{ old('description', $category->description) }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
        <a href="{{ route('admin.category.index') }}" class="btn btn-secondary ms-2">← Retour</a>
    </form>
</div>
@endsection
