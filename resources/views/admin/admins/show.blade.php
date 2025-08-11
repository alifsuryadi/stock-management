@extends('layouts.admin')

@section('title', 'Detail Admin - Stock Management')
@section('header', 'Detail Admin')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Detail Admin</h5>
                    <div>
                        <a href="{{ route('admin.admins.edit', $admin) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('admin.admins.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="30%">Nama Lengkap</th>
                            <td>: {{ $admin->full_name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>: {{ $admin->email }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Lahir</th>
                            <td>: {{ $admin->birth_date->format('d F Y') }}</td>
                        </tr>
                        <tr>
                            <th>Jenis Kelamin</th>
                            <td>: {{ $admin->gender == 'male' ? 'Laki-laki' : 'Perempuan' }}</td>
                        </tr>
                        <tr>
                            <th>Terdaftar Sejak</th>
                            <td>: {{ $admin->created_at->format('d F Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Terakhir Diperbarui</th>
                            <td>: {{ $admin->updated_at->format('d F Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
