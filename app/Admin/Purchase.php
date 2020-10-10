<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = ['supplier_id', 'product_id', 'buy', 'qty'];
}
