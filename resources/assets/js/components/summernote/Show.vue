	<template>
	<form action="" >
		<div class="container">
			<br>
			<div class="row">
				<div class="col-md-4">
					<b-card no-body>
						<h4 slot="header" class="text-center">Datos del Libro</h4>
						<b-list-group class="text-center" flush>							
							<b-list-group-item><!-- autor -->
								<b-img center fluid alt="Responsive image" class="imgCircular" :src='userSummernote.route'/>
								<a :href="'/usuarios/'+userSummernote.id">{{userSummernote.name_user}}</a>
							</b-list-group-item>
							<b-list-group-item>
								<b-img center alt="Responsive image" width="140" height="200" :src='summernote.route'/>
							</b-list-group-item>
							<b-list-group-item v-if="(userAuth.id != summernote.user_id) && (userAuth.role_id !== 3)">
								<span class="navbar-text"  @click="favorite" >
									 <a class="nav-link" href="#" v-if="favorited == true"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAIWSURBVEhL7VY7SxxhFJ2EoBILHyAWFmmCrvfbXYXFzDfLkiWQwkJSWfgDBJWIpY2NnaQQrFOZpImQpAkIks1+s7tRAhFiYbOlWiwpxEYUAj7Ot3vxsbk+FmdEMAdOMTPn3jNz75074/zH/UQhFWsxOjpqPPrse+qn79EPX9MH46mh1UTiMctOkHGj7b4XnYD+S0WvCtDO43jQpNOPWHY5jKvGYLKD4COJRqsNJB2w2iPHeehrNYkb25W0ltAWc17383Lyi2A0zUnB1USyQ2jH8UTvpOvVhO6vrRbbnEdO04gUFBRhvmeS1Mt2FZh0TzPuaFsKCJKoUpYtK0DfhiVhGMz3RTrZFsYeLUiiMGiHl23LQ7UsiUKhVjNsWzbOiqIQiFmaZlvHwXv7XhKFQTtPbAtjV01JojBoXEqxrR2uaEQShcCS3XZsWwHW3qogDJTo7yzbncLo7peSODBi/+dTvW1sdx64+EkMCoA5j16zzb/4lkg0oRxFKfAmxIL6iN4+YBsZdqVBXKoOvgEL0jdcxPdkrAvDtiUkqYl2MS3F442c9nrI6J4O9PyXlPA6RMvmF/uf1nO62mDSTxqwW99KiS+kVvuXDlIt8F16hbL9EY3OUqvf+WdEHBYMyj90mr5KhijrASb3zTpRHcuDhX0l7PfU/sacmtKmn1QvWBIubDnx9Gt24axoauXTtwM7sVcuhbsHxzkGXv4jnw6Gu7sAAAAASUVORK5CYII="><span class="sr-only">(current)</span></a>
									  <a class="nav-link" href="#" v-else><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAALdSURBVEhL7ZZLaFNBFIbj+7lQUUFFuqltMpMmxbRm5rYaXelCRNSADwQFRcX6wJ2IGxfqRhR0IV2oCCotuvUBJnNv0lZBEcSKVnElKr6o4vuF/ufe00jQPGpz3egHQzh/zj1n5sy5cyfwn3+TbHPdeKPCG40W52wtr2JkbSVO2lokzy+oHsFuObqUmGCUaHH9lbxC/kbLE7CXmURiKLsVx8TlJiTpxYO3jZL7jSXW2zq8FcEOI/hTjAe2JeeR7/dAYJCjxWb4viZ/+Ox1lNjgTUIehf0Evz2ODs1xgxcCDxzCql5hpisoKMs5rsdiw+CzE6v6gIDLyR/jmdGhxeySR5dSo+C7B+Mj+bOcD82UkqaaZJSlgthxsQhV+eomVaKa5YIg6Wos5h2qV8+Sh0lEx+HPlwi2kqWS2HG5C9syl82SYNWtmGSaTQ/s5Tokvve78laKyyo6DTm+ZRqDNSxRKUQbxANs+gYqeo2al023qTqpc9n0DXR5O0q+j00vMUYLm75BlaVXjk23BGfzZuITSJpFP21n053JbggpNn2hW4jh9ErlHSaOCs7Eqr906shklioOXr8lWPELmgBLHljxDT/LjcOpA+Mgmz/B67QQpXifagpJliqGiYs1SPq2w6qdylI+KMVxJL9pElUjWRowdjw0A5V8g7hrWfoVkxBjsdd34dTWnkwOYfmPyTTXT0LSbozTLBUmZdXVYr8fYQJnBpKck95CLAdftdEsF8ctjxYPkfwiXQpYLpvMLCGwbfcRwy47aR8pHaqiTkfT9RgdDLNckrQll3p7Kk/R95jl/uF9yHHloQ+/EluKfb0uRSJj4NeK/viM1W5jeWDgkrAKE+hFwAvO7OAUlnNAb6TKwOeOscINLFcGp0FOp2MVSZ73XXWo+dwLgZaf8N+Rfu9nuaDUg3Ht2UGlxzhGpxESPk5rOZ9d/IWazT1ocJ01sZqJLP8d6H7t51XJJwKBH40rM2HGTemkAAAAAElFTkSuQmCC"><span class="sr-only">(current)</span></a>

								</span>
		    
								<b-dropdown v-if="dropdownActived "  v-model="selected" variant="outline-danger" :text="textDrop">
									<div class="myDropDown">
										<div v-for="motivation in motivations">
											<b-dropdown-item  @click="selectedMotiv(motivation)">{{ motivation.name }}</b-dropdown-item>
										</div>					
									</div>
								</b-dropdown>	            			
							</b-list-group-item>
							<b-list-group-item v-if="userAuth.id != summernote.user_id">
							<b-form-group  label="Calificalo">
						      <b-form-radio-group  :disabled="scored" class="score" buttons  button-variant="invisible" id="radios2" v-model="selectedCalification" name="radioSubComponent">
						        <b-form-radio v-bind:class="[selectedCalification >= 5 ? starCheck :'', scored == false ? 'star' :'']" value="5" >★</b-form-radio>
						        <b-form-radio v-bind:class="[selectedCalification >= 4 ? starCheck:'', scored == false ? 'star' :'']"  value="4" >★</b-form-radio>
						        <b-form-radio v-bind:class="[selectedCalification >= 3 ? starCheck:'', scored == false ? 'star' :'']"  value="3" >★</b-form-radio>
						        <b-form-radio v-bind:class="[selectedCalification >= 2 ? starCheck:'', scored == false ? 'star' :'']"  value="2">★</b-form-radio>
						        <b-form-radio v-bind:class="[selectedCalification >= 1 ? starCheck:'', scored == false ? 'star' :'']" value="1">★</b-form-radio>				        
						      </b-form-radio-group>
						      <b-btn @click="scoreSummernote" :disabled="scored" >{{ btnScore }}</b-btn>
						    </b-form-group>
							</b-list-group-item>			
						</b-list-group>
						<b-card-body class="card-text margin">
							<p><b>Titulo:</b> {{summernote.name}}</p>
							<p><b>Autor:</b> {{userSummernote.name_user}}</p> 
							<div v-if="summernote.status==0">
								<p><b>Estado:</b> En Proceso</p>
							</div>
							<div v-else>
								<p><b>Estado:</b> Completado</p>
							</div>
							<div v-if="summernote.rating==0">
								<p><b>Mayor de 18:</b> No</p>
							</div>
							<div v-else>
								<p><b>Mayor de 18:</b> Si</p>
							</div>
							<p><b>Creado el:</b> {{summernote.created_at}}</p>
							<p><b>Ultima actualizacion:</b> {{ moment(summernote.updated_at).format('DD/MM/YYYY')}}</p>
							<label><b>Genero:</b></label>
						  	<b-badge pill variant="warning" style="margin-right: 6px;">{{summernote.genre.name}}</b-badge>	
							<p><b>Calificacion:</b> {{Math.round(summernote.score)}}<img src="https://img.icons8.com/color/16/000000/filled-star.png"></p>
							<!-- <p><b>Categorias:</b></p>
							<div v-for="category in summernote.categories">
								<p>{{ category.name }}</p>
							</div> -->
							<label><b>Categoria(s):</b></label>
			  				<b-badge pill variant="success"  v-for="category in summernote.categories" key="category.id" style="margin-right: 6px;">{{ category.name }}</b-badge>	
			  				<br>
							<b-button id="search" :href="'/summernote/'+summernote.id+'/leer'" class="btn btn-primary marginbutton">Leer</b-button>
						</b-card-body>
					</b-card>
				</div>
				<div class="col-md-6">
					<b-row >
						<b-col cols="12">
							<b-card >
								<h4 slot="header" class="text-center">Sinopsis</h4>
								<label class="text-justify">{{summernote.abstract}}</label>
							</b-card>
						</b-col>						
					</b-row>
					<br>
					<b-row>

						<!-- <comment :id="id"></comment> -->
						<b-col cols="12">
							<b-card >
							<h4 slot="header" class="text-center">Comentarios</h4>
							 <b-list-group   flush>
					            <b-list-group-item  v-for="(comment , i) in summernote.comments" :key="i" v-if='comment.comment !== null' >
					            	<b-row >
					            		<b-col cols="2">
					            			<b-btn variant="link" :href="'/usuarios/'+comment.id" >
					            				<b-img width="35" left class="imgCircularComentario" :src='comment.routePictureUser'/>
					            			</b-btn>
					            			<p class="text-center" style="font-size: 10px;">{{comment.name_user}}</p>
					            		</b-col>
					            		<b-col cols="10">
					            			<b-row>
					            				<p class="card-text col-md-10 ">{{ comment.comment.description }}</p>
					            				<!-- <b-btn class="col-md-2" variant="link"><i class="material-icons sm">list</i></b-btn> -->
													<div class="btn-group dropright" v-if="comment.comment.user_id == userAuth.id || userAuth.id == summernote.user_id" >
														  <button type="button" class="btn btn-link dropdown-toggle center" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
														    <span><i class="material-icons ">list</i></span>
														  </button>
														  <div class="dropdown-menu"  >
														     <b-dropdown-item-button @click="deleteCommentGeneral(comment.comment.id)" lhref="#">Eliminar</b-dropdown-item-button>
										    				<b-dropdown-item-button v-if="comment.comment.user_id == userAuth.id " @click="infoEditCommentGeneral(comment.comment)" href="#">Editar</b-dropdown-item-button>
														  </div>
													</div>					            				
					            			</b-row>
					            			<b-button @click.stop="infoShowResponses(i)" v-if="comment.comment.comments_reponse.length" size="sm" variant="link">Ver Respuestas</b-button>
					            			<b-button @click.stop="infoShowAnswer(i)" size="sm" variant="link">Responder</b-button>
					            			<small class="text-muted rigtht"  >{{ comment.comment.date }}</small>
					            			<b-collapse :id="'answer'+i" class="mt-2"><!-- Responder comentario -->
													<b-list-group-item  action exact-active-class exact >
										            	<b-form inline >
										            		<b-btn variant="link" :href="'/usuarios/'+userAuth.id" >
												            	<b-img width="35" center class="imgCircularComentario" :src='userAuth.route'/>

												            </b-btn>								            		
													      	<b-input-group class="col-md-9" >
													      		 <b-form-textarea style="resize: none;"  v-model="commentResponse[i]" placeholder="Comentar..."></b-form-textarea>
															   <!-- 	<b-input  center v-model="commentResponse[i]"	type="text" placeholder="Escribe una respuesta" /> -->
															    <b-input-group-append>
															      <b-button center size="sm" @click.stop="saveCommentResponse(comment.comment.id , i)" variant="primary">Responder</b-button>
															    </b-input-group-append>
															  </b-input-group>
													    </b-form>
										            </b-list-group-item>
										     </b-collapse>
					            			<b-collapse :id="'collapse'+i" class="mt-2">
													<b-list-group-item action v-for="(response , index) in comment.comment.comments_reponse" v-if="response.user !== null" :key="index" >
														<b-row>
															<b-col cols="3">
																<b-btn variant="link" :href="'/usuarios/'+response.user_id" >
										            				<b-img width="35" left class="imgCircularComentario" href="momo" :src='response.user.routePictureUser'/>
										            			</b-btn>		
										            			<p class="text-center" style="font-size: 10px;">{{response.user.name_user}}</p>
							            					</b-col>
							            					<b-col cols="9">
							            						<b-row>
										            				<p class="card-text col-md-9 ">{{ response.description }}</p>
										            				<!-- <p class="card-text col-md-10 ">{{ comment.comment.description }}</p> -->
										            				<!-- <b-btn class="col-md-2" variant="link"><i class="material-icons sm">list</i></b-btn> -->
																	<div class="btn-group dropright" v-if="response.user_id == userAuth.id || userAuth.id == summernote.user_id " >
																		  <button type="button" class="btn btn-link dropdown-toggle center" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
																		    <span><i class="material-icons ">list</i></span>
																		  </button>
																		  <div class="dropdown-menu"  >
																		     <b-dropdown-item-button  @click="deleteCommentResponse(response.id)" lhref="#">Eliminar</b-dropdown-item-button>
														    				<b-dropdown-item-button v-if="response.user_id == userAuth.id " @click="infoEditCommentResponse(response)"  href="#">Editar</b-dropdown-item-button>
																		  </div>
																	</div>
										            			</b-row>
							            						

							            						<small class="text-muted rigth"  >{{ response.date }}</small>
							            					</b-col>
														</b-row>
													</b-list-group-item>
										     </b-collapse>
					            		</b-col>					            		 
					            	</b-row>
					            </b-list-group-item>
					            <b-list-group-item action>					            	
					            	<b-form inline >
					            		<b-btn variant="link" :href="'/usuarios/'+userAuth.id" >
										    <b-img width="35" center class="imgCircularComentario" :src='userAuth.route'/> 
										</b-btn>
								      	<b-input-group class="col-md-9" >
										   	<!-- <b-input size="sm" center v-model="generalComment"
					            				type="text"
					                  			placeholder="Escribe un comentario" /> -->
					                  		 <b-form-textarea style="resize: none;" v-model="generalComment"  placeholder="Escribe un comentario" ></b-form-textarea>
										    <b-input-group-append>
										      <b-button center size="sm" @click="saveGeneralComment()" variant="primary">Comentar</b-button>
										    </b-input-group-append>
										  </b-input-group>
								    </b-form>
					            </b-list-group-item>
					        </b-list-group>
							</b-card>
						</b-col>
					</b-row>
				</div>
			</div>
		</div>
		<b-modal ref="modalEditCommentGeneral" id="modalEditCommentGeneral" @ok="editCommentGeneral(modalEditCommentGeneral.commentGeneral.id)" @hide="resetModals()" title="Editar"  >
            <b-container fluid>
                	<b-form-textarea style="resize: none;"  v-model="modalGeneralComment"  placeholder="Escribe un comentario" >             		
                	</b-form-textarea>
            </b-container>            
        </b-modal>
        <b-modal ref="modalEditCommentResponse" id="modalEditCommentResponse" @ok="editCommentResponse(modalEditCommentResponse.commentResponse.id)" @hide="resetModals()" title="Editar"  >
            <b-container fluid>
                	<b-form-textarea style="resize: none;"  v-model="modalResponseComment"  placeholder="Escribe un comentario" >             		
                	</b-form-textarea>
            </b-container>            
        </b-modal>
        <b-modal id="modalPlagio" no-close-on-backdrop  ref="modalPlagio" title="Especifique cual es el plagio que infringe este texto (Especifique claramente)"   @ok="handleOkPlagio" @cancel="hideCancel">
		      <b-container fluid>
                	<b-form-textarea v-model="description_plagio"  placeholder="Especifique: Autor, Obra y/o link de la obra plagiada" >             		
                	</b-form-textarea>
            </b-container>    
		</b-modal>
		<b-modal id="modalMayor" no-close-on-backdrop  ref="modalMayor" title="Contenido Para mayores de 18 años"   @ok="handleOkMayor" @cancel="hideCancel">
		      <b-container fluid>
                	<p>¿Estas seguro de realizar esta Denuncia?</p>
            </b-container>    
		</b-modal>
        <b-modal id="modalGenre" no-close-on-backdrop  ref="modalGenre" title="Selecciona el Genero al que este libro deberia pertenecer"   @ok="handleOkGenre" @cancel="hideCancel">
		      <b-form-radio-group id="radioGenre" v-model="selected_genre_name_complaint" name="radioGenre">
		      	<b-col cols="*">
					<b-form-radio v-for="genre in genres" :key="genre.id" :value="genre.name" v-if="summernote.genre.id != genre.id" >{{ genre.name }}</b-form-radio>
				</b-col>
		      </b-form-radio-group>	
		</b-modal>
	</form>


</template>

<script>
	// var bus = new Vue()
	// import comment from './Comments.vue'
	export default{
		props: ['id'],
		mounted(){
			this.getSummernote();
			this.getUserScoreSummernote();
			this.getUserFavoriteSummernote();
			this.getMotivationSummernote();
			// this.getUserComplaintSummernote();
			this.getUserAuth();
			this.getGenres();
			// this.motivationsDeleted();
		},
		data(){
			return{
				modalGeneralComment:'',				
				modalEditCommentGeneral: {
					commentGeneral:{}
				},
				modalResponseComment:'',				
				modalEditCommentResponse: {
					commentResponse:{}
				},
				generalComment:'',
				commentResponse:[],
				//COMENT....................................
				textDrop:'Denunciar',
				dropdownActived:true,
				selected:null,
				motivations:[],
				genres:[],
				selected_genre_name_complaint:0,
				description_plagio:'',
				scored:false,
				favorited:false,
				btnScore:'Calificar',
				selectedCalification:0,
				motivations_user:[],
				starCheck:'starCheck',
				summernote:{
					name:'',
					abstract:'',
					status: '',
					created_at: '',
					updated_at: '',
					user_id:0,
					route:'',
					rating:0,
					genre:0,
				},
				userSummernote:{
					id:0,
					name:'',
					name_user:'',
					last_name: '',
					about_name:'',
					name_user: '',
					email:'',
					route:''
				},
				userAuth:{
					id:0,
					name:'',
					name_user:'',
					last_name: '',
					about_name:'',
					name_user: '',
					email:'',
					route:'',
					role:0,

				}
			}
		},
		methods:{
			//////////////////////////////////COMENTARIOS//////////////////////////////////////////////////////////////////////////
			motivationsDeleted(){
				var motivations = this.motivations;	
				var cont = 0;			
				for (var x = 0 ; x < this.motivations_user.length; x++) {
					for (var i = 0 ; i < this.motivations.length; i++) 	{					
						if(this.motivations_user[x]['pivot']['motivation_text_id'] == this.motivations[i]['id']){
							motivations.splice(i, 1);
						}
					}
				}
				for (var i = 0 ; i < this.motivations.length; i++){						
					if((this.motivations[i]['id'] == 3) && (this.summernote.rating == 1)){
						motivations.splice(i, 1);
					}
				}								
				this.motivations = motivations;
				if(this.motivations.length == 0){
					this.dropdownActived = false;
				}

			},
			deleteCommentGeneral(idCommentGeneral){
				axios.delete('/comentarios/'+idCommentGeneral).then(response=>{
	                console.log(response);
	                this.getSummernote();
	            }).catch(error=>{
	                console.log(error);	                
	            })			
	        },
			deleteCommentResponse(idCommentResponde){
				axios.delete('/comentarios_respuesta/'+idCommentResponde).then(response=>{
	                console.log(response);
	                this.getSummernote();
	            }).catch(error=>{
	                console.log(error);	                
	            })	
			},
			infoEditCommentGeneral(comment, index, button){
	          	this.modalEditCommentGeneral.commentGeneral = comment
	          	this.modalGeneralComment=comment.description
	          	this.$root.$emit('bv::show::modal', 'modalEditCommentGeneral', button)
			},
			infoEditCommentResponse(commentResponse, index, button){
	          	this.modalEditCommentResponse.commentResponse = commentResponse
	          	this.modalResponseComment=commentResponse.description
	          	this.$root.$emit('bv::show::modal', 'modalEditCommentResponse', button)
			},
			editCommentGeneral: function(idComment){
				console.log(idComment);
				if(this.modalGeneralComment == '')
				{
					this.$refs.modalEditCommentGeneral.hide();
				}	
				else{
					axios.put('/comentarios/'+idComment,{
		                description:this.modalGeneralComment
		            }).then(response =>{
		                this.$refs.modalEditCommentGeneral.hide();
		                this.getSummernote();
		            }).catch(error =>{
		                console.log(error.response.status);
		            });
				} 
	        },
	        editCommentResponse: function(idComment){
				console.log(idComment);
				if(this.modalResponseComment == '')
				{
					this.$refs.modalEditCommentResponse.hide();
				}	
				else{
					axios.put('/comentarios_respuesta/'+idComment,{
		                description:this.modalResponseComment
		            }).then(response =>{
		                this.$refs.modalEditCommentResponse.hide();
		                this.getSummernote();
		            }).catch(error =>{
		            	console.log(error)
		            });
				} 
	        },
	        resetModals () {
	          this.modalEditCommentGeneral.commentGeneral=''
	          this.modalGeneralComment=''
	          this.modalEditCommentResponse.commentResponse=''
	          this.modalResponseComment=''
	        },
			 infoShowResponses (item, button) {
			 	console.log(item)
		          this.$root.$emit('bv::toggle::collapse', 'collapse'+item, button)
	        },
	        infoShowAnswer (item, button) {
			 	console.log(item)
		          this.$root.$emit('bv::toggle::collapse', 'answer'+item, button)
	        },		
			saveGeneralComment (evt) {
				if(this.generalComment != ""){ //verificacion de que se ah escrito un comentario
					axios.post('/comentarios',{
		                idSummernote: this.id,
		                description:this.generalComment
		            }).then(response =>{
		                this.getSummernote();
		                this.generalComment="";
		            }).catch(error =>{
		                console.log(error.response)
		                alert('No tiene autorizacion para comentar');
		            });
				}		      
		    },
		    saveCommentResponse(idComment, index, button){
		    	console.log(this.commentResponse[index])
		    	if(this.commentResponse[index] != ""){ //verificacion de que se ah escrito un comentario
					axios.post('/comentarios_respuesta',{
		                idComment: idComment,
		                description:this.commentResponse[index]
		            }).then(response =>{
		                this.getSummernote();
		                this.commentResponse[index]="";
		            }).catch(error =>{
		                console.log(error.response)
		                alert('No tiene autorizacion para comentar'); 
		            });
				}		
		    },
		    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		    setComplaint(idMotivation,description){
		    	axios.post('/complaintSummernotes',{
	                idSummernoteComplaint:this.id,
	                idMotivation:idMotivation,
	   				description:description,
	            }).then(response =>{
	            	// this.dropdownActived=false;
	            	console.log(response); 
	            	this.motivations_user=response.data;
					this.motivationsDeleted();
	            }).catch(error =>{
	            	console.log(error.response.data.message);
	            	if(error.response.status == 404){
	            		if(error.response.data.message == 'Unauthenticated'){
	            			alert("Logeate o Registrate")
	            		}
	            		else{
	            			alert("No tienes autorizacion para realizar esta accion");
	            		}
	            	}
	            	else{
	               		alert("No se ah podido realizar esta accion")
	               	}
	            });	
		    },
			selectedMotiv(motivation){
				if(motivation.name == 'Genero Incorrecto'){
					this.selected_genre_name_complaint = '';
					this.$root.$emit('bv::show::modal', 'modalGenre');
				}
				else if(motivation.name == 'Plagio'){
					description_plagio:'';
					this.$root.$emit('bv::show::modal', 'modalPlagio');
				}
				else if(motivation.name == '+18' ){
					this.$root.$emit('bv::show::modal', 'modalMayor');
				}						
			},
			handleOkPlagio(evt) {
				if(this.description_plagio !== ''){
					this.setComplaint(1,this.description_plagio);
				}	
				this.selected_genre_name_complaint = '';
		    	this.description_plagio = '';
				this.$refs.modalPlagio.hide();	       
		    },
			handleOkGenre (evt) {
				if(this.selected_genre_name_complaint !== ''){
					this.setComplaint(2,'Genero Recomendado : '+this.selected_genre_name_complaint);
				}
				this.selected_genre_name_complaint = '';
		    	this.description_plagio = '';
		       	this.$refs.modalGenre.hide();
		    },
		    handleOkMayor (evt) {
		    	this.setComplaint(3,'Este Libro deberia ser para mayores de 18 años');				
				this.selected_genre_name_complaint = '';
		    	this.description_plagio = '';
		       	this.$refs.modalMayor.hide();
		    },

		    
		    hideCancel(evt){
		    	this.selected_genre_name_complaint = '';
		    	this.description_plagio = '';
		    	this.$root.$emit('bv::hide::modal','modalGenre');
		    	this.$root.$emit('bv::hide::modal','modalPlagio');
		    	this.$root.$emit('bv::hide::modal','modalMayor');
		    },
			getGenres(){	            
	            axios.get('/generos/Data').then(response =>{	                
	                this.genres=response.data;	                
	            })
        	},
			getUserComplaintSummernote(){
				axios.get('/complaintSummernotes/verify/'+this.id).then(response => {
					this.motivations_user=response.data;
					this.motivationsDeleted();

				}).catch(error => {
					console.log(error)
				})
			},
			getMotivationSummernote(){
	            axios.get('/motivos-texto/Data').then(response =>{
	                this.motivations=response.data;
	                this.getUserComplaintSummernote();
	            })
	        },
			favorite(){
				if(this.favorited==false){//verificar si agregar o cancelar a favorito
					var routeFavorite='/favoritos'
				}
				else{
					var routeFavorite='/favoritos/cancel'
				}				
				axios.post(routeFavorite,{
					idSummernote:this.id	                              
	            }).then(response =>{ 
	            	console.log(response.data)
	            	if(this.favorited){
	            		this.favorited=false
	            	}
	            	else{
	            		this.favorited=true
	            	}	            	
	            }).catch(error =>{
	                console.log(error.response)
		        });
			},
			getUserFavoriteSummernote(){
				axios.get('/favoritos/'+this.id+'/show').then(response => {
					var object=response.data
					if(object.length!=0){
	            		this.favorited=true
					}
				}).catch(error => {
					console.log(error)
				})
			},
			getUserScoreSummernote(){
				axios.get('/calificacion/'+this.id).then(response => {
					var object=response.data
					if(object.length!=0){
							this.scored=true
							this.selectedCalification=object[0].pivot.score
							this.btnScore='Calificado'
					}					

				}).catch(error => {
					console.log(error)
				})
			},
			scoreSummernote(){
				var routeScore='/calificacion';
				if(!this.scored){
					axios.post(routeScore,{
		                score: this.selectedCalification,
		                idSummernote: this.id,                
		            }).then(response =>{           	      	
		            	this.scored=true
		            	this.btnScore='Calificado'
		            }).catch(error =>{
		                console.log(error.response)
		            });
		        }
		        else{
		        	alert("No puede calificar")
		        }

			},		
			getSummernote(){
				axios.get('/summernote/Data/Comment/'+this.id).then(response => {
					console.log(response)
					var summernote = response.data
					this.summernote=summernote
					this.getUserSummernote(summernote.user_id)
				}).catch(error => {
					console.log(error)
				})
			},
			getUserSummernote(idUser){
				axios.get('/usuarios/Data/'+idUser).then(response => {
					console.log(response)
					this.userSummernote = response.data

				}).catch(error => {
					console.log(error)
				})
			},
			getUserAuth(){
				axios.get('/usuarioAutenticado').then(response => {
					console.log(response)
					this.userAuth = response.data
				}).catch(error => {
					console.log(error)
				})
			},
		}
	};
</script>
<style >
	.imgCircular {
	    width:100px;
	    height:100px;
	    border-radius:50px;
	    border:1px solid #C0C0C0;
	}
	.imgCircularComentario {
	    width:40px;
	    height:40px;
	    border-radius:50%;
	    border:1px solid #C0C0C0;
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