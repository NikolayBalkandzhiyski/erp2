@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row valign">
            <h2 class="center-align">{!! trans('tasks.create') !!}</h2>
            {!! Form::open(array('url' => 'tasks', 'method' => 'POST' ,'class' => 'col s12')) !!}

            <div class="row">
                <div class="input-field col s12 m12 l4 offset-l4">
                    {!! Form::text('task_date',null,['class' => 'task_date','id' => 'task_date','placeholder' => trans('tasks.pick_date'),'required' => 'required']) !!}
                    @if($errors->has('task_date'))
                        <span class="red">{!! $errors->first('task_date') !!}</span>
                    @endif
                </div>
            </div>
            <div class="row center">
                <button class="btn waves-effect waves-light" type="submit" name="action">{!! trans('tasks.save') !!}
                    <i class="material-icons right">send</i>
                </button>
            </div>

            {!! Form::close() !!}
        </div>
    </div>


@endsection
