@extends('layouts.backend.main')

@section('title','Dashboard')

@section('content')
    <!-- Page Heading -->
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Supplier</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('supplier.store')}}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" class="form-control" name="name" value="{{ old('name')}}">
                </div>
                <div class="form-group">
                    <label>Alamat</label>
                    <textarea class="form-control" name="address" cols="30" rows="4">{{ old('address')}}</textarea>
                </div>
                <div class="form-group">
                    <label>Telp. Kantor</label>
                    <input type="text" class="form-control" name="phone" value="{{ old('phone')}}">
                </div>
                <div class="form-group">
                    <label>No. HP</label>
                    <input type="text" class="form-control" name="mobile" value="{{ old('mobile')}}">
                </div>
                <div class="float-right">
                    <a href="{{ route('supplier.index')}}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection