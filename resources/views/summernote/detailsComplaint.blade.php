@extends('master')

@section('contenido')
<div class="container" >
	<div id="motivations" class="justify-content-center">
		    <div class="col-md-12 justify-content-center">
		    	<div class="row">
		    		<div id="tit">
		    			<div id="txt"><h2>Detalle de Denuncias a {{ $summernote->name }}</h2></div>
		    		</div>
		    	</div>
		    </div>	
		    <br>
		    <div  id="app">
		    		<details_complaint_summernotes id="{{ $summernote->id  }}">
					</details_complaint_summernotes>
		    </div>

	</div>
</div>
@endsection