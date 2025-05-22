@extends('layouts.app')
@section('title', $viewData["title"])
@section('subtitle', $viewData["subtitle"])
@section('content')

<!-- Formulaire de filtrage par catégorie -->


<!-- Liste des produits -->
<div class="row">
  @foreach ($viewData["products"] as $product)
  <div class="col-md-4 col-lg-3 mb-2">
    <div class="card">
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
