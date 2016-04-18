@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row valign">
            <h3 class="center-align">{!! trans('recipes.edit_product') !!}</h3>
            {!! Form::model($product,array('url' => '/recipes/'.$recipe_id.'/'.$id.'/updateRecipeProduct', 'method' => 'PATCH' ,'class' => 'col s12')) !!}

                @include('recipes.form', ['buttonEdit' => trans('recipes.add')])

            {!! Form::close() !!}
        </div>
    </div>
@endsection()