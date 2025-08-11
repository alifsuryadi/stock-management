@extends('layouts.admin')

@section('title', 'Detail Produk - Stock Management')
@section('header', 'Detail Produk')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Detail Produk: {{ $product->name }}</h5>
                    <div>
                        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            @if ($product->image)
                                <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}"
                                    class="img-fluid rounded">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center rounded"
                                    style="height: 300px;">
                                    <span class="text-muted">No Image</span>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-8">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="30%">Nama Produk</th>
                                    <td>: {{ $product->name }}</td>
                                </tr>
                                <tr>
                                    <th>Kategori</th>
                                    <td>: {{ $product->category->name }}</td>
                                </tr>
                                <tr>
                                    <th>Deskripsi</th>
                                    <td>: {{ $product->description ?: '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Stok</th>
                                    <td>:
                                        <span class="badge bg-{{ $product->stock <= 10 ? 'danger' : 'success' }} fs-6">
                                            {{ $product->stock }} Unit
                                        </span>
                                        @if ($product->stock <= 10)
                                            <span class="text-danger ms-2">
                                                <i class="fas fa-exclamation-triangle"></i> Stok Rendah
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Dibuat</th>
                                    <td>: {{ $product->created_at->format('d F Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Terakhir Diperbarui</th>
                                    <td>: {{ $product->updated_at->format('d F Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
