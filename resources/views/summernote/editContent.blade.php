@extends('master')
@section('artyom')
<div class="container-fluid">
	<?php
	use Carbon\Carbon;
	?>
	@foreach ($papers as $paper)  
		<div class="left">
		    <div class="item" style="font-size: 20px;margin-top: 5px;">
		        <i class="fas"><img src="https://img.icons8.com/material-rounded/25/ffffff/menu.png"></i>MENÚ
		    </div>
		    <div class="item">
		        <i class="fas"><img src="https://img.icons8.com/small/25/ffffff/visible.png"></i>
				<a href="{{ route('summernote.showContent', $paper->summernote_id ) }}" class="btn" role="button" style="color:white;
				box-shadow: none;">Vista Previa</a>
		    </div>
		    <div class="item active">
		        <i class="fas"><img src="https://img.icons8.com/ios/25/ffffff/export-pdf.png"></i>
				<a href="{{ route('exports.pdf', $paper->summernote_id ) }}" class="btn" role="button" style="color:white;
				box-shadow: none;">Exportar a PDF</a>
		    </div>
		    <div class="item">
		        <i class="fas"><img src="https://img.icons8.com/small/25/ffffff/delete-file.png"></i>
				<a data-toggle="modal" data-target="#exampleModal" class="btn" href="#" role="button" style="color:white;
				box-shadow: none;">Eliminar Hoja</a>
		    </div>
		    <div class="item form-inline">
		    	{{-- <div class="row"> --}}
		    		<i class="fas"><img src="https://img.icons8.com/small/25/ffffff/borrow-book.png" style="margin: -5px 0 0 0px;"></i>
		       		<div id="labelPublish" style="margin: 0px 0px 0 20px; cursor: pointer;"></div>
		    	{{-- </div> --}}
		    </div>
		    <div class="item">
		        <i class="fas"><img src="https://img.icons8.com/small/25/ffffff/voice-presentation.png"></i>Comandos
		    </div>
		    @foreach ($arrayCommands as $command)
						@if ($command['name'] == 'Punto' || $command['name'] == 'Punto y coma')
							<div class="item row form-group">
								<i class="fas"></i>
							<p class="col-sm-4" id="basic-addon1"><b>{{ $command['name'] }}</b></p>
						  	<input type="text" class="form-control col-sm-4" style="height: 30px;" name="customized_commands" aria-describedby="basic-addon1" value="{{ $command['description'] }}" disabled>						  	
						  </div>
						@else
							<div class="item row form-group">
								<i class="fas"></i>
					   		 <p class="col-sm-4" id="basic-addon1"><b>{{ $command['name'] }}</b></p>					  	
					 		 <input type="text" class="form-control col-sm-4" style="height: 30px;" name="customized_commands" aria-describedby="basic-addon1" value={{  $command['description'] }}>			
					 		 </div>			
						@endif
				@endforeach
				<div class="item">
		       <button type="button" class="btn btn-sm btn-info" id="editcommands">Guardar</button>
				<button type="button" class="btn btn-sm btn-info" id="resetValues">Reestablecer valores</button>
		   		 </div>
				
		    <input type="checkbox" style="display:none" id="privateCheck"  class="check"></label>
		</div>
     
<div class="row">		
		<div class="col-md-8 offset-2">
			<div class="row">
		    	<div id="tit">
		    		<div id="txt"><h2 class="text-uppercase" style="font-size: x-large;">{{ $summernote->name }}</h2></div>
		    	</div>
		    </div>
		    <br>
			<nav aria-label="Page navigation example">
			  <ul class="pagination justify-content-center">
			  	{{ $papers->links()}}
			  </ul>
			</nav>
			
				<p class="updated text-right">Ultimo Guardado : {{ \Carbon\Carbon::parse($paper->updated_at)->diffForHumans()}}</p>
			<div id="toolbar"></div>
			<br>
			<div class="form-group" id="summernote" contenteditable="true"></div
			<br>
		</div>
	</div>
   @endforeach
    <nav aria-label="Page navigation example">
	  <ul class="pagination justify-content-center">
	  	{{ $papers->links()}}
	  </ul>
	</nav>
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Eliminar Hoja</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        Si eliminas esta hoja, no podras volver a recuperarla, ¿Estas Seguro de su eliminacion?
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
	        <button type="button" class="btn btn-danger" id="deletePaper" data-dismiss="modal">Eliminar</button>
	      </div>
	    </div>
	  </div>
	</div>
</div>
{{-- <script src="moment.js"></script> --}}
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
	

// Fin de la inicializacion de Artyom -->
// <-- Inicio - Creando una serie de comandos
	var commands = {!! json_encode($arrayCommands) !!};	
	var commandsArtyom = [];
	commands.forEach(function(command){
		commandsArtyom.push(
			{
	        	indexes: [command.description],
		        action: function(){
		        	switch(command.name){
		        		case 'Negrita' : $('#summernote').summernote('bold');console.log(command.name);
		        			break;
		        		case 'Cursiva' : $('#summernote').summernote('italic');
		        			break;
		        		case 'Tachado' : $('#summernote').summernote('strikethrough');
		        			break;
		        		case 'Subrayado' : $('#summernote').summernote('underline');
		        			break;
		        		case 'Punto' : console.log("punto");
		        			break;
		        		case 'Punto y coma' : console.log("punto y coma");
		        			break;		        		
		        	}
		     	}
		    },
		);
		
	});
 	
$(document).ready(function() {
		var commands = {!! json_encode($arrayCommands) !!};
		var content = {!! json_encode($paper->content) !!};
		var id = {!! json_encode($paper->id) !!};
		var summernote_id = {!! json_encode($paper->summernote_id) !!};
		var papers= {!! json_encode($papers) !!};
		$( "#labelPublish" ).click(function() {
			 	var private = 0;
		        if($("#privateCheck").is(":checked")) {
		        	$("#privateCheck").prop('checked', false);
		        	console.log("checkeado poner publico");
		        	private= 0; //poner publico
		        	 $("#labelPublish").html('<label>Publicar</label>');
		        }
		        else{
		        	console.log("No checkeado poner privado");
		        	 $("#labelPublish").html('<label>DesPublicar</label>');
		        	$("#privateCheck").prop('checked', true);
		        	private = 1; //poner privado
		        }
		        axios.post('/publicarSummernote',{
	                idSummernote: summernote_id,
	                private : private	                
	            }).then(response =>{
	            	console.log(private);
	            	if(response.data != 0 && response.data != 1){
	            		alert(response.data);
	            		 $("#privateCheck").prop('checked', false);
	            		  $("#labelPublish").html('<label>Publicar</label>');
	            	}
	            }).catch(error =>{
	                if(error.response.status==500){
	                    alert("no se ha podido realizar esta accion");
	                }          
	            });
		});
		window.onload = function() {	
			 axios.get('/summernote/Data/'+summernote_id).then(response => {
				var summernote= response.data;
				if(summernote.private == 1){
					 $("#privateCheck").prop('checked', false);
					 $("#labelPublish").html('<label>Publicar</label>');

				}else{
					 $("#privateCheck").prop('checked', true);
					 $("#labelPublish").html('<label>DesPublicar</label>');
				}
			}).catch(error => {
				console.log(error)
			})
		}
		

		$( "#resetValues" ).click(function() {
			commands.forEach(function(command, i){
				command.description=document.getElementsByName("customized_commands")[i].value;
			});
			axios.post('/resetValues', {
				commands: commands,
			}).then(response =>{
				console.log(commands);
				window.location.reload(true);
			}).catch(error =>{
	            if(error.response.status==500){
                    alert("no se ha podido realizar esta accion");
                }          
	   		});	
			
		});

		$( "#deletePaper" ).click(function() {
			if(papers.length == 1){
				alert("Esta Hoja no puede ser eliminada");
			}
			else{
				axios.delete('/paper/'+id).then(response=>{
	                var paperss= response.data;
	                var currentPage = {{ $papers->currentPage() }}; 
		       		var total =  {{ $papers->total() }};
		       		var summernote_id =  {{ $paper->summernote_id }}; 
		       		if(total == currentPage){
		       			window.location.href = '/summernote/'+ summernote_id+'/edit/content?page='+(--currentPage);
		       		}
		       		else{
		       			window.location.href = '/summernote/'+ summernote_id+'/edit/content?page='+(currentPage);
		       		}
	                    
	            }).catch(error=>{
	                 alert("Esta Hoja no se puede eliminar");
	            })
			}
			
		});
		$( "#editcommands" ).click(function() {
			commands.forEach(function(command, i){
				command.description=document.getElementsByName("customized_commands")[i].value;
			});
			axios.post('/comandos/user', {
				commands: commands,
			}).then(response =>{
				console.log(commands);
				window.location.reload(true);
			}).catch(error =>{
	            console.log(error);
	            if(error.response.status==500){
                    alert("no se ha podido realizar esta accion");
                }

	   		});	
		});
		function Repetir() {
			setInterval(function(){ 
				axios.get('/paper/'+id).then(response => {
					var paper = response.data		
					$('.updated').html('Guardado '+paper.dateUpdated );		
				});
			}, 300000); //cada 5 minutos		
		}
		function saveContent(){
			axios.put('/paper/'+ id, {
	    		content: $('#summernote').summernote('code')
	       	}).then(response =>{
	       		var paper= response.data;
	       		$('.updated').html('Guardado '+paper.dateUpdated );
	       		Repetir();
	       		var txt = document.createElement("p");
	       		txt.innerHTML = paper.content;
	       		var words = txt.innerText.split(" ");
	       		var total =  {{ $papers->total() }};
	       		var summernote_id =  {{ $paper->summernote_id }};
	       		var txt2 = document.createElement("x");
	       		txt2.innerHTML = content;
	       		var words2 = txt2.innerText.split(" ");
	       		var total =  {{ $papers->total() }};
	       		var summernote_id =  {{ $paper->summernote_id }};
	       		var currentPage = {{ $papers->currentPage() }};
	       		console.log(words.length);
	       		if(words.length >= 750 && (words.length != words2.length)){
	       			if(currentPage == total){
	       				axios.post('/paper',{
			                idSummernote: summernote_id		                
			            }).then(response =>{
			            	window.location.href = '/summernote/'+ summernote_id +'/edit/content?page='+total;
			            }).catch(error =>{
			                console.log(error.response);
			            });
	       			}
	       			window.location.href = '/summernote/'+ summernote_id+'/edit/content?page='+(++currentPage);
	       		}
	       		
	        }).catch(error =>{
	            console.log(error)
	   		});	 
		};
		var Save = function(context) {
			var ui = $.summernote.ui;
			var button = ui.button({
				contents: '<i class="fa fa-floppy-o" style="font-size:15px;"></i>',
				tooltip: 'Guardar',
				container: false,
				//función que realizará el botón
				click: function () {						
					saveContent();

				},
			});
		    return button.render();
		};
		var NewPaper = function(context) {
			var ui = $.summernote.ui;
			var button = ui.button({
				contents: '<i class="fa fa-file-o" style="font-size:15px;"></i>',
				tooltip: 'Nueva Hoja',
				container: false,
				//función que realizará el botón
				click: function () {
					axios.get('/paper/'+id).then(response => {
						var paper = response.data.content;	
						console.log(paper);
						var text = document.createElement('div');
						text.innerHTML = paper;
						if(text.innerText.length >= 50){
							var currentPage = {{ $papers->currentPage() }};
							axios.post('/paper',{
				                idSummernote: summernote_id		                
				            }).then(response =>{
				            	window.location.href = '/summernote/'+ summernote_id+'/edit/content?page='+(++currentPage);
				            }).catch(error =>{
				                console.log(error.response)
				            });
						}
						else{
							alert("no tiene suficientes palabras para crear una nueva hoja");
						}			
					}).catch(error => {
						console.log(error)
					});
				},
			});
		    return button.render();
		};
		// <-- Inicio - Botones de Artyom
		var texto = content;
		var StartArtyom = function(context){
			var ui = $.summernote.ui;
			var button = ui.button({
				contents: '<i class="material-icons" style="font-size:16px;">mic</i>',				
				tooltip: 'Artyom',
				container: false,
				click: function () {
					artyom.addCommands(commandsArtyom);
					console.log("commands");
					console.log(commandsArtyom);
					artyom.initialize({
						lang:"es-ES",// Más lenguajes son soportados, lee la documentación
						continuous:true,// Reconoce 1 solo comando y basta de escuchar
						listen:true, // Iniciar !
						debug:true, // Muestra un informe en la consola
						speed:1, // Habla normalmente
						mode:"normal",
						executionKeyword:"ahora",
					}).then(function(){
					    console.log("Ready to work !");
					    console.log(artyom.getProperties());
					});
					$('.listen').html('Escuchando...');
					artyom.when('COMMAND_MATCHED',function(){
						artyom.redirectRecognizedTextOutput(function(recognized,isFinal){
						    if(isFinal){
						    	var arrayRecognized = recognized.split(" ");
						    	var length = arrayRecognized.length;
						    	var commandFind = false;
						    	for (var i = 0; i < arrayRecognized.length ; i++) {
						    		commands.forEach(function(command){
						    			arrayDescription = command.description.split(" ");
						    			if(arrayRecognized[i] == arrayDescription[0]){
						    				switch(command.name){
								        		case 'Negrita' :
								        			if(arrayRecognized[i+1] != 'ahora' && commandFind == false){
								        				commandFind = true;
								        				$('#summernote').summernote('bold');
								        			}
								        			else{
								        				arrayRecognized.splice(i, 2);
								        			}
								        			break;
								        		case 'Cursiva' : 
								        			if(arrayRecognized[i+1] != 'ahora' && commandFind == false){
								        				commandFind = true;
								        				$('#summernote').summernote('italic');
								        			}
								        			else{
								        				arrayRecognized.splice(i, 2);
								        			}
								        			break;
								        		case 'Tachado' : 
								        			if(arrayRecognized[i+1] != 'ahora' && commandFind == false){
								        				commandFind = true;
								        				$('#summernote').summernote('strikethrough');
								        			}
								        			else{
								        				arrayRecognized.splice(i, 2);
								        			}
								        			break;
								        		case 'Subrayado' :
								        			if(arrayRecognized[i+1] != 'ahora' && commandFind == false){
								        				commandFind = true;
								        				$('#summernote').summernote('underline');
								        			}
								        			else{
								        				arrayRecognized.splice(i, 2);
								        			}
								        			break; 
								        		case 'Punto' : 
								        			if(arrayRecognized[i+1] == 'ahora' ){
								        				arrayRecognized.splice(i, 2);
								        				arrayRecognized.push(".");
								        			}
								        			break;
								        		case 'Punto y coma' :
								        			console.log("puntilla y comilla");
								        			if(arrayRecognized[i+1] == 'y' &&  arrayRecognized[i+2] == 'coma' && arrayRecognized[i+3] == 'ahora'){
								        				arrayRecognized.splice(i, 4);
								        				arrayRecognized.push(";");
								        			} 
								        			break;
											}
						    			}
									});
						    	}
						    							    	
						    	var textFinal="";
						    	//verificando clases activadas						    	
						    	if ( $('button.note-btn-bold').hasClass('active') ) {
								 	arrayRecognized.unshift("<b>");
								 	arrayRecognized.push("</b>");
								}
								if ( $('button.note-btn-italic').hasClass('active') ) {
								 	arrayRecognized.unshift("<i>");
								 	arrayRecognized.push("</i>");
								}
								if ( $('button.note-btn-underline').hasClass('active') ) {
								 	arrayRecognized.unshift("<u>");
								 	arrayRecognized.push("</u>");
								}
								if ( $('button.note-btn-strikethrough').hasClass('active') ) {
								 	arrayRecognized.unshift("<strike>");
								 	arrayRecognized.push("</strike>");
								}
								for (var i = 0; i < arrayRecognized.length; i++) {
						    		textFinal += " " + arrayRecognized[i];
						    	}						    	
						    	console.log(textFinal);
						    	axios.get('/paper/'+id).then(response => {
						    		if(response.data.content == null){
						    			var texto =  textFinal;
						    		}
						    		else{
						    			var texto = response.data.content + " " + textFinal;
						    		}
									
							        $('#summernote').summernote('code', texto);
								}).catch(error => {
									console.log(error)
								});
								artyom.restart();
						    }
						});
					});
					artyom.when('NOT_COMMAND_MATCHED',function(){
						artyom.redirectRecognizedTextOutput(function(recognized,isFinal){
						    if(isFinal){
						    	var arrayRecognized = recognized.split(" ");
						    	var textFinal="";
						    	if ( $('button.note-btn-bold').hasClass('active') ) {
								 	arrayRecognized.unshift("<b>");
								 	arrayRecognized.push("</b>");
								}
								if ( $('button.note-btn-italic').hasClass('active') ) {
								 	arrayRecognized.unshift("<i>");
								 	arrayRecognized.push("</i>");
								}
								if ( $('button.note-btn-underline').hasClass('active') ) {
								 	arrayRecognized.unshift("<u>");
								 	arrayRecognized.push("</u>");
								}
								if ( $('button.note-btn-strikethrough').hasClass('active') ) {
								 	arrayRecognized.unshift("<strike>");
								 	arrayRecognized.push("</strike>");
								}
								for (var i = 0; i < arrayRecognized.length; i++) {
						    		textFinal += " " + arrayRecognized[i];
						    	}
						    	console.log(textFinal);
						    	axios.get('/paper/'+id).then(response => {
									if(response.data.content == null){
						    			var texto =  textFinal;
						    		}
						    		else{
						    			var texto = response.data.content + " " + textFinal;
						    		}
							        $('#summernote').summernote('code', texto);
								}).catch(error => {
									console.log(error)
								});
								artyom.restart();
						    }
						});
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
					$('.listen').html(' ');
					 artyom.fatality().then(() => {
				        console.log("Artyom succesfully stopped !");
				    });
				},
			});
		    return button.render();
		};

// Fin - Botones Artyom -->
		
		$('#summernote').summernote({
		    disableResizeEditor: true,
		    tabsize: 2,
			lang: 'es-ES',
			// height: ($(window).height() - 250),
			height: 1000,
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
			    newPaper: NewPaper,
			    artyom: StartArtyom,
			    stop: StopArtyom
			},
			toolbar: [
			    // [Nombre del grupo de botones, [nombre del boton creado ej: 'save']]
			    ['fontsize', ['save', 'newPaper', 'artyom', 'stop']],
			    ['style', ['bold', 'italic', 'underline', 'clear']],
			    ['font', ['strikethrough', 'superscript', 'subscript']],
			    ['fontname', ['fontname', 'fontsize', 'color']],
			    // ['color', []],
			    ['para', ['ul', 'ol', 'paragraph', 'height']],
			    // ['height', []],
			    // ['table', []],
			    ['insert', ['table', 'link', 'picture']],
	      		['view', ['fullscreen', 'undo', 'redo']]
			],
			callbacks: {
                onChange: function() {
          			saveContent();
          			if ( $('button.note-btn-bold').hasClass('active') ) {
					   // console.log('momo');
					  }
			    },

            }
			
	 	});
	 	//Aquí traemos el contenido de la base de datos y lo convertimos
		$('#summernote').summernote('code', content);
	});
</script>
@endsection
@section('Estilos')
<style >
	.switch {
	  position: relative;
	  display: inline-block;
	  width: 60px;
	  height: 34px;
	}

	/* Hide default HTML checkbox */
	.switch input {display:none;}

	/* The slider */
	.slider {
	  position: absolute;
	  cursor: pointer;
	  top: 0;
	  left: 0;
	  right: 0;
	  bottom: 0;
	  background-color: #ccc;
	  -webkit-transition: .4s;
	  transition: .4s;
	}

	.slider:before {
	  position: absolute;
	  content: "";
	  height: 26px;
	  width: 26px;
	  left: 4px;
	  bottom: 4px;
	  background-color: white;
	  -webkit-transition: .4s;
	  transition: .4s;
	}

	.check:checked + .slider {
	  background-color: #2196F3;
	}

	.check:focus + .slider {
	  box-shadow: 0 0 1px #2196F3;
	}

	.check:checked + .slider:before {
	  -webkit-transform: translateX(26px);
	  -ms-transform: translateX(26px);
	  transform: translateX(26px);
	}

	/* Rounded sliders */
	.slider.round {
	  border-radius: 34px;
	}

	.slider.round:before {
	  border-radius: 50%;
	}
	.material-icons.md-10 { font-size: 13px; }


	.note-toolbar{
		background-color: #17a2b8;
	}


	.left,
    .right {
        top: 50%;
        float: left;
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
        width: 300px;
        transition: width 1s;
        border-style: solid;
        border-color: #ccc;
        border-width: 1px;
    }

    .left:hover {
        width: 300px;
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
	/*.note-editor.note-frame .note-editing-area .note-editable {
	    overflow: auto;
	    height: 1000px !important
	    data-limit-rows: 2;
	}*/
</style>
@endsection