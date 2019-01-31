<template>
	<b-container fluid>
		<b-jumbotron >
			<div class="twPc-div">
			    <a class="twPc-bg twPc-block" style="backgroundImage: url(/storage/logo/background.png); object-fit: cover;"></a>
				<div>
					<div class="twPc-button">
			            <div v-if="userProfile.id != userAuth.id">
							<b-button-group>
								<b-btn variant="primary" v-if="userAuth.role_id != 3" @click="followUser()"><img src="/storage/logo/follow.png" alt="x" style="padding-right: 10px; padding-bottom: 2px;" />{{ textButtonFollow }}</b-btn>
								<div class="dropdown" v-if="dropdownActived == true" v-model="selected" :text="textDrop">
								  <button class="btn btn-outline-danger dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								    Denunciar
								  </button>
								  <div class="dropdown-menu dropdown-menu-right myDropDown" aria-labelledby="dropdownMenuButton">
								  	<div v-for="motivation in motivations">
										<div class="dropdown-item"  @click="selectedMotiv(motivation.id,motivation.name)">{{ motivation.name }}</div>
									</div>
								  </div>
								</div>
							</b-button-group>
						</div>
					</div>
					<div class="twPc-avatarLink">
						<img :src="userProfile.route" class="twPc-avatarImg">
						<h4 style="text-transform: capitalize;"><center>{{userProfile.name_user }}</center></h4>
					</div>
					<div class="row twPc-divStats">
						<div class="col-md-4">
							<span class="twPc-StatLabel twPc-block">Publicaciones</span>
								<span class="twPc-StatValue">{{userSummernotes.length}}</span>
						</div>
						<div class="col-md-4">
							<span class="twPc-StatLabel twPc-block">Seguidores</span>
								<span class="twPc-StatValue">{{userFollowers.length}}</span>
						</div>
						<div class="col-md-4">
							<span class="twPc-StatLabel twPc-block">Siguiendo</span>
								<span class="twPc-StatValue">{{userFollowed.length}}</span>
						</div>
					</div>
				</div>
			</div>
	 	 </b-jumbotron>
	 	 <b-row>
	 	 	<b-col cols="*" md="3">
		        <div class="cardd">
				    <div class="box">
				        <div class="img">
				            <b-img center fluid alt="Responsive image" class="imgRedondaUserLeft" :src='userProfile.route'/>
				        </div>
				        <h2>{{userProfile.name_user }}</h2>
				        <div v-if="userProfile.about_me!==null">
				        	<h6><span>Acerca de Mi</span></h6>
				        	<p> {{ userProfile.about_me }} </p>	
				        </div>
						<h6><span>Sexo</span></h6>
						<div v-if="userProfile.sex==='M'">
							<p>Masculino</p>
						</div>
						<div v-else>
							<p>Femenino</p>
						</div>
						<h6><span>Edad</span></h6>
						<p>{{ userProfile.birthdate }} años</p>
						<div v-if="userProfile.page_web!==null">
							<h6><span>Página Web</span></h6>
							<a :href="userProfile.page_web" style="color: blue;">{{ userProfile.page_web }}</a>
						</div>
				    </div>
				</div>
	 	 	</b-col>
	 	 	<b-col class="container-fluid">
			    <!-- Tabs with card integration -->
			    <b-card no-body>
			      <b-tabs small card v-model="tabIndex">
			        <b-tab title="Libros del Autor" v-if="userProfile.id != userAuth.id">	        
				      	<div v-for="(summernote , i) in userSummernotes" :key="i">
			        		<div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 project wow animated animated4 fadeInLeft" v-bind:style="{ backgroundImage: 'url(' + summernote.route + ')' }">
						        <div class="project-hover">
						        	<center><h5>{{ summernote.name }}</h5>
						            <hr />
						            <p><b>Calificación: </b>{{ Math.round(summernote.score) }} ★</p>
						            <b-link :href="'/summernote/'+summernote.id">Ver Libro</b-link>
									<div v-if="userProfile.id == userAuth.id">
										<b-link style="text-decoration: none;" href="#" @click="deleteFavorite(summernote)" >Eliminar</b-link>
									</div>
									</center>
						        </div>
						    </div>   	
			        	</div>
						<div class="clearfix"></div>
			        </b-tab>
			        <b-tab title="Favoritos">
			        	<div v-for="(summernote , i) in userSummernotesFavorites" :key="i">
			        		<div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 project wow animated animated4 fadeInLeft" v-bind:style="{ backgroundImage: 'url(' + summernote.route + ')' }">
						        <div class="project-hover">
						        	<center><h5>{{ summernote.name }}</h5>
						            <hr />
						            <p><b>Autor: </b>{{ summernote.user.name_user }}</p>
						            <b-link :href="'/summernote/'+summernote.id">Ver Libro</b-link>
									<div v-if="userProfile.id == userAuth.id">
										<b-link style="text-decoration: none;" href="#" @click="deleteFavorite(summernote)" >Eliminar</b-link>
									</div>
									</center>
						        </div>
						    </div>   	
			        	</div>
						<div class="clearfix"></div>
			        </b-tab>
			        <b-tab title="Seguidores" >
			        	<b-row>
			        		<b-card-group class="col-md-12">
					        	<b-col cols="*" md="3"  v-for="user in userFollowers"
					        			:key="user.id">							 
					        			<b-card 		        			
					        			border-variant="primary" 
					        			col="mb-3"
							            align="center"
							            >	
							            <b-img center fluid alt="Responsive image" class="imgRedondaFollow" :src='user.route'/>
										<b-link :href="'/usuarios/'+ user.id" class="text-center" style="text-transform: capitalize;" > {{user.name_user }}</b-link>

						    		</b-card>
					        	</b-col>
					        </b-card-group>	 
			        	</b-row>			          
			        </b-tab>
			         <b-tab title="Seguidos" >
			         	<b-row>
			        		<b-card-group class="col-md-12">
					        	<b-col cols="*" md="3"  v-for="user in userFollowed"
					        			:key="user.id">							 
					        			<b-card 		        			
					        			border-variant="primary" 
					        			col="mb-3"
							            align="center"
							            >	
							            <b-img center fluid alt="Responsive image" class="imgRedondaFollow" :src='user.route'/>
										<b-link :href="'/usuarios/'+ user.id" class="text-center" style="text-transform: capitalize;" > {{user.name_user }}</b-link>

						    		</b-card>
					        	</b-col>
					        </b-card-group>	 
			        	</b-row>
			        </b-tab>			        
			      </b-tabs>
			    </b-card>
	 	 	</b-col>
	 	 </b-row> 	
	</b-container>			

</template>
<script >
export default{
	props: ['id'],
		mounted(){
			this.getUserProfile();
			this.getUsersFollowers();
			this.getUsersFollowed();
			this.getUserAuth();
			this.getMotivationUser();
			this.getSummernotes();
			this.getSummernotesFavorites();
			this.getUserFollowProfile();
			this.getUserComplaintProfile();
		},
		data(){
			return{
				textButtonFollow:'Seguir',
				textDrop:'Denunciar',
				dropdownActived:true,
				selected:null,
				userSummernotes:[],
				userSummernotesFavorites:[],
				userFollowers:[],
				userFollowed:[],
				motivations:[],
				tabIndex: 0,
				objectSummernote:'',
				idSummernoteDelete:0,
				modalSummernoteDelete:{
					objectSummernote:{},
				},
				userProfile:{
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
					route:''
				}
			}
		},
		methods:{
			deleteFavorite(summernote){
				var routeFavorite='/favoritos/cancel'
				axios.post(routeFavorite,{
					idSummernote:summernote.id	                              
	            }).then(response =>{ 
	            	this.getSummernotesFavorites();            	
	            }).catch(error =>{
	                console.log(error.response)
		        });
			},			
			followUser(){							
				if(this.textButtonFollow=='Seguir'){
						var routeFollow='/follows';
				}
				else{
					var routeFollow='/follows/cancel';
				}
				axios.post(routeFollow,{	                
	                idUserFollow:this.userProfile.id
	            }).then(response =>{
	            	if(this.textButtonFollow=='Seguir'){
							this.textButtonFollow='Dejar de Seguir'
					}
					else{
						this.textButtonFollow='Seguir'
					}           	

	            }).catch(error =>{
	                if(error.response.status == 404){
						alert("No tienes permitido realiar esta acion");				
	                }
	            });
			},
			selectedMotiv(id,name){
				console.log("post");
				this.selected = id;
				this.textDrop=name;
				axios.post('/complaintUsers',{
	                idUserComplaint:this.userProfile.id,
	                idMotivation:id,
	            }).then(response =>{
	            	this.dropdownActived=false;
	            	console.log(response);  	
	            }).catch(error =>{
	                if(error.response.status == 404){
						alert("No tienes permitido realiar esta acion");				
	                }
	            });				
			},
			getUserFollowProfile(){
				axios.get('/follows/isFollow/'+this.id).then(response => {
					var seguido=response.data;
					if(seguido==1){
						this.textButtonFollow='Dejar de Seguir'
					}
					else{
						this.textButtonFollow='Seguir'
					}

				}).catch(error => {
					console.log(error)
				})
			},
			getUserComplaintProfile(){
				axios.get('/complaintUsers/isComplaint/'+this.id).then(response => {
					var motivation=response.data;
					if(motivation.length){
						this.textDrop="Usuario Denunciado";
						this.dropdownActived=false;						
					}

				}).catch(error => {
					console.log(error)
				})
			},
			getUserAuth(){
				axios.get('/usuarioAutenticado').then(response => {
					console.log(response)
					var userAuth=response.data;
					this.userAuth = response.data
					if(this.id != userAuth.id ){
						this.tabIndex=3;
					}
					if(userAuth.role_id == 3){
						this.dropdownActived = false;
					}

				}).catch(error => {
					console.log(error)
				})
			},
			getUserProfile(){
				axios.get('/usuarios/Data/'+this.id).then(response => {
					console.log(response)
					this.userProfile = response.data

				}).catch(error => {
					console.log(error)
				})
			},
			getUsersFollowers(){
				axios.get('/follows/followers/'+this.id).then(response => {
					console.log(response)
					this.userFollowers = response.data

				}).catch(error => {
					console.log(error)
				})
			},
			getUsersFollowed(){
				axios.get('/follows/followed/'+this.id).then(response => {
					console.log(response)
					this.userFollowed = response.data

				}).catch(error => {
					console.log(error)
				})
			},
			getMotivationUser(){
	            axios.get('/motivos-usuario/Data').then(response =>{
	                console.log(response)
	                this.motivations=response.data
	            })
	        },
	        getSummernotes(){
	            axios.get('/summernotes/Data/'+this.id).then(response =>{
	                console.log(response)
	                this.userSummernotes=response.data
	            })
	        },
	        getSummernotesFavorites(){
	            axios.get('/favoritos/'+this.id).then(response =>{
	                console.log(response)
	                this.userSummernotesFavorites=response.data
	            })
	        },


		}
	};
</script>
<style>
	/*b-link.label {font-family: verdana;}*/
	b-link.label {
		font-size:10vw;
	}
	.card-header{
		background-color: #e6bc53 !important;
	}
	.nav-tabs .nav-link.active .nav-tabs .nav-item.show .nav-link{
		color: black !important;
		font-size: 13px;
	}
	a:link, a:hover, a:active, a:visited{
		color: #191919;
	}
	.jumbotron {
	    padding: 0rem 0rem;
	}
	.imgRedondaFollow {
	    width:60px;
	    height:60px;
	    border-radius:30px;
	    border:1px solid #C0C0C0;
	    object-fit: cover;
	}
	.imgBiblioteca{
		height: 300px;
		width: 180px;
	}

	/*estilos del card de informacion*/
	.cardd {
	    left:50%;
	    width:300px;
	    height:auto; 
	    background:#fff;
	    box-shadow:0 20px 50px rgba(155,17,30,.3);
	    border-radius:10px;
	    transition:0.5s;
	    border: 1px solid #e1e8ed;
	}
	.cardd .box {
	    left:0;
	    text-align:center;
	    padding:20px;
	    box-sizing:border-box;
	    width:100%;
	}
	.cardd .box .img {
	    width:120px;
	    height:120px;
	    margin:0 auto;
	    border-radius:50%;
	    overflow:hidden;
	}
	.cardd .box .img img {
	    width:100%;
	    height:100%;
	    object-fit: cover;
	}
	.cardd .box h2 {
	    font-size:20px;
	    color:#262626;
	    margin:20px auto;
	}
	.cardd .box h6 span {
	    font-size:14px;
	    background:#e91e63;
	    color:#fff;
	    display:inline-block;
	    padding:4px 10px;
	    border-radius:15px;
	}
	.cardd .box p {
	    color:#262626;
	}

	/*Estilos de la cabezera*/
	.twPc-div {
	    background: #fff none repeat scroll 0 0;
	    border: 2px solid #e1e8ed;
	    border-radius: 6px;
	    height: 310px;
	}
	.twPc-bg {
	    background-position: 0 50%;
	    background-size: 100% auto;
	    border-bottom: 1px solid #e1e8ed;
	    border-radius: 4px 4px 0 0;
	    height: 150px;
	    width: 100%;
	}
	.twPc-block {
	    display: block !important;
	}
	.twPc-button {
	    margin: -40px -10px 0;
	    text-align: right;
	    width: 100%;
	}
	.twPc-avatarLink {
	    background-color: #fff;
	    border-radius: 6px;
	    display: inline-block !important;
	    float: left;
	    margin: -60px 15px 0 564px;
	    max-width: 100%;
	    padding: 1px;
	    vertical-align: bottom;
	}
	.twPc-avatarImg {
	    border: 2px solid #fff;
	    border-radius: 7px;
	    box-sizing: border-box;
	    color: #fff;
	    height: 130px;
	    width: 130px;
	    object-fit: cover;
	}
	.twPc-divStats {
	    text-align: center;
	    width: 100%
	}
	.twPc-StatLabel {
	    color: black;
	    font-size: 11px;
	    font-weight: bold;
	    letter-spacing: 0.02em;
	    overflow: hidden;
	    text-transform: uppercase;
	    transition: color 0.15s ease-in-out 0s;
	}
	.btn{
		padding: 0.2rem 0.75rem; 
	}
	/*Vista de Libros*/
	.project {
		width: 200px;
		height: 300px;
		background-size: cover;
		background-position: center;
		padding: 0 !important;
		margin-right: 20px;
		margin-bottom: 20px;
		float: left;
		border: 1px solid;
	}
	
	.project-hover {
		width: 100%;
		height: 100%;
		color: #fff;
		opacity: 0;
		-webkit-transition: all 0.5s ease;
		-moz-transition: all 0.5s ease;
		-o-transition: all 0.5s ease;
		transition: all 0.5s ease;
		background-color: rgba(64, 64, 64, 0.7);
		padding: 60px 20px 0px 20px;
	}

	.project-hover hr {
		height: 30px;
		width: 0;
		-webkit-transition: all 0.5s ease;
		-moz-transition: all 0.5s ease;
		-o-transition: all 0.5s ease;
		transition: all 0.5s ease;
		background-color: rgba(255, 255, 255, 1);
		border: 0;
	}

	.project-hover a {
		color: rgba(255, 255, 255, 1);
		padding: 2px 22px;
		line-height: 40px;
		border: 2px solid rgba(255, 255, 255, 1);
		-webkit-transition: all 0.5s ease-in-out;
		-moz-transition: all 0.5s ease-in-out;
		-o-transition: all 0.5s ease-in-out;
		transition: all 0.5s ease-in-out;
	}

	.project-hover a:hover {
		border-color: rgba(51, 51, 51, 1);
		color: rgba(51, 51, 51, 1);
		background-color: rgba(250, 251, 253, 0.7)
	}

	.project:hover .project-hover {
		opacity: 1;
	}

	.project:hover .project-hover hr {
		width: 100%;
		height: 5px;
	}
</style>