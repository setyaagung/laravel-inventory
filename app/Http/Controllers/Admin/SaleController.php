<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Product;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Darryldecode\Cart\Cart;
use Illuminate\Support\Facades\Auth;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $products = Product::orderBy('name', 'ASC')->get();
        $invoice = Carbon::now()->format('Ymd') . Str::random(8);

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

        return view('backend.sale.create', compact('products', 'invoice', 'cartData', 'data_total'));
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
        //
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
    public function clear()
    {
        \Cart::session(Auth()->id())->clear();
        return redirect()->back();
    }
}
