<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{!! $subject !!}</title>
</head>
<body>
@foreach($deliveries as $delivery)
    <table style="border-collapse: collapse;">
        <thead style="width:550px">
        <tr style="border: 1px solid black;">
            <th colspan="2" style="border: 1px solid black;">{!! trans('reports.date_created') !!} {!! $delivery->created_at !!}</th>
            <th colspan="2" style="border: 1px solid black;">{!! trans('reports.total') !!} {!! number_format($delivery->delivery_total,2) !!}{!! trans('reports.price_sign') !!}</th>
        </tr>
        </thead>
        <tbody>
        <tr style="background: #dadada;">
            <td style="border: 1px solid black;">{!! trans('reports.product_name') !!}</td>
            <td style="border: 1px solid black;">{!! trans('reports.price') !!}</td>
            <td style="border: 1px solid black;">{!! trans('reports.count_delivered') !!}</td>
            <td style="border: 1px solid black;">{!! trans('reports.count_left') !!}</td>
        </tr>
        @if($delivery->products)
        @foreach($delivery->products as $product)
            <tr>
                <td style="border: 1px solid black;">{!! $product['name'] !!}</td>
                <td style="border: 1px solid black;">{!! number_format($product['product_price'], 2) !!}{!! trans('reports.price_sign') !!}</td>
                <td style="border: 1px solid black;">{!! number_format($product['delivery_product_count'], 9) !!}{!! trans('reports.kg_sign') !!}</td>
                <td style="border: 1px solid black;">{!! number_format($product['delivery_count_left'], 9) !!}{!! trans('reports.kg_sign') !!}
                </td>
            </tr>
        @endforeach
        @else
            <tr>
                <td style="border: 1px solid black;">{!! $delivery['name'] !!}</td>
                <td style="border: 1px solid black;">{!! number_format($delivery['product_price'], 2) !!}{!! trans('reports.price_sign') !!}</td>
                <td style="border: 1px solid black;">{!! number_format($delivery['delivery_product_count'], 9) !!}{!! trans('reports.kg_sign') !!}</td>
                <td style="border: 1px solid black;">{!! number_format($delivery['delivery_count_left'], 9) !!}{!! trans('reports.kg_sign') !!}
                </td>
            </tr>
        @endif
        </tbody>
    </table>
    </br>
    <div style="height: 30px;"></div>
@endforeach
</body>
</html>