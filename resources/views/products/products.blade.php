@extends('layouts.app')

@section('content')
    <div class="row">
        <ul class="collection with-header col s12 m12 l4 offset-l4">
            <h5>{!! trans('product.name') !!}<span class="right"> {!! trans('product.options') !!}</span></h5>
            <hr>
                @foreach($products as $product)
                    @if(Auth::check() && in_array(Auth::user()->id,session('admins')))
                        {!! Form::open(['method' => 'DELETE','url' => 'products/'.$product->id]) !!}
                            <button onclick="return confirm('{!! trans('product.delete') !!}');" type="submit" class="btn-flat right secondary-content"><i class="material-icons">delete</i></button>
                        {!! Form::close() !!}
                    @endif
                        <a href="
                    @if(Auth::check() && in_array(Auth::user()->id,session('admins')))
                        {!! url('/products/'.$product->id).'/edit' !!}
                    @else{!! '#' !!}
                    @endif"
                       class="collection-item">{!! $product->name !!}
                    </a>
                @endforeach

            <div class="center">
                {!! $products->links() !!}
            </div>
        </ul>
    </div>

@endsection()