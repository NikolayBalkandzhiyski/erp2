<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\DB;

class DeliveryProductsRequest extends Request
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


        $products = DB::table('products as p')
                    ->select('p.name')
                    ->get();

        foreach($products as $product){
            $name .= $product->name.',';
        }

        $rules = [
            'name' => 'required|in:'.$name,
            'product_count' => 'required|numeric',
            'product_price' => 'required|numeric',
            'product_id' => 'required|integer',
            'measure' => 'required'
        ];

        return $rules;
    }
}
