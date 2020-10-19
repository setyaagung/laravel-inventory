<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Product;
use App\Admin\Sale;
use App\Admin\SaleDetail;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Darryldecode\Cart\Cart;
use PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $first_date = date('Y-m-d', strtotime($request->first_date));
        $last_date = date('Y-m-d', strtotime($request->last_date));
        if ($request->has('first_date', 'last_date')) {
            $sales = Sale::whereDate('created_at', '>=', $first_date)->whereDate('created_at', '<=', $last_date)->orderBy('created_at', 'desc')->get();
        } else {
            $sales = Sale::orderBy('created_at', 'desc')->get();
        }
        return view('backend.sale.index', compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if ($request->has('search')) {
            $products = Product::orderBy('name', 'ASC')->where('name', 'LIKE', '%' . $request->search . '%')->paginate(5);
        } else {
            $products = Product::orderBy('name', 'ASC')->paginate(5);
        }

        //cart item
        if (request()->tax) {
            $tax = "+10%";
        } else {
            $tax = "0%";
        }
        $condition = new \Darryldecode\Cart\CartCondition(array(
            'name' => 'tax',
            'type' => 'tax', //tipenya apa
            'target' => 'total', //target kondisi ini apply ke mana (total, subtotal)
            'value' => $tax, //contoh -12% or -10 or +10 etc
            'order' => 1
        ));

        \Cart::session(Auth()->id())->condition($condition);
        $items = \Cart::session(Auth()->id())->getContent();
        if (\Cart::isEmpty()) {
            $cartData = [];
        } else {
            foreach ($items as $row) {
                $cart[] = [
                    'rowId' => $row->id,
                    'name' => $row->name,
                    'qty' => $row->quantity,
                    'pricesingle' => $row->price,
                    'price' => $row->getPriceSum(),
                    'created_at' => $row->attributes['created_at'],
                ];
            }

            $cartData = collect($cart)->sortBy('created_at');
        }
        //total
        $sub_total = \Cart::session(Auth()->id())->getSubTotal();
        $total = \Cart::session(Auth()->id())->getTotal();
        //tax
        $new_condition = \Cart::session(Auth()->id())->getCondition('tax');
        $tax = $new_condition->getCalculatedValue($sub_total);

        $data_total = [
            'sub_total' => $sub_total,
            'total' => $total,
            'tax' => $tax
        ];

        return view('backend.sale.create', compact('products', 'cartData', 'data_total'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sale = Sale::findOrFail($id);
        return view('backend.sale.detail', compact('sale'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function filter(Request $request)
    {
        $first_date = date('Y-m-d', strtotime($request->first_date));
        $last_date = date('Y-m-d', strtotime($request->last_date));
    }

    public function addProduct($id)
    {
        $product = Product::findOrFail($id);

        $cart = \Cart::session(Auth()->id())->getContent();
        $checkItemId = $cart->whereIn('id', $id);

        if ($checkItemId->isNotEmpty()) {
            if ($product->stock == $checkItemId[$id]->quantity) {
                return redirect()->back()->with('error', 'Telah mencapai jumlah maximum Product | Silahkan tambah stock Product terlebih dahulu untuk menambahkan');
            } else {
                \Cart::session(Auth()->id())->update($id, [
                    'quantity' => 1
                ]);
            }
        } else {
            \Cart::session(Auth()->id())->add([
                'id' => $id,
                'name' => $product->name,
                'price' => $product->sell,
                'quantity' => 1,
                'attributes' => array(
                    'created_at' => date('Y-m-d H:i:s')
                )
            ]);
        }
        return redirect()->back();
    }

    public function removeProduct($id)
    {
        \Cart::session(Auth()->id())->remove($id);
        return redirect()->back();
    }

    public function updatecart(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $cart = \Cart::session(Auth()->id())->getContent();
        $checkItemId = $cart->whereIn('id', $id);
        $quantity = $request->quantity;

        if ($product->stock < $quantity) {
            return redirect()->back()->with('error', 'Stok produk mencapai jumlah maximum | Silahkan tambah stok terlebih dahulu.');
        } else {
            \Cart::session(Auth()->id())->update($id, array(
                'quantity' => array(
                    'relative' => false,
                    'value' => $quantity
                )
            ));

            return redirect()->back();
        }
    }
    public function clear()
    {
        \Cart::session(Auth()->id())->clear();
        return redirect()->back();
    }

    public function pay(Request $request)
    {
        $cart_total = \Cart::session(Auth()->id())->getTotal();
        $pay = request()->pay;
        $change = (int)$pay - (int)$cart_total;

        if ($change >= 0) {
            DB::beginTransaction();

            try {

                $all_cart = \Cart::session(Auth()->id())->getContent();


                $filterCart = $all_cart->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'quantity' => $item->quantity
                    ];
                });

                foreach ($filterCart as $cart) {
                    $product = Product::findOrFail($cart['id']);

                    if ($product->stock == 0) {
                        return redirect()->back()->with('errorSale', 'jumlah pembayaran gak valid');
                    }

                    $product->decrement('stock', $cart['quantity']);
                }

                $sale = Sale::create([
                    'invoice' => Carbon::now()->format('Ymd') . Str::random(8),
                    'user_id' => Auth::id(),
                    'information' => $request->information,
                    'pay' => request()->pay,
                    'pay_method' => $request->pay_method,
                    'total' => $cart_total
                ]);

                foreach ($filterCart as $cart) {

                    SaleDetail::create([
                        'sale_id' => $sale->id,
                        'product_id' => $cart['id'],
                        'qty' => $cart['quantity'],
                    ]);
                }

                \Cart::session(Auth()->id())->clear();

                DB::commit();
                return redirect()->back()->with('success', 'Transaksi Berhasil dilakukan | Klik History untuk print');
            } catch (\Exeception $e) {
                DB::rollback();
                return redirect()->back()->with('errorSale', 'jumlah pembayaran tidak valid');
            }
        }
        return redirect()->back()->with('errorSale', 'jumlah pembayaran tidak valid');
    }

    public function invoice($invoice)
    {
        $sale = Sale::where('invoice', $invoice)->firstOrFail();
        $pdf = PDF::loadView('backend.sale.invoice', compact('sale'))->setPaper('4x6in.', 'potrait');
        return $pdf->stream();
    }
}
