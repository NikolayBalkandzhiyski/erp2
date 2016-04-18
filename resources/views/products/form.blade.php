<div class="row">
    <div class="input-field col s12 m12 l4 offset-l4">
        {!! Form::text('name',null,['class' => 'validate','autofocus']) !!}
        {!! Form::label('name', trans('product.name')) !!}
        @if($errors->has('name'))
            <span class="red">{!! $errors->first('name') !!}</span>
        @endif
    </div>
    <div class="input-field col">
        @if($errors->has('measure_id'))
            <span class="red">{!! $errors->first('measure_id') !!}</span>
        @endif
    </div>
</div>
<div class="row center">
    <button class="btn waves-effect waves-light" type="submit" name="action">{!! trans('product.save') !!}
        <i class="material-icons right">send</i>
    </button>
</div>