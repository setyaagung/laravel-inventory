<?php

namespace App\Admin;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = ['invoice', 'user_id', 'total', 'pay', 'pay_method', 'information'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function saleDetails()
    {
        return $this->hasMany(SaleDetail::class);
    }
}
