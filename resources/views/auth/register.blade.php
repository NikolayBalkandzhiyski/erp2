@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

            <h3 class="center">{!! trans('basic.register') !!}</h3>

            <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                {!! csrf_field() !!}

                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <div class="col s12 m12 l6 offset-l3 input-field">
                        <input type="text" class="validate" name="name" value="{{ old('name') }}">
                        <label class="col-md-4 control-label">{!! trans('basic.name') !!}</label>

                        @if ($errors->has('name'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">

                    <div class="col s12 m12 l6 offset-l3 input-field">
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                        <label class="col-md-4 control-label">{!! trans('basic.email') !!}</label>
                        @if ($errors->has('email'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">

                    <div class="col s12 m12 l6 offset-l3 input-field">
                        <input type="password" class="form-control" name="password">
                        <label class="col-md-4 control-label">{!! trans('basic.password') !!}</label>
                        @if ($errors->has('password'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">

                    <div class="col s12 m12 l6 offset-l3 input-field">
                        <input type="password" class="form-control" name="password_confirmation">
                        <label class="col-md-4 control-label">{!! trans('basic.confirm_password') !!}</label>
                        @if ($errors->has('password_confirmation'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>
                <div class="col offset-l5 offset-m4 offset-s3">
                    <div class="center">
                        <button type="submit" class="btn">
                            <i class="fa fa-btn fa-user"></i>{!! trans('basic.register') !!}
                        </button>
                    </div>
                </div>
            </form>


        </div>
    </div>
@endsection
