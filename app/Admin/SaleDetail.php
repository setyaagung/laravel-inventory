<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model
{
    protected $fillable = ['sale_id', 'product_id', 'qty', 'price', 'total'];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
