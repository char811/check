@extends('layoutadmin')

@section('title')
@stop

@section('headExtra')
{{ HTML::style('css/signin.css') }}
@stop

@section('content')

<div class="kit"></div>
<div class="container">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-8">
                    <form role="searchclient" action="{{ action('UsersController@clients') }}" method="get"
                          class="form-search" id="clients_search">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="input-group input-group-sm">
                            <input type="text" id="email" class="form-control" placeholder="Имя" name="email" required
                                   value="{{ $term }}"/>
                                <span class="input-group-addon"><a href="#" onclick="$('#clients_search').submit();">
                                        <i class="glyphicon glyphicon-search"></i></a>
                                </span>
                        </div>
                    </form>
                </div>
                <div class="col-lg-2">
                    <a class="btn btn-success btn-sm pull-right" href="{{ action('UsersController@newClientCreate') }}"><i
                            class="glyphicon glyphicon-plus"></i></a>
                </div>
                <ul class="nav nav-pills">
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Сортировка<b class="caret"></b></a>
                        <ul id="menu1" class="dropdown-menu">
                            <li><a href="{{action('UsersController@clients') }}?id=old">Старые данные</a></li>
                            <li><a href="{{ action('UsersController@clients') }}?id=new">Новые данные</a></li>
                        </ul>
                    </li>
                </ul>
            </div>

        </div>
    </div>

    @if(Session::has('newClient'))
    <script type="text/javascript">
        $.growl.notice({message: "Новый клиент успешно занесен в базу данных..." });
    </script>
    @endif

    @if(Session::has('changeClient'))
    <script type="text/javascript">
        $.growl.notice({message: "Данные клиента успешно изменены" });
    </script>
    @endif

    @if(Session::has('manager'))
    <script type="text/javascript">
        $.growl.notice({message: "Новый менеджер успешно занесен в базу данных..." });
    </script>
    @endif


    <div class="row">
        <table id="example" class="table table-striped table-bordered clientTable" class="tablesorter" data-height="400"
               data-side-pagination="server" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]"
               width="100%" cellspacing="0">
            <thead>
            <tr>
                <th class="sortable"> Имя <i class="glyphicon pull-right"></i></th>
                <th class="sortable"> Фамилия <i class="glyphicon pull-right"></i></th>
                <th class="sortable"> Отчество <i class="glyphicon pull-right"></i></th>
                <th class="sortable"> Эмейл <i class="glyphicon pull-right"></i></th>
                <th class="sortable"> Мобильный <i class="glyphicon pull-right"></i></th>
                <th class="sortable"> Дата <i class="glyphicon pull-right"></i></th>
                <th></th>
            </tr>
            </thead>

            <tfoot>
            <tr>
                <th>Имя</th>
                <th>Фамилия</th>
                <th>Отчество</th>
                <th>Эмейл</th>
                <th>Мобильный</th>
                <th>Дата</th>
                <th></th>
            </tr>
            </tfoot>

            <tbody>
            @foreach($clients as $client)
            <tr>

                <td>{{{$client->username}}}</td>
                <td>{{{$client->first_name}}}</td>
                <td>{{{$client->last_name}}}</td>
                <td>{{{$client->email}}}</td>
                <td>{{{$client->mobile}}}</td>
                <td>{{$client->created_at}}</td>

                <td>

                    <div style="position: relative"><a href="#modal" class="btn btn-info btn-sm" data-toggle="modal"
                                                       data-target="#basicModal{{$client->id}}"><i
                                class="glyphicon glyphicon-eye-open"></i></a>

                        <form class="ajaxForm" action="{{URL::route('clientDelete', array('id'=>$client->id)) }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button type="submit" class="btn btn-danger btn-sm popconfirm"
                                    style="position: absolute; top: 0px; left: 38px;"><i
                                    class="glyphicon glyphicon-remove-sign"></i></button>
                        </form>
                    </div>

                </td>
            </tr>

            @endforeach
            </tbody>
        </table>
    </div>
    <div style="position:relative">
        <div id="pager" class="pager" style="top: 30px; position: absolute; ">
            <form>
                <img src="/public/script/tablesorter-master/addons/pager/icons/first.png" class="first">
                <img src="/public/script/tablesorter-master/addons/pager/icons/prev.png" class="prev">
                <input type="text" class="pagedisplay">
                <img src="/public/script/tablesorter-master/addons/pager/icons/next.png" class="next">
                <img src="/public/script/tablesorter-master/addons/pager/icons/last.png" class="last">
                <select class="pagesize">
                    <option selected="selected" value="10">10</option>
                    <option value="20">20</option>
                    <option value="30">30</option>
                    <option value="40">40</option>
                </select>
            </form>
        </div>
    </div>
</div>





@foreach($clients as $client)
<div class="modal" id="basicModal{{ $client->id }}" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><button class="close" type="button" data-dismiss="modal">x</button>
                <h4 class="modal-title" id="myModalLabel"><p>Эмейл - {{{$client->email}}} </p></h4>
            </div>
            <div class="modal-body">
                <h3>
                    <p>Имя:  {{{$client->username}}} </p>
                    <p>Фамилия:  {{{$client->first_name}}} </p>
                    <p>Отчество:  {{{$client->last_name}}} </p>
                    <p>Мобильный:  {{{$client->mobile}}} </p>
                </h3>
            </div>
            <div class="modal-footer">
                <form action="{{ action('UsersController@clientChange') }}" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" value="{{$client->id}}" required />
                    <button type="submit" class="btn btn-info btn-sm">Изменить</button>
                    <a class="btn" href="#" data-dismiss="modal">Отмена</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

@stop
