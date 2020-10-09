@extends('layouts.backend.main')

@section('title','Detail Product')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Product</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <th>Barcode</th>
                            <td>:</td>
                            <td>{!! \DNS1D::getBarcodeHTML($product->code, 'I25+'); !!}</td>
                            <th>Nama</th>
                            <td>:</td>
                            <td>{{ $product->name }}</td>
                        </tr>
                        <tr>
                            <th>Supplier</th>
                            <td>:</td>
                            <td>{{ $product->supplier->name}}</td>
                            <th>Kode</th>
                            <td>:</td>
                            <td>{{ $product->code }}</td>
                        </tr>
                        <tr>
                            <th>Stok</th>
                            <td>:</td>
                            <td>{{ $product->stock}}</td>
                            <th>Minimal Stok</th>
                            <td>:</td>
                            <td>{{ $product->minimum_stock }}</td>
                        </tr>
                        <tr>
                            <th>Harga Beli</th>
                            <td>:</td>
                            <td>Rp. {{ (number_format($product->buy,2,',','.')) }}</td>
                            <th>Harga Jual</th>
                            <td>:</td>
                            <td>Rp. {{ (number_format($product->sell,2,',','.')) }}</td>
                        </tr>
                        <tr>
                            <th>Dibuat</th>
                            <td>:</td>
                            <td>{{ date('d F Y H:i', strtotime($product->created_at)) }}</td>
                            <th>Diperbarui</th>
                            <td>:</td>
                            <td>{{ date('d F Y H:i', strtotime($product->updated_at)) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="float-right">
                <a href="{{ route('product.index')}}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
@endsection