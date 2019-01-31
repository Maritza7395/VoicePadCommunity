@extends('master')
@section('notVue')
<body id="Edit">
    <div class="container-fluid">
         @if (session('success'))
             <b-alert class="text-center" variant="success"  dismissible show> {{ session('success') }}</b-alert>              
            @endif
             <div class="login-form row">
                <div class="col-md-3 columna2">
                    <img src="/storage/logo/LogoG.png" height="300px;" width="299px">
                </div>
                <div class="col-md-9">
                    <div class="main-div">
                        <div class="panel">
                            <img src="/storage/logo/LogoBig.png">
                        </div>
                        <div class="borde"></div>
                        <form id="Login" method="POST" action="{{ route('editUser') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                            <img width="100px" height="100px" src="{{ auth()->user()->existPicturePerfil(auth()->user()->name_user,auth()->user()->sex) }}">
                                            <p><label for="avatar">
                                                <br>
                                               <input  type="file" name="avatar" accept="image/*" {{ $errors->has('avatar') ? ' is-invalid' : '' }}>                                        
                                            </label></p>
                                        <div class="row">
                                            {!! $errors->first('avatar','<span class="error alert alert-danger">:message</span>') !!}
                                        </div>    
                                    </div>
                                    <div class="form-group">
                                        <h6>Nombre de Usuario:</h6>
                                        <input id="name_user" type="text" class="form-control{{ $errors->has('name_user') ? ' is-invalid' : '' }}" name="name_user" value="{{ auth()->user()->name_user }}" disabled="true">
                                        @if ($errors->has('name_user'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('name_user') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <h6>Nombre:</h6>
                                        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name"
                                         @if (old('name')==null)
                                                value="{{ auth()->user()->name }}" 
                                            @else
                                                value="{{ old('name') }}" 
                                            
                                            @endif
                                         required autofocus>

                                        @if ($errors->has('name'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <h6>Apellido:</h6>
                                        <input id="last_name" type="text" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" 
                                            @if (old('last_name')==null)
                                                value="{{ auth()->user()->last_name }}" 
                                            @else
                                                value="{{ old('last_name') }}" 
                                            
                                            @endif

                                            required autofocus>

                                        @if ($errors->has('last_name'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('last_name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <h6>Fecha de Nacimiento:</h6>
                                        <input id="birthdate" type="date" class="form-control{{ $errors->has('birthdate') ? ' is-invalid' : '' }}" name="birthdate" 
                                         @if (old('birthdate')==null)
                                                value="{{ auth()->user()->birthdate }}" 
                                            @else
                                                value="{{ old('birthdate') }}" 
                                            
                                            @endif
                                        required autofocus>

                                        @if ($errors->has('birthdate'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('birthdate') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <h6>Acerca de mi:</h6>
                                         <textarea id="about_me" type="text" style="height: 188px !important;" class="form-control{{ $errors->has('about_me') ? ' is-invalid' : '' }}" name="about_me" 
                                         autofocus>@if (old('about_me')==null){{ auth()->user()->about_me }}@else{{ old('about_me') }}@endif </textarea>

                                        @if ($errors->has('birthdate'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('birthdate') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <h6>Email:</h6>
                                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" 
                                        @if (old('email')==null)
                                            value="{{ auth()->user()->email }}" 
                                        @else
                                            value="{{ old('email') }}" 
                                        
                                        @endif
                                        required>

                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <h6>Pagina Web:</h6>
                                        <input id="page_web" type="text" class="form-control{{ $errors->has('page_web') ? ' is-invalid' : '' }}" name="page_web" value="{{ auth()->user()->page_web }}" >

                                        @if ($errors->has('page_web'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('page_web') }}</strong>
                                            </span>
                                        @endif                         
                                    </div>
                                    <div class="form-group">
                                        <h6>Sexo:</h6>
                                        <input  name="sex" 
                                        @if (old('sex')==null && auth()->user()->sex =='M' )
                                           checked="checked" 
                                        @elseif(old('sex')=='M')
                                            checked="checked" 
                                        @endif
                                        type="radio" value='M'> Masculino

                                        <input  name="sex"
                                        @if (old('sex')==null && auth()->user()->sex=='F' )
                                           checked="checked" 
                                        @endif
                                        type="radio" value='F'> Femenino    
                                    </div>
                                    <button type="submit" style="height: 35px; line-height: 35px;" class="btn btn-primary">Editar</button>    
                                </div>
                            </div>   
                        </form>
                    </div>
                </div>
            </div>
    </div></div>
</body>
<style type="text/css">
    input, button, select, optgroup, textarea{
        border-style: solid;
        border-color: #721422;
        border-width: 1px;
        border-radius: 4px;
    }
    button, input {
        overflow: visible;
        color: #ec9b1b;
        
    }
    h6{
        text-align: left !important;
        padding-left: 2px;
    }
    .borde{
        border-top-style: solid;
        border-top-color: #721422;
        padding-bottom: 20px; 
    }
    .columna2{
        padding-top: 150px;
    }
    body#Edit{ background-image:url("https://hdwallsource.com/img/2014/9/blur-26347-27038-hd-wallpapers.jpg"); background-repeat:no-repeat; background-position:center; background-size:cover;}
    .container{
        padding-top: 10px;

    }
    .form-heading { color:#fff; font-size:23px;}
    .panel {
        margin-bottom: 15px;
    }
    .login-form .form-control {
      border: 1px solid #d4d4d4;
      border-radius: 4px;
      font-size: 14px;
      height: 35px; 
    }
    .main-div {
      background: #ffffff none repeat scroll 0 0;
      border-radius: 8px;
      margin: 10px auto 30px;
      max-width: 80%;
      padding: 20px 20px 20px 20px;
    }

    .login-form .form-group {
      margin-bottom:10px;
    }
    .login-form{ text-align:center; padding-top: 5px;}
    .login-form  .btn.btn-primary {
      background: #9b111e none repeat scroll 0 0;
      border-color: #f0ad4e;
      color: #ffffff;
      font-size: 14px;
      width: 100%;
      height: 50px;
      line-height: 50px;
      padding: 0;
    }
    .login-form .btn.btn-primary.reset {
      background: #ff9900 none repeat scroll 0 0;
    }
</style>
@endsection