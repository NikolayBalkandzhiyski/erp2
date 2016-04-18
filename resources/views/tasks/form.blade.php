<div class="row">
    <div class="input-field col s12 m12 l2  offset-l3">
        {!! Form::number('count',null,['class' => 'validate','id' => 'count','autocomplete' => 'off','autofocus']) !!}
        {!! Form::label('count', trans('tasks.count')) !!}
        @if($errors->has('count'))
            <span class="red">{!! $errors->first('count') !!}</span>
        @endif
    </div>
    <div class="input-field col s12 m12 l4">
        {!! Form::text('recipe',null,['class' => 'validate','id' => 'recipe','autocomplete' => 'off']) !!}
        {!! Form::hidden('recipe_id',null,['id' => 'recipe_id']) !!}
        @if($errors->has('recipe_id'))
            <span class="red">{!! $errors->first('recipe_id') !!}</span>
        @endif
        {!! Form::label('recipe', trans('tasks.recipe')) !!}
        @if($errors->has('recipe'))
            <span class="red">{!! $errors->first('recipe') !!}</span>
        @endif
    </div>
</div>
<div class="row center">
    <button class="btn waves-effect waves-light" type="submit" name="action">{!! $buttonEdit !!}
        <i class="material-icons right">send</i>
    </button>
</div>
<hr>
@if($errors->messages())
    @foreach($errors->messages() as $message)
        @foreach($message as $msg)
            <span class="red">{!! $msg.'<br>' !!}</span>
        @endforeach
    @endforeach
@endif
<table class="centered bordered hilight striped" id="records_table">
    <thead>
    <tr>
        <th data-field="product">{!! trans('tasks.product') !!}</th>
        <th data-field="recipe_name">{!! trans('tasks.recipe_count') !!}</th>
        <th data-field="delivery_count">{!! trans('tasks.task_recipe_product_count') !!}</th>
        <th data-field="delivery_count">{!! trans('tasks.delivery_count') !!}</th>
    </tr>
    </thead>
    <tbody>

    </tbody>
</table>

<script>

    $("#recipe").autocomplete({
        source: "{{ url('tasks/ajaxsearch') }}",
        minLength: 3,
        select: function (event, ui) {
            $('#recipe_id').val(ui.item.recipe_id);
            $('table').show();
            $('tbody > tr').remove();

            var trHTML = '';
            var count = $('#count').val();


            if (!count) {
                alert('Моля изберете кол-во');
                $('#count').focus();
                exit();
            }

            if (count <= 0) {
                alert('Моля изберете кол-во по-голямо от 0');
                $('#count').focus();
                exit();
            }

            $.each(ui.item.recipe_products, function (i, item) {
                var low_count = '';
                var low_calculated_count = '';
                var calculated_count = Number(item.recipe_product_count * count);

                if (item.delivery_count_left <= 0 || item.recipe_product_count >= item.delivery_count_left) {
                    low_count = 'red  accent-4';
                }


                if(Number(calculated_count) > Number(item.delivery_count_left)){
                    low_calculated_count = 'red';
                }

                trHTML += '<tr><td>' + item.product_name + '</td>' +
                        '<td>'+ item.recipe_product_count + '</td>' +
                        '<td class="' + low_calculated_count + '">'+ calculated_count +'</td>' +
                        '<td class="' + low_count + '">'
                        + item.delivery_count_left + '</td>' +
                        '<input type="hidden" name="product[' + item.product_id + '][delivery_count_left]" value="' + item.delivery_count_left + '" />' +
                        '<input type="hidden" name="product[' + item.product_id + '][id]" value="' + item.product_id + '" />' +
                        '<input type="hidden" name="product[' + item.product_id + '][product_name]" value="' + item.product_name + '" />' +
                        '<input type="hidden" name="product[' + item.product_id + '][recipe_product_count]" value="' + item.recipe_product_count + '" />' +
                        '<input type="hidden" name="product[' + item.product_id + '][task_recipe_product_count]" value="' + calculated_count + '" /></tr>';


            });
            $('#records_table').append(trHTML);
        }
    });
    $('#count').change(function () {
        $('#recipe').val('');
        $('#recipe_id').val('');
        $('tbody > tr').remove();
    });

</script>