@extends('layouts.app')

@section('content')

    <div class="container">
        {!! Form::open(['url' => url('reports/products/search'),'class' => 'z-depth-1','method' => 'GET']) !!}
        <div class="row">
            <h4 class="center">{!! trans('reports.products_report') !!}</h4>
            {{-- Input for name --}}
            <div class="input-field col s12 m12 l4 offset-l4">
                {!! Form::text('name',null,['class' => 'name','id' => 'name','autofocus']) !!}
                {!! Form::label('name',trans('reports.products_name')) !!}
                {!! Form::hidden('product_id',null,['id' => 'product_id']) !!}
                {{-- Show errors for name --}}
                @if($errors->has('name'))
                    <span class="red">{!! $errors->first('name') !!}</span>
                @endif
            </div>
            <div class="input-field col s12 m12 l4 offset-l4">
                {!! Form::text('delivery_count_left',null,['class' => 'delivery_count_left','id' => 'delivery_count_left']) !!}
                {!! Form::label('name',trans('reports.count_left_less_than')) !!}
                {{-- Show errors for name --}}
                @if($errors->has('delivery_count_left'))
                    <span class="red">{!! $errors->first('delivery_count_left') !!}</span>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="center">
                {!! Form::submit(trans('reports.search'),['class' => 'btn center']) !!}
            </div>
        </div>

        {!! Form::close() !!}
    </div>

    @if(isset($products))
        <div id="export" class="fixed-action-btn horizontal click-to-toggle" style="bottom: 10px; right: 24px;">
            <a class="btn-floating btn-large red">
                <i class="large material-icons">get_app</i>
            </a>
            <ul>
                <li>
                    <a class="btn-floating green center" href="{!! url('/reports/products/export') !!}">
                        {!! trans('reports.export_xls') !!}
                    </a>
                </li>
                <li>
                    <a class="btn-floating blue center" href="{!! url('/reports/products/mailProducts') !!}"><i class="material-icons">email</i>
                    </a>
                </li>
            </ul>
        </div>
        <div class="container">
            <table class="centered bordered striped responsive-table">
                <thead>
                <tr>
                    <th data-field="name">{!! trans('reports.product_name') !!}</th>
                    <th data-field="price">{!! trans('reports.price') !!}</th>
                    <th data-field="delivered_count">{!! trans('reports.count_delivered') !!}</th>
                    <th data-field="count_left">{!! trans('reports.count_left') !!}</th>
                </tr>
                </thead>

                <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{!! $product->name !!}</td>
                        <td>{!! number_format($product->product_price,2) !!}{!! trans('reports.price_sign') !!}</td>
                        <td>{!! number_format($product->delivery_product_count,9) !!}{!! trans('reports.kg_sign') !!}</td>
                        {{-- Alert if product count is less than $minimum --}}
                        <td @if($product->delivery_count_left < $minimum) class="red" @endif>{!! number_format($product->delivery_count_left,9) !!}{!! trans('reports.kg_sign') !!}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <script>
        $("#name").autocomplete({
            source: "{{ url('deliveries/ajaxsearch') }}",
            minLength: 3,
            select: function (event, ui) {
                $('#name').val(ui.item.id);
                $('#product_id').val(ui.item.id);
            }
        });
    </script>
@endsection