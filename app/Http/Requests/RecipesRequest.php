<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Recipes;

class RecipesRequest extends Request
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

        $recipes = Recipes::all('name');

        foreach($recipes as $recipe)
            $name .= $recipe->name.',';

        return [
            'name' => 'required|not_in:'.$name
        ];
    }
}
