@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row valign">
            <h3 class="center-align">{!! trans('product.product_edit') !!}</h3>
            {!! Form::model($product,array('method' => 'PATCH' ,'url' => 'products/'.$product->id ,'class' => 'col s12')) !!}

              @include('products.form')

            {!! Form::close() !!}
        </div>
    </div>
@endsection