<?php

namespace App\Admin;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = ['invoice', 'user_id', 'total', 'information'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
