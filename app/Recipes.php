<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recipes extends Model
{
    protected $fillable = ['name'];

    public function user() {
        $this->belongsTo('App\User');
    }

    public function recipeProducts() {
        return $this->belongsTo('App\RecipeProducts');
    }

}
