<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $guarded = [];

    public function setAdminIdAttribute($value)
    {
        $this->attributes['admin_id'] = 1 ;
    }

    public function coupon()
    {
        return $this->belongsToMany(Coupon::class, 'coupon_shops');
    }
}
