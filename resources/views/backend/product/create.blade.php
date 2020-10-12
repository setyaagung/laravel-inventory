@extends('layouts.backend.main')

@section('title','Tambah Product')

@section('content')
    <!-- Page Heading -->
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Produk</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('product.store')}}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Supplier</label>
                    <select class="form-control select2bs4 @error('supplier_id') is-invalid @enderror" name="supplier_id" style="width: 100%">
                        <option value="">-- Pilih Supplier --</option>
                        @foreach ($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                        @endforeach
                    </select>
                    @error('supplier_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Kode</label>
                    <input type="text" class="form-control" name="code" value="{{ $code }}" readonly>
                </div>
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name')}}">
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Minimal Stok</label>
                    <input type="number" class="form-control @error('minimum_stock') is-invalid @enderror" name="minimum_stock" value="5">
                    @error('minimum_stock')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Harga Beli</label>
                    <input type="number" class="form-control @error('buy') is-invalid @enderror" name="buy" value="{{ old('buy')}}">
                    @error('buy')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Harga Jual</label>
                    <input type="number" class="form-control @error('sell') is-invalid @enderror" name="sell" value="{{ old('sell')}}">
                    @error('sell')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="float-right">
                    <a href="{{ route('product.index')}}" class="btn btn-secondary">Kembali</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection