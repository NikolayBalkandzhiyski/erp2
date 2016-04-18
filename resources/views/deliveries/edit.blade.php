@extends('layouts.app')

@section('content')
    <div class="container">
        @if(isset($products))
            <table class="centered striped">
                <thead>
                <tr>
                    <th data-field="name">{!! trans('delivery.product') !!}</th>
                    <th data-field="price">{!! trans('delivery.count') !!}</th>
                    <th data-field="count">{!! trans('delivery.price') !!}</th>
                    <th data-field="delete">{!! trans('delivery.options') !!}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{!! $product->name !!}</td>
                        <td>{!! $product->product_count !!}</td>
                        <td>{!! $product->product_price !!}</td>
                        <td>
                            @if(Auth::check() && in_array(Auth::user()->id,session('admins')))
                                {!! Form::open(['method' => 'DELETE','url' => 'deliveries/'.$id.'/'.$product->id.'/'.$product->delivery_product_id.'/destroyDeliveryProduct']) !!}
                                <button onclick="return confirm('{!! trans('delivery.confirm_product_delete') !!}');"
                                        type="submit" class="btn-flat right secondary-content">
                                    <i class="material-icons">delete</i>
                                </button>
                                {!! Form::close() !!}

                                <a class="btn-flat right"
                                   href="{!! url('/deliveries/'.$id.'/'.$product->id.'/'.$product->delivery_product_id.'/editProduct') !!}">
                                    <i class="material-icons">mode_edit</i>
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
    </div>
    <div class="container">
        <div class="row">
            <div class="col s12 m12 l2 right">
                <blockquote class="grey lighten-3">
                    <h6>{!! trans('delivery.total_delivery_amount') !!}</h6>
                    <h5>{!! number_format($delivery_total, 2) !!}{!! trans('delivery.price_sign') !!}</h5>
                </blockquote>
            </div>
        </div>
    </div>
    <div class="center">
        {!! $products->links() !!}
    </div>
    @endif
    @if(Auth::check() && in_array(Auth::user()->id,session('admins')))
        <div class="row valign">
            <h4 class="center-align">{!! trans('delivery.create') !!}</h4>
            {!! Form::open(array('url' => '/deliveries/'.$id, 'method' => 'PATCH' ,'class' => 'col s12')) !!}

            @include('deliveries.form' ,['buttonEdit' => trans('delivery.add')])

            {!! Form::close() !!}

        </div>
        @endif

@endsection