<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = ['name', 'address', 'phone', 'mobile', 'email'];
}
