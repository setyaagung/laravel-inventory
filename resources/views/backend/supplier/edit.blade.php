@extends('layouts.backend.main')

@section('title','Edit Supplier')

@section('content')
    <!-- Page Heading -->
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Supplier</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('supplier.update',$supplier->id)}}" method="POST">
                @csrf
                @method('PATCH')
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" class="form-control" name="name" value="{{ $supplier->name }}" autofocus>
                </div>
                <div class="form-group">
                    <label>Alamat</label>
                    <textarea class="form-control" name="address" cols="30" rows="4">{{ $supplier->address }}</textarea>
                </div>
                <div class="form-group">
                    <label>Telp. Kantor</label>
                    <input type="text" class="form-control" name="phone" value="{{ $supplier->phone }}">
                </div>
                <div class="form-group">
                    <label>No. HP</label>
                    <input type="text" class="form-control" name="mobile" value="{{ $supplier->mobile }}">
                </div>
                <div class="float-right">
                    <a href="{{ route('supplier.index')}}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
@endsection