<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $admins;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Set admin users ids
     * @return array
     */
    public function admins() {
        $admins = [1];

        return $admins;
    }

    /**
     * A user can create mny measures
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function measures() {
        return $this->hasMany('App\Measures');
    }

    /**
     * A user can have many products
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products() {
        return $this->hasMany('App\Products');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function deliveryProducts() {
        return $this->hasMany('App\DeliveryProducts');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function deliveries() {
        return $this->hasMany('App\Deliveries');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function recipes() {
        return $this->hasMany('App\Recipes');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function recipeProducts() {
        return $this->hasMany('App\RecipeProducts');
    }

    public function tasks() {
        return $this->hasMany('App\Tasks');
    }

    public function taskRecipes() {
        return $this->hasMany('App\TaskRecipes');
    }
}
