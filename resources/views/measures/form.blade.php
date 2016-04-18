<div class="row">
    <div class="input-field col s12 m12 l4 offset-l3">
        {!! Form::label('name', trans('measures.name')) !!}
        {!! Form::text('name', null, ['class' => 'validate','autofocus']) !!}

        @if($errors->has('name'))
            <span class="red">{!! $errors->first('name') !!}</span>
        @endif
    </div>
    <div class="input-field col s12 m12 l2">
        {!! Form::label('name', trans('measures.divisor')) !!}
        {!! Form::text('multiplier', null, ['class' => 'validate']) !!}
        @if($errors->has('multiplier'))
            <span class="red">{!! $errors->first('multiplier') !!}</span>
        @endif
    </div>
</div>
<div class="row center">
    <button class="btn waves-effect waves-light" type="submit" name="action">{!! $saveButtonText !!}
        <i class="material-icons right">send</i>
    </button>
</div>