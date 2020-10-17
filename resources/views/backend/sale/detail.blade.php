@extends('layouts.backend.main')

@section('title','Detail Penjualan')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Penjualan</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Diperbarui!</strong> {{ $message }}.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if ($message = Session::get('delete'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Dihapus!</strong> {{ $message }}.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if ($message = Session::get('error'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Gagal!</strong> {{ $message }}.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="row">
                <div class="col-md-8">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <th>Nomor Invoice</th>
                                    <td>:</td>
                                    <td>{{ $sale->invoice}}</td>
                                    <th>User</th>
                                    <td>:</td>
                                    <td>{{ $sale->user->name }}</td>
                                </tr>
                                <tr>
                                    <th>Metode Pembayaran</th>
                                    <td>:</td>
                                    @if ($sale->pay_method == 'cash')
                                        <td>Cash</td>
                                    @else
                                        <td>Transfer</td>
                                    @endif
                                    <th>Dibuat</th>
                                    <td>:</td>
                                    <td>{{ $sale->created_at->isoFormat('D MMMM Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Total</th>
                                    <td>:</td>
                                    <td>Rp. {{number_format( $sale->total,2,',','.') }}</td>
                                    <th>Pembayaran</th>
                                    <td>:</td>
                                    <td>Rp. {{ number_format($sale->pay,2,',','.')}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Qty</th>
                                    <th>Harga</th>
                                    <th>Sub Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total_qty = 0;
                                @endphp
                                @foreach ($sale->saleDetails as $detail)
                                @php
                                    $total_qty += $detail->qty;
                                @endphp
                                    <tr>
                                        <td>{{ $loop->iteration}}</td>
                                        <td>{{ $detail->product->name}}</td>
                                        <td>{{ $detail->qty}}</td>
                                        <td>Rp. {{ number_format($detail->product->sell,2,',','.')}}</td>
                                        <td>Rp. {{ number_format($detail->qty * $detail->product->sell,2,',','.')}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="2">
                                        <b><i>Jumlah</i></b>
                                    </th>
                                    <th>
                                        <b><i>{{ $total_qty }}</i></b>
                                    </th>
                                    <th>
                                        <b><i>Total</i></b>
                                    </th>
                                    <th>
                                        <b><i>Rp. {{ number_format($sale->total,2,',','.')}}</i></b>
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                        <div class="float-right">
                            <a href="{{ route('sale.index')}}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection