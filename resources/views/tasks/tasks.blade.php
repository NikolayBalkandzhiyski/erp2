@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col s12 m12 l12 z-depth-1">
                <p class="center">Hello {!! Auth::user()->name !!}</p>
            </div>
            <hr>
        </div>
        <div class="row">
            <table class="centered bordered hilight striped">
                <thead>
                <tr>
                    <th data-field="id">{!! trans('tasks.id') !!}</th>
                    <th data-field="task_date">{!! trans('tasks.task_date') !!}</th>
                    <th data-field="user">{!! trans('tasks.username') !!}</th>
                    <th data-field="options">{!! trans('tasks.options') !!}</th>
                </tr>
                </thead>
                <tbody>
                @if(isset($tasks))
                    @foreach($tasks as $task)
                        <tr>
                            <td>{!! $task->id !!}</td>
                            <td>{!! $task->task_date !!}</td>
                            <td>{!! $task->username !!}</td>
                            <td>
                                <a class="btn-flat right" href="{!! url('/tasks/'.$task->id).'/edit' !!}">
                                    <i class="material-icons">mode_edit</i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </div>

@endsection
