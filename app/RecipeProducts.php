<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RecipeProducts extends Model
{
    protected $fillable = ['name','product_id','product_count'];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function recipes() {
        return $this->hasMany('App\Recipes');
    }
}
