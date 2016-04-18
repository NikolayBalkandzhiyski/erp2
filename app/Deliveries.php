<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed id
 */
class Deliveries extends Model
{
    protected $fillable = ['product_count','total','id'];

    public function user() {
        return $this->belongsTo('App\User');
    }
}
