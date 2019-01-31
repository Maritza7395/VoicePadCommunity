<template>
	<b-container>
		<br>
		<b-row>
	 	 	<b-col  cols="3" sm="3">
	 	 		<b-card header="Filtrado"
		                header-tag="header">	            
		             <b-list-group  flush class="text-center">
		             	<b-list-group-item> 
		             		<b-form-input v-model="inputSearch" type="text" placeholder="Buscar por palabra clave"></b-form-input>
		             	</b-list-group-item>
			            <b-list-group-item >
			            	<h6><b>Filtrar por item</b></h6>
			            	<b-form-radio-group plain id="radio" v-model="selectedItem" name="radioSub">
						      	<b-col cols="*">
        							<b-form-radio v-for="item in itemSearch" :key="item.id" :value="item.id">{{ item.name }}</b-form-radio>
        						</b-col>
						      </b-form-radio-group>	
			        	</b-list-group-item>
			        	<b-list-group-item  v-if="selectedItem == 1">
			        		<h6><b>Filtrar por Genero</b></h6>
			        		<b-row>
						      <b-form-radio-group plain id="radios2" v-model="selectedGenre" name="radioSubComponent">
						      	<b-col cols="*">
						      		<b-form-radio  value="0">Todos</b-form-radio>
        							<b-form-radio v-for="genre in genres" :key="genre.id" :value="genre.id">{{ genre.name }}</b-form-radio>
        						</b-col>
						      </b-form-radio-group>	        								        					
	        				</b-row>
	        				
			        	</b-list-group-item>
			        	<b-list-group-item v-if="selectedItem == 1">
			        		<h6><b>Filtrar por Categorias</b></h6>	        				
	        				<b-row>
	        					<b-form-radio-group plain id="checkboxes1" name="flavour1" v-model="selectedCategories" >
	        						<b-col cols="*">
	        							<b-form-radio  value="0">Todos</b-form-radio>
	        							<b-form-radio v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</b-form-radio>
	        						</b-col>							      	 		
					      		</b-form-radio-group>			        					
	        				</b-row>		
			        	</b-list-group-item>
			        </b-list-group>		            
			        <b-card-footer style="background-color: white;">
			        	<b-btn id="search" variant="primary" class="col-md-12" @click="filter()">Buscar</b-btn>
			        </b-card-footer>	           
		        </b-card>							   
	 	 	</b-col>
	 	 	<b-col lg="6">
	 	 		<b-table responsive :items="summernotes" :fields="fields" show-empty class="table-bordered"
				 	stacked="md"
				 	:current-page="currentPageSummernote"
		            :per-page="perPageSummernote">
				  	<template slot="name" slot-scope="row">
					  		<b-row> <!-- row principal -->
					  			<b-row style="width: 100%;"> <!-- row del titulo -->
					  				<div class="col-md-12" style="text-align: center;">
					  					<p class="text-uppercase"><b>{{ row.item.name }}</b></p>
					  				</div>
					  				
					  			</b-row> 
					  			<b-row style="margin: 1px; width:100%;"> <!-- row del contenido -->
					  				<b-col lg="3">
					  					<a :href="'/summernote/'+row.item.id">
					  						<b-img width="125" height="175" alt="img" :src='row.item.route'/>
					  					</a>
					  				</b-col>
					  				<div class="col-lg-9" align-self="center">
					  					<label v-if="row.item.abstract.slice(0, 100).length < row.item.abstract.length" class="text-justify"> {{ row.item.abstract.slice(0, 200)+"..."}} </label>
						  				<label v-else class="text-justify">{{ row.item.abstract.slice(0, 200) }}</label>
						  				<br>
						  				<label style="font-size: small;"><i><b>Genero:</b></i></label>
						  				<b-badge pill variant="warning" style="margin-right: 6px;">{{ row.item.genre.name }}</b-badge>	
						  				<label style="font-size: small;"><i><b>Calificacion: </b>{{ Math.round(row.item.score) }}<img src="https://img.icons8.com/color/16/000000/filled-star.png" style="margin: -2px 0 0 5px;"></i></label>
						  				<br>
						  				<label style="font-size: small;"><i><b>Categoria(s):</b></i></label>
						  				<b-row style="padding-left: 15px; font-size: medium;">
						  					<b-badge pill variant="success" v-for=" (category , i) in row.item.categories" :key="category.id" v-if="i < 10" style="margin-right: 6px;">{{ category.name }}</b-badge>	
						  				</b-row>
						  				<b-row v-if="row.item.paper">
						  					{{ "frase en la hoja " + row.item.paper.number + " de este libro" }}
							  			</b-row>
					  				</div>
					  			</b-row>  			
					  		</b-row>
				  	</template>
					<template slot="row-details" slot-scope="row">
					    <b-card>
					        <ul>
					           <li v-for="(value, key) in row.item" :key="key">{{ key }}: {{ value}}</li>
					        </ul>
					    </b-card>
			      	</template> 
		    	</b-table>
		    	 <b-row>
		            <b-col md="6" class="my-1">
		                <b-pagination :total-rows="totalRowsSummernote" :per-page="perPageSummernote" v-model="currentPageSummernote" class="my-0" />
		            </b-col>
		            <b-col md="6" class="my-1">
		                	<b-row>
			                    <b-col md="8" style="margin-top: 8px;">
			                      <p><b>Elementos por página</b></p>
			                    </b-col>
			                    <b-col md="4">
			                      <b-form-select :options="pageOptionsSummernote" v-model="perPageSummernote" />
			                    </b-col>
			                  </b-row>
		            </b-col>
        		</b-row>   
	 	 	</b-col>
	 	 	<b-col v-if="selectedItem == 1" col lg="3"> 
	 	 		<b-table :items="users" :fields="fieldsUsers" show-empty
				 	stacked="md"
				 	:current-page="currentPageUsers"
		            :per-page="perPageUsers" class="table-bordered"
		            >
            		<template slot="name" slot-scope="row">

            			 <a :href="'/usuarios/'+row.item.id">
            			 	<b-row align-h="center">
            			 		<b-col lg="4">
            			 			<b-img class="imgRedondaUsuario" :src='row.item.route'/> 	 		
            			 		</b-col>
	            			 	<b-col lg="6"  align-self="center">
	            			 		<label>{{ row.item.name_user }}</label>
	            			 	</b-col>
	            			 </b-row>   
		  				 </a>
		  				
		  			</template>           
					<template slot="row-details" slot-scope="row">
					    <b-card>
					        <ul>
					           <li v-for="(value, key) in row.item" :key="key">{{ key }}: {{ value}}</li>
					        </ul>
					    </b-card>
			      	</template> 
		       
		    	</b-table>
		    	 <b-row>
		            <b-col md="7" class="my-1">
		                <b-pagination size="sm" :total-rows="totalRowsUsers" :per-page="perPageUsers" v-model="currentPageUsers" class="my-0" />
		            </b-col>
		            <b-col md="5" class="my-1">
		                <b-form-group horizontal style="font-size: small;" class="mb-0">
		                    <b-form-select size="sm" :options="pageOptionsUsers" v-model="perPageUsers" />
		                </b-form-group>
		            </b-col>
        		</b-row>   
	 	 	</b-col>
	 	 </b-row>
	</b-container>
</template>
<script>
	export default {
		props: ['id'],
		data(){
			return{
				currentPageSummernote: 1,
		        perPageSummernote: 5,
		        pageOptionsSummernote: [ 5, 10, 15 ],
		        pageOptionsUsers: [15,25,35],
		        totalRowsSummernote: 0,
		        currentPageUsers: 1,
		        perPageUsers: 15,
		        totalRowsUsers: 0,
		      	fields: {
		            name: {
		            key: 'name',
		            label: 'Libros',
		            sortable: true
		            },
		           
				 },
				 fieldsUsers: {
		            name: {
		            key: 'name',
		            label: 'Usuarios',
		            sortable: true
		            },
		           
				 },
				summernotes:[],
				users:[],	
				inputSearch:'',
				selectedItem:1,	
				selectedCategories:0,
				selectedGenre:0,
				genres:[],		
				itemSearch:[
					{id: 1, name: 'Libros y Usuarios'},
					{id: 2, name: 'Frases'},
				],
				categories:[],
			}
		},
		mounted(){
			if(this.id){
				if(isNaN(this.id) ){ //verificando si es categoria o inputSearch
					var newInput= this.id.replace("+", " ");
					this.inputSearch=newInput;
					console.log(newInput);
				}
				else{
					console.log("es numero");
					this.selectedCategories=this.id;
				}
				// history.pushState({}, null, 'https://voicepadcommunity.me/search');
				this.filter();
			}
			else{
				this.getSummernotesAll();
				this.getUsers();
			}			
			this.getCategories();
			this.getGenres();
		},
		methods:{
			filter(){
				if(  (this.selectedItem == 2 && this.inputSearch.trim().length) || this.selectedItem == 1 ){ //verificacion para filtrar
					axios.post('/search',{
						selectedItem_id: this.selectedItem,
						inputSearch: this.inputSearch,
						category_id: this.selectedCategories,
						genre_id: this.selectedGenre		               
			            }).then(response =>{
			            	this.summernotes=response.data.Summernotes;
			            	this.users=response.data.Users;
			            	this.totalRowsSummernote=response.data.Summernotes.length;
			            	this.totalRowsUsers=response.data.Users.length;
			            }).catch(error =>{
			                console.log(error.response)
			            });
		        }

			},
			getSummernotesAll(){
				 axios.get('/search/Data').then(response =>{ //NO TRAER EL CONTENIDO DEL LIBRO
	                console.log(response.data)
	                this.summernotes=response.data;
	                this.totalRowsSummernote=response.data.length
	            })
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
			getGenres(){
				axios.get('/generos/Data').then(response => {
					console.log(response)
					var genres = response.data
					this.genres = response.data
				}).catch(error => {
					console.log(error)
				})
			},
			getUsers(){
	            axios.get('/Data/usuarios').then(response =>{
	                console.log(response.data.users)
	                this.users=response.data.users
	                this.totalRowsUsers=response.data.users.length
	            });
	        } ,
			
		}
	};
</script>
<style>
.imgRedondaUsuario {
    width:50px;
    height:50px;
    border-radius:25px;
    border:1px solid #C0C0C0;
}
</style>