@extends('layouts.admin')
@section('title', $viewData["title"])
@section('content')
<div class="card mb-4">
  <div class="card-header">
    Create Products
  </div>
  <div class="card-body">
    @if($errors->any())
    <ul class="alert alert-danger list-unstyled">
      @foreach($errors->all() as $error)
      <li>- {{ $error }}</li>
      @endforeach
    </ul>
    @endif

    <form method="POST" action="{{ route('admin.product.store') }}" enctype="multipart/form-data">
      @csrf
      <div class="row">
        <div class="col">
          <div class="mb-3 row">
            <label class="col-lg-2 col-md-6 col-sm-12 col-form-label">Name:</label>
            <div class="col-lg-10 col-md-6 col-sm-12">
              <input name="name" value="{{ old('name') }}" type="text" class="form-control">
            </div>
          </div>
        </div>
        <div class="col">
          <div class="mb-3 row">
            <label class="col-lg-2 col-md-6 col-sm-12 col-form-label">Price:</label>
            <div class="col-lg-10 col-md-6 col-sm-12">
              <input name="price" value="{{ old('price') }}" type="number" class="form-control">
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col">
          <div class="mb-3 row">
            <label class="col-lg-2 col-md-6 col-sm-12 col-form-label">Image:</label>
            <div class="col-lg-10 col-md-6 col-sm-12">
              <input class="form-control" type="file" name="image">
            </div>
          </div>
        </div>
        <div class="col">
          &nbsp;
        </div>
      </div>
      <div class="col">
        <div class="mb-3 row">
          <label class="col-lg-2 col-md-6 col-sm-12 col-form-label">Supplier Name:</label>
          <select name="supplier_id" id="" class="form-control">
            <option value="" disabled selected>Select Supplier</option>
            @foreach ($viewData["suppliers"] as $supplier)
            <option  value="{{ $supplier->id }}">{{ $supplier->raison_sociale }}</option>
            @endforeach
          </select>
        </div>
                <div class="mb-3 row">
          <form method="GET" action="{{ route('admin.product.index') }}" class="mb-3 d-flex" style="gap: 10px;">
    <select name="categorie_id" class="form-control" style="max-width: 250px;">
      <option value="">sélectionner une categorie</option>
      @foreach ($viewData["categories"] as $category)
        <option value="{{ $category->id }}" {{ request('categorie_id') == $category->id ? 'selected' : '' }}>
          {{ $category->name }}
        </option>
      @endforeach
    </select>
  </form>
  </div>
      </div>
      <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea class="form-control" name="description" rows="3">{{ old('description') }}</textarea>
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>
</div>

<div class="card">
  <div class="card-header">
    Manage Products
  </div>
  <div class="card-body">
    <form method="GET" action="{{ route('admin.product.index') }}" class="mb-3 d-flex" style="gap: 10px;">
  <select name="categorie_id" class="form-control" style="max-width: 250px;">
    <option value="">-- Filtrer par catégorie --</option>
    @foreach ($viewData["categories"] as $category)
      <option value="{{ $category->id }}" {{ request('categorie_id') == $category->id ? 'selected' : '' }}>
        {{ $category->name }}
      </option>
    @endforeach
  </select>
  <button type="submit" class="btn btn-secondary">Filtrer</button>
</form>
    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Name</th>
          <th scope="col">Supplier</th>
          <th scope="col">Edit</th>
          <th scope="col">Delete</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($viewData["products"] as $product)
        <tr>
          <td>{{ $product->getId() }}</td>
          <td>{{ $product->getName() }}</td>
          <td>
            <a class="btn btn-primary" href="{{route('admin.product.edit', ['id'=> $product->getId()])}}">
              <i class="bi-pencil"></i>
            </a>
          </td>
          <td>
            <form action="{{ route('admin.product.delete', $product->getId())}}" method="POST">
              @csrf
              @method('DELETE')
              <button class="btn btn-danger">
                <i class="bi-trash"></i>
              </button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    <div class="d-flex justify-content-center mt-3">
        {{ $viewData['products']->links() }}
    </div>
  </div>
</div>
@endsection
