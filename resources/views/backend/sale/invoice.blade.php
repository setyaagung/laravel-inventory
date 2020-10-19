<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>{{ $sale->invoice}}</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

</head>

<body>
    <div style="width: 250px">
        @php
            $company = \DB::select('select * from companies where id = ?', [1])
        @endphp
        <div style="text-align: center;margin-bottom: 15px">
            @foreach ($company as $com)
                <h3 style="margin: 0">{{ $com->name}}</h3>
                <small>
                    {{$com->address}}
                    <br>
                    Telepon : {{ $com->phone}} - HP : {{ $com->mobile}}
                </small>
            @endforeach
        </div>
        <hr class="mb-1 mt-1" style="border: dashed">
        <div class="row" style="font-size: 12px">
            <div class="col-sm-6">
                <p class="mb-0">No Invoice</p>
                <p class="mb-0">Kasir</p>
                <p class="mb-0">Tanggal</p>
            </div>
            <div class="col-sm-6 text-right" style="float: right;">
                <p class="mb-0">{{$sale->invoice}}</p>
                <p class="mb-0">{{ $sale->user->name}}</p>
                <p>{{ date('Y-m-d : H:i:s', strtotime($sale->created_at)) }}</p>
            </div>
        </div>
        <hr class="mb-1 mt-1" style="border: dashed">
        <table class="table-sm table-borderless" style="font-size: 12px">
            <thead>
                <tr>
                    <td><b>Produk</b></td>
                    <td><b>Qty</b></td>
                    <td><b>Harga</b></td>
                    <td><b>Total</b></td>
                </tr>
            </thead>
            <tbody>
                @foreach ($sale->saleDetails as $detail)
                    <tr>
                        <td>{{ $detail->product->name}}</td>
                        <td>{{ $detail->qty}} x</td>
                        <td>Rp {{ number_format($detail->product->sell) }}</td>
                        <td>Rp {{ number_format($detail->qty * $detail->product->sell) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <hr class="mb-1 mt-1" style="border: dashed">
        <div class="row" style="font-size: 12px">
            <div class="col-sm-6">
                <p class="mb-0">Grand Total</p>
                <p class="mb-0">Pembayaran</p>
                <p class="mb-0">Kembalian</p>
            </div>
            <div class="col-sm-6 text-right" style="float: right;">
                <p class="mb-0"><b>Rp {{ number_format($sale->total) }}</b></p>
                <p class="mb-0">Rp {{ number_format($sale->pay) }}</p>
                <p>Rp {{ number_format($sale->pay - $sale->total) }}</p>
            </div>
        </div>
        <hr class="mb-3 mt-1" style="border: dashed">
        <div style="text-align: center;""\>
            <h4 class="m-0">Terimakasih</h4>
            <p>Silahkan berkunjung kembali</p>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

</body>

</html>
