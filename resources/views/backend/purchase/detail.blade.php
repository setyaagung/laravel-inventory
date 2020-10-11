@extends('layouts.backend.main')

@section('title','Detail Pemesanan')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Pemesanan</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
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
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Produk</th>
                                    <th>Qty</th>
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
                                        <td>{{ $detail->qty }}</td>
                                        <td>Rp. {{ number_format($detail->buy,2,',','.') }}</td>
                                        <td>Rp. {{ number_format($detail->total,2,',','.') }}</td>
                                        <td>
                                            <form action="{{ route('purchase.destroy_detail',$detail->id)}}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin dihapus?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
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
                    </div>
                </div>
            </div>
            <div class="float-right">
                <a href="{{ route('purchase.index')}}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
@endsection