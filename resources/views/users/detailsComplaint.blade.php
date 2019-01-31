@extends('master')

@section('contenido')
<div class="container" >
	<div id="motivations" class="justify-content-center">
		    <div class="row">
		    	<div id="tit">
		    		<div id="txt"><h2>Detalle de Denuncias a {{ $user->name_user }}</h2></div>
		    	</div>
		    </div>
		    <br>
		    <div  id="app">
		    		<details_complaint_users id="{{ $user->id  }}">
					</details_complaint_users>
		    </div>
		    <div class="col-sm-5">
		        
		    </div>
	</div>
</div>
@endsection