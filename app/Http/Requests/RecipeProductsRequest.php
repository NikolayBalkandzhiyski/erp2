<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Products;
use App\RecipeProducts;

class RecipeProductsRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        static $name;
        static $product_id;

        $products = Products::all('name');

        foreach($products as $product){
            $name .= $product->name.',';
        }

        $recipe_products = RecipeProducts::where('recipe_id','=',$this->recipes)->get();

        foreach($recipe_products as $recipe_product){
            $product_id .= $recipe_product->product_id.',';
        }

        $rules = [
            'name' => 'required|in:'.$name,
            'product_count' => 'required|numeric',
            'product_id' => 'required|integer|not_in:'.$product_id,
            'measure' => 'required'
        ];

        return $rules;
    }
}
