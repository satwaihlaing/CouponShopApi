<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $guarded = [];

    public function setAdminIdAttribute($value)
    {
        $this->attributes['admin_id'] = 1 ;
    }

    public function shops()
    {
        return $this->belongsToMany(Shop::class, 'coupon_shops');
    }
}
