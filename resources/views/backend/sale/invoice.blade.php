<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $sale->invoice}}</title>
    <style>
        .container {
            width: 300px;
        }
        .header {
            margin: 0;
            text-align: center;
        }
        h2, p {
            margin: 0;
        }
        .flex-container-1 {
            display: flex;
            margin-top: 10px;
        }
        .flex-container-1 > div {
            text-align : left;
        }
        .flex-container-1 .right {
            text-align : right;
            width: 200px;
        }
        .flex-container-1 .left {
            width: 100px;
        }
        .flex-container {
            width: 300px;
            display: flex;
        }
        .flex-container > div {
            -ms-flex: 1;  /* IE 10 */
            flex: 1;
        }
        ul {
            display: contents;
        }
        ul li {
            display: block;
        }
        hr {
            bsale-style: dashed;
        }
        a {
            text-decoration: none;
            text-align: center;
            padding: 10px;
            background: #00e676;
            bsale-radius: 5px;
            color: white;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        @php
            $company = \DB::select('select * from companies where id = ?', [1])
        @endphp
        <div class="header" style="margin-bottom: 30px;">
            @foreach ($company as $com)
                <h2>{{ $com->name}}</h2>
                <small>
                    {{$com->address}}
                    <br>
                    Telepon : {{ $com->phone}} - HP : {{ $com->mobile}}
                </small>
            @endforeach
        </div>
        <hr>
        <div class="flex-container-1">
            <div class="left">
                <ul>
                    <li>No Invoice</li>
                    <li>Kasir</li>
                    <li>Tanggal</li>
                </ul>
            </div>
            <div class="right">
                <ul>
                    <li> {{ $sale->invoice }} </li>
                    <li> {{ $sale->user->name }} </li>
                    <li> {{ date('Y-m-d : H:i:s', strtotime($sale->created_at)) }} </li>
                </ul>
            </div>
        </div>
        <hr>
        <div class="flex-container" style="margin-bottom: 10px; text-align:right;">
            <div style="text-align: left;">Produk</div>
            <div>Qty</div>
            <div>Harga</div>
            <div>Total</div>
        </div>
        @foreach ($sale->saleDetails as $detail)
            <div class="flex-container" style="text-align: right;">
                <div style="text-align: left;">{{ $detail->product->name }}</div>
                <div>{{ $detail->qty}}</div>
                <div>Rp {{ number_format($detail->product->sell) }} </div>
                <div>Rp {{ number_format($detail->qty * $detail->product->sell) }} </div>
            </div>
        @endforeach
        <hr>
        <div class="flex-container" style="text-align: right; margin-top: 10px;">
            <div></div>
            <div>
                <ul>
                    <li>Grand Total</li>
                    <li>Pembayaran</li>
                    <li>Kembalian</li>
                </ul>
            </div>
            <div style="text-align: right;">
                <ul>
                    <li>Rp {{ number_format($sale->total) }} </li>
                    <li>Rp {{ number_format($sale->pay) }}</li>
                    <li>Rp {{ number_format($sale->pay - $sale->total) }}</li>
                </ul>
            </div>
        </div>
        <hr>
        <div class="header" style="margin-top: 50px;">
            <h3>Terimakasih</h3>
            <p>Silahkan berkunjung kembali</p>
        </div>
    </div>
</body>
</html>