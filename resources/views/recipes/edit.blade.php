@extends('layouts.app')

@section('content')
    <div class="container">
        <table class="centered responsive-table striped">
            <thead>
            <tr>
                <th data-field="name">{!! trans('recipes.product') !!}</th>
                <th data-field="price">{!! trans('recipes.count') !!}</th>
                <th data-field="count">{!! trans('recipes.delivery_price') !!}</th>
                <th data-field="total">{!! trans('recipes.price') !!}</th>
                <th data-field="delete">{!! trans('recipes.options') !!}</th>
            </tr>
            </thead>
            <tbody>
            @if(!empty($products))
                @foreach($products as $product)
                    <tr>
                        <?php
                        $recipe_total += $product->product_total;
                        ?>
                        <td>{!! $product->name !!}</td>
                        <td>{!! $product->product_count !!}</td>
                        <td>{!! $product->product_price !!}</td>
                        <td>{!! number_format($product->product_total, 2) !!}</td>
                        {{--<td>{!! $product->product_price !!}</td>--}}
                        <td>{!! Form::open(['method' => 'DELETE','url' => 'recipes/'.$product->recipe_id.'/'.$product->recipe_product_id]) !!}
                            <button onclick="return confirm('{!! trans('recipes.confirm_recipe_delete') !!}');"
                                    type="submit" class="btn-flat right secondary-content">
                                <i class="material-icons">delete</i>
                            </button>
                            {!! Form::close() !!}
                            <a class="btn-flat right"
                               href="{!! url('/recipes/'.$product->recipe_id.'/'.$product->recipe_product_id.'/editRecipeProduct') !!}">
                                <i class="material-icons">mode_edit</i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
    <div class="container">
        <div class="row">
            <div class="col s12 m12 l2 right">
                <blockquote class="grey lighten-3">
                    <h6>{!! trans('recipes.total_recipe_amount') !!}</h6>
                    <h5>{!! number_format($recipe_total,2) !!}{!! trans('recipes.price_sign') !!}</h5>
                </blockquote>
            </div>
        </div>
    </div>
    <div class="row">
        @if(isset($product))
            <div class="center">
                {!! $products->links() !!}
            </div>
        @endif
        <div class="row valign">
            <h3 class="center-align">{!! trans('recipes.edit').$recipe->name !!}
                <a class="btn-flat"
                   href="{!! url('/recipes/'.$id.'/editRecipeName') !!}">
                    <i class="material-icons">mode_edit</i>
                </a>
            </h3>
            {!! Form::open(array('url' => '/recipes/'.$id, 'method' => 'PATCH' ,'class' => 'col s12')) !!}

            @include('recipes.form', ['buttonEdit' => trans('recipes.add')])

            {!! Form::close() !!}
        </div>
    </div>
@endsection()