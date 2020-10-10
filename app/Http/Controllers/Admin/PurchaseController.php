<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Product;
use App\Admin\Purchase;
use App\Admin\PurchaseDetail;
use App\Admin\Supplier;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PurchaseController extends Controller
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
    public function create()
    {
        $suppliers = Supplier::orderBy('name', 'ASC')->get();
        $doc = 'PO' . Carbon::now()->format('Ymd') . rand(10000000000, 99999999999);
        return view('backend.purchase.create', compact('suppliers', 'doc'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $product_id = $request->product_id;
            $qty = $request->qty;
            $document_number = $request->document_number;
            $supplier = $request->supplier_id;
            $purchase_id = Purchase::insertGetId([
                'document_number' => $document_number,
                'supplier' => $supplier,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            foreach ($qty as $e => $q) {
                if ($q == 0) {
                    continue;
                }
                $dtProduct = Product::where('id', $product[$e])->first();
                $buy = $dtProduct->buy;
                $total = $buy * $q;
                PurchaseDetail::insert([
                    'purchase_id' => $purchase_id,
                    'product_id' => $product_id[$e],
                    'qty' => $q,
                    'buy' => $buy,
                    'total' => $total
                ]);
            }
            \Session::flash('sukses', 'Pemesanan produk berhasil dibuat');
        } catch (\Exception $e) {
            \Session::flash('gagal', 'gagal');
        }
        return redirect()->back();
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

    public function getProduct($supplier)
    {
        $suppliers = Supplier::orderBy('name', 'ASC')->get();
        $products = Product::where('supplier_id', $supplier)->orderBy('name', 'ASC')->get();
        $doc = 'PO' . Carbon::now()->format('Ymd') . rand(10000000000, 99999999999);
        return view('backend.purchase.create', \compact('suppliers', 'products', 'doc', 'supplier'));
    }
}
