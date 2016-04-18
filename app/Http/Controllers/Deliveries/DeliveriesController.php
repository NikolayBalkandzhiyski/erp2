<?php

namespace App\Http\Controllers\Deliveries;


use App\Deliveries;
use App\DeliveryProducts;
use App\Http\Requests\DeliveryProductsRequest;
use App\Measures;
use App\Products;
use App\Recipes;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;

class DeliveriesController extends Controller
{

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

        $deliveries = DB::table('deliveries')
            ->join('delivery_products', 'deliveries.id', '=', 'delivery_products.delivery_id')
            ->join('users' ,'deliveries.user_id', '=' , 'users.id')
            ->select('deliveries.id as delivery_id','deliveries.created_at',DB::raw('SUM(delivery_products.product_count) as count'),
                DB::raw('SUM(delivery_products.total) as total'),'users.name as username')
            ->groupBy('deliveries.id')
            ->paginate(10);

        foreach ($deliveries as $delivery) {
            $delivery->count = number_format($delivery->count,9);
            $delivery->total = number_format($delivery->total,9);
        }


        $title = trans('delivery.deliveries_list');

        return view('deliveries.deliveries',compact('deliveries','title'));
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     * @internal param Request $request
     * @internal param Session $session
     * @internal param Request $request
     */
    public function create()
    {

        $title = trans('delivery.create');

        $measures = Measures::all();

        return view('deliveries.create',compact('title','measures'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param DeliveryProductsRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(DeliveryProductsRequest $request)
    {

        $input = new DeliveryProducts($request->all());


            $delivery = new Deliveries();

            $delivery->ip = $request->ip();
            Auth::user()->deliveries()->save($delivery);

            $calculated_count =  $request->product_count / $request->measure;

            $input->ip = $request->ip();
            $input->delivery_id = $delivery->id;
            $input->product_count = $calculated_count;
            $input->count_left = $calculated_count;
            $input->total = $calculated_count * $request->product_price;

            Auth::user()->deliveryProducts()->save($input);


        return redirect('deliveries/'.$delivery->id.'/edit');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $products = DB::table('delivery_products as dp')
            ->join('products as p', 'dp.product_id', '=', 'p.id')
            ->select('p.*','dp.product_count','dp.product_price','dp.id as delivery_product_id')
            ->where('dp.delivery_id', '=' , $id)
            ->paginate(10);

        $delivery_total = 0;
        foreach ($products as $product) {
            $product->product_count = number_format($product->product_count,9);
            $delivery_total += $product->product_count * $product->product_price;
        }

        $measures = Measures::all();

        $title = trans('delivery.edit_delivery');

        return view('deliveries.edit', compact('products','id','title','delivery_total','measures'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DeliveryProductsRequest $request, $id)
    {

        $input = new DeliveryProducts($request->all());

        $calculated_count =  $request->product_count / $request->measure;

        $input->delivery_id = $id;
        $input->ip = $request->ip();
        $input->count_left = $calculated_count;
        $input->product_count = $calculated_count;
        $input->total = $calculated_count * $request->product_price;

        Auth::user()->deliveryProducts()->save($input);
        return redirect('deliveries/'.$id.'/edit');
    }

    /**
     * Show form for update delivered product
     * @param $delivery_id
     * @param $product_id
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editProduct($delivery_id,$product_id,$id)
    {

        $product = DB::table('delivery_products as dp')
            ->join('products as p', 'dp.product_id', '=', 'p.id')
            ->select('p.name','dp.product_id','dp.product_count','dp.product_price')
            ->where([['dp.delivery_id', '=' , $delivery_id],['dp.product_id', '=', $product_id],['dp.id','=',$id]])
            ->first();

        $product->product_count = number_format($product->product_count,9);


        $measures = Measures::all();

        $title = trans('delivery.edit_product');

        return view('deliveries.editProduct', compact('product','delivery_id','id','title','measures'));
    }

    /**
     * Update delivered prodcut
     * @param DeliveryProductsRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function updateProduct(DeliveryProductsRequest $request, $delivery_id,$product_id,$id)
    {
        $product = DeliveryProducts::where([['delivery_id', '=', $delivery_id],['product_id', '=', $product_id],['id','=',$id]])->first();

        $calculated_count =  $request->product_count / $request->measure;

        $product->delivery_id = $delivery_id;
        $product->product_id = $product_id;
        $product->product_count = $calculated_count;
        $product->count_left = $calculated_count;
        $product->product_price = $request->product_price;
        $product->total = $calculated_count * $request->product_price;

        Auth::user()->deliveryProducts()->save($product);
        return redirect('deliveries/'.$delivery_id.'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('delivery_products')
            ->where([
                ['delivery_id','=',$id],
            ])
            ->delete();

        DB::table('deliveries')
            ->where('id', '=' , $id)
            ->delete();

        return redirect('/deliveries');
    }

    public function destroyDeliveryProduct($id,$product_id,$delivery_product_id) {
        DB::table('delivery_products')
            ->where([
                    ['product_id', '=' ,$product_id],
                    ['delivery_id','=',$id],
                    ['id','=',$delivery_product_id],
                ])
            ->delete();

        return redirect('/deliveries/'.$id.'/edit');
    }

    public function ajaxsearch() {
        $input = Input::get('term');

        $products = DB::table('products')
                    ->where('name', 'like', '%'.$input.'%')
                    ->get();

        foreach ($products as $product) {
            $data[] = ['value' => $product->name,'id' => $product->id];
        }
        return Response::json($data);
    }
}
