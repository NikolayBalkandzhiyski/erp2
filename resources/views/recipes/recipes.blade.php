@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row valign-wrapper">
            <table class="bordered centered responsive-table highlight">
                <thead>
                <tr>
                    <th data-field="id">{!! trans('recipes.recipe') !!}</th>
                    <th data-field="id">{!! trans('recipes.recipe_name') !!}</th>
                    <th data-field="name">{!! trans('recipes.recipes_products_count') !!}</th>
                    <th data-field="date">{!! trans('recipes.created_at') !!}</th>
                    <th data-field="date">{!! trans('recipes.username') !!}</th>
                    <th data-field="options">{!! trans('recipes.options') !!}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($recipes as $recipe)
                    <tr>
                        <td>{!! $recipe->id !!}</td>
                        <td>{!! $recipe->name !!}</td>
                        <td>{!! $recipe->product_count !!}</td>
                        <td>{!! $recipe->created_at!!}</td>
                        <td>{!! $recipe->username!!}</td>
                        <td>
                            {!! Form::open(['class' => 'right','method' => 'DELETE','url' => 'recipes/'.$recipe->id]) !!}
                            <button onclick="return confirm('{!! trans('recipes.confirm_recipe_delete') !!}');" type="submit" class="btn-flat right secondary-content">
                                <i class="material-icons">delete</i></button>
                            {!! Form::close() !!}
                            <a class="btn-flat right" href="{!! url('/recipes/'.$recipe->id).'/edit' !!}">
                                <i class="material-icons">mode_edit</i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="center">
            {!! $recipes->links() !!}
        </div>
    </div>
@endsection