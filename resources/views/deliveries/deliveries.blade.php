@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row valign-wrapper">
            <table class="bordered centered responsive-table highlight">
                <thead>
                <tr>
                    <th data-field="id">{!! trans('delivery.delivery') !!}</th>
                    <th data-field="name">{!! trans('delivery.delivery_products_count') !!}</th>
                    <th data-field="price">{!! trans('delivery.total') !!}</th>
                    <th data-field="date">{!! trans('delivery.created_at') !!}</th>
                    <th data-field="date">{!! trans('delivery.username') !!}</th>
                    <th data-field="options">{!! trans('delivery.options') !!}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($deliveries as $delivery)
                    <tr>
                        <td>{!! $delivery->delivery_id !!}</td>
                        <td>{!! $delivery->count !!}</td>
                        <td>{!! $delivery->total!!}{!! trans('delivery.price_sign') !!}</td>
                        <td>{!! $delivery->created_at!!}</td>
                        <td>{!! $delivery->username!!}</td>
                        <td>
                            @if(Auth::check() && in_array(Auth::user()->id,session('admins')))
                                {!! Form::open(['class' => 'right','method' => 'DELETE','url' => 'deliveries/'.$delivery->delivery_id]) !!}
                                <button onclick="return confirm('{!! trans('product.delete') !!}');" type="submit"
                                        class="btn-flat right secondary-content">
                                    <i class="material-icons">delete</i></button>
                                {!! Form::close() !!}
                            @endif
                            <a class="btn-flat right" href="{!! url('/deliveries/'.$delivery->delivery_id).'/edit' !!}">
                                <i class="material-icons">mode_edit</i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="center">
            {!! $deliveries->links() !!}
        </div>
    </div>
@endsection