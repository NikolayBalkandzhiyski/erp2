<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Measures extends Model
{
    protected $fillable = ['name','multiplier','ip','user_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo('App\User');
    }

}
