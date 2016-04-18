@extends('layouts.app')

@section('content')

    <div class="container z-depth-1" style="min-height: 200px;">
        <h4 class="center">{!! trans('reports.report_deliveries') !!}</h4>

        {!! Form::open(['url' => url('reports/deliveries/search'),'method' => 'GET']) !!}
        <div class="row">
            {{-- Datepicker date_from --}}
            <div class="col s12 m12 l3 offset-l3">
                {!! Form::date('date_from',null,['class' => 'datepicker report_dates','id' => 'date_from','placeholder' => trans('reports.date_from')]) !!}
                @if($errors->has('date_from'))
                    <span class="red">{!! $errors->first('date_from') !!}</span>
                @endif
            </div>

            {{-- Datepicker date_to --}}
            <div class="col s12 m12 l3">
                {!! Form::date('date_to',null,['class' => 'datepicker report_dates','id' => 'date_to','placeholder' => trans('reports.date_to')]) !!}
                @if($errors->has('date_to'))
                    <span class="red">{!! $errors->first('date_to') !!}</span>
                @endif
            </div>

        </div>
        <div class="row">
        {{-- Input for name --}}
        <div class="input-field col s12 m12 l4 offset-l4">
            {!! Form::text('name',null,['class' => '','id' => 'name']) !!}
            {!! Form::label('name','Name:') !!}
            {{-- Show errors for name --}}
            @if($errors->has('name'))
                <span class="red">{!! $errors->first('name') !!}</span>
            @endif
        </div>
        </div>
        <div class="row">
            <div class="center">
                {!! Form::submit(trans('reports.search'),['class' => 'btn']) !!}
            </div>
        </div>
        {!! Form::close() !!}
    </div>

    @if(isset($deliveries))
        <div id="export" class="fixed-action-btn horizontal click-to-toggle" style="bottom: 10px; right: 24px;">
            <a class="btn-floating btn-large red">
                <i class="large material-icons">get_app</i>
            </a>
            <ul>
                <li>
                    <a class="btn-floating green center" href="{!! url('/reports/deliveries/export') !!}">
                        {!! trans('reports.export_xls') !!}
                    </a>
                </li>
                <li>
                    <a class="btn-floating blue center" href="{!! url('/reports/deliveries/mailDeliveries') !!}">
                        <i class="material-icons">email</i>
                    </a>
                </li>
            </ul>
        </div>
        <div class="container">

            <ul class="collapsible popout" data-collapsible="accordion">
                @foreach($deliveries as $delivery)
                    <li class="li">
                        <div class="collapsible-header blue-grey lighten-5">
                            <i class="material-icons">import_export</i>
                            <span class=""><strong>{!! trans('reports.date_created') !!}</strong> {!! $delivery->created_at !!}</span>
                            <span class="right"><strong>{!! trans('reports.total') !!}</strong> {!! $delivery->delivery_total !!}{!! trans('reports.price_sign') !!}</span>
                        </div>
                        <div class="collapsible-body">
                            <table class="centered striped">
                                <thead>
                                <tr>
                                    <th data-field="id">{!! trans('reports.product_name') !!}</th>
                                    <th data-field="product_price">{!! trans('reports.product_price') !!}</th>
                                    <th data-field="name">{!! trans('reports.count_delivered') !!}</th>
                                    <th data-field="price">{!! trans('reports.count_left') !!}</th>
                                </tr>
                                </thead>

                                <tbody>
                                @if(isset($delivery->products))
                                    @foreach($delivery->products as $product)
                                        <tr>
                                            <td>{!! $product->name !!}</td>
                                            <td>{!! number_format($product->product_price,2) !!}{!! trans('reports.price_sign') !!}</td>
                                            <td>{!! number_format($product->delivery_product_count,9) !!}{!! trans('reports.kg_sign') !!}</td>
                                            <td>{!! number_format($product->delivery_count_left,9) !!}{!! trans('reports.kg_sign') !!}</td>
                                        </tr>
                                    @endforeach
                                 @else
                                    <tr>
                                        <td>{!! $delivery->name !!}</td>
                                        <td>{!! number_format($delivery->product_price,2) !!}{!! trans('reports.price_sign') !!}</td>
                                        <td>{!! number_format($delivery->delivery_product_count,9) !!}{!! trans('reports.kg_sign') !!}</td>
                                        <td>{!! number_format($delivery->delivery_count_left,9) !!}{!! trans('reports.kg_sign') !!}</td>
                                    </tr>
                                 @endif
                                </tbody>
                            </table>
                        </div>
                    </li>
                @endforeach
            </ul>

        </div>
    @endif
@endsection