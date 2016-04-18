<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('/');
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //
});

Route::group(['middleware' => 'web'], function () {
    Route::auth();

    Route::get('/', 'HomeController@index');

    Route::get('/deliveries/ajaxsearch', 'Deliveries\DeliveriesController@ajaxsearch');

    Route::get('/recipes/ajaxsearch', 'Recipes\RecipesController@ajaxsearch');

    Route::get('/tasks/ajaxsearch','Tasks\TasksController@ajaxsearch');

    Route::resource('/measures', 'Measures\MeasuresController');

    Route::resource('/products','Products\ProductsController');

    Route::resource('/deliveries', 'Deliveries\DeliveriesController');

    Route::get('/deliveries/{id}/{product_id}/{delivery_products_id}/editProduct', 'Deliveries\DeliveriesController@editProduct');

    Route::patch('/deliveries/{delivery_id}/{product_id}/{id}/updateProduct', 'Deliveries\DeliveriesController@updateProduct');

    Route::delete('/deliveries/{id}/{product_id}/{delivery_product_id}/destroyDeliveryProduct','Deliveries\DeliveriesController@destroyDeliveryProduct');

    Route::resource('/recipes','Recipes\RecipesController');

    Route::get('/recipes/{recipe_id}/{id}/editRecipeProduct', 'Recipes\RecipesController@editRecipeProduct');

    Route::patch('/recipes/{recipe_id}/{id}/updateRecipeProduct', 'Recipes\RecipesController@updateRecipeProduct');

    Route::delete('/recipes/{recipe_id}/{id}', 'Recipes\RecipesController@destroyRecipeProduct');

    Route::get('/recipes/{id}/editRecipeName', 'Recipes\RecipesController@editRecipeName');

    Route::patch('/recipes/{id}/updateRecipeName', 'Recipes\RecipesController@updateRecipeName');

    Route::resource('/tasks', 'Tasks\TasksController');

    Route::delete('/tasks/{task_id}/{id}/destroyTaskRecipe','Tasks\TasksController@destroyTaskRecipe');

    Route::get('/reports/deliveries','Reports\ReportsController@deliveriesReport');

    Route::get('/reports/deliveries/search', 'Reports\ReportsController@deliveriesSearch');

    Route::get('/reports/deliveries/export', 'Reports\ReportsController@deliveriesExport');

    Route::get('/reports/products', 'Reports\ReportsController@productsReport');

    Route::get('/reports/products/search', 'Reports\ReportsController@productsSearch');

    Route::get('/reports/products/export', 'Reports\ReportsController@productsExport');

    Route::get('/reports/products/mailProducts', 'Reports\ReportsController@productsEmail');

    Route::get('/reports/deliveries/mailDeliveries', 'Reports\ReportsController@deliveriesEmail');
});

