@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <h4 class="center">{!! trans('tasks.recipes_added') !!}</h4>

            <div class="collection col s12 m12 l6 offset-l3">
                @foreach($task_recipes as $task_recipe)
                    {!! Form::open(['class' => 'right','method' => 'DELETE','url' => 'tasks/'.$id.'/'.$task_recipe->id.'/destroyTaskRecipe']) !!}
                    <button onclick="return confirm('{!! trans('recipes.confirm_recipe_delete') !!}');" type="submit"
                            class="btn-flat right secondary-content">
                        <i class="material-icons">delete</i></button>
                    {!! Form::close() !!}

                    <a href={!! url('recipes/'.$task_recipe->recipe_id.'/edit') !!} class="collection-item">{!! $task_recipe->name !!}
                        <span
                                class="right">{!! $task_recipe->recipe_count !!}</span>
                    </a>
                @endforeach
            </div>
        </div>
        <hr>
        <div class="row">
            <h2 class="center">{!! trans('tasks.edit') !!} {!! $task_date !!}</h2>
            {!! Form::open(array('url' => '/tasks/'.$id, 'method' => 'PATCH' ,'class' => 'col s12')) !!}

            @include('tasks.form', ['buttonEdit' => trans('tasks.add')])

            {!! Form::close() !!}

        </div>
    </div>

@endsection