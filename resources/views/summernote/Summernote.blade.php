@extends('master')
@section('contenido')
<div class="container-fluid">
	<br>
	<div class="row">
		<h1></h1>
		<div class="col-md-2"></div>
		{{-- editor de texto --}}
		<div class="col-md-8">
			<div id="toolbar"></div>
			<br>
			<textarea class="form-group" id="summernote"></textarea>
		</div>		
		<div class="left">
		    <div class="item">
		        <i class="fas fa-fw fa-bars"></i>
		    </div>
		    <div class="item active">
		        <i class="fas fa-fw fa-map-marked-alt"></i> Map
		    </div>
		    <div class="item">
		        <i class="fas fa-fw fa-columns"></i> Split
		    </div>
		    <div class="item">
		        <i class="fas fa-fw fa-th"></i> Grid
		    </div>
		    <div class="item">
		        <i class="fas fa-fw fa-user-circle"></i> Dash
		    </div>
		</div>
	</div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
<script type="text/javascript">
// <-- Inicio del menu lateral
	function openNav() {
	    document.getElementById("mySidenav").style.width = "250px";
	}

	function closeNav() {
	    document.getElementById("mySidenav").style.width = "0";
	}
// Fin del menu lateral -->

// <-- Inicio de Artyom
	const artyom = new Artyom();
	artyom.initialize({
		    lang:"es-ES",// Más lenguajes son soportados, lee la documentación
		    continuous:false,// Reconoce 1 solo comando y basta de escuchar
		    listen:true, // Iniciar !
		    debug:true, // Muestra un informe en la consola
		    speed:1, // Habla normalmente
		    mode:"normal",
		    name: "Eva"
		}).then(function(){
		    console.log("Ready to work !");
		    console.log(artyom.getProperties());
		});
// Fin de la inicializacion de Artyom -->
	$(document).ready(function() {
		var content = {!! json_encode($summernote->content) !!};
		var id = {!! json_encode($summernote->id) !!};
// <-- Inicio - Creando el boton guardar
		var Save = function(context) {
			var ui = $.summernote.ui;
			var se = "Guardado Exitosamente";
			var button = ui.button({
				contents: '<i class="fa fa-floppy-o" style="font-size:15px;"></i>',
				tooltip: 'Guardar',
				container: false,
				//función que realizará el botón
				click: function () {
					axios.post('/summernoteContenido/'+ id, {
			    	content: $('#summernote').summernote('code')
			       	}).then(response =>{
			           	console.log(response.data);
			           	alert(se);
			        }).catch(error =>{
			            console.log(error.response)
			            if(error.response.status==422){
			                this.errorsCreate=error.response.data.errors
			           	}
			   		});	   
				},
			});
		    return button.render();
		};
// Fin -->
// <-- Inicio - Botones de Artyom
		var texto = content;
		var StartArtyom = function(context){
			var ui = $.summernote.ui;
			var button = ui.button({
				contents: '<i class="material-icons" style="font-size:16px;">mic</i>',				
				tooltip: 'Artyom',
				container: false,
				click: function () {
					artyom.say("te escucho");
					artyom.redirectRecognizedTextOutput(function(recognized,isFinal){
					    if(isFinal){
					        console.log("Texto final reconocido: " + recognized);
					        texto += recognized;
					        $('#summernote').summernote('code', texto);

					    }else{
					        console.log(recognized);
					    }
					    
					});
				},
			});
		    return button.render();
		};
		var StopArtyom = function(context){
			var ui = $.summernote.ui;
			var button = ui.button({
				contents: '<i class="material-icons" style="font-size:16px;">mic_off</i>',				
				tooltip: 'Artyom',
				container: false,
				click: function () {
					artyom.say("ya no te escucho");
					UserDictation.stop();
				},
			});
		    return button.render();
		};
// Fin - Botones Artyom -->
		$('#summernote').summernote({
			lang: 'es-ES',
			height: ($(window).height() - 250),
			toolbarContainer: '#toolbar', //separa el toolbar en otro div
			tabsize: 2,
			placeholder: 'Write here...',
			focus: true,
			codemirror: {
			    mode: 'text/html',
			    htmlMode: true,
			    lineNumbers: true
			},
			buttons: {
			    save: Save, //ponemos nombre del toolbar, y la variable del boton
			    artyom: StartArtyom,
			    stop: StopArtyom
			},
			toolbar: [
			    // [Nombre del grupo de botones, [nombre del boton creado ej: 'save']]
			    ['height', ['save', 'artyom', 'stop']],
			    ['style', ['bold', 'italic', 'underline', 'clear']],
			    ['font', ['strikethrough', 'superscript', 'subscript']],
			    ['fontname', ['fontname']],
			    ['fontsize', ['fontsize']],
			    ['color', ['color']],
			    ['para', ['ul', 'ol', 'paragraph']],
			    ['table', ['height']],
			    ['insert', ['table', 'link', 'picture']],
	      		['view', ['fullscreen', 'undo', 'redo']]
			],
	 	});
	 	//Aquí traemos el contenido de la base de datos y lo convertimos
		$('#summernote').summernote('code', content);
	});
// <-- Inicio - Creando una serie de comandos
	var bold = "sombra";
	var italic = "cursiva";
	var underline = "subraya";
	var strikethrough = "casa";
	var punto = "punto";
 	artyom.addCommands([
    	{
        	indexes: [bold],
	        action: function(){
	            console.log("entro");
		        $('#summernote').summernote('bold');
		        artyom.say("negrita activado");
	     	}
	    },
	    {
	        indexes: [italic],
	        action: function(){
	            console.log("entro");
		        $('#summernote').summernote('italic');
		        artyom.say("cursiva activado");
	        }
	    },
	    {
	        indexes: [underline],
	        action: function(){
	            console.log("entro");
		        $('#summernote').summernote('underline');
		        artyom.say("subrayado activado");
	        }
	    },
	    {
	        indexes: [strikethrough],
	        action: function(){
	            console.log("entro");
		        $('#summernote').summernote('strikethrough');
		        artyom.say("tachado activado");
	        }
	    },
	    {
	        indexes: [punto],
	        action: function(){
	            console.log("entro");
		        $('#summernote').summernote('insertText', '.');
		        artyom.say("punto insertado");
	        }
	    }
	]);
// Fin -->
</script>
@endsection
@section('Estilos')
<style>
.left,
    .right {
        top: 50%;
        float: left;
        transform: translateY(125%);
    }

    .left {
        background: #337ab7;
        display: inline-block;
        white-space: nowrap;
        width: 50px;
        transition: width .5s;
    }

    .right {
        background: #fff;
        width: 350px;
        transition: width 1s;
        border-style: solid;
        border-color: #ccc;
        border-width: 1px;
    }

    .left:hover {
        width: 250px;
    }

    .item:hover {
        background-color: #222;
    }

    .left .fas {
        margin: 15px;
        width: 20px;
        color: #fff;
    }

    i.fas {
        font-size: 17px;
        vertical-align: middle !important;
    }

    .item {
        height: 50px;
        overflow: hidden;
        color: #fff;
    }
</style>
@endsection