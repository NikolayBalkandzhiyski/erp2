<?php

namespace App\Http\Controllers\Tasks;

use App\DeliveryProducts;
use App\Http\Requests\TasksRequest;
use App\RecipeProducts;
use App\TaskRecipes;
use App\Tasks;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class TasksController extends Controller
{
    public function __construct() {
        return $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $tasks = DB::table('tasks')
            ->join('users', 'tasks.user_id', '=', 'users.id')
            ->select('tasks.*', 'users.name as username')
            ->get();

        $title = trans('tasks.tasks');

        return view('tasks.tasks', compact('title', 'tasks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $title = trans('tasks.create');

        return view('tasks.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TasksRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(TasksRequest $request) {

        $task = new Tasks();
        $task->task_date = date('Y-m-d', strtotime($request->task_date));
        $task->ip = $request->ip();

        Auth::user()->tasks()->save($task);

        return redirect('tasks/' . $task->id . '/edit');
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
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {

        $task = Tasks::where('id', '=', $id)->first();

        $task_date = $task->task_date;

        $title = trans('tasks.edit');

        $task_recipes = TaskRecipes::where('task_id', '=', $id)
            ->join('recipes', 'task_recipes.recipe_id', '=', 'recipes.id')
            ->select(
                'recipes.name',
                'task_recipes.id',
                'task_recipes.recipe_id',
                'task_recipes.recipe_count'
            )
            ->get();

        return view('tasks.edit', compact('title', 'id', 'task_date', 'task_recipes'));
    }

    /**
     * Update the specified resource in storage.
     *Validate fields and counts
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {

        $validator = Validator::make($request->all(), [
            'count'     => 'required|numeric|min:0',
            'recipe_id' => 'required|numeric'
        ]);

        $validator->after(function ($validator) {

            $products = $validator->getData();

            if (isset($products['product'])) {
                foreach ($products['product'] as $product) {
                    if ($product['task_recipe_product_count'] > $product['delivery_count_left']) {
                        $validator->errors()->add('product.*.product_name',
                            trans('tasks.not_enough_delivery_count') . strtoupper($product['product_name']) . trans('tasks.for') . $products['recipe']);
                    }
                }
            } else {
                $validator->errors()->add('recipe', trans('tasks.product_required'));
            }
        });

        if ($validator->fails()) {
            return redirect('tasks/' . $id . '/edit')
                ->withErrors($validator)
                ->withInput();
        }

        $task_recipe = new TaskRecipes();
        $task_recipe->task_id = $id;
        $task_recipe->recipe_id = $request->recipe_id;
        $task_recipe->recipe_count = $request->count;
        $task_recipe->ip = $request->ip();

        Auth::user()->tasks()->save($task_recipe);

        $products = $request->product;
        foreach ($products as $product) {

            while ($product['task_recipe_product_count'] > 0) {

                $delivery_product = DeliveryProducts::where('count_left', '>', 0)
                    ->where('product_id', '=', $product['id'])
                    ->first();

                if ($product['task_recipe_product_count'] >= $delivery_product->count_left) {
                    $product['task_recipe_product_count'] -= $delivery_product->count_left;
                    $delivery_product->count_left = 0;
                    $delivery_product->save();

                } else {
                    $delivery_product->count_left = $delivery_product->count_left - $product['task_recipe_product_count'];
                    $product['task_recipe_product_count'] = 0;
                    $delivery_product->save();
                }

            }

        }

        return redirect('tasks/' . $id . '/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {

        DB::table('task_recipes')
            ->where([
                ['id','=',$id],
            ])
            ->delete();
        return redirect('tasks/'.$id.'/edit');
    }

    /**
     * Delete recipe from task
     * @param $id
     * @param $task_id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroyTaskRecipe($id,$task_id) {

        $recipe_products = DB::table('task_recipes as tr')
            ->join('recipe_products as rp','tr.recipe_id','=','rp.recipe_id')
            ->select(
               'rp.product_id','rp.product_count','tr.recipe_count'
            )
            ->where('tr.id','=',$task_id)
            ->get();

        foreach($recipe_products as $recipe_product){

            $product = DB::table('delivery_products as dp')
               ->where('dp.product_id','=',$recipe_product->product_id)
               ->first();

            $update_count = ($recipe_product->recipe_count * $recipe_product->product_count);

            $count = ($product->count_left + $update_count);

            DB::table('delivery_products as dp')
                ->where('id','=',$product->id)
                ->update([
                    'dp.count_left' => $count
                ]);

        }

        DB::table('task_recipes')
            ->where([
                ['id','=',$task_id],
            ])
            ->delete();
        return redirect('tasks/'.$id.'/edit');
    }

    public function ajaxsearch() {
        $input = Input::get('term');

        $recipes = DB::table('recipes as r')
            ->join('recipe_products as rp', 'r.id', '=', 'rp.recipe_id')
            ->select(
                'r.id as recipe_id',
                'r.name as recipe_name',
                'rp.product_count as recipe_product_count'
            )
            ->where('r.name', 'like', '%' . $input . '%')
            ->groupBy('rp.recipe_id')
            ->get();


        foreach ($recipes as $recipe) {
            $recipe->products = DB::table('recipe_products as rp')
                ->join('delivery_products as dp', 'rp.product_id', '=', 'dp.product_id')
                ->join('products as p', 'dp.product_id', '=', 'p.id')
                ->select(
                    'rp.product_id as product_id',
                    'rp.product_count as recipe_product_count',
                    DB::raw('SUM(dp.count_left) as delivery_count_left'),
                    'p.name as product_name'
                )
                ->where('rp.recipe_id', '=', $recipe->recipe_id)
                ->groupBy('rp.product_id')
                ->get();
            foreach ($recipe->products as $product) {
                $product->delivery_count_left = number_format($product->delivery_count_left,9);
            }

            $recipe->recipe_product_count = $recipe->recipe_product_count;

            $data[] = [
                'value'                => $recipe->recipe_name,
                'recipe_id'            => $recipe->recipe_id,
                'recipe_products'      => $recipe->products,
                'recipe_product_count' => $recipe->recipe_product_count
            ];

        }

        return Response::json($data);

    }
}
