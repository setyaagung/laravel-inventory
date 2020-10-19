@extends('layouts.backend.main')

@section('title','History Penjualan')

@section('content')
    <!-- Page Heading -->
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">History Penjualan</h1>
        <a href="{{route('sale.create')}}" class="btn btn-sm btn-primary shadow-sm">
            Tambah
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header">
            <button class="btn btn-success btn-sm btn-filter"><i class="fas fa-filter"></i> Filter Tanggal</button>
        </div>
        <div class="card-body">
            @if ($message = Session::get('update'))
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <strong>Perbarui!</strong> {{ $message }}.
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

            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Invoice</th>
                            <th>Total</th>
                            <th>Metode Pembayaran</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sales as $sale)
                            <tr>
                                <td>{{ $loop->iteration}}</td>
                                <td>
                                    <a href="{{ route('sale.show', $sale->id)}}">{{ $sale->invoice}}</a>
                                </td>
                                <td>Rp. {{ number_format($sale->total,2,',','.')}}</td>
                                @if ($sale->pay_method == 'cash')
                                    <td>Cash</td>
                                @else
                                    <td>Transfer</td>
                                @endif
                                <td>{{ $sale->created_at->isoFormat('D MMMM Y')}}</td>
                                <td>
                                    <a href="{{ route('sale.invoice',$sale->invoice)}}" class="btn btn-sm btn-success" target="_blank"><i class="fas fa-file-invoice"></i> Nota</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- MODAL FILTER -->
    <div class="modal fade" id="modalFilter" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-light" id="staticBackdropLabel">Filter By Tanggal</h5>
                    <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('sale.index')}}" method="GET">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Tanggal Awal</label>
                            <input type="date" class="form-control" name="first_date" required>
                        </div>
                        <div class="form-group">
                            <label for="">Tanggal Akhir</label>
                            <input type="date" class="form-control" name="last_date" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function(){
            $('.btn-filter').click(function(e){
                e.preventDefault();
                $('#modalFilter').modal();
            })
        });
    </script>
@endpush