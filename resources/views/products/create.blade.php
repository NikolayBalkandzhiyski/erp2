@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row valign">
            <h2 class="center-align">{!! trans('product.create') !!}</h2>
            {!! Form::open(array('method' => 'POST' ,'url' => 'products' ,'class' => 'col s12')) !!}

                 @include('products.form')

            {!! Form::close() !!}
        </div>
    </div>
@endsection