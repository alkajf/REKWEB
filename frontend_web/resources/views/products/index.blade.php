@extends('layouts.app')

@section('title', 'Products')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h1 class="card-title mb-0">Daftar Products</h1>
                        <a href="{{ route('products.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Create Product
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

                    @if (!empty($products))
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Price</th>
                                        <th>Stock</th>
                                        <th>Description</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product)
                                        <tr>
                                            <td>{{ $product['id'] ?? '' }}</td>
                                            <td>{{ $product['name'] ?? '' }}</td>
                                            <td>
                                                @if(isset($product['category']))
                                                    <span class="badge bg-info">{{ $product['category']['name'] ?? '' }}</span>
                                                @endif
                                            </td>
                                            <td>Rp {{ number_format($product['price'] ?? 0, 0, ',', '.') }}</td>
                                            <td>
                                                <span class="badge {{ ($product['stock'] ?? 0) > 0 ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $product['stock'] ?? 0 }}
                                                </span>
                                            </td>
                                            <td>{{ \Illuminate\Support\Str::limit($product['description'] ?? '', 50) }}</td>
                                            <td>{{ isset($product['created_at']) ? date('d M Y', strtotime($product['created_at'])) : '' }}</td>
                                            <td>
                                                <div class="btn-group gap-3" role="group">
                                                    <a href="{{ route('products.edit', $product['id']) }}" class="btn btn-sm btn-warning">
                                                        Edit
                                                    </a>
                                                    <form action="{{ route('products.destroy', $product['id']) }}" method="POST" class="d-inline" 
                                                          onsubmit="return confirm('Are you sure you want to delete this product?');">
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
                            <i class="bi bi-info-circle"></i> Belum ada data products.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
