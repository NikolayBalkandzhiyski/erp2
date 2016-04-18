@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row valign">
            <h4 class="center-align">{!! trans('delivery.create') !!}</h4>
            {!! Form::open(array('url' => '/deliveries', 'method' => 'POST' ,'class' => 'col s12')) !!}

                 @include('deliveries.form',['buttonEdit' => trans('delivery.save')])

            {!! Form::close() !!}
        </div>
    </div>
@endsection