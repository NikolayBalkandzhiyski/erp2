@extends('layouts.app')

@section('content')
    <div class="row">
        <ul class="collection with-header col s12 m12 l6 offset-l3">
            <h5>{!! trans('measures.name') !!}<span class="right">{!! trans('measures.divisor') !!}</span></h5>
            <hr>
            @foreach($measures as $measure)
                {!! Form::open(['method' => 'DELETE','url' => 'measures/'.$measure->id]) !!}
                <button onclick="return confirm('{!! trans('measures.delete') !!}');" type="submit" class="btn-flat right secondary-content"><i class="material-icons">delete</i></button>
                {!! Form::close() !!}
                <a href="{!! url('/measures/'.$measure['id']).'/edit' !!}" class="collection-item">{!! $measure['name'] !!}
                    <span class="right">{!! $measure['multiplier'] !!}</span></a>
            @endforeach

            <div class="cetner">
                {!! $measures->links() !!}
            </div>
        </ul>
    </div>

@endsection()