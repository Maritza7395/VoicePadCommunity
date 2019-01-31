@extends('master')
@section('showContent')
{{-- <div id="app">
	<show-content id="{{ $id }}" ></show-content>
</div> --}}
{{-- @{{row.value}} --}}
<div class="container" >
	<div id="showContent">
		<div class="col-md-10" style="width: auto; margin:auto;">
				<show-content  id="{{ $summernote->id }}"></show-content>			
		</div>
	</div>
	<nav aria-label="Page navigation example">
	  <ul class="pagination justify-content-center">
	  	{{ $papers->links()}}
	  </ul>
	</nav>
    @foreach ($papers as $paper)
        <div  class=" paper efecto2">				
				{!! html_entity_decode($paper->content) !!}
		</div>
    @endforeach
    <nav aria-label="Page navigation example">
	  <ul class="pagination justify-content-center">
	  	{{ $papers->links()}}
	  </ul>
	</nav>

</div>
@stop

<style>
	body{
		background-color: #E9E9E9 !important;
	}	
	.paper{
		background-color: white;	
		width: 80%;
		height: 1000px;
		padding: 40px;
		margin: auto;
		margin-bottom: 10px;
	}

	/* efecto 2 */
	.efecto2
	{
	  position: relative;
	}
	.efecto2:before, .efecto2:after
	{
	/* Posiciona la sobora por detras del color de la caja*/
		  z-index: -1; 
		  position: absolute;
		  /* no aplico ningun contenidos HTML */
		  content: "";
		  /* posiciona la sombra con respecto al borde inferior, izquierdo y superior */
		  bottom: 15px;
		  left: 10px;
		  top: 80%;
		  /* configura el ancho */
		  width: 50%;
	/* color de fondo */
		  background: #777;
		  /* definicion de la sombra estandar para box-shadow */
		  -webkit-box-shadow: 0 15px 10px #777;
		  -moz-box-shadow: 0 15px 10px #777;
		  box-shadow: 0 15px 10px #777;
		  /* rotacion de la sombra */
		  -webkit-transform: rotate(-3deg);
		  -moz-transform: rotate(-3deg);
		  -o-transform: rotate(-3deg);
		  -ms-transform: rotate(-3deg);
		  transform: rotate(-3deg);
	}
	.efecto2:after
	{
		  /* rotacion de la sombra */
		  -webkit-transform: rotate(3deg);
		  -moz-transform: rotate(3deg);
		  -o-transform: rotate(3deg);
		  -ms-transform: rotate(3deg);
		  transform: rotate(3deg);
		  /* posiciona la sombra con respecto al borde izquierdo y derecho */
		  right: 10px;
		  left: auto;
	}
	#form {
      width: 250px;
          margin: 0 auto;
          height: 50px;
    }
    #form p {
      text-align: center;
    }
    #form label {
      font-size: 20px;
    }
    .score {
      direction: rtl;
      unicode-bidi: bidi-override;
      text-align: left;
    }
    .star:hover,
    .star:hover ~ .star {
      color: orange;
    }
    .starCheck{
    	color: orange;
    }
</style>
