@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

            <h3 class="center">{!! trans('basic.login') !!}</h3>

            <div class="row">
                {!! Form::open(array('class' => '')) !!}

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
            </div>
            <div class="row">
                    <div class="center">
                        <div class="switch">
                            <label>{!! trans('basic.remember_me') !!}<br>
                                Off
                                <input type="checkbox" name="remember">
                                <span class="lever"></span>
                                On
                            </label>
                        </div>
                    </div>
                <br>
                <div class="center">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn waves-effect">
                            <i class="fa fa-btn fa-sign-in"></i>{!! trans('basic.login') !!}
                        </button>

                        <a class="btn waves-effect"
                           href="{{ url('/password/reset') }}">{!! trans('basic.forgotten_password') !!}</a>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>

        </div>
    </div>
@endsection
