<template>	
	<b-container> 
	<nav class="navbar navbar-expand-md navbar-light bg-light">
		 <a class="navbar-brand text-uppercase" :href="'/summernote/'+id" style="border-right: 1px solid gray; padding-right: 12px;"><b>{{ summernote.name }}</b></a>
		 <a class="navbar-brand text-uppercase" :href="'/usuarios/'+userSummernote.id" style="border-right: 1px solid gray; padding-right: 12px;"><b>{{ userSummernote.name_user }}</b></a>
		  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">		  
		  </button>
		  <div class="collapse navbar-collapse" id="navbarSupportedContent" v-if="userAuth.id !== summernote.user_id">
		    <ul class="navbar-nav mr-auto">
		      <li class="nav-item active">
		       
		      </li>  
		    </ul>
				<span class="navbar-text"  @click="favorite" >
					 <a class="nav-link" href="#" v-if="favorited == true" style="padding:0"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAIWSURBVEhL7VY7SxxhFJ2EoBILHyAWFmmCrvfbXYXFzDfLkiWQwkJSWfgDBJWIpY2NnaQQrFOZpImQpAkIks1+s7tRAhFiYbOlWiwpxEYUAj7Ot3vxsbk+FmdEMAdOMTPn3jNz75074/zH/UQhFWsxOjpqPPrse+qn79EPX9MH46mh1UTiMctOkHGj7b4XnYD+S0WvCtDO43jQpNOPWHY5jKvGYLKD4COJRqsNJB2w2iPHeehrNYkb25W0ltAWc17383Lyi2A0zUnB1USyQ2jH8UTvpOvVhO6vrRbbnEdO04gUFBRhvmeS1Mt2FZh0TzPuaFsKCJKoUpYtK0DfhiVhGMz3RTrZFsYeLUiiMGiHl23LQ7UsiUKhVjNsWzbOiqIQiFmaZlvHwXv7XhKFQTtPbAtjV01JojBoXEqxrR2uaEQShcCS3XZsWwHW3qogDJTo7yzbncLo7peSODBi/+dTvW1sdx64+EkMCoA5j16zzb/4lkg0oRxFKfAmxIL6iN4+YBsZdqVBXKoOvgEL0jdcxPdkrAvDtiUkqYl2MS3F442c9nrI6J4O9PyXlPA6RMvmF/uf1nO62mDSTxqwW99KiS+kVvuXDlIt8F16hbL9EY3OUqvf+WdEHBYMyj90mr5KhijrASb3zTpRHcuDhX0l7PfU/sacmtKmn1QvWBIubDnx9Gt24axoauXTtwM7sVcuhbsHxzkGXv4jnw6Gu7sAAAAASUVORK5CYII="><span class="sr-only">(current)</span></a>
					  <a class="nav-link" href="#" v-else style="padding:0"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAALdSURBVEhL7ZZLaFNBFIbj+7lQUUFFuqltMpMmxbRm5rYaXelCRNSADwQFRcX6wJ2IGxfqRhR0IV2oCCotuvUBJnNv0lZBEcSKVnElKr6o4vuF/ufe00jQPGpz3egHQzh/zj1n5sy5cyfwn3+TbHPdeKPCG40W52wtr2JkbSVO2lokzy+oHsFuObqUmGCUaHH9lbxC/kbLE7CXmURiKLsVx8TlJiTpxYO3jZL7jSXW2zq8FcEOI/hTjAe2JeeR7/dAYJCjxWb4viZ/+Ox1lNjgTUIehf0Evz2ODs1xgxcCDxzCql5hpisoKMs5rsdiw+CzE6v6gIDLyR/jmdGhxeySR5dSo+C7B+Mj+bOcD82UkqaaZJSlgthxsQhV+eomVaKa5YIg6Wos5h2qV8+Sh0lEx+HPlwi2kqWS2HG5C9syl82SYNWtmGSaTQ/s5Tokvve78laKyyo6DTm+ZRqDNSxRKUQbxANs+gYqeo2al023qTqpc9n0DXR5O0q+j00vMUYLm75BlaVXjk23BGfzZuITSJpFP21n053JbggpNn2hW4jh9ErlHSaOCs7Eqr906shklioOXr8lWPELmgBLHljxDT/LjcOpA+Mgmz/B67QQpXifagpJliqGiYs1SPq2w6qdylI+KMVxJL9pElUjWRowdjw0A5V8g7hrWfoVkxBjsdd34dTWnkwOYfmPyTTXT0LSbozTLBUmZdXVYr8fYQJnBpKck95CLAdftdEsF8ctjxYPkfwiXQpYLpvMLCGwbfcRwy47aR8pHaqiTkfT9RgdDLNckrQll3p7Kk/R95jl/uF9yHHloQ+/EluKfb0uRSJj4NeK/viM1W5jeWDgkrAKE+hFwAvO7OAUlnNAb6TKwOeOscINLFcGp0FOp2MVSZ73XXWo+dwLgZaf8N+Rfu9nuaDUg3Ht2UGlxzhGpxESPk5rOZ9d/IWazT1ocJ01sZqJLP8d6H7t51XJJwKBH40rM2HGTemkAAAAAElFTkSuQmCC"><span class="sr-only">(current)</span></a>

				</span>
		    
		     <span class="navbar-text">
		       <b-form-radio-group  :disabled="scored" class="score" buttons  button-variant="invisible" id="radios2" v-model="selectedCalification" name="radioSubComponent">
		        <b-form-radio  v-bind:class="[selectedCalification >= 5 ? starCheck :'', scored == false ? 'star' :'']" value="5" >★</b-form-radio>
		        <b-form-radio v-bind:class="[selectedCalification >= 4 ? starCheck:'', scored == false ? 'star' :'']"  value="4" >★</b-form-radio>
		        <b-form-radio v-bind:class="[selectedCalification >= 3 ? starCheck:'', scored == false ? 'star' :'']"  value="3" >★</b-form-radio>
		        <b-form-radio v-bind:class="[selectedCalification >= 2 ? starCheck:'', scored == false ? 'star' :'']"  value="2">★</b-form-radio>
		        <b-form-radio v-bind:class="[selectedCalification >= 1 ? starCheck:'', scored == false ? 'star' :'']" value="1">★</b-form-radio>
		      </b-form-radio-group>
		       <b-btn @click="scoreSummernote" :disabled="scored" variant="info">{{ btnScore }}</b-btn>
		    </span>
		  </div>
		</nav>
		</b-container>
</template>

<script>
	// document.oncontextmenu = function(){return false;}
	export default{
		props: ['id'],
		data(){
			return{			
				scored:false,
				favorited:false,
				btnScore:'Calificar',
				selectedCalification:0,
				motivations_user:[],
				starCheck:'starCheck',
				userSummernote:{},
				summernote:{},
				userAuth:{},
			}
		},
		mounted(){
			this.getUserScoreSummernote();
			this.getUserFavoriteSummernote();
			this.getSummernote();
			this.getUserAuth();

		},
		methods:{
			 getUserAuth(){
		        axios.get('/usuarioAutenticado').then(response => {
		          console.log(response)
		          this.userAuth = response.data
		        }).catch(error => {
		          console.log(error)
		        })
		      },
			getSummernote(){
				axios.get('/summernote/Data/'+this.id).then(response => {
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
				console.log("coco");
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
			
		}
	};
	
</script>
<style>
	.paper{
		background-color: white;
		border: 1px solid lightgray;
		margin-top: 20px;
		padding-bottom: 20px;
		width: 80%;
		height: auto;
	}
</style>