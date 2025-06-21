@extends('layouts.admin')
@section('title', $viewData['title'])
@section('content')
  <div class="card mb-4">
    <div class="card-header">
      Create User
    </div>
    <div class="card-body">
      @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif
      @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
      @endif
      @if ($errors->any())
        <ul class="alert alert-danger list-unstyled">
          @foreach ($errors->all() as $error)
            <li>- {{ $error }}</li>
          @endforeach
        </ul>
      @endif

      <form method="POST" action="{{ route('admin.user.store') }}">
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
              <label class="col-lg-2 col-md-6 col-sm-12 col-form-label">Email:</label>
              <div class="col-lg-10 col-md-6 col-sm-12">
                <input name="email" value="{{ old('email') }}" type="email" class="form-control">
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <div class="mb-3 row">
              <label class="col-lg-2 col-md-6 col-sm-12 col-form-label">Password:</label>
              <div class="col-lg-10 col-md-6 col-sm-12">
                <input name="password" type="password" class="form-control">
              </div>
            </div>
          </div>
          <div class="col">
            <div class="mb-3 row">
              <label class="col-lg-2 col-md-6 col-sm-12 col-form-label">Confirm Password:</label>
              <div class="col-lg-10 col-md-6 col-sm-12">
                <input name="password_confirmation" type="password" class="form-control">
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <div class="mb-3 row">
              <label class="col-lg-2 col-md-6 col-sm-12 col-form-label">Balance:</label>
              <div class="col-lg-10 col-md-6 col-sm-12">
                <input name="balance" value="{{ old('balance', 0) }}" type="number" class="form-control">
              </div>
            </div>
          </div>
          <div class="col">
            <div class="mb-3 row">
              <label class="col-lg-2 col-md-6 col-sm-12 col-form-label">Role:</label>
              <div class="col-lg-10 col-md-6 col-sm-12">
                <select name="role" class="form-control" id="roleSelect">
                  <option value="client" {{ old('role') == 'client' ? 'selected' : '' }}>Client</option>
                  <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <div class="mb-3 row align-items-end">
              <div class="col-lg-10 col-md-6 col-sm-12">
                <div class="form-check form-switch">
                  <input type="checkbox" name="is_super_admin" value="1" id="isSuperAdminCheckbox"
                    {{ old('is_super_admin') ? 'checked' : '' }} class="form-check-input" role="switch">
                  <label class="form-check-label" for="isSuperAdminCheckbox">Is Super Admin?</label>
                </div>
              </div>
            </div>
          </div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
  </div>

  <div class="card">
    <div class="card-header">
      Manage Users
    </div>
    <div class="card-body">
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Role</th>
            <th scope="col">Super Admin</th>
            <th scope="col">Balance</th>
            <th scope="col">Edit</th>
            <th scope="col">Delete</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($viewData['users'] as $user)
            <tr>
              <td>{{ $user->getId() }}</td>
              <td>{{ $user->getName() }}</td>
              <td>{{ $user->getEmail() }}</td>
              <td>{{ $user->getRole() }}</td>
              <td>{{ $user->getIsSuperAdmin() ? 'Yes' : 'No' }}</td>
              <td>${{ $user->getBalance() }}</td>
              <td>
                <a class="btn btn-primary" href="{{ route('admin.user.edit', ['id' => $user->getId()]) }}">
                  <i class="bi-pencil"></i>
                </a>
              </td>
              <td>
                <form action="{{ route('admin.user.delete', $user->getId()) }}" method="POST">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?');">
                    <i class="bi-trash"></i>
                  </button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
      {{-- Custom pagination for users --}}
      @if ($viewData['users']->count())
        <div class="d-flex flex-column align-items-center mt-4">
          @php
            $paginator = $viewData['users'];
          @endphp

          <nav>
            <ul class="pagination">
              @if ($paginator->onFirstPage())
                <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
              @else
                <li class="page-item">
                  <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo;</a>
                </li>
              @endif

              @foreach ($paginator->getUrlRange(1, $paginator->lastPage()) as $page => $url)
                @if ($page == $paginator->currentPage())
                  <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                @else
                  <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                @endif
              @endforeach

              @if ($paginator->hasMorePages())
                <li class="page-item">
                  <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">&raquo;</a>
                </li>
              @else
                <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
              @endif
            </ul>
          </nav>
          <div class="mb-2 text-muted small">
            Showing
            <strong>{{ $paginator->firstItem() ?? 0 }}</strong>
            to
            <strong>{{ $paginator->lastItem() ?? 0 }}</strong>
            of
            <strong>{{ $paginator->total() }}</strong>
            users
            (Page <strong>{{ $paginator->currentPage() }}</strong> of <strong>{{ $paginator->lastPage() }}</strong>)
          </div>
        </div>
      @endif
    </div>
  </div>
@endsection

@push('styles')
  <style>
    #isSuperAdminCheckbox {
      width: 3em;
      height: 1.5em;
      cursor: pointer;
    }

    label[for="isSuperAdminCheckbox"] {
      padding-left: 0.5em;
      vertical-align: middle;
    }
  </style>
@endpush

@push('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const roleSelect = document.getElementById('roleSelect');
      const superAdminCheckbox = document.getElementById('isSuperAdminCheckbox');

      function toggleSuperAdminCheckbox() {
        if (roleSelect.value === 'client') {
          superAdminCheckbox.disabled = true;
          superAdminCheckbox.checked = false;
        } else {
          superAdminCheckbox.disabled = false;
        }
      }

      toggleSuperAdminCheckbox();

      roleSelect.addEventListener('change', toggleSuperAdminCheckbox);
    });
  </script>
@endpush
