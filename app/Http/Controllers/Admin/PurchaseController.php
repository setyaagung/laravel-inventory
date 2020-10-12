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
        $purchases = Purchase::withCount(['purchaseDetails'])->orderBy('created_at', 'DESC')->get();
        return view('backend.purchase.index', compact('purchases'));
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
            $product = $request->product_id;
            $qty = $request->qty;
            $document_number = $request->document_number;
            $supplier = $request->supplier_id;
            $purchase = Purchase::insertGetId([
                'document_number' => $document_number,
                'supplier_id' => $supplier,
                'created_at' => \date('Y-m-d H:i:s'),
                'updated_at' => \date('Y-m-d H:i:s')
            ]);
            foreach ($qty as $e => $qt) {
                if ($qt == 0) {
                    continue;
                }
                $dtProduct = Product::where('id', $product[$e])->first();
                $buy = $dtProduct->buy;
                $total = $qt * $buy;
                PurchaseDetail::insert([
                    'purchase_id' => $purchase,
                    'product_id' => $product[$e],
                    'qty' => $qt,
                    'buy' => $buy,
                    'total' => $total
                ]);
            }
            \Session::flash('create', 'Pemesanan produk berhasil dibuat');
        } catch (\Exception $e) {
            \Session::flash('error', 'Pemesanan produk gagal');
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
        $purchase = Purchase::findOrFail($id);
        return view('backend.purchase.detail', compact('purchase'));
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
        try {
            $qty = $request->qty;
            $buy = $request->buy;
            $product_id = $request->product_id;
            $id = $request->id;

            foreach ($qty as $e => $q) {
                $data['qty'] = $q;
                $data['buy'] = $buy[$e];
                $data['total'] = $q * $buy[$e];
                $detail = $id[$e];

                PurchaseDetail::where('id', $detail)->update($data);

                Product::where('id', $product_id[$e])->update([
                    'buy' => $data['buy'],
                ]);
            }
            \Session::flash('success', 'Data pemesanan produk berhasil diperbarui');
        } catch (\Exception $e) {
            \Session::flash('error', 'Data pemesanan produk gagal diperbarui');
        }
        return redirect()->back();
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

    public function approved($id)
    {
        try {
            Purchase::where('id', $id)->update([
                'status_id' => 2,
            ]);
            \Session::flash('approved', 'Produk yang telah dipesan berhasil disetujui');
        } catch (\Exception $e) {
            \Session::flash('error', 'Produk yang telah dipesan belum dapat disetujui');
        }
        return redirect()->back();
    }

    public function destroy_detail($id)
    {
        try {
            PurchaseDetail::where('id', $id)->delete();
            \Session::flash('delete', 'Produk dalam detail pemesanan berhasil dihapus');
        } catch (\Exception $e) {
            \Session::flash('error', 'Produk dalam detail pemesanan gagal dihapus');
        }
        return redirect()->back();
    }
}
