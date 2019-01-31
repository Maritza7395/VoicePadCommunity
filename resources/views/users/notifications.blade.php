@extends('master')

@section('contenido')
<div class="container" >
	<br>
	<div id="users" class="justify-content-center">
		    <div class="row">
		    	<div class="col-md-8 offset-md-2"  id="tit">
		    		<div id="txt"><h2>Notificaciones</h2></div>
		    	</div>
		    </div>
		    <div id="app">
		    	<notification-index></notification-index>
		    </div>
	</div>
</div>
@endsection