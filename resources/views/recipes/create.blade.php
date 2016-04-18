@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row valign">
            <h3 class="center-align">{!! trans('recipes.create') !!}</h3>
            {!! Form::open(array('url' => '/recipes', 'method' => 'POST' ,'class' => 'col s12')) !!}

            <div class="row">
                <div class="input-field col s12 m12 l4 offset-l4">
                    {!! Form::text('name',null,['class' => 'validate','id' => 'name','autocomplete' => 'off','autofocus']) !!}
                    {!! Form::hidden('product_id',null,['id' => 'product_id']) !!}
                    {!! Form::label('name', trans('product.name')) !!}
                    @if($errors->has('name'))
                        <span class="red">{!! $errors->first('name') !!}</span>
                    @endif
                </div>
            </div>
            <div class="row center">
                <button class="btn waves-effect waves-light" type="submit" name="action">{!! trans('recipes.save') !!}
                    <i class="material-icons right">send</i>
                </button>
            </div>

            {!! Form::close() !!}
        </div>
    </div>
@endsection()