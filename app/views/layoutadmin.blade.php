<!DOCTYPE html>
<html>
    <head>
        <meta content="text/html; charset=utf-8" http-equiv="content-type">
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
		<title>@yield('title') Site!</title>
        @section('styles')
        <!-- DataTables CSS -->
        <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/themes/smoothness/jquery-ui.css">
        <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="/public/script/bootstrapvalidator/dist/css/bootstrapValidator.css"/>
        <link rel="stylesheet" href="/public/css/style.css">
        <link rel="stylesheet" href="/public/script/jquerygrowl/stylesheets/jquery.growl.css">
        <link rel="shortcut icon" href="/public/chart-up-color.png" type="image/png">
 



        <!-- DataTables JS -->

        {{ HTML::script(URL::asset('public/script/jquery-2.1.1.js')) }}

        <script src="http://netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js" type="text/javascript" charset="utf-8"></script>

        <script type="text/javascript" src="/public/script/bootstrapvalidator/dist/js/bootstrapValidator.js"></script>
        <script type="text/javascript" src="/public/script/bootstrapvalidator/src/js/language/ru_RU.js"></script>
        <script type="text/javascript" src="/public/script/jQuery-Mask-Plugin-master/dist/jquery.mask.min.js"></script>
        <script src="/public/script/pyramid/highcharts.js"></script>
        <script src="/public/script/pyramid/funnel.js"></script>
        {{ HTML::script(URL::asset('public/script/bootstrap-table.js')) }}
        <!--<script type="text/javascript" src="/public/script/jQuery-Autocomplete-master/dist/jquery.autocomplete.js"></script>-->
        {{ HTML::script(URL::asset('public/script/jquerygrowl/javascripts/jquery.growl.js')) }}
        {{ HTML::script(URL::asset('public/script/tablesorter-master/js/jquery.tablesorter.js')) }}
        {{ HTML::script(URL::asset('public/script/tablesorter-master/addons/pager/jquery.tablesorter.pager.js')) }}
        {{ HTML::script(URL::asset('public/script/tooltip.js')) }}
        {{ HTML::script(URL::asset('public/script/bootstrap-confirmation.js')) }}
        {{ HTML::script(URL::asset('public/script/jquery.popconfirm.js')) }}

        {{ HTML::script(URL::asset('public/script/admin.js')) }}
        {{ HTML::script(URL::asset('public/script/tik.js')) }}
        {{ HTML::script(URL::asset('public/script/mask.js')) }}

        @show
    </head>
    <body>
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="/">Главная</a>
                <button type="button" class="navbar-toggle" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1">

                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

            </div>
            <div id="bs-example-navbar-collapse-1" class="navbar-collapse collapse" style="height: 1px;">
                <ul class="nav navbar-nav">
                    @if(Auth::check())
                    <li><a href="{{action('OrdersController@Orders')}}">Заказы</a></li>
                    <li><a href="{{action('UsersController@clients')}}">Клиенты</a></li>
                    <li><a href="{{action('OrdersController@statistics')}}">Статистика</a></li>
                    @if (Auth::user()->admin && !Session::get('id'))
                    <li><a href="{{action('ServicesController@create')}}">Новые услуги</a></li>
                    <li><a href="{{action('CitiesController@create')}}">Новые города</a></li>
                    <li><a href="{{action('UsersController@showManagers')}}">Менеджеры</a></li>
                    @endif
                </ul>
                <form class="navbar-form navbar-right" role="exit" action="{{ action('UsersController@getLogout') }}"
                      method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <button class="btn btn-success">Выйти</button>
                </form>
                @if(Auth::user()->admin && Session::has('id'))
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#"><strong>{{ Session::get('name') }}</strong></a></li>
                </ul>
                @endif
                @if(Auth::user()->admin && !Session::has('id') || !Auth::user()->admin)
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#"><strong>{{ Auth::user()->username }}</strong></a></li>
                </ul>
                @endif
                @endif

                @if (Auth::user()->admin && Session::has('id'))
                <div class="line">
                    <div id="childLine"> Вы на ходитесь в режиме Shadow для менеджера
                        <font color="#1d36ff">
                            {{ Session::get('name') }} (Город {{ Session::get('city') }} ) !
                        </font>


                    <form  style="width: 37%" id="reg" action="{{ action('UsersController@shadowDelete') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <a href="#" onclick="$('#reg').submit();">Можете выйти из Shadow</a>
                    </form>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    @yield('content')
    </body>
</html>
