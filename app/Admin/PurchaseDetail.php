<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class PurchaseDetail extends Model
{
    protected $fillable = ['purchase_id', 'product_id', 'buy', 'qty', 'total'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
