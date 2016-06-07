<!DOCTYPE html>
<html>
    <head>
        <meta content="text/html; charset=utf-8" http-equiv="content-type">
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
		<title>@yield('title') MyName!</title>
        @section('styles')
        <!-- DataTables CSS -->
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
        <script type="text/javascript" src="/public/script/bootstrapvalidator/src/js/language/en_US.js"></script>
        <script type="text/javascript" src="/public/script/jQuery-Mask-Plugin-master/dist/jquery.mask.min.js"></script>
        {{ HTML::script(URL::asset('public/script/bootstrap-table.js')) }}
        {{ HTML::script(URL::asset('public/script/jquerygrowl/javascripts/jquery.growl.js')) }}

        {{ HTML::script(URL::asset('public/script/admin.js')) }}

        {{ HTML::script(URL::asset('public/script/tablesorter-master/js/jquery.tablesorter.js')) }}
        {{ HTML::script(URL::asset('public/script/tooltip.js')) }}
        {{ HTML::script(URL::asset('public/script/bootstrap-confirmation.js')) }}
        {{ HTML::script(URL::asset('public/script/jquery.popconfirm.js')) }}
        {{ HTML::script(URL::asset('public/script/tik.js')) }}
        {{ HTML::script(URL::asset('public/script/mask.js')) }}

    </head>
    <body>

@yield('content')

    </body>
</html>
