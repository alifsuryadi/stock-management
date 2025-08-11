@extends('layouts.admin')

@section('title', 'Transaksi - Stock Management')
@section('header', 'Daftar Transaksi')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Riwayat Transaksi</h5>
                    <a href="{{ route('admin.transactions.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Transaksi
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Kode Transaksi</th>
                                    <th>Tipe</th>
                                    <th>Total Item</th>
                                    <th>Admin</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transactions as $transaction)
                                    <tr>
                                        <td>{{ $transaction->transaction_code }}</td>
                                        <td>
                                            <span class="badge bg-{{ $transaction->type == 'in' ? 'success' : 'danger' }}">
                                                {{ $transaction->type == 'in' ? 'Stock In' : 'Stock Out' }}
                                            </span>
                                        </td>
                                        <td>{{ $transaction->total_quantity }}</td>
                                        <td>{{ $transaction->admin->full_name }}</td>
                                        <td>{{ $transaction->transaction_date->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <a href="{{ route('admin.transactions.show', $transaction) }}"
                                                class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.transactions.edit', $transaction) }}"
                                                class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.transactions.destroy', $transaction) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Yakin ingin menghapus transaksi ini? Stok akan dikembalikan.')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak ada data transaksi.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{ $transactions->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
