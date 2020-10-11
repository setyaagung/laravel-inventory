<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = ['document_number', 'supplier_id'];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function purchaseDetails()
    {
        return $this->hasMany(PurchaseDetail::class);
    }

    public function total()
    {
        $purchase = $this->id;

        $total = PurchaseDetail::where('purchase_id', $purchase)->sum('total');
        return $total;
    }
}
