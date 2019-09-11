<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class coupon extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'coupon';
    public $timestamps = false;

}
