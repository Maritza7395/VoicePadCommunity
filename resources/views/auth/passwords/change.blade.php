@extends('master')
@section('notVue')
<body id="Pass">
    <div class="container">
        <div class="login-form row">
            <div class="col-md-6 columna2">
                <img src="/storage/logo/LogoG.png">
            </div>
            <div class="col-md-6">
                <div class="main-div">
                    <div class="panel">
                        <img src="/storage/logo/LogoBig.png">
                    </div>
                    <div class="borde"></div>
                    <form id="Login" method="POST" action="{{ route('changePassword') }}">
                        @csrf
                        <div class="form-group">
                            <h6 for="email">Contraseña Actual:</h6>
                            <input id="current-password" type="password" class="form-control{{ $errors->has('current-password') ? ' is-invalid' : '' }}" name="current-password" required>
                            @if ($errors->has('current-password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('current-password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <h6>Nueva Contraseña:</h6>
                            <input id="new-password" type="password" class="form-control{{ $errors->has('new-password') ? ' is-invalid' : '' }}" name="new-password" required>
                            @if ($errors->has('new-password'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('new-password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <h6>Repetir Contraseña:</h6>
                            <input id="new-password_confirm" type="password" class="form-control{{ $errors->has('new-password-confirmation') ? ' is-invalid' : '' }}" name="new-password_confirmation" required>
                            @if ($errors->has('new-password_confirmation'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('new-password_confirmation') }}</strong>
                                </span>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary">Cambiar Contraseña</button>
                    </form>
                </div>
            </div>
        </div>
    </div></div>
</body>
<style type="text/css">
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
        max-width: 50%;
        max-height: 50%;
        padding-top: 50px;
    }
    body#Pass{ background-image:url("https://hdwallsource.com/img/2014/9/blur-26347-27038-hd-wallpapers.jpg"); background-repeat:no-repeat; background-position:center; background-size:cover;}
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
      height: 50px;
    }
    .main-div {
      background: #ffffff none repeat scroll 0 0;
      border-radius: 8px;
      margin: 10px auto 30px;
      max-width: 80%;
      padding: 30px 70px 30px 71px;
    }

    .login-form .form-group {
      margin-bottom:10px;
    }
    .login-form{ text-align:center; padding-top: 5px;}
    .forgot a {
      color: #777777;
      font-size: 14px;
      text-decoration: underline;
    }
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
    .forgot {
      text-align: left; margin-bottom:30px;
    }
    .botto-text {
      color: #ffffff;
      font-size: 14px;
      margin: auto;
    }
    .login-form .btn.btn-primary.reset {
      background: #ff9900 none repeat scroll 0 0;
    }
    .back { text-align: left; margin-top:10px;}
    .back a {color: #444444; font-size: 13px;text-decoration: none;}
</style>
@endsection
