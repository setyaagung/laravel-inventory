<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use SoftDeletes;
    protected $fillable = ['name', 'address', 'phone', 'mobile'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
