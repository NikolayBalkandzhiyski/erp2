<?php

namespace App\Http\Controllers\Recipes;

use App\Http\Requests\RecipeProductsRequest;
use App\Http\Requests\RecipesRequest;
use App\Measures;
use App\Products;
use App\RecipeProducts;
use App\Recipes;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class RecipesController extends Controller
{

    /**
     *Auth for users
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $title = trans('recipes.recipes_list');

        $recipes = DB::table('recipes as r')
            ->leftJoin('recipe_products as rp', 'r.id', '=', 'rp.recipe_id')
            ->join('users as u', 'r.user_id', '=', 'u.id')
            ->select(
                'r.id as id',
                'r.name',
                DB::raw('SUM(rp.product_count) as product_count'),
                'r.created_at',
                'u.name as username')
            ->groupBy('rp.recipe_id')
            ->paginate(10);

        return view('recipes.recipes', compact('title', 'recipes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $title = trans('recipes.create');

        return view('recipes.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RecipesRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(RecipesRequest $request) {


            $recipe = new Recipes();

            $recipe->name = $request->name;
            $recipe->ip = $request->ip();

            Auth::user()->recipes()->save($recipe);



        return redirect('recipes/' . $recipe->id . '/edit');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * Get recipe products
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $title = trans('recipes.edit');

        $products = DB::table('recipe_products as rp')
            ->select(
                'rp.product_id',
                'rp.recipe_id',
                'p.name',
                'rp.product_count',
                'rp.id as recipe_product_id',
                'dp.product_price',
                DB::raw('rp.product_count * dp.product_price as product_total')
            )
            ->join('products as p', 'rp.product_id', '=', 'p.id')
            ->leftJoin('delivery_products as dp', 'p.id', '=', 'dp.product_id')
            ->where('rp.recipe_id', '=', $id)
            ->groupBy('rp.product_id')
            ->paginate(10);

        $measures = Measures::all();

        $recipe_total = 0;

        $recipe = Recipes::where('id', '=', $id)->first();

        return view('recipes.edit', compact('title', 'products', 'recipe', 'id', 'recipe_total','measures'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param RecipeProductsRequest|Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(RecipeProductsRequest $request, $id) {

        $recipe_product = new RecipeProducts();
        $calculated_count = $request->product_count / $request->measure;
        $recipe_product->recipe_id = $id;
        $recipe_product->product_id = $request->product_id;
        $recipe_product->product_count = $calculated_count;
        $recipe_product->ip = $request->ip();

        Auth::user()->recipeProducts()->save($recipe_product);

        return redirect('recipes/' . $id . '/edit');

    }

    /**
     * Show form for editing recipe product
     * @param $recipe_id
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @internal param $recipeID
     */
    public function editRecipeProduct($recipe_id, $id) {
        $title = trans('recipes.edit');

        $product = DB::table('recipe_products as rp')
            ->join('products as p', 'rp.product_id', '=', 'p.id')
            ->select(
                'p.name',
                'rp.recipe_id',
                'rp.product_id',
                'rp.product_count'
            )
            ->where('rp.id', '=', $id)
            ->first();

        $measures = Measures::all();

        return view('recipes.editRecipeProduct', compact('title', 'product', 'id', 'recipe_id','measures'));
    }

    /**
     * Update recipe product
     * @param RecipeProductsRequest $request
     * @param $recipe_id
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function updateRecipeProduct(RecipeProductsRequest $request, $recipe_id, $id) {

        $recipe_product = RecipeProducts::where('id', '=', $id)->first();
        $calculated_count = $request->product_count / $request->measure;

        $recipe_product->product_id = $request->product_id;
        $recipe_product->product_count = $calculated_count;
        $recipe_product->ip = $request->ip();

        Auth::user()->recipeProducts()->save($recipe_product);

        return redirect('recipes/' . $recipe_id . '/edit');

    }

    /**
     * Show form for recipe name
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editRecipeName($id) {

        $title = trans('recipes.edit_recipe_name');

        $recipeName = Recipes::where('id', '=', $id)->first();

        return view('recipes.editName', compact('title','recipeName','id'));

    }

    /**
     * Update recipe name
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function updateRecipeName(Request $request,$id) {

        $input = $request->all();

        $recipe = Recipes::findOrFail($id);

        $recipe->update($input);


        return redirect('recipes/'.$id.'/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        DB::table('recipe_products')
            ->where([
                ['recipe_id', '=', $id],
            ])
            ->delete();

        DB::table('recipes')
            ->where('id', '=', $id)
            ->delete();

        return redirect('/recipes');
    }

    /**
     * @param $recipe_id
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroyRecipeProduct($recipe_id, $id) {
        DB::table('recipe_products')
            ->where('id', '=', $id)
            ->delete();

        return redirect('/recipes/' . $recipe_id . '/edit');
    }

    public function ajaxsearch(Request $request) {
        $input = $request->get('term');
        // dd($request);
        $products = DB::table('delivery_products as dp')
            ->join('products as p', 'dp.product_id', '=', 'p.id')
            ->where('name', 'like', '%' . $input . '%')
            ->where('dp.count_left', '!=', 0)
            ->select('dp.product_id', 'p.name', 'dp.count_left')
            ->groupBy('dp.product_id')
            ->get();

        foreach ($products as $product) {
            $data[] = ['id' => $product->product_id, 'value' => $product->name, 'count' => $product->count_left];
        }
        return Response::json($data);
    }
}
