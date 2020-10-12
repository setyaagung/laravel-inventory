<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class GoodReceipt extends Model
{
    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    public function totalItem()
    {
        $purchase = $this->purchase_id;
        $total = PurchaseDetail::where('purchase_id', $purchase)->count();
        return $total;
    }
}
