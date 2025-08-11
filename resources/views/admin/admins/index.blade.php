@extends('layouts.admin')

@section('title', 'Kelola Admin - Stock Management')
@section('header', 'Kelola Admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Daftar Admin</h5>
                    <a href="{{ route('admin.admins.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Admin
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Tanggal Lahir</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($admins as $admin)
                                    <tr>
                                        <td>{{ $admin->full_name }}</td>
                                        <td>{{ $admin->email }}</td>
                                        <td>{{ $admin->gender == 'male' ? 'Laki-laki' : 'Perempuan' }}</td>
                                        <td>{{ $admin->birth_date->format('d/m/Y') }}</td>
                                        <td>
                                            <a href="{{ route('admin.admins.show', $admin) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.admins.edit', $admin) }}"
                                                class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @if ($admin->id != Auth::guard('admin')->id())
                                                <form action="{{ route('admin.admins.destroy', $admin) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Yakin ingin menghapus admin ini?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Tidak ada data admin.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{ $admins->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
