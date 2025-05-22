@extends('layouts.app')
@section('title', $viewData["title"])
@section('subtitle', $viewData["subtitle"])
@section('content')

<!-- Formulaire de filtrage par catégorie -->
<div class="mb-4">
  <form action="{{ route('product.index') }}" method="GET">
    <label for="category">Filtrer par catégorie :</label>
    <select id="category" name="category" onchange="this.form.submit()">
      <option value="">Toutes les catégories</option>
      @foreach ($viewData["categories"] as $cat)
        <option value="{{ $cat->name }}"
          {{ request()->get('category') == $cat->name ? 'selected' : '' }}>
          {{ $cat->name }}
        </option>
      @endforeach
    </select>
  </form>
</div>

<!-- Liste des produits -->
<div class="row">
  @foreach ($viewData["products"] as $product)
  <div class="col-md-4 col-lg-3 mb-2">
    <div class="card position-relative">
      @if ($product->quantity_store == 0)
        <span class="badge bg-danger position-absolute" style="top: 10px; left: 10px; z-index: 10;">
          Rupture de stock
        </span>
      @endif
      <img src="{{ asset('/storage/'.$product->getImage()) }}" class="card-img-top img-card">
      <div class="card-body text-center">
        <a href="{{ route('product.show', ['id'=> $product->getId()]) }}"
          class="btn bg-primary text-white">{{ $product->getName() }}</a>
        <p class="mt-2">
          <strong>Catégorie :</strong>
          {{ $product->category ? $product->category->name : 'Non catégorisé' }}
        </p>
      </div>
    </div>
  </div>
  @endforeach
</div>

@endsection
