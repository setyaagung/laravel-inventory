<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>{{ $sale->invoice}}</title>

    <!-- Custom styles for this template-->
    <link href="{{ asset('backend/css/sb-admin-2.min.css')}}" rel="stylesheet">

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
        <table style="width: 100%;font-size: 12px">
            <tr>
                <td>No Invoice</td>
                <td style="text-align: right">{{ $sale->invoice}}</td>
            </tr>
            <tr>
                <td>Kasir</td>
                <td style="text-align: right">{{$sale->user->name}}</td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td style="text-align: right">{{date($sale->created_at)}}</td>
            </tr>
        </table>
        <hr class="mb-1 mt-1" style="border: dashed">
        <table class="table-sm table-borderless" style="width: 100%;font-size: 12px">
            <thead>
                <tr>
                    <td><b>Produk</b></td>
                    <td><b>Qty</b></td>
                    <td><b>Harga</b></td>
                    <td style="text-align: right"><b>Total</b></td>
                </tr>
            </thead>
            <tbody>
                @foreach ($sale->saleDetails as $detail)
                    <tr>
                        <td>{{ $detail->product->name}}</td>
                        <td>{{ $detail->qty}} x</td>
                        <td>Rp {{ number_format($detail->product->sell) }}</td>
                        <td style="text-align: right">Rp {{ number_format($detail->qty * $detail->product->sell) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <hr class="mb-1 mt-1" style="border: dashed">
        <table style="width: 100%;font-size: 12px">
            <tr>
                <td>Grand Total</td>
                <td style="text-align: right"><b>Rp {{ number_format($sale->total)}}</b></td>
            </tr>
            <tr>
                <td>Pembayaran</td>
                <td style="text-align: right">Rp {{ number_format($sale->pay)}}</td>
            </tr>
            <tr>
                <td>Kembalian</td>
                <td style="text-align: right">Rp {{ number_format($sale->pay - $sale->total)}}</td>
            </tr>
        </table>
        <hr class="mt-1" style="border: dashed">
        <div style="text-align: center;margin-top: -10px">
            <h4>Terimakasih</h4>
            <p>Silahkan berkunjung kembali</p>
        </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('backend/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{ asset('backend/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('backend/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('backend/js/sb-admin-2.min.js')}}"></script>

</body>

</html>
