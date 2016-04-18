<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{!! $subject !!}</title>
</head>
<body>
<table style="border-collapse: collapse;">
    <thead>
    <tr style="border: 1px solid black; background: #dadada;">
        <th style="border: 1px solid black;">{!! trans('reports.product_name') !!}</th>
        <th style="border: 1px solid black;">{!! trans('reports.price') !!}</th>
        <th style="border: 1px solid black;">{!! trans('reports.count_delivered') !!}</th>
        <th style="border: 1px solid black;">{!! trans('reports.count_left') !!}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($products as $product)
        <tr style="border: 1px solid black;">
            <td style="border: 1px solid black;">{!! $product['name'] !!}</td>
            <td style="border: 1px solid black;">{!! number_format($product['product_price'], 2) !!}{!! trans('reports.price_sign') !!}</td>
            <td style="border: 1px solid black;">{!! number_format($product['delivery_product_count'], 9) !!}{!! trans('reports.kg_sign') !!}</td>
            <td style="border: 1px solid black;
            @if($product['delivery_count_left'] <= $minimum)
                    background: #ff0000;
            @endif">
                {!! number_format($product['delivery_count_left'], 9) !!}{!! trans('reports.kg_sign') !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
