<template>
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
                        <form id="Login" v-on:submit.prevent="createBook">
                        	<b-alert variant="danger" dismissible :show="showDismissibleAlert" @dismissed="showDismissibleAlert=false"
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
							    <label for="image" class="col-sm-2 col-form-label">Portada:</label>
							    <div class="col-sm-10">
							    	<b-form-file  v-on:change="onImageChange" v-model="image" name="image" :state="Boolean(image)"  id="image" placeholder="Escoge un archivo..."></b-form-file>
								<!-- <input type="file" v-on:change="onImageChange" class="form-control"> -->
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
						            <div v-for=" (category , i) in categories" :key="i" v-if="  i < categoriesLength/3">
							           	<input type="checkbox" id="nombre" v-model="idCategoriesSave" :value="category.id">
      									<label for="nombre">{{category.name}}</label>
						            </div>
					            </div>
					            <div class="col-sm-4">
						            <div v-for=" (category , i) in categories" :key="i" v-if="i >= categoriesLength/3 && i< (categoriesLength/3)+(categoriesLength/3)">
							           	<input type="checkbox" id="nombre" v-model="idCategoriesSave" :value="category.id">
      									<label for="nombre">{{category.name}}</label>
						            </div>
					            </div>
					            <div class="col-sm-4">
						            <div v-for=" (category , i) in categories" :key="i" v-if="i >= (categoriesLength/3)+(categoriesLength/3) && i<= categoriesLength">
							           	<input type="checkbox" id="nombre" v-model="idCategoriesSave" :value="category.id">
      									<label for="nombre">{{category.name}}</label>
						            </div>
					            </div>
							</div>
						</b-modal>
                            <button type="submit" class="btn btn-primary">Crear</button>
                        </form>
                    </div>
                </div>
            </div>
    </div></div>
</body>
</template>
<script>
	export default{
		mounted(){
			this.getGenres();
			this.getCategories();
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
			}
		},
		methods:{
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
					this.categoriesLength=response.data.length;
				}).catch(error => {
					console.log(error)
				})
			},
			selectedOp(id, name){
				this.idgenero=id;
				this.selectedDefault=name;
				this.showDismissibleAlert=false;
			},
			createBook: function(){
				if(this.idgenero==0){
					this.showDismissibleAlert=true;
					//alert("Debe Seleccionar Genero");
				}
				else{
					
					 axios.post('/summernote',{
		                name: this.name,
		                abstract:this.abstract,
		                clasificacion: this.clasificacion,
		                idgenero: this.idgenero,
		                categoriesSave: this.idCategoriesSave,
		                image: this.image
		            }).then(response =>{
		            	var summernote=response.data
		            	this.createPaper(summernote.id);
		            }).catch(error =>{
		                console.log(error.response.data.message)
		                if(error.response.status==422){
		                    this.errorsCreate=error.response.data.errors
		                }
		                 if(error.response.status==500 && error.response.data.message == 'Image source not readable'){
		                 	alert('Debe ingresar una imagen correcta');
		                }
		            });
				}
	           
			},
			createPaper(idSummernote){
				axios.post('/paper',{
		                idSummernote: idSummernote		                
		            }).then(response =>{
		            	var paper=response.data
		            	window.location.href='/summernote/'+idSummernote+'/edit/content';
		            }).catch(error =>{
		                console.log(error.response)
		            });
			},
			getGenres(){
				axios.get('/generos/Data').then(response => {
					console.log(response)
					var genres = response.data
					this.genres = response.data
				}).catch(error => {
					console.log(error)
				})
			},
		}
	};
</script>
<style type="text/css">
	.columna2{
        padding-top: 150px;
    }
    .col-form-label{
    	font-weight: bold !important;
    }
    .tags{
		background:#e91e63;
		margin-right: 5px;
	}

    /*Switch de clasificacion*/
	.checkbox.checbox-switch {
	    padding-left: 0;
	}
	.checkbox.checbox-switch label,
	.checkbox-inline.checbox-switch {
	    display: inline-block;
	    position: relative;
	    padding-top: 5px;
	}
	.checkbox.checbox-switch label input,
	.checkbox-inline.checbox-switch input {
	    display: none;
	}
	.checkbox.checbox-switch label span,
	.checkbox-inline.checbox-switch span {
	    width: 50px;
	    border-radius: 20px;
	    height: 20px;
	    border: 3px solid #dbdbdb;
	    background-color: #cc0000;
	    border-color: #cc0000;
	    box-shadow: rgb(223, 223, 223) 0px 0px 0px 0px inset;
	    transition: border 0.4s ease 0s, box-shadow 0.4s ease 0s;
	    display: inline-block;
	    vertical-align: middle;
	    margin-right: 5px;
	}
	.checkbox.checbox-switch label span:before,
	.checkbox-inline.checbox-switch span:before {
	    display: inline-block;
	    width: 16px;
	    height: 16px;
	    border-radius: 50%;
	    background: rgb(255,255,255);
	    content: " ";
	    top: 0;
	    position: relative;
	    left: 0px;
	    transition: all 0.3s ease;
	    box-shadow: 0 1px 4px rgba(0,0,0,0.4);
	    top:-2px;
	}
	.checkbox.checbox-switch label > input:checked + span:before,
	.checkbox-inline.checbox-switch > input:checked + span:before {
	    left: 28px;top:-2px;
	}

	/* Switch Primary */
	.checkbox.checbox-switch.switch-primary label > input:checked + span,
	.checkbox-inline.checbox-switch.switch-primary > input:checked + span {
	    background-color: rgb(0, 105, 217);
	    border-color: rgb(0, 105, 217);
	    /*box-shadow: rgb(0, 105, 217) 0px 0px 0px 8px inset;*/
	    transition: border 0.4s ease 0s, box-shadow 0.4s ease 0s, background-color 1.2s ease 0s;
	}
	.checkbox.checbox-switch.switch-primary label > input:checked:disabled + span,
	.checkbox-inline.checbox-switch.switch-primary > input:checked:disabled + span {
	    background-color: red;
	    border-color: red;
	   /* box-shadow: rgb(109, 163, 221) 0px 0px 0px 8px inset;*/
	    transition: border 0.4s ease 0s, box-shadow 0.4s ease 0s, background-color 1.2s ease 0s;
	}

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
    .container{
        padding-top: 10px;
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
		padding-top: 100px;
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
	
	
    /*boton de categorias*/
    .fs-it-btn {
	  margin-top: 6px;
	  margin-left: -15px;
	  margin-bottom: 10px;
	  border: 1px solid #a2a2a2;
	  border-radius: 4px;
	  color: #fff;
	  font-weight: bold;
	  font-size: 12px;
	}
	.fs-it-btn-vertical-line {
	  text-align:center;
	  padding: 4px 0 5px 10px;
	  margin-left: 10px;
	  border-left: 1px solid #a2a2a2;
	}
	.bg-blue {
	    background-color: #2c9deb;
	}
</style>