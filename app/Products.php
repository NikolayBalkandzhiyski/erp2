<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
   protected $fillable = ['name','measure_id','ip','user_id'];


   /**
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
   public function user() {
      return $this->belongsTo('App\User');
   }
}
