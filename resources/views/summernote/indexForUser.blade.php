@extends('master')
@section('contenido')
<div id="app">
	<div id="users" class="center-block col-md-10">
		    {{-- <div class="justify-content-center">
		    	<h1 class="" style="text-align: center">Administracion de Usuarios</h1>
		    </div> --}}
		    <div  id="app">
		    		<index_for_user id="{{ $id }}" ></index_for_user>
		    </div>
		    <div class="col-sm-5">
		        
		    </div>
	</div>
	
</div>
@endsection 