@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row valign">
            <h4 class="center-align">{!! trans('measures.create') !!}</h4>
            {!! Form::open(array('method' => 'POST' ,'url' => 'measures' ,'class' => 'col s12')) !!}

            @include('measures.form' ,['saveButtonText' => trans('measures.save_measure')])

            {!! Form::close() !!}
        </div>
    </div>

@endsection