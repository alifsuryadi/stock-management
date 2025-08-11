@extends('layouts.admin')

@section('title', 'Detail Kategori - Stock Management')
@section('header', 'Detail Kategori')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Detail Kategori: {{ $category->name }}</h5>
                    <div>
                        <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="30%">Nama Kategori</th>
                                    <td>: {{ $category->name }}</td>
                                </tr>
                                <tr>
                                    <th>Deskripsi</th>
                                    <td>: {{ $category->description ?: '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Jumlah Produk</th>
                                    <td>: <span class="badge bg-info">{{ $category->products->count() }}</span></td>
                                </tr>
                                <tr>
                                    <th>Dibuat</th>
                                    <td>: {{ $category->created_at->format('d F Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    @if ($category->products->count() > 0)
                        <hr>
                        <h6>Produk dalam Kategori Ini</h6>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Nama Produk</th>
                                        <th>Stok</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($category->products as $product)
                                        <tr>
                                            <td>{{ $product->name }}</td>
                                            <td>
                                                <span class="badge bg-{{ $product->stock <= 10 ? 'danger' : 'success' }}">
                                                    {{ $product->stock }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.products.show', $product) }}"
                                                    class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i> Lihat
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
