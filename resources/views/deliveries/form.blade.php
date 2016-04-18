<div class="row">
    <div class="input-field col s12 m12 l3 offset-l4">
        {!! Form::text('name',null,['class' => 'validate','id' => 'name','autocomplete' => 'off','autofocus']) !!}
        {!! Form::hidden('product_id',null,['id' => 'product_id']) !!}
        @if($errors->has('product_id'))
            <span class="red">{!! $errors->first('product_id') !!}</span>
        @endif
        {!! Form::label('name', trans('product.name')) !!}
        @if($errors->has('name'))
            <span class="red">{!! $errors->first('name') !!}</span>
        @endif
    </div>

    <div class="input-field col s12 m12 l1">
        {!! Form::text('product_price',null,['class' => 'validate','id' => 'product_price','autocomplete' => 'off']) !!}
        {!! Form::label('product_price', trans('delivery.price')) !!}
        @if($errors->has('product_price'))
            <span class="red">{!! $errors->first('product_price') !!}</span>
        @endif
    </div>
</div>
<div class="row">
    <div class="input-field col s12 m12 l2 offset-l4">
        {!! Form::text('product_count',null,['class' => 'validate','id' => 'product_count','autocomplete' => 'off']) !!}
        {!! Form::label('product_count', trans('delivery.count')) !!}
        @if($errors->has('product_count'))
            <span class="red">{!! $errors->first('product_count') !!}</span>
        @endif
    </div>

    <div class="input-field col s12 m12 l2">
        <select name="measure">
            <option selected disabled>{!! trans('delivery.choose_measure') !!}</option>
            @foreach($measures as $measure)
                <option value="{!! $measure->multiplier !!}">{!! $measure->name !!}</option>
            @endforeach
        </select>
        <label>{!! trans('delivery.measure') !!}</label>
        @if($errors->has('measure'))
            <span class="red">{!! $errors->first('measure') !!}</span>
        @endif
    </div>


</div>
<div class="row center">
    <button class="btn waves-effect waves-light" type="submit" name="action">{!! $buttonEdit !!}
        <i class="material-icons right">send</i>
    </button>
</div>
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