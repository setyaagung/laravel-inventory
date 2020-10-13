@extends('layouts.backend.main')

@section('title','Point Of Sales')

@section('content')
    <!-- Page Heading -->
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Point Of Sales</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header">
            <button class="btn btn-sm btn-warning btn-refresh"><i class="fas fa-sync-alt"></i> Refresh</button>
        </div>
        <div class="card-body">
            <input type="hidden" name="grand_total" value="0">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Scan Barcode</label>
                        <input type="text" class="form-control" name="barcode" autocomplete="off">
                    </div>
                </div>
            </div>
            <form action="{{ route('pos.store')}}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Kode</th>
                                        <th>Nama</th>
                                        <th>Harga</th>
                                        <th>Qty</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody class="product-ajax">
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="table table-responsive">
                                    <table class="table table-striped">
                                        <tbody>
                                            <tr>
                                                <th>Bayar</th>
                                                <td>:</td>
                                                <td>
                                                    <input type="number" class="form-control" name="bayar">
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Kembalian</th>
                                                <td>:</td>
                                                <td class="kembalian"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            $("input[name='barcode']").focus();
            $("input[name='grand_total']").val(0);
            $("input[name='bayar']").val('');

            $("input[name='barcode']").keypress(function(e){
                if(e.which == 13){
                    e.preventDefault();
                    var code = $(this).val();
                    var url = "{{ url('product/ajax')}}"+'/'+code;
                    var _this = $(this);

                    $.ajax({
                        type: 'get',
                        dataType : 'json',
                        url: url,
                        success: function(product){
                            console.log(product);
                            _this.val('');

                            var nilai = '';
                            nilai += '<tr>';

                            nilai += '<td>';
                            nilai += product.product.code;
                            nilai += '<input type="hidden" class="form-control" name="product_id[]" value="'+product.product.id+'">';
                            nilai += '</td>';

                            nilai += '<td>';
                            nilai += product.product.name;
                            nilai += '</td>';

                            nilai += '<td class="sale">';
                            nilai += product.product.sell;
                            nilai += '</td>';

                            nilai += '<td>';
                            nilai += '<input type="number" class="form-control" name="qty[]" value="1">';
                            nilai += '</td>';

                            nilai += '<td>';
                            nilai += '<button class="btn btn-sm btn-danger delete"><i class="fas fa-trash"></i></button>';
                            nilai += '</td>';

                            nilai += '</tr>';

                            var total = parseInt($("input[name='grand_total']").val());
                            total += product.product.sell;

                            $("input[name='grand_total']").val(total);

                            $('.product-ajax').append(nilai);
                            $("input[name='bayar']").val(0);
                        }
                    });
                }
            });
            $('body').on('click','.delete', function(e){
                e.preventDefault();
                $(this).closest('tr').remove();
            });

            $("button[type='submit']").click(function(e){
                var grand_total = parseInt($("input[name='grand_total']").val());
                var bayar = parseInt($("input[name='bayar']").val());

                if(bayar < grand_total){
                    e.preventDefault();
                    alert('Uang pembayaran tidak cukup');
                }
                alert(grand_total);
            });

            $("input[name='bayar']").keyup(function(e){
                var grand_total = parseInt($("input[name='grand_total']").val());
                var bayar = parseInt($(this).val());
                var kembalian = bayar - grand_total;

                $('.kembalian').text(kembalian);
            });

            $('.btn-refresh').click(function(e){
                e.preventDefault();
                $('.preloader').fadeIn();
                location.reload();
            });
        });
    </script>
@endpush