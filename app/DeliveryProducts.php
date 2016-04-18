<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryProducts extends Model
{
    protected $fillable = ['product_id','product_count','product_price'];

    public function user() {
        return $this->belongsTo('App\User');
    }
}
