@extends('layouts.backend.main')

@section('title','List Point Of Sales')

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header">
            <button class="btn btn-sm btn-warning btn-refresh"><i class="fas fa-sync-alt"></i> Refresh</button>
            <a href="{{ route('sale.index')}}" class="btn btn-sm btn-success"><i class="fas fa-home"></i> History</a>
            <div class="float-right">
                <b>{{ \Carbon\Carbon::now()->isoFormat('D MMMM Y')}}</b>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <form action="{{ route('sale.addproduct',$product->id)}}" method="POST">
                                            @csrf
                                            @if ($product->stock == 0)
                                                <td>{{ $loop->iteration}}</td>
                                                <td>{{ $product->name}} <sup><span class="badge badge-primary">{{ $product->stock}}</span></sup></td>
                                                <td></td>
                                            @else
                                                <td>{{ $loop->iteration}}</td>
                                                <td>{{ $product->name}} <sup><span class="badge badge-primary">{{ $product->stock}}</span></sup></td>
                                                <td>
                                                    <button type="submit" class="btn btn-sm btn-success"><i class="fas fa-plus"></i></button>
                                                </td>
                                            @endif
                                        </form>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-8">
                    @if ($message = Session::get('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> {{ $message }}.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="bg-secondary text-white">
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th style="width: 20%">Qty</th>
                                    <th>Harga</th>
                                    <th>Sub Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($cartData as $index=>$item)
                                    <tr>
                                        <td>{{ $loop->iteration}}</td>
                                        <td>{{ $item['name']}}</td>
                                        <td>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-minus"></i></button>
                                                </div>
                                                <input type="text" class="form-control" value="{{ $item['qty']}}" disabled>
                                                <div class="input-group-append">
                                                    <button type="submit" class="btn btn-sm btn-success"><i class="fas fa-plus"></i></button>
                                                </div>
                                            </div>
                                        </td>
                                        <td>Rp. {{ number_format($item['pricesingle'],0,',','.')}}</td>
                                        <td>Rp. {{ number_format($item['price'],0,',','.')}}</td>
                                        <td>
                                            <form action="{{ route('sale.removeproduct',$item['rowId'])}}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-md">
                                                    <i class="fas fa-trash text-danger"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="5">Empty Cart</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>
                                        <b><i>Jumlah</i></b>
                                    </th>
                                    <th>
                                        <b><i>3</i></b>
                                    </th>
                                    <th>
                                        <b><i>Grand Total</i></b>
                                    </th>
                                    <th>
                                        <b><i>50000</i></b>
                                    </th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                        <div class="bg-primary text-center text-white p-1">
                            <p>
                                <h5>Total</h5>
                                <h4><b><i>10000</i></b></h4>
                            </p>
                        </div>
                        <div class="text-center p-1">
                            <form action="{{route('sale.clear')}}" method="POST">
                                @csrf
                                <button class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin ingin meng-clear cart ?');" type="submit">
                                    Clear
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            //refresh
            $('.btn-refresh').click(function(e){
                e.preventDefault();
                $('.preloader').fadeIn();
                location.reload();
            })
        })
    </script>
@endpush