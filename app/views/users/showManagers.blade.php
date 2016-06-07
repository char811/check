@extends('layoutadmin')

@section('content')
<div class="kit"></div>

<div class="container">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-8">
                    <form name="uni" action="{{ action('UsersController@showManagers') }}" method="get"
                          class="form-search" id="orders_search">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="input-group input-group-sm">
                            <input type="text" id="emailManager" class="form-control" placeholder="Эмейл" name="email" required
                                   value="{{ $term }}"/>
                             <span class="input-group-addon"><a href="#" onclick="$('#orders_search').submit();">
                                     <i class="glyphicon glyphicon-search"></i></a>
                             </span>
                        </div>
                    </form>


                </div>
                <div class="col-lg-2">
                    <a class="btn btn-success btn-sm pull-right" href="{{ action('UsersController@newManager') }}"><i
                            class="glyphicon glyphicon-plus"></i></a>

                </div>
            </div>

        </div>
    </div>


@if(Session::has('changeManager'))
<script type="text/javascript">
    $.growl.error({message: "{{Session::get('changeManager')}}" });
</script>
@endif
@if(Session::has('changeManagergood'))
<script type="text/javascript">
    $.growl.notice({message: "{{Session::get('changeManagergood')}}" });
</script>
@endif

    <div class="row">
        <table id="example" class="table table-striped table-bordered managerTable" class="tablesorter"
               data-height="400" width="100%" cellspacing="0">

            <thead>
            <tr>
                <th class="sortable"> Менеджер <i class="glyphicon pull-right"></i></th>
                <th class="sortable"> Эмейл <i class="glyphicon pull-right"></i></th>
                <th class="sortable"> Город <i class="glyphicon pull-right"></i></th>
                <th></th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th> Менеджер </th>
                <th> Эмейл </th>
                <th> Город </th>
                <th></th>
            </tr>
            </tfoot>

            <tbody>
            @foreach($managers as $manager)
            <tr>
                <td>{{{$manager->username}}}</td>
                <td>{{{$manager->email}}}</td>
                @if($manager->city!=0)
                <td>{{{$manager->cities()->first()->engname}}}</td>
                @else
                <td></td>
                @endif
                <td>
                    <div style="position: relative">
                        <a href="#modal" class="btn btn-info btn-sm" data-toggle="modal"
                           data-target="#basicModal{{$manager->id}}"><i class="glyphicon glyphicon-eye-open"></i></a>

                        <form action="{{ URL::route('shadow', array('id' => $manager->id)) }} ">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button type="submit" class="btn btn-primary btn-sm"
                                    style="position: absolute; top: 0px; left: 50px;"><i
                                    class="glyphicon glyphicon-user"></i></button>
                        </form>
                        <form class="managerDelete"
                              action="{{URL::route('managerDelete', array('id'=>$manager->id)) }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button type="submit" class="btn btn-danger btn-sm popconfirm"
                                    style="position: absolute; top: 0px; left: 100px;"><i
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






@foreach($managers as $manager)
<div class="modal" id="basicModal{{ $manager->id }}" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><button class="close" type="button" data-dismiss="modal">x</button>
                <h4 class="modal-title" id="myModalLabel"><p>Эмейл - {{{$manager->email}}} </p></h4>
            </div>
            <div class="modal-body">
                <h3>
                    <p>Имя:  {{{$manager->username}}} </p>
                    @if($manager->city!=0)
                    <p>Город:  {{{$manager->cities()->first()->engname}}} </p>
                    @endif
                </h3>
            </div>
            <div class="modal-footer">
                <form action="{{ action('UsersController@managerChange') }}" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" value="{{$manager->id}}" required />
                    <button type="submit" class="btn btn-info btn-sm">Изменить</button>
                    <a class="btn" href="#" data-dismiss="modal">Отмена</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

@stop