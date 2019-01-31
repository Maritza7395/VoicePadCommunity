<template>
	<b-nav-item >
		<li class="dropdown">
			<label  class="dropdown-toggle"  data-toggle="dropdown">Descubrir</label>
	            <ul class="dropdown-menu multi-column columns-2">
		            <div class="row">
			            <div class="col-sm-4">
				            <ul class="multi-column-dropdown">
				            	<div @click="redirectSearch(category.id)" v-for=" (category , i) in categories" :key="i" v-if="  i < categoriesLength/3">
				            		  <li>
						            	<a >{{ category.name }}</a>
						            </li>
				            	</div>
					          
				            </ul>
			            </div>
			            <div class="col-sm-4">
				            <ul class="multi-column-dropdown">
					            <div  @click="redirectSearch(category.id)"  v-for="(category , i) in categories" :key="i" v-if="i >= categoriesLength/3 && i< (categoriesLength/3)+(categoriesLength/3)">
					            	 <li ><a >{{ category.name }}</a></li>
					            </div>
					           
				            </ul>
			            </div>
			            <div class="col-sm-4">
				            <ul class="multi-column-dropdown">
					            <div  @click="redirectSearch(category.id)"  v-for="(category , i) in categories" :key="i" v-if="i >= (categoriesLength/3)+(categoriesLength/3) && i<= categoriesLength">
					            	 <li ><a >{{ category.name }}</a></li>
					            </div>
					           
				            </ul>
			            </div>
		            </div>
	            </ul>
	        </li>

	</b-nav-item>
       
</template>
<script>
	export default{
		data(){
			return{
				categories:[],
				categoriesLength: 0,
			}

		},
		mounted(){
			this.getCategories();
		},
		methods:{
			redirectSearch(idCategory){
				window.location.href = '/search/'+idCategory
			},
			discoverCategory(idCategory){
				axios.post('/searchCategory',{
					idCategory: this.idCategory		               
		            }).then(response =>{
		            	console.log(response.data);
		            }).catch(error =>{
		                console.log(error.response)
		            });

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
		}
	};
</script>
<style>
	.dropdown-menu {
	min-width: 200px;
}
.dropdown-menu.columns-2 {
	min-width: 490px;
}
.dropdown-menu.columns-3 {
	min-width: 600px;
}
.dropdown-menu li a {
	padding: 5px 15px;
	font-weight: 300;
}
.multi-column-dropdown {
	list-style: none;
  margin: 0px;
  padding: 0px;
}
.multi-column-dropdown li a {
	display: block;
	clear: both;
	line-height: 1.428571429;
	color: #333;
	white-space: normal;
}
.multi-column-dropdown li a:hover {
	text-decoration: none;
	color: #262626;
	background-color: #999;
}
 
@media (max-width: 767px) {
	.dropdown-menu.multi-column {
		min-width: 240px !important;
		overflow-x: hidden;
	}
}
</style>