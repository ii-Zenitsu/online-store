@extends('layouts.admin')
@section('title', $viewData["title"])
@section('content')
<div class="card mb-4">
  <div class="card-header">
    Create Suppliers
  </div>
  <div class="card-body">
    @if($errors->any())
    <ul class="alert alert-danger list-unstyled">
      @foreach($errors->all() as $error)
      <li>- {{ $error }}</li>
      @endforeach
    </ul>
    @endif

    <form method="POST" action="{{ route('admin.supplier.store') }}" enctype="multipart/form-data">
      @csrf
      <div class="row">
        <div class="col">
          <div class="mb-3 row">
            <label class="col-lg-2 col-md-6 col-sm-12 col-form-label">Raison Sociale:</label>
            <div class="col-lg-10 col-md-6 col-sm-12">
              <input name="raison_sociale" value="{{ old('raison_sociale') }}" type="text" class="form-control">
            </div>
          </div>
          <div class="mb-3 row">
            <label class="col-lg-2 col-md-6 col-sm-12 col-form-label">Adresse:</label>
            <div class="col-lg-10 col-md-6 col-sm-12">
              <input name="adresse" value="{{ old('adresse') }}" type="text" class="form-control">
            </div>
          </div>
          <div class="mb-3 row">
            <label class="col-lg-2 col-md-6 col-sm-12 col-form-label">Téléphone:</label>
            <div class="col-lg-10 col-md-6 col-sm-12">
              <input name="tele" value="{{ old('tele') }}" type="text" class="form-control">
            </div>
          </div>
          <div class="mb-3 row">
            <label class="col-lg-2 col-md-6 col-sm-12 col-form-label">Email:</label>
            <div class="col-lg-10 col-md-6 col-sm-12">
              <input name="email" value="{{ old('email') }}" type="email" class="form-control">
            </div>
          </div>
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
    Manage Suppliers
  </div>
  <div class="card-body">
    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Raison Sociale</th>
          <th scope="col">Adresse</th>
          <th scope="col">Téléphone</th>
          <th scope="col">Email</th>
          <th scope="col">Description</th>
          <th scope="col">Edit</th>
          <th scope="col">Delete</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($viewData["suppliers"] as $supplier)
        <tr>
          <td>{{ $supplier->id }}</td>
          <td>{{ $supplier->raison_sociale }}</td>
          <td>{{ $supplier->adresse }}</td>
          <td>{{ $supplier->tele }}</td>
          <td>{{ $supplier->email }}</td>
          <td>{{ $supplier->description }}</td>
          <td>
            <a class="btn btn-primary" href="{{ route('admin.supplier.edit', ['id' => $supplier->id]) }}">
              <i class="bi-pencil"></i>
            </a>
          </td>
          <td>
            <form action="{{ route('admin.supplier.destroy', $supplier->id) }}" method="POST">
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
  </div>
</div>
@endsection