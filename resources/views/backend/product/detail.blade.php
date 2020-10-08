@extends('layouts.backend.main')

@section('title','Detail Product')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Product</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table style="width: 100%">
                        <tr>
                            <td>Supplier</td>
                            <td>:</td>
                            <td>{{ $product->supplier->name }}</td>
                        </tr>
                        <tr>
                            <td>Kode</td>
                            <td>:</td>
                            <td>{{ $product->code }}</td>
                        </tr>
                        <tr>
                            <td>Nama</td>
                            <td>:</td>
                            <td>{{ $product->name }}</td>
                        </tr>
                        <tr>
                            <td>Stok</td>
                            <td>:</td>
                            <td>{{ $product->stock }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table style="width: 100%">
                        <tr>
                            <td>Minimal Stok</td>
                            <td>:</td>
                            <td>{{ $product->minimum_stock }}</td>
                        </tr>
                        <tr>
                            <td>Harga Beli</td>
                            <td>:</td>
                            <td>Rp. {{number_format($product->buy,2, ',' , '.')}}</td>
                        </tr>
                        <tr>
                            <td>Harga Jual</td>
                            <td>:</td>
                            <td>Rp. {{number_format($product->sell,2, ',' , '.')}}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="float-right">
                <a href="{{ route('product.index')}}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
@endsection