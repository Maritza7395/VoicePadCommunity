

<template>
<!-- 	<b-container>
		<form  v-on:submit.prevent="editSummernote">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<b-card no-body>
					<h3 slot="header" class="text-center">Editar Libro</h3>
					<b-card-body>
						 <b-alert variant="danger"
					             dismissible
					             :show="showDismissibleAlert"
					             @dismissed="showDismissibleAlert=false"
					             class="text-center">
					      Debes Seleccionar un Genero
					    </b-alert>
						<b-form-group horizontal 
									:label-cols="2" 
									breakpoint="md" 
									label="Titulo:" 
									label-for="name" 
									label-size="lg">
							<b-form-input id="name" v-model="name" placeholder="Enter the title..." required></b-form-input>
						</b-form-group>
						 <span v-if="errorsCreate.name" class="error">{{ errorsCreate.name[0] }}</span>
						<b-form-group horizontal 
									:label-cols="2" 
									breakpoint="md" 
									label="Sinopsis:" 
									label-for="abstract" 
									label-size="lg">
								<b-form-textarea id="abstract"
							                     v-model="abstract"
							                     placeholder="Enter something"
							                     :rows="6"
							                     no-resize>
							    </b-form-textarea>	
						</b-form-group>
						  <span v-if="errorsCreate.abstract" class="error">{{ errorsCreate.abstract[0] }}</span>
						<b-form-group horizontal 
									:label-cols="2" 
									breakpoint="md" 
									label="Portada:" 
									label-for="file" 
									label-size="lg">

							<b-form-file  v-on:change="onImageChange" v-model="image" name="image" id="image" placeholder="Choose a file..."></b-form-file>
							<b-img center fluid alt="Responsive image" width="100" heigth="auto"  :src='summernote.route'/>
 -->							<!-- <input type="file" v-on:change="onImageChange" class="form-control"> -->
	
<!-- 						</b-form-group>
						  <span v-if="errorsCreate.image" class="error">{{ errorsCreate.image[0] }}</span>
						<div class="row">
							<div class="col-md-6">
								<b-form-group horizontal 
									:label-cols="4" 
									breakpoint="md" 
									label="Género:" 
									label-for="genero" 
									label-size="lg">
									<b-dropdown required id="genero" v-model="idgenero" :text="selectedDefault" class="m-md-2" variant="outline-primary">
										<div v-for="genre in genres">
								 	 		<b-dropdown-item @click="selectedOp(genre.id, genre.name)">{{genre.name}}</b-dropdown-item>
										</div>
								 	</b-dropdown>
								</b-form-group>
							</div>
							<div class="col-md-6">
								 <b-form-group horizontal 
									:label-cols="6" 
									breakpoint="md" 
									label="Clasificacion: +18" 
									label-for="clasificacion" 
									label-size="lg">
									<label class="switch">
								  		<input type="checkbox" class="check" id="clasificacion" v-model="clasificacion" >
								  		<span class="slider round"></span>
									</label>
								</b-form-group>
							</div>
						</div>
						<b-form-group horizontal
								:label-cols="2"
								breakpoint="md"
								label="Categorías:"
								label-for="categories"
								label-size="lg">
							<div id="categories" class="row">
							  <b-btn v-b-modal.modalCategoria variant="primary" size="sm">
							    Agregar
							    <b-badge pill variant="dark">
							      <i class="material-icons md-10">add_circle_outline</i>
							    </b-badge>
							  </b-btn>
							  <br>
							  <div class="col-sm-1"></div>
							  <div v-for="categorySave in nameCategoriesSave" >
							  	<h5><b-badge pill variant="success">{{categorySave}}</b-badge></h5>
							  </div>
							</div>
						</b-form-group>
						<div class="row">
							<input class="btn btn-primary" style="margin-left: 574px" type="submit" value="Siguiente">
						</div> -->
						<!-- Modal Categorias -->
						<!-- <b-modal id="modalCategoria" no-close-on-backdrop  ref="modalCategoria" title="Seleccionar Categorias"   @ok="handleOk" @cancel="hideCancel">
							<div v-for="category in categories">									 
      							<input type="checkbox" id="nombre" v-model="idCategoriesSave" :value="category.id">
      							<label for="nombre">{{category.name}}</label>
							</div>
						</b-modal>
					</b-card-body>
				</b-card>
			</div>
		</div>
	</form>
	</b-container> -->
	<body id="LoginForm">
    <div class="container">
             <div class="login-form row">
                <div class="col-md-6 columna2">
                    <img src="/storage/logo/LogoG.png" height="300px;" width="299px">
                </div>
                <div class="col-md-6">
                    <div class="main-div">
                        <div class="panel">
                            <img src="/storage/logo/LogoBig.png">
                        </div>
                        <div class="borde"></div>
                        <form id="Login" v-on:submit.prevent="editSummernote">
                        	 <b-alert variant="danger"
					             dismissible
					             :show="showDismissibleAlert"
					             @dismissed="showDismissibleAlert=false"
					             class="text-center">
						      Debes Seleccionar un Genero
						    </b-alert>
                            <div class="form-group row">
							    <label for="name" class="col-sm-2 col-form-label">Título:</label>
							    <div class="col-sm-10">
							    	<input id="name" v-model="name" class="form-control" placeholder="Ingrese un título..." required>
							    </div>
							</div>
							<span v-if="errorsCreate.name" class="error">{{ errorsCreate.name[0] }}</span>
                            <div class="form-group row">
							    <label for="abstract" class="col-sm-2 col-form-label">Sinopsis:</label>
							    <div class="col-sm-10">
							    	<b-form-textarea id="abstract"
							                     v-model="abstract"
							                     placeholder="Ingrese algo..."
							                     :rows="6"
							                     no-resize>
							    	</b-form-textarea>
							    </div>
							</div>
                            <span v-if="errorsCreate.abstract" class="error">{{ errorsCreate.abstract[0] }}</span>
                            <div class="form-group row">
							    <label for="image" style="padding-top: 38px;" class="col-sm-2 col-form-label">Portada:</label>
							    <div class="col-sm-7" style="padding-top: 30px;">
							    	<b-form-file  v-on:change="onImageChange" v-model="image" name="image" :state="Boolean(image)"  id="image" placeholder="Escoge un archivo..."></b-form-file>
								<!-- <input type="file" v-on:change="onImageChange" class="form-control"> -->
							    </div>
							    <div class="col-md-3">
							    	<b-img center alt="Responsive image" width="70px" heigth="70px"  :src='summernote.route'/>
							    </div>
							</div>
							<span v-if="errorsCreate.image" class="error">{{ errorsCreate.image[0] }}</span>
							<div class="form-group row">
							    <label for="genero" class="col-sm-2 col-form-label">Género:</label>
							    <div class="col-sm-10">
							    	<b-dropdown required id="genero" v-model="idgenero" :text="selectedDefault" class="m-md-2" variant="outline-primary">
										<div class="myDropDown">
											<div v-for="genre in genres">
									 	 		<b-dropdown-item @click="selectedOp(genre.id, genre.name)">{{genre.name}}</b-dropdown-item>
											</div>
										</div>
								 	</b-dropdown>
							    </div>
							</div>
							<div class="form-group row">
							    <label for="clasificacion" class="col-sm-4 col-form-label">Clasificación +18 </label>
							    <div class="col-sm-8">
								  	<div class="checkbox checbox-switch switch-primary">
									    <label>
									        <input type="checkbox" class="checkbox checbox-switch switch-primary" id="clasificacion" v-model="clasificacion"/>
									        <span></span>                                        
									    </label>
									</div>
							    </div>
							</div>
							<div class="form-group row">
							    <label for="categories" class="col-sm-3 col-form-label">Categorías: </label>
							    <div class="col-sm-9">
							    	<button type="button" v-b-modal.modalCategoria class="btn bg-blue fs-it-btn">
									    <i class="fa fa-plus" aria-hidden="true"></i>
									    <span class="fs-it-btn-vertical-line"></span>
									    Agregar</button>
									    <br>
								  	<div id="categories" class="row">
									  <div v-for="categorySave in nameCategoriesSave" >
									  	<h5><b-badge class="tags">{{categorySave}}</b-badge></h5>
									  </div>
									</div>
							    </div>
							</div>
							<!-- Modal Categorias -->
							
						<b-modal id="modalCategoria" no-close-on-backdrop  ref="modalCategoria" title="Seleccionar Categorias"   @ok="handleOk" @cancel="hideCancel">
							<div class="row">
								<div class="col-sm-4">
						            <div v-for="(category , i) in categories" :key="i" v-if="  i < categories.length/3">
							           	<input type="checkbox" id="nombre" v-model="idCategoriesSave" :value="category.id">
      									<label for="nombre">{{category.name}}</label>
						            </div>
					            </div>
					            <div class="col-sm-4">
						            <div v-for="(category , i) in categories" :key="i" v-if="i >= categories.length/3 && i< (categories.length/3)+(categories.length/3)">
							           	<input type="checkbox" id="nombre" v-model="idCategoriesSave" :value="category.id">
      									<label for="nombre">{{category.name}}</label>
						            </div>
					            </div>
					            <div class="col-sm-4">
						            <div v-for=" (category , i) in categories" :key="i" v-if="i >= (categories.length/3)+(categories.length/3) && i<= categories.length">
							           	<input type="checkbox" id="nombre" v-model="idCategoriesSave" :value="category.id">
      									<label for="nombre">{{category.name}}</label>
						            </div>
					            </div>
							</div>
						</b-modal>
                            <button type="submit" class="btn btn-primary">Editar</button>
                        </form>
                    </div>
                </div>
            </div>
    </div></div>
</body>
</template>
<script >
	export default{
		props: ['id'],
		mounted(){
			this.getSummernote();
			this.getCategories();
			this.getSummernoteCategories();	
			this.getGenres();		
		},
		data(){
			return{
				name: '',
				abstract: '',
				image: '',
				clasificacion: false,
				idgenero:0,
				selectedDefault: 'Seleccionar Genero',
				idCategoriesSave:[],
				nameCategoriesSave:[],
				genres:[],
				categories:[],
				showDismissibleAlert: false,
				errorsCreate:[],
				summernote:{
					name:'',
					abstract:'',
					status: '',
					created_at: '',
					updated_at: '',
					user_id:0,
					route:'',
				},
			}

		},
		methods:{
			getSummernote(){
				axios.get('/summernote/Data/'+this.id).then(response => {
					console.log(response)
					var summernote = response.data
					this.summernote=summernote
					this.name=summernote.name
					this.abstract=summernote.abstract
					this.idgenero=summernote.genre_id
					this.clasificacion=summernote.rating
				}).catch(error => {
					console.log(error)
				})
			},	
			getSummernoteCategories(){
				axios.get('/summernoteCategorias/'+this.id).then(response => {
					console.log(response)
					var categories=response.data
					if(categories){
						for (var i = 0; i < categories.length; i++) {
							this.idCategoriesSave.push(categories[i].id);
							this.nameCategoriesSave.push(categories[i].name);
						}
					}
				}).catch(error => {
					console.log(error)
				})
			},			
			onImageChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);
            },
            createImage(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.image = e.target.result;
                };
                reader.readAsDataURL(file);
            },
			handleOk (evt) {
				this.nameCategoriesSave=[];
				for (var i =0; i < this.idCategoriesSave.length ; i++) {
					for (var j =0; j < this.categories.length ; j++) {
						if(this.categories[j]['id'] == this.idCategoriesSave[i]){
							this.nameCategoriesSave.push(this.categories[j]['name']);
						}
					}
				}
		       this.$refs.modalCategoria.hide()
		    },
		    hideCancel(evt){
		    	this.idCategoriesSave=[];
		    	for (var i =0; i < this.categories.length ; i++) {
					for (var j =0; j < this.nameCategoriesSave.length ; j++) {
						if(this.categories[i]['name'] == this.nameCategoriesSave[j]){
							this.idCategoriesSave.push(this.categories[i]['id']);
						}
					}
				}
		    	this.$root.$emit('bv::hide::modal','modalCategoria')
		    },
		   
			getCategories(){
				axios.get('/categorias/Data').then(response => {
					console.log(response)
					var categories = response.data;
					this.categories = response.data;
				}).catch(error => {
					console.log(error)
				})
			},
			selectedOp(id, name){
				this.idgenero=id;
				this.selectedDefault=name;
				this.showDismissibleAlert=false;
			},
			editSummernote: function(){
				if(this.idgenero==0){
					this.showDismissibleAlert=true;
					//alert("Debe Seleccionar Genero");
				}
				else{
					
					 axios.put('/summernote/'+this.id,{
		                name: this.name,
		                abstract:this.abstract,
		                clasificacion: this.clasificacion,
		                idgenero: this.idgenero,
		                categoriesSave: this.idCategoriesSave,
		                image: this.image
		            }).then(response =>{
		            	if(response.data != ''){
		            		alert(response.data);
		            	}
		            	else{
		            		location.reload();
		            	}
		            }).catch(error =>{
		                console.log(error.response)
		                if(error.response.status==422){
		                    this.errorsCreate=error.response.data.errors
		                }
		            });
				}
	           
			},
			getGenres(){
				axios.get('/generos/Data').then(response => {
					console.log(response)
					var genres=response.data
					this.genres = genres
					for (var i = 0; i < genres.length; i++) {
						if(genres[i].id == this.idgenero){
							this.selectedDefault=genres[i].name;
						}
					}
				}).catch(error => {
					console.log(error)
				})
			},
		}




	};
</script>
<style>
	/*Cuerpo de la vista y formulario*/
	body#LoginForm{ 
		background-image:url("https://hdwallsource.com/img/2014/9/blur-26347-27038-hd-wallpapers.jpg"); 
		background-repeat:no-repeat; 
		background-position:center; 
		background-size:cover;
		margin: -70px -15px -22px -15px;
	}
	.borde{
        border-top-style: solid;
        border-top-color: #721422;
        padding-bottom: 20px; 
    }
    .form-heading { color:#fff; font-size:23px;}
    .panel {
        margin-bottom: 15px;
        text-align:center;
    }
    .login-form .form-control {
      border: 1px solid #d4d4d4;
      border-radius: 4px;
      font-size: 14px;

    }
    .myDropDown {
	    float: none !important;
	}
	.m-md-2 {
	    margin: 0 !important;
	}
    .main-div {
      background: #ffffff none repeat scroll 0 0;
      border-radius: 8px;
      margin: 10px auto 30px;
      max-width: 100%;
      padding: 20px 70px 50px 71px;
    }

    .login-form .form-group {
      margin-bottom:10px;
    }
    .login-form{ 
		padding-top: 50px;
    }
    .login-form  .btn.btn-primary {
      background: #9b111e none repeat scroll 0 0;
      border-color: #f0ad4e;
      color: #ffffff;
      font-size: 14px;
      width: 100%;
      height: 30px;
      padding: 0;
    }
    .login-form .btn.btn-primary.reset {
      background: #ff9900 none repeat scroll 0 0;
    }
</style>