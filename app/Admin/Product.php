<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    protected $fillable = ['supplier_id', 'code', 'name', 'stock', 'minimum_stock', 'buy', 'sell'];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
