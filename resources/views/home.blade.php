@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col s12 m12 l12 z-depth-1">
            <p class="center">Hello {!! Auth::user()->name !!}</p>
        </div>
        <hr>

    </div>
</div>
@endsection
