@extends('layouts.backend.main')

@section('title','Detail Good Receipt')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Good Receipt</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Approved!</strong> {{ $message }}.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if ($message = Session::get('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Gagal!</strong> {{ $message }}.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="row">
                <div class="col-md-10">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <th>Good Receipt</th>
                                    <td>:</td>
                                    <td>{{ $gr->document_number}}</td>
                                    <th>Pemesanan</th>
                                    <td>:</td>
                                    <td>{{ $gr->purchase->document_number }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>:</td>
                                    @if ($gr->status_id == 1)
                                        <td>
                                            <span class="badge badge-warning">{{ $gr->status->name }}</span>
                                        </td>
                                    @else
                                        <td>
                                            <span class="badge badge-success">{{ $gr->status->name }}</span>
                                        </td>
                                    @endif
                                    <th>Dibuat</th>
                                    <td>:</td>
                                    <td>{{ $gr->created_at->isoFormat('D MMMM Y') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Qty</th>
                                <th>Harga Beli</th>
                                <th>Grand Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($gr->purchase->purchaseDetails as $detail)
                                <tr>
                                    <td>{{ $detail->product->name }}</td>
                                    <td>{{ $detail->qty }}</td>
                                    <td>Rp. {{ number_format($detail->buy,2,',','.') }}</td>
                                    <td>Rp. {{ number_format($detail->total,2,',','.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th>
                                    <b><i>Total</i></b>
                                </th>
                                <th>
                                    <b><i>Rp. {{ number_format($detail->sumBuy(),2,',','.') }}</i></b>
                                </th>
                                <th>
                                    <b><i>Rp. {{ number_format($detail->sumTotal(),2,',','.') }}</i></b>
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="float-right">
                        @if ($gr->status_id == 1)
                            <a href="{{ route('goodreceipt.index')}}" class="btn btn-secondary">Kembali</a>
                            <a href="#" class="btn btn-success" data-toggle="modal" data-target="#approvedModal">Approved</a>
                        @else
                            <a href="{{ route('goodreceipt.index')}}" class="btn btn-secondary">Kembali</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Approved Modal-->
    <div class="modal fade" id="approvedModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Approved?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Apakah anda yakin ingin Meng Approved Dokumen ini ?</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <form action="{{ route('goodreceipt.approved',$gr->id)}}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-success">Ok, Approved</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection