@extends('layouts.backend.main')

@section('title','Detail Pemesanan')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Pemesanan</h1>
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
                                    <th>Nomor Dokumen</th>
                                    <td>:</td>
                                    <td>{{ $purchase->document_number}}</td>
                                    <th>Supplier</th>
                                    <td>:</td>
                                    <td>{{ $purchase->supplier->name }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>:</td>
                                    <td>
                                        @if ($purchase->status_id == 1)
                                            <span class="badge badge-pill badge-warning">{{ $purchase->status->name }}</span>
                                        @else
                                            <span class="badge badge-pill badge-success">{{ $purchase->status->name }}</span>
                                        @endif
                                    </td>
                                    <th>Dibuat</th>
                                    <td>:</td>
                                    <td>{{ $purchase->created_at->isoFormat('D MMMM Y') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <form action="{{ route('purchase.update',$purchase->id)}}" method="POST">
                            @csrf
                            @method('PATCH')
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Produk</th>
                                        <th style="width: 15%">Qty</th>
                                        <th>Harga Beli</th>
                                        <th>Total</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $total_qty = 0;
                                        $total_buy = 0;
                                        $total = 0;
                                    @endphp
                                    @foreach ($purchase->purchaseDetails as $detail)
                                        @php
                                            $total_qty += $detail->qty;
                                            $total_buy += $detail->buy;
                                            $total += $detail->total;
                                        @endphp
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $detail->product->name }}</td>
                                            <td>
                                                @if ($purchase->status_id == 1)
                                                    <input type="number" class="form-control" name="qty[]" value="{{ $detail->qty }}">
                                                    <input type="hidden" name="id[]" value="{{ $detail->id }}">
                                                    <input type="hidden" name="product_id[]" value="{{ $detail->product_id }}">
                                                @else
                                                    {{ $detail->qty }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($purchase->status_id == 1)
                                                    <input type="number" class="form-control" name="buy[]" value="{{ $detail->buy }}">
                                                @else
                                                    Rp. {{ number_format($detail->buy,2,',','.') }}
                                                @endif
                                            </td>
                                            <td>Rp. {{ number_format($detail->total,2,',','.') }}</td>
                                            <td>
                                                
                                            </td>
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
                                            <b><i>Rp. {{ number_format($total_buy,2,',','.') }}</i></b>
                                        </th>
                                        <th>
                                            <b><i>Rp. {{ number_format($total,2,',','.') }}</i></b>
                                        </th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                            <div class="float-right">
                                @if ($purchase->status_id == 1)
                                    <a href="{{ route('purchase.index')}}" class="btn btn-secondary">Kembali</a>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                @else
                                    <a href="{{ route('purchase.index')}}" class="btn btn-secondary">Kembali</a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection