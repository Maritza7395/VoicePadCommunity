<template>
	<b-navbar-nav>          
          <b-nav-item>
            <b-input-group size="sm" > 
            <b-form-input size="sm" type="text" placeholder="Buscar" v-model="inputSearch"></b-form-input>           	
               <b-input-group slot="append">
                <b-button @click="search"  size="sm" class="my-sm-0" type="submit"><i class="material-icons">search</i></b-button>
            </b-input-group>
             
            </b-input-group>
          </b-nav-item>
        </b-navbar-nav>
</template>
<script>
	export default{
		data(){
			return{
				inputSearch:'',

			}
		},
		mounted(){
			
		},
		methods:{
			search(){
				if(this.inputSearch){
					var newInput= this.inputSearch.replace(/ /g, "+")
					console.log(newInput);
					window.location.href = '/search/'+newInput
				}
			}
		}

	}
</script>