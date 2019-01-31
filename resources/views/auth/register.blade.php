@extends('master')
@section('notVue')
<body id="Register">
    <div class="container-fluid">
             <div class="login-form row">
                <div class="col-md-3 columna2">
                    <img src="/storage/logo/LogoG.png" height="300px;" width="299px">
                </div>
                <div class="col-md-9">
                    <div class="main-div">
                        <div style="margin-top: -5px;">
                            <img src="/storage/logo/LogoBig.png" width="60px">
                        </div>
                        <div class="borde"></div>
                        <form id="Login" method="POST" action="{{ route('register') }}"  enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <h6>Nombre de Usuario:</h6>
                                        <input id="name_user" type="text" class="form-control{{ $errors->has('name_user') ? ' is-invalid' : '' }}" name="name_user" value="{{ old('name_user') }}" required autofocus>

                                        @if ($errors->has('name_user'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('name_user') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <h6>Foto de Perfil:</h6>
                                        <input  id="avatar" type="file" name="avatar" accept="image/*" {{ $errors->has('avatar') ? ' is-invalid' : '' }}>
                                    </div>
                                    <div class="form-group">
                                        <h6>Nombre:</h6>
                                        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>
                                         @if ($errors->has('name'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <h6>Apellido:</h6>
                                        <input id="last_name" type="text" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{ old('last_name') }}" required autofocus>
                                        @if ($errors->has('last_name'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('last_name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <h6>Fecha de Nacimiento:</h6>
                                        <input id="birthdate" type="date" class="form-control{{ $errors->has('birthdate') ? ' is-invalid' : '' }}" name="birthdate" value="{{ old('birthdate') }}" required autofocus >

                                        @if ($errors->has('birthdate'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('birthdate') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <h6>Email:</h6>
                                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
                                        @if ($errors->has('email'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                    </div>
                                    <div class="form-group">
                                        <h6>Página Web:</h6>
                                        <input id="page_web" type="text" class="form-control{{ $errors->has('page_web') ? ' is-invalid' : '' }}" name="page_web" value="{{ old('page_web') }}" >
                                        @if ($errors->has('page_web'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('page_web') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <h6>Sexo:</h6>
                                        <input  name="sex" 
                                        @if (old('sex')==null || old('sex')=='M')
                                            checked="checked" 
                                        @endif
                                        type="radio" value="M"> Masculino

                                        <input  name="sex" {{ old('sex')=="F" ? 'checked='.'"checked"' : '' }} type="radio" value="F"> Femenino                           
                                    </div>
                                    <div class="form-group">
                                        <h6>Contraseña:</h6>
                                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                                        @if ($errors->has('password'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <h6>Repetir Contraseña:</h6>
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Registrar</button>    
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
        padding-top: 110px;
    }
    body#Register{ background-image:url("https://hdwallsource.com/img/2014/9/blur-26347-27038-hd-wallpapers.jpg"); background-repeat:no-repeat; background-position:center; background-size:cover;}
    .container{
        padding-top: 10px;

    }
    .form-heading { color:#fff; font-size:23px;}

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
      height: 40px;
      padding: 0;
    }
    .login-form .btn.btn-primary.reset {
      background: #ff9900 none repeat scroll 0 0;
    }
    .back { text-align: left; margin-top:10px;}
    .back a {color: #444444; font-size: 13px;text-decoration: none;}
</style>
@endsection


