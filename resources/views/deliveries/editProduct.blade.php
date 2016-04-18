@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row valign">
            <h4 class="center-align">{!! trans('delivery.edit_product') !!}</h4>
            {!! Form::model($product,['url' => '/deliveries/'.$delivery_id.'/'.$product->product_id.'/'.$id.'/updateProduct', 'method' => 'PATCH' ,'class' => 'col s12']) !!}

                @include('deliveries.form', ['buttonEdit' => trans('delivery.save')])

            {!! Form::close() !!}

        </div>
    </div>

@endsection