@extends('layouts.backend.main')

@section('title','List Pemesanan')

@section('content')
    <!-- Page Heading -->
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">List Pemesanan</h1>
        <a href="{{route('purchase.create')}}" class="btn btn-sm btn-primary shadow-sm">
            Tambah
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            @if ($message = Session::get('approved'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Approved!</strong> {{ $message }}.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if ($message = Session::get('delete'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Dihapus!</strong> {{ $message }}.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if ($message = Session::get('cant-delete'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Gagal!</strong> {{ $message }}.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Approved?</th>
                            <th>Nomor Dokumen</th>
                            <th>Supplier</th>
                            <th>Total Item</th>
                            <th>Grand Total</th>
                            <th>Status</th>
                            <th>Dibuat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($purchases as $purchase)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <a href="{{ route('purchase.approved',$purchase->id)}}" onclick="return confirm('Yakin ingin menyetujui pemesanan ini?')">
                                        <i class="fas fa-paint-brush"></i>
                                    </a>
                                </td>
                                <td><a href="{{ route('purchase.show',$purchase->id)}}">{{ $purchase->document_number }}</a></td>
                                <td>{{ $purchase->supplier->name }}</td>
                                <td>{{ $purchase->purchaseDetails->count()}}</td>
                                <td>Rp. {{ number_format($purchase->total(),2,',','.') }}</td>
                                <td>
                                    @if ($purchase->status_id == 1)
                                        <span class="badge badge-pill badge-warning">{{ $purchase->status->name }}</span>
                                    @else
                                        <span class="badge badge-pill badge-success">{{ $purchase->status->name }}</span>
                                    @endif
                                </td>
                                <td>{{ $purchase->created_at->isoFormat('D MMMM Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection