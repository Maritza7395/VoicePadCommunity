<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
   <script id="Cookiebot" src="https://consent.cookiebot.com/uc.js" data-cbid="d032af19-31bb-4e8d-9f45-5d5fc84be982" type="text/javascript" async></script>
	<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge"; charset=utf-8>
  <meta name="viewport" content="width=device-width, initial-scale=1">
 

  
 <meta name="csrf-token" content="{{ csrf_token() }}">

   <!-- Scripts -->
    <script type="text/javascript" src="{{ URL::asset('js/commands/artyom.window.js') }}"></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
     <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons' rel="stylesheet">  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/app.css') }}">

	<title>{{ config('app.name', 'VoicePad') }}</title>
    <style>
      body {
          height: 200%;
          background-color: white;
      }
      .imgRedondaNavbar {
          width:40px!important;
          height:40px!important;
          border-radius:20px!important;
          border:1px solid #C0C0C0;
          object-fit: cover;
      }
      .myDropDown
      {
         float:right;
        height: 125px;
        width:auto;
        overflow: auto;
      }
      .navcolor
      {
        background-color: #721422;
      }
  </style>
</head>
<body>
    @yield('Estilos')
    <div id="app">
      <b-navbar class="navcolor sticky-top" toggleable="md" type="dark">
         <b-navbar-toggle target="nav_collapse"></b-navbar-toggle>
        <b-navbar-brand href="/"><img src="/storage/logo/logo2.png"></b-navbar-brand>
        <nav_filter></nav_filter>       
        <b-collapse is-nav id="nav_collapse">   
           <b-navbar-nav>
          <b-nav-item href="{{ route('search.index') }} ">{{ __('Busqueda Avanzada') }}</b-nav-item> 
          <categories_filter></categories_filter>
        </b-navbar-nav>     
           <b-navbar-nav left class="ml-auto">
                @if (Auth::check())
                  @if(auth()->user()->role_id==2 || auth()->user()->role_id==1)
                   <b-nav-item href="{{ route('summernote.indexForUser') }} ">{{ __('Mis Obras') }}</b-nav-item> 
                  <b-nav-item href="{{ route('summernote.create') }} ">{{ __('Crear Obra') }}</b-nav-item> 
                  @endif
               

                  @if (auth()->user()->role_id==1 || auth()->user()->role_id==3)
                    <b-nav-item-dropdown text="Administracion" right>
                       <div role="group">
                          <b-dropdown-header>Usuarios</b-dropdown-header>
                          <b-dropdown-item  href="{{ route('usuarios.index') }}">{{ __('Usuarios') }}</b-dropdown-item>
                          <b-dropdown-item  href="{{ route('summernote.index') }}">{{ __('Libros') }}</b-dropdown-item>
                          <b-dropdown-item href="{{ route('administradores.index') }}">{{ __('Administradores') }}</b-dropdown-item>                        
                        </div>

                        <div role="group" >
                                <b-dropdown-header>Denuncias</b-dropdown-header>
                                <b-dropdown-item  href="{{ route('complaintUsers.index') }}">{{ __('Denuncia a Usuarios') }}</b-dropdown-item>
                                <b-dropdown-item href="{{ route('complaintSummernotes.index') }}">{{ __('Denuncia a Libros') }}</b-dropdown-item>
                        </div>

                        <div role="group" a>
                          <b-dropdown-header >Registros</b-dropdown-header>
                          <b-dropdown-item href="{{ route('generos.index') }}">{{ __('Generos') }}</b-dropdown-item>
                          <b-dropdown-item href="{{ route('comandos.index') }}">{{ __('Comandos') }}</b-dropdown-item>
                          <b-dropdown-item href="{{ route('categorias.index') }}">{{ __('Categorias') }}</b-dropdown-item>
                          <b-dropdown-item  href="{{ route('addProfileDefault') }}">{{ __('Fotos por defecto') }}</b-dropdown-item>                            
                        </div>
                        <div role="group" >
                                <b-dropdown-header>Motivos de Denuncia</b-dropdown-header>
                                <b-dropdown-item  href="{{ route('motivos-usuario.index') }}">{{ __('Motivos-Usuario') }}</b-dropdown-item>
                                <b-dropdown-item href="{{ route('motivos-texto.index') }}">{{ __('Motivos-Texto') }}</b-dropdown-item>
                        </div>
                      </b-nav-item-dropdown>  
                  @endif
                @endif          
              </b-navbar-nav>
               <b-navbar-nav class="ml-auto">
              @guest              
                <b-nav-item href="{{ route('login') }} ">{{ __('Iniciar Sesion') }}</b-nav-item> 
                <b-nav-item href="{{ route('register') }} ">{{ __('Registrarse') }}</b-nav-item> 
              @else                
                  {{-- <b-dropdown variant="info" split right> --}}
                    <notification></notification>
                    <b-nav-item href="{{ "/usuarios/".auth()->user()->id}} ">
                      <b-img alt="Responsive image" class="imgRedondaNavbar" src="{{ Auth::user()->existPicturePerfil(auth()->user()->name_user, auth()->user()->sex) }}" ></b-img>
                    </b-nav-item>   
                  <b-nav-item-dropdown split right text="{{ Auth::user()->name_user}} ">
                    <b-dropdown-item href="{{'/usuarios/'.auth()->user()->id  }}" >{{ __('Mi Perfil') }}</b-dropdown-item>
                    <b-dropdown-item href="{{route('changePassword') }} " >{{ __('Cambiar Contraseña') }}</b-dropdown-item>
                    <b-dropdown-item href="{{ route('editUser') }} " >{{ __('Editar Perfil') }}</b-dropdown-item>
                    <b-dropdown-divider></b-dropdown-divider>
                    <b-dropdown-item  href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> {{ __('Cerrar Sesion') }}</b-dropdown-item>
                     <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;"> @csrf</form> 
                  </b-nav-item-dropdown>
               @endguest 
          </b-navbar-nav>

        </b-collapse>
      </b-navbar>
      <b-container fluid>
        @if (Auth::check() && (auth()->user()->confirmed==0 ))        
           <b-alert  class="text-center" show variant="danger">
            Aun no has verificado tu correo -> 
            <b-btn href="{{ route('register.send_mail_verify') }}"  onclick="event.preventDefault(); document.getElementById('send_mail_verify').submit();" variant="outline-danger">
              {{ __('Enviar correo de verificacion') }}
            </b-btn>
          </b-alert>
            <form id="send_mail_verify" action="{{ route('register.send_mail_verify') }}" method="POST" style="display: none;"> @csrf</form>
            @if (session('mail'))
             <b-alert class="text-center" variant="success"  dismissible show> {{ session('mail') }}</b-alert>              
            @endif
        @endif        
      </b-container>
     <div> @yield('contenido')</div>      
</div>
<div id="showContent">@yield('showContent')</div>
       <div> @yield('notVue')</div>
       <div>@yield('artyom')</div>
    <script src="{{ mix('js/app.js') }}"></script> 
    <!-- include summernote-es-ES -->
   {{--  <script src="{{ URL::asset('js/lang/summernote-es-ES.js') }}"></script> --}}

{{-- 	<footer>
    Copyrigt * {{ date('Y')}}
    <button href="/policy/cookies">Politica de Cookies</button>
  </footer> --}}
  <!-- Footer starts here -->

<footer>
    <div class="row navcolor" style="margin: 0; padding: 10px 0 10px 0; ">
      <div class="col-md-3" style="color: white;"> Copyrigt * {{ date('Y')}}</div>
      <div class="col-md-3" > <a style="color: white;" href="/policy/cookies">Politica de cookies</a></div>
      <div class="col-md-3" > <a style="color: white;" href="/policy/termsconditions">Terminos y Condiciones</a></div>
    </div>
</footer> 
</body>
</html>
