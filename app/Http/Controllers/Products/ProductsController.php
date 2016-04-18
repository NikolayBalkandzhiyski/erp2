<?php

namespace App\Http\Controllers\Products;

use App\Http\Requests\ProductsRequest;
use App\Measures;
use App\Products;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ProductsController extends Controller
{
    /**
     *redirect of not auth
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = DB::table('products')
            ->select('products.*')
            ->paginate(10);

        $title = trans('product.products_list');

        return view('products.products', compact('products','title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $title = trans('product.create');

        return view('products.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductsRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductsRequest $request)
    {
        $input = new Products($request->all());
        $input->ip = $request->ip();

        Auth::user()->products()->save($input);

        return redirect('/products');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = DB::table('products')
            ->select('products.*')
            ->where('products.id', '=', $id)
            ->first();

        $title = trans('product.product_edit');

        return view('products.edit',compact('product','title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductsRequest|Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductsRequest $request, $id)
    {
        $input = $request->all();
        $input['ip'] = $request->ip();
        $input['user_id'] = Auth::id();

        $product = Products::findOrFail($id);

        $product->update($input);

        return redirect('/products');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('products')->where('id', '=', $id)->delete();

        return redirect('/products');
    }
}
