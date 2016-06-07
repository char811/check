@extends('layoutt')

@section('title')
Our company
@stop

@section('content')
<div class="containerImg">
    <div style="border: 7px solid rgba(120, 120, 120, 1);" >
   <img src="/public/styles/klava.jpg" style="width: 101%; margin-left: -6px">
        <div class="titleText">

            <span class="color_18">COMPANY</span>

            </div>
</div>

<div>
    <div id="depth2" >
    <div id="block_carousel_about">
       <div>
           <div id="myCarousel" class="carousel slide" data-ride="carousel"
                style="width: 46%; margin-top: 1%; height: 13%; margin-left: 2%">

               <!-- Carousel indicators -->
               <ol class="carousel-indicators">
                   <li data-target="#myCarousel" data-slide-to="0" class="active" style="background: #1445cd"></li>
                   <li data-target="#myCarousel" data-slide-to="1" style="background: #1445cd"></li>
               </ol>

               <!-- Carousel items -->

               <div class="carousel-inner">
                   <div class="item active">
                       <img style="align: center; padding: 5px" src="/public/styles/2.jpg">
                   </div>
                   <div class="item">
                       <img style="align: center;  padding: 5px" src="/public/styles/1.jpg">
                   </div>
               </div>

               <!-- Carousel nav -->
               <a class="carousel-control left" href="#myCarousel" data-slide="prev">
                   <span class="glyphicon glyphicon-chevron-left"></span>
               </a>
               <a class="carousel-control right" href="#myCarousel" data-slide="next">
                   <span class="glyphicon glyphicon-chevron-right"></span>
               </a>
           </div>
       </div>
        <div id="about_us">
            <h4 id="h4" style="text-align: center">A BIT ABOUT US</h4>
        <p id="p" style="text-align: center">With experience, certifications and a love for all things what we building for you. Our
            company working with yours wishes and we are ready listen all your thoughts and objections. Welcome to our company !
            </p>
       </div>
    </div>
    <div id="service">
        <p id="service_p">SERVICES</p>
        <ul>
            @foreach($services as $service)
            <li id="service_li">
                <b>
                   {{{ $service->name }}}
                </b>
            </li>
            @endforeach
        </ul>
    </div>
    <div id="form_block_main">
{{Form::open(array('url'=>action('UsersController@Record'), 'role'=>'form',  'method'=>'post', 'class' => 'form-horizontal registrationForm jquerymask')) }}
        <h3 id="h3">Fill FORM with your desired service</h3>
        <br /><br />
@if (!$errors->isEmpty())
<div class="alert alert-danger">
    @foreach ($errors->all() as $error)
    <p>{{ $error }}</p>
    @endforeach
</div>
@endif

@if(Session::has('message'))
<script type="text/javascript">
    $.growl.notice({message: "Message delivered" });
</script>
@endif

        <div class="form-group">
                <label class="col-sm-1 control-label"></label>
            <div class="col-sm-10">
                {{ Form::select('service', array('default' => 'Please Select Service')
                +Service::all()->lists('name', 'id'), null, array('class' => 'form-control')) }}
            </div>
        </div>
        <div class="form-group">
                <label class="col-sm-1 control-label"></label>
             <div class="col-sm-10">
                 {{ Form::select('city', array('default' => 'Please Select City')
                 +City::all()->lists('engname', 'id'), null, array('class' => 'form-control')) }}
             </div>
        </div>
        <div class="form-group">
                <label class="col-sm-1 control-label"></label>
            <div class="col-sm-10">
                {{ Form::text('username', null, array('class' => 'form-control','placeholder' => 'Name')) }}
            </div>
        </div>
        <div class="form-group">
                <label class="col-sm-1 control-label"></label>
            <div class="col-sm-10">
                {{ Form::text('first_name', null, array('class' => 'form-control',  'placeholder' => 'First name')) }}
            </div>
        </div>
        <div class="form-group">
                <label class="col-sm-1 control-label"></label>
            <div class="col-sm-10">
                {{ Form::text('last_name', null,  array('class' => 'form-control','placeholder' => 'Last name')) }}
             </div>
        </div>
        <div class="form-group">
                <label class="col-sm-1 control-label"></label>
            <div class="col-sm-10">
                {{ Form::email('email', null, array('class' => 'form-control',  'placeholder' => 'Email')) }}
              </div>
        </div>
        <div class="form-group">
               <label class="col-sm-1 control-label"></label>
            <div class="col-sm-10">
                {{ Form::text('mobile', null,  array('class' => 'form-control mobile', 'placeholder' => '0(000)-000-00-00')) }}
            </div>
        </div>
        <div class="form-group">
                <label class="col-sm-1 control-label"></label>
            <div class="col-sm-10">
                {{ Form::textarea('comment', null, array('class' => 'form-control bbeditor', 'placeholder' => 'Message')) }}<br />
                </div>
        </div>
        <div class="form-group">
                <label class="col-sm-1 control-label">  </label>
            <div class="col-sm-10">
                {{ Form::submit('Send', array('class' => 'btn btn-lg btn-primary btn-block')) }}
            </div>
         </div>

        {{Form::close()}}
        </div>
    </div>
  </div>
</div>

@stop
