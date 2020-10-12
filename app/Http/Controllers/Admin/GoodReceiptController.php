<?php

namespace App\Http\Controllers\Admin;

use App\Admin\GoodReceipt;
use App\Admin\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GoodReceiptController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $goodreceipts = GoodReceipt::orderBy('created_at', 'DESC')->get();
        return view('backend.goodreceipt.index', compact('goodreceipts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $gr = GoodReceipt::findOrFail($id);
        return view('backend.goodreceipt.detail', compact('gr'));
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

    public function approved($id)
    {
        try {
            $gr = GoodReceipt::findOrFail($id);
            DB::transaction(function () use ($id, $gr) {
                GoodReceipt::where('id', $id)->update([
                    'status_id' => 2,
                ]);

                foreach ($gr->purchase->purchaseDetails as $detail) {
                    $qty = $detail->qty;
                    $product_id = $detail->product_id;

                    $p = Product::findOrFail($product_id);
                    $old_stock = $p->stock;
                    $new_stock = $old_stock + $qty;

                    Product::where('id', $product_id)->update([
                        'stock' => $new_stock
                    ]);
                }
            });
            \Session::flash('success', 'Dokumen berhasil di Approved');
        } catch (\Exception $e) {
            \Session::flash('error', 'Tidak dapat Meng Approved Dokumen');
        }
        return redirect()->back();
    }
}
