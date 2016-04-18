<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    protected $fillable = ['datepicker'];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function taskRecipes() {
        return $this->belongsTo('App\TaskRecipes');
    }
}
