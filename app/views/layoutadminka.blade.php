<!DOCTYPE html>
<html>
    <head>
        <meta content="text/html; charset=utf-8" http-equiv="content-type">
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
		<title>@yield('title') MyName!</title>

        @section('styles')
        <!-- DataTables CSS -->
        <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/themes/smoothness/jquery-ui.css">
        <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="/public/script/bootstrapvalidator/dist/css/bootstrapValidator.css"/>
        <link rel="stylesheet" href="/public/css/style.css">
        <link rel="stylesheet" href="/public/script/jquerygrowl/stylesheets/jquery.growl.css">
        <link rel="stylesheet" href="/public/script/pyramid/css/structure/infragistics.css">
        <link rel="stylesheet" href="/public/script/pyramid/css/themes/infragistics/infragistics.theme.css">
        <link rel="shortcut icon" href="/public/chart-up-color.png" type="image/png">
 


        <!-- DataTables JS -->

        {{ HTML::script(URL::asset('public/script/jquery-2.1.1.js')) }}

        <script src="http://netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js" type="text/javascript" charset="utf-8"></script>
        <script type="text/javascript" src="/public/script/bootstrapvalidator/dist/js/bootstrapValidator.js"></script>
        <script type="text/javascript" src="/public/script/bootstrapvalidator/src/js/language/ru_RU.js"></script>
        <script type="text/javascript" src="/public/script/jQuery-Mask-Plugin-master/dist/jquery.mask.min.js"></script>

        {{ HTML::script(URL::asset('public/script/bootstrap-table.js')) }}
       <script type="text/javascript" src="/public/script/pyramid/infragistics.js"></script>

        <script src="/public/script/pyramid/highcharts.js"></script>
        <script src="/public/script/pyramid/funnel.js"></script>

        {{ HTML::script(URL::asset('public/script/tablesorter-master/js/jquery.tablesorter.js')) }}
        {{ HTML::script(URL::asset('public/script/tooltip.js')) }}
        {{ HTML::script(URL::asset('public/script/bootstrap-confirmation.js')) }}
        {{ HTML::script(URL::asset('public/script/jquery.popconfirm.js')) }}
        {{ HTML::script(URL::asset('public/script/admin.js')) }}
        {{ HTML::script(URL::asset('public/script/tik.js')) }}



 </head>
    <body>
        <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">
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
                    <li><a href="{{action('ServicesController@create')}}">Новые услуги</a></li>
                    <li><a href="{{action('OrdersController@Orders')}}">Заказы</a></li>
                    <li><a href="{{action('UsersController@Clients')}}">Клиенты</a></li>
                    </ul>

                    <ul class="nav navbar-nav">
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Меню <b class="caret"></b></a>
                            <ul id="menu1" class="dropdown-menu">
                                @foreach($cities as $city)
                                <li><a href="{{URL::route('su',array('city'=>$city->engname))}}">{{$city->engname}}</a></li>
                                @endforeach
                            </ul>
                        </li>
                    </ul>

                    <form class="navbar-form navbar-right" role="exit" action="{{ action('UsersController@getLogout') }}" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <button class="btn btn-success">Выйти</button>
                    </form>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#"><strong>{{ Auth::user()->username }}</strong></a></li>
                    </ul>
                    @endif
            </div>





		</div>
</div>

@yield('content')
            
    </body>
</html>
