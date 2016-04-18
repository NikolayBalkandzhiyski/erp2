<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="/favicon.png"/>

    <title>{!! $title !!}</title>
    {{--STYLES--}}
    {!! Html::style('materialize-css/css/jquery-ui.css') !!}
    {!! Html::style('materialize-css/css/materialize.css') !!}
    {{--SCRIPTS--}}
    {!! Html::script('materialize-css/js/jquery-1.12.1.min.js') !!}
    {!! Html::script('materialize-css/js/jquery-ui.min.js') !!}
    {!! Html::script('materialize-css/js/materialize.min.js') !!}
    {!! Html::script('materialize-css/js/script.js') !!}

</head>
<body id="app-layout">

<nav>
    <div class="nav-wrapper  teal lighten-1">
        <a href="{{ url('/') }}" class="brand-logo"><i class="material-icons">home</i></a>
        <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
        <ul class="right hide-on-med-and-down">
            <!-- Authentication Links -->
            @if (Auth::guest())
                <li><a href="{{ url('/login') }}">{!! trans('basic.login') !!}</a></li>
            @else
                {{--REPORTS--}}
                <ul id="reports" class="dropdown-content">
                    <li><a href="{!! url('reports/deliveries') !!}">{!! trans('reports.deliveries_report') !!}</a></li>
                    <li><a href="{!! url('reports/products') !!}">{!! trans('reports.products_report') !!}</a></li>
                </ul>
                <li class="@if(Request::is('reports/*') || Request::is('reports')) {!! 'active' !!}  @endif">
                    <a class="dropdown-button" data-activates="reports"
                       href="{{ url('/reports') }}">{!! trans('reports.reports') !!}
                        <i class="material-icons right">arrow_drop_down</i></a>
                </li>
                {{--TASKS--}}
                <ul id="tasks" class="dropdown-content">
                    <li><a href="{!! url('tasks') !!}">{!! trans('tasks.tasks_list') !!}</a></li>
                    <li><a href="{!! url('tasks/create') !!}">{!! trans('tasks.create') !!}</a></li>
                </ul>
                <li class="@if(Request::is('tasks/*') || Request::is('tasks')) {!! 'active' !!}  @endif">
                    <a class="dropdown-button" data-activates="tasks"
                       href="{{ url('/tasks') }}">{!! trans('tasks.tasks') !!}
                        <i class="material-icons right">arrow_drop_down</i></a>
                </li>
                {{--RECIPES--}}
                <ul id="recipes" class="dropdown-content">
                    <li><a href="{!! url('recipes/') !!}">{!! trans('recipes.recipes_list') !!}</a></li>
                    <li><a href="{!! url('recipes/create') !!}">{!! trans('recipes.create') !!}</a></li>
                </ul>
                <li class="@if(Request::is('recipes/*') || Request::is('recipes')) {!! 'active' !!}  @endif">
                    <a class="dropdown-button" data-activates="recipes"
                       href="{{ url('/recipes') }}">{!! trans('recipes.recipes') !!}
                        <i class="material-icons right">arrow_drop_down</i></a>
                </li>
                {{--DELIVERIES--}}
                <ul id="deliveries" class="dropdown-content">
                    <li><a href="{!! url('deliveries/') !!}">{!! trans('delivery.deliveries_list') !!}</a></li>
                @if(Auth::check() && in_array(Auth::user()->id,session('admins')))
                    <li><a href="{!! url('deliveries/create') !!}">{!! trans('delivery.create') !!}</a></li>
                @endif
                </ul>
                <li class="@if(Request::is('deliveries/*') || Request::is('deliveries')) {!! 'active' !!}  @endif">
                    <a class="dropdown-button" data-activates="deliveries"
                       href="{{ url('/deliveries') }}">{!! trans('delivery.deliveries') !!}
                        <i class="material-icons right">arrow_drop_down</i></a>
                </li>
                {{--PRODUCTS--}}
                @if(Auth::check() && in_array(Auth::user()->id,session('admins')))
                <ul id="products" class="dropdown-content">
                    <li><a href="{!! url('products/') !!}">{!! trans('product.products_list') !!}</a></li>
                    <li><a href="{!! url('products/create') !!}">{!! trans('product.create') !!}</a></li>
                </ul>
                <li class="@if(Request::is('products/*') || Request::is('products')) {!! 'active' !!}  @endif">
                    <a class="dropdown-button" data-activates="products"
                       href="{{ url('/products') }}">{!! trans('product.products') !!}
                        <i class="material-icons right">arrow_drop_down</i></a>
                </li>
                @endif
                {{--MEASURES--}}
                @if(Auth::check() && in_array(Auth::user()->id,session('admins')))
                <ul id="measures" class="dropdown-content">
                    <li><a href="{!! url('measures/') !!}">{!! trans('measures.measures_list') !!}</a></li>
                    <li><a href="{!! url('measures/create') !!}">{!! trans('measures.create') !!}</a></li>
                </ul>
                <li class="@if(Request::is('measures/*') || Request::is('measures')) {!! 'active' !!}  @endif">
                    <a class="dropdown-button" data-activates="measures"
                       href="{{ url('/measures') }}">{!! trans('basic.measures') !!}
                        <i class="material-icons right">arrow_drop_down</i></a>
                </li>
                @endif
                {{--AUTH--}}
                @if(Auth::check() && in_array(Auth::user()->id,session('admins')))
                    <li class="@if(Request::is('register')) {!! 'active' !!}  @endif">
                        <a href="{{ url('/register') }}">{!! trans('basic.register') !!}</a>
                    </li>
                @endif
                <ul id="dropdown1" class="dropdown-content">
                    <li><a href="{{ url('/logout') }}">{!! trans('basic.logout') !!}</a></li>
                </ul>
                <li>
                    <a class="dropdown-button" href="#!" data-activates="dropdown1">{{ Auth::user()->name }}<i
                                class="material-icons right">arrow_drop_down</i></a>
                </li>
            @endif
        </ul>
        <ul class="side-nav" id="mobile-demo">
            @if (Auth::guest())
                <li><a href="{{ url('/login') }}">{!! trans('basic.login') !!}</a></li>
            @else
                {{--REPORTS--}}
                <ul id="reports_mobile" class="dropdown-content">
                    <li><a href="{!! url('reports/deliveries') !!}">{!! trans('reports.deliveries_report') !!}</a></li>
                    <li><a href="{!! url('reports/products') !!}">{!! trans('reports.products_report') !!}</a></li>
                </ul>
                <li class="@if(Request::is('reports/*') || Request::is('reports')) {!! 'active' !!}  @endif">
                    <a class="dropdown-button" data-activates="reports_mobile"
                       href="{{ url('/reports') }}">{!! trans('reports.reports') !!}
                        <i class="material-icons right">arrow_drop_down</i></a>
                </li>
                {{--TASKS--}}
                <ul id="tasks_mobile" class="dropdown-content">
                    <li><a href="{!! url('tasks') !!}">{!! trans('tasks.tasks_list') !!}</a></li>
                    <li><a href="{!! url('tasks/create') !!}">{!! trans('tasks.create') !!}</a></li>
                </ul>
                <li class="@if(Request::is('tasks/*') || Request::is('tasks')) {!! 'active' !!}  @endif">
                    <a class="dropdown-button" data-activates="tasks_mobile"
                       href="{{ url('/tasks') }}">{!! trans('tasks.tasks') !!}
                        <i class="material-icons right">arrow_drop_down</i></a>
                </li>
                {{--RECIPES--}}
                <ul id="recipes_mobile" class="dropdown-content">
                    <li><a href="{!! url('recipes/') !!}">{!! trans('recipes.recipes_list') !!}</a></li>
                    <li><a href="{!! url('recipes/create') !!}">{!! trans('recipes.create') !!}</a></li>
                </ul>
                <li class="@if(Request::is('recipes/*') || Request::is('recipes')) {!! 'active' !!}  @endif">
                    <a class="dropdown-button" data-activates="recipes_mobile"
                       href="{{ url('/recipes') }}">{!! trans('recipes.recipes') !!}
                        <i class="material-icons right">arrow_drop_down</i></a>
                </li>
                {{--DELIVERIES--}}
                <ul id="deliveries_mobile" class="dropdown-content">
                    <li><a href="{!! url('deliveries/') !!}">{!! trans('delivery.deliveries_list') !!}</a></li>
                    <li><a href="{!! url('deliveries/create') !!}">{!! trans('delivery.create') !!}</a></li>
                </ul>
                <li class="@if(Request::is('deliveries/*') || Request::is('deliveries')) {!! 'active' !!}  @endif">
                    <a class="dropdown-button" data-activates="deliveries_mobile"
                       href="{{ url('/deliveries') }}">{!! trans('delivery.deliveries') !!}
                        <i class="material-icons right">arrow_drop_down</i></a>
                </li>
                {{--PRODUCTS--}}
                <ul id="products_mobile" class="dropdown-content">
                    <li><a href="{!! url('products/') !!}">{!! trans('product.products_list') !!}</a></li>
                    <li><a href="{!! url('products/create') !!}">{!! trans('product.create') !!}</a></li>
                </ul>
                <li class="@if(Request::is('products/*') || Request::is('products')) {!! 'active' !!}  @endif">
                    <a class="dropdown-button" data-activates="products_mobile"
                       href="{{ url('/products') }}">{!! trans('product.products') !!}
                        <i class="material-icons right">arrow_drop_down</i></a>
                </li>
                {{--MEASURES--}}
                <ul id="measures_mobile" class="dropdown-content">
                    <li><a href="{!! url('measures/') !!}">{!! trans('measures.measures_list') !!}</a></li>
                    <li><a href="{!! url('measures/create') !!}">{!! trans('measures.create') !!}</a></li>
                </ul>
                <li class="@if(Request::is('measures/*') || Request::is('measures')) {!! 'active' !!}  @endif">
                    <a class="dropdown-button" data-activates="measures_mobile"
                       href="{{ url('/measures') }}">{!! trans('basic.measures') !!}
                        <i class="material-icons right">arrow_drop_down</i></a>
                </li>
                {{--AUTH--}}
                @if(Auth::check() && in_array(Auth::user()->id,session('admins')))
                    <li class="@if(Request::is('register')) {!! 'active' !!}  @endif"><a
                                href="{{ url('/register') }}">{!! trans('basic.register') !!}</a></li>
                @endif
                <ul id="dropdown_mobile" class="dropdown-content">
                    <li><a href="{{ url('/logout') }}">{!! trans('basic.logout') !!}</a></li>
                </ul>
                <li>
                    <a class="dropdown-button" href="#!" data-activates="dropdown_mobile">{{ Auth::user()->name }}<i
                                class="material-icons right">arrow_drop_down</i></a>
                </li>
            @endif
        </ul>
    </div>
</nav>

@yield('content')

</body>
</html>
