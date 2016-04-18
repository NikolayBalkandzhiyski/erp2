@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row valign">
            <h4 class="center-align">{!! trans('measures.edit') !!}</h4>
            {!! Form::model($measure, ['method' => 'PATCH' ,'url' => 'measures/'.$measure->id ,'class' => 'col s12']) !!}

            @include('measures.form', ['saveButtonText' => trans('measures.update_measure')])

            {!! Form::close() !!}
        </div>
    </div>

@endsection