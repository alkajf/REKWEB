@extends('layouts.app')

@section('title', 'Categories')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h1 class="card-title mb-0">Daftar Categories</h1>
                        <a href="{{ route('categories.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Create Category
                        </a>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (!empty($categories))
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $category)
                                        <tr>
                                            <td>{{ $category['id'] ?? '' }}</td>
                                            <td>{{ $category['name'] ?? '' }}</td>
                                            <td>{{ $category['description'] ?? '' }}</td>
                                            <td>
                                                {{ isset($category['created_at']) 
                                                    ? date('d M Y', strtotime($category['created_at'])) 
                                                    : '' }}
                                            </td>
                                            <td>
                                                <div class="btn-group gap-2" role="group">
                                                    <a href="{{ route('categories.edit', $category['id']) }}"
                                                       class="btn btn-sm btn-warning">
                                                        Edit
                                                    </a>

                                                    <form action="{{ route('categories.destroy', $category['id']) }}"
                                                          method="POST"
                                                          class="d-inline"
                                                          onsubmit="return confirm('Are you sure you want to delete this category?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i> Belum ada data categories.
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection
