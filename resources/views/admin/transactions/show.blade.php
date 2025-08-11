@extends('layouts.admin')

@section('title', 'Detail Transaksi - Stock Management')
@section('header', 'Detail Transaksi')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Detail Transaksi: {{ $transaction->transaction_code }}</h5>
                    <div>
                        <a href="{{ route('admin.transactions.edit', $transaction) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('admin.transactions.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="30%">Kode Transaksi</th>
                                    <td>: {{ $transaction->transaction_code }}</td>
                                </tr>
                                <tr>
                                    <th>Tipe Transaksi</th>
                                    <td>:
                                        <span class="badge bg-{{ $transaction->type == 'in' ? 'success' : 'danger' }}">
                                            {{ $transaction->type == 'in' ? 'Stock In (Masuk)' : 'Stock Out (Keluar)' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Tanggal Transaksi</th>
                                    <td>: {{ $transaction->transaction_date->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Admin</th>
                                    <td>: {{ $transaction->admin->full_name }}</td>
                                </tr>
                                <tr>
                                    <th>Catatan</th>
                                    <td>: {{ $transaction->notes ?: '-' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <hr>
                    <h6>Detail Produk</h6>

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>Kategori</th>
                                    <th>Quantity</th>
                                    <th>Stok Saat Ini</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transaction->transactionDetails as $detail)
                                    <tr>
                                        <td>{{ $detail->product->name }}</td>
                                        <td>{{ $detail->product->category->name }}</td>
                                        <td>
                                            <span class="badge bg-info">{{ $detail->quantity }}</span>
                                        </td>
                                        <td>
                                            <span
                                                class="badge bg-{{ $detail->product->stock <= 10 ? 'danger' : 'success' }}">
                                                {{ $detail->product->stock }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="fw-bold">
                                    <td colspan="2">Total Quantity</td>
                                    <td>
                                        <span class="badge bg-primary">{{ $transaction->total_quantity }}</span>
                                    </td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
