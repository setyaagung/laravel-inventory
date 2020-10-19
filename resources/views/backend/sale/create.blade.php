@extends('layouts.backend.main')

@section('title','List Point Of Sales')

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold">List Produk</h6>
                    <div class="float-right">
                        <button class="btn btn-sm btn-warning btn-refresh"><i class="fas fa-sync-alt"></i> Refresh</button>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('sale.create') }}" method="GET">
                        <div>
                            <input type="text" name="search" class="form-control form-control-sm mb-3" placeholder="Cari Produk ..." onblur="this.form.submit()">
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered">
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
                        <div class="float-left mt-2">
                            Jumlah Data : {{ $products->total()}}
                        </div>
                        <div class="float-right">
                            {{ $products->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold">Cart</h6>
                    <div class="float-right">
                        <b>{{ \Carbon\Carbon::now()->isoFormat('D MMMM Y')}}</b>
                    </div>
                </div>
                <div class="card-body">
                    @if ($message = Session::get('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> {{ $message }}.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    
                    @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> {{ $message }}.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                    <div class="table-responsive" style="min-height: 45.4vh">
                        <table class="table table-hover table-sm">
                            <thead class="bg-secondary text-white">
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th style="width: 17%">Qty</th>
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
                                            <form action="{{ route('sale.updatecart',$item['rowId'])}}" method="POST">
                                                @csrf
                                                <div class="input-group">
                                                    <input type="number" name="quantity" class="form-control form-control-sm" value="{{ $item['qty']}}">
                                                    <div class="input-group-append">
                                                        <button type="submit" class="btn btn-sm btn-success"><i class="fas fa-check"></i></button>
                                                    </div>
                                                </div>
                                            </form>
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
                                        <td class="text-center" colspan="6">Empty Cart</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <table class="table table-sm table-borderless">
                        <tr>
                            <th width="60%">Sub Total</th>
                            <th width="40%" class="text-right">
                                Rp. {{ number_format($data_total['sub_total'],2,',','.') }} </th>
                        </tr>
                        <tr>
                            <th>
                                <form action="{{ route('sale.create') }}" method="get">
                                    PPN 10%
                                    <input type="checkbox" {{ $data_total['tax'] > 0 ? "checked" : ""}} name="tax"
                                        value="true" onclick="this.form.submit()">
                                </form>
                            </th>
                            <th class="text-right">Rp.
                                {{ number_format($data_total['tax'],2,',','.') }}</th>
                        </tr>
                        <tr>
                            <th>Total</th>
                            <th class="text-right font-weight-bold">Rp.
                                {{ number_format($data_total['total'],2,',','.') }}</th>
                        </tr>
                    </table>
                    <div class="row">
                        <div class="col-sm-4">
                            <form action="{{route('sale.clear')}}" method="POST">
                                @csrf
                                <button class="btn btn-danger btn-sm btn-block" onclick="return confirm('Apakah anda yakin ingin meng-clear cart ?');" type="submit">
                                    Clear
                                </button>
                            </form>
                        </div>
                        <div class="col-sm-4">
                            <a class="btn btn-primary btn-sm btn-block" href="{{ route('sale.index')}}">History</a>
                        </div>
                        <div class="col-sm-4">
                            <button class="btn btn-success btn-sm btn-block" data-toggle="modal" data-target="#modalPay">Bayar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- MODAL BAYAR -->
    <div class="modal fade" id="modalPay" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title w-100 text-light" id="exampleModalLabel">Billing Information</h5>
                    <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('sale.pay')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th width="60%">Sub Total</th>
                                <th width="40%" class="text-right">Rp.
                                    {{ number_format($data_total['sub_total'],2,',','.') }} </th>
                            </tr>
                            @if($data_total['tax'] > 0)
                                <tr>
                                    <th>PPN 10%</th>
                                    <th class="text-right">Rp.
                                        {{ number_format($data_total['tax'],2,',','.') }}</th>
                                </tr>
                            @endif
                        </table>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Input Nominal</label>
                                    <input type="number" class="form-control" name="pay" id="oke" autofocus>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Metode Pembayaran</label>
                                    <select name="pay_method" class="form-control">
                                        <option value="cash">Cash</option>
                                        <option value="transfer">Transfer</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Informasi</label>
                            <textarea name="information" class="form-control" rows="3"></textarea>
                        </div>
                        <h6 class="font-weight-bold">Total :</h6>
                        <h4 class="font-weight-bold mb-5">Rp. {{ number_format($data_total['total'],2,',','.') }}</h4>
                        <input id="totalHidden" type="hidden" name="totalHidden" value="{{$data_total['total']}}" />
                    
                        <h6 class="font-weight-bold">Bayar :</h6>
                        <h4 class="font-weight-bold mb-5" id="paying"></h4>
                        <h6 class="font-weight-bold text-primary">Kembalian :</h6>
                        <h4 class="font-weight-bold text-primary" id="change"></h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="saveButton" disabled onclick="openWindowReload(this)">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function(){
            //reload
            $('.btn-refresh').click(function(e){
                e.preventDefault();
                $('.preloader').fadeIn();
                location.reload();
            });

            $('#modalPay').on('shown.bs.modal', function(){
                $('#oke').trigger('focus');
            });

            oke.oninput = function () {
                let total = parseInt(document.getElementById('totalHidden').value) ? parseInt(document.getElementById('totalHidden').value) : 0;
                let pay = parseInt(document.getElementById('oke').value) ? parseInt(document.getElementById('oke').value) : 0;
                let result = pay - total;
                document.getElementById("paying").innerHTML = pay ? 'Rp ' + convertToRupiah(pay) + ',00' : 'Rp ' + 0 +
                    ',00';
                document.getElementById("change").innerHTML = result ? 'Rp ' + convertToRupiah(result) + ',00' : 'Rp ' + 0 +
                    ',00';
                check(pay, total);
                const saveButton = document.getElementById("saveButton");   
                if(total === 0){
                    saveButton.disabled = true;
                }
            }

            function check(pay, total) {
                const saveButton = document.getElementById("saveButton");   
                if (pay < total) {
                    saveButton.disabled = true;
                } else {
                    saveButton.disabled = false;
                }
            }

            function convertToRupiah(number) {

                if (number) {
                    var rupiah = "";
                    var numberrev = number.toString().split("").reverse().join("");

                    for (var i = 0; i < numberrev.length; i++)
                    if (i % 3 == 0)
                        rupiah += numberrev.substr(i, 3) + ".";
                        return (rupiah.split("", rupiah.length - 1).reverse().join(""));
                }else{
                    return number;
                }
            }
        });
    </script>
@endpush