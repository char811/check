@extends('layoutadmin')

@section('content')
<div class="kit"></div>

<div class="container">
    <div class="row">
        <table class="table table-striped table-bordered" class="tablesorter" data-height="400"
               width="100%" cellspacing="0">

            <thead>
            <tr>
                <th> Клиенты</th>
                <th> Заявки</th>
                @if(Auth::user()->admin && !Session::has('id'))
                <th> Менеджеры</th>
                <th> Города</th>
                @endif
            </tr>
            </thead>

            <tbody>
            <tr>
                @if(!Auth::user()->admin || Auth::user()->admin && Session::has('id'))
                <td>{{{($countClients)}}}</td>
                <td>{{{$countOrders}}}</td>
                @endif
                @if(Auth::user()->admin && !Session::has('id'))
                <td>{{{($countClients-1)}}}</td>
                <td>{{{$countOrders}}}</td>
                <td>{{{$countManagers}}}</td>
                <td>{{{$towns}}}</td>
                @endif
            </tr>
            </tbody>
         </table>
    </div>
</div>

<div class="container">
    <div class="row">
        @foreach($services as $service)
				@if(isset($orders[$service->id]))
        <div class="col-md-4">
            <div id="{{$service->id}}"></div>
            {{{$name=$service->name}}}
            <form>
                <input type="hidden" name="{{$service->id}}"/>
            </form>
        </div>
				@endif
        @endforeach
    </div>
    <div id="chartdiv"></div>
</div>

@stop