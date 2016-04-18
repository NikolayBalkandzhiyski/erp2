<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskRecipes extends Model
{
    protected $fillable = ['count','recipe'];

    protected $hidden = ['id','task_recipe_product_count'];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function tasks() {
        return $this->hasMany('App\Tasks');
    }
}
