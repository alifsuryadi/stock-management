@extends('layouts.admin')

@section('title', 'Edit Transaksi - Stock Management')
@section('header', 'Edit Transaksi')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Form Edit Transaksi: {{ $transaction->transaction_code }}</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning">
                        <i class="fas fa-info-circle"></i>
                        <strong>Catatan:</strong> Hanya catatan dan tanggal transaksi yang dapat diubah.
                        Untuk mengubah produk, hapus transaksi ini dan buat yang baru.
                    </div>

                    <form action="{{ route('admin.transactions.update', $transaction) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Kode Transaksi</label>
                                <input type="text" class="form-control" value="{{ $transaction->transaction_code }}"
                                    readonly>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Tipe Transaksi</label>
                                <input type="text" class="form-control"
                                    value="{{ $transaction->type == 'in' ? 'Stock In (Masuk)' : 'Stock Out (Keluar)' }}"
                                    readonly>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="transaction_date" class="form-label">Tanggal Transaksi</label>
                                <input type="datetime-local"
                                    class="form-control @error('transaction_date') is-invalid @enderror"
                                    id="transaction_date" name="transaction_date"
                                    value="{{ old('transaction_date', $transaction->transaction_date->format('Y-m-d\TH:i')) }}"
                                    required>
                                @error('transaction_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Catatan</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">{{ old('notes', $transaction->notes) }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr>
                        <h6>Detail Produk (Tidak dapat diubah)</h6>

                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Produk</th>
                                        <th>Kategori</th>
                                        <th>Quantity</th>
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
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('admin.transactions.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
