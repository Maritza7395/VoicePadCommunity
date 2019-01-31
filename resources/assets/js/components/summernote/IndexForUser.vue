<template>
	<div class="container-fluid row">
	<div class="col-md-3"></div>
	<div class="col-md-9">
		<br>
		<b-form-group horizontal label="Filtrar" class="mb-0">
              <b-input-group>
                <b-form-input v-model="filter" placeholder="Buscar" />
                <b-input-group-append>
                  <b-btn :disabled="!filter" @click="filter = ''">Limpiar</b-btn>
                </b-input-group-append>
              </b-input-group>
         </b-form-group>
         <br>
		 <b-table style="width:100%" :items="summernotes" :fields="fields" show-empty
		 	stacked="md"
		 	:current-page="currentPage"
            :per-page="perPage"
		 	:filter="filter"
            @filtered="onFiltered"
		 		 	 >
		  	<template slot="obras" slot-scope="row">
		  		<!-- {{ row.item }}   -->	
		  		<b-row> <!--row principal -->
					<b-col lg="4">
						<b-img alt="Responsive image" width="125" height="175" :src='row.item.route'/>
					</b-col>
					<b-col md="8" align-self="center">
						<b-row><b>Titulo:</b> {{ row.item.name }}</b-row>
						<b-row v-if="row.item.private == 0"><b>Publico:</b> Si </b-row>
						<b-row v-else><b>Publico:</b> No</b-row>
						<b-row v-if="row.item.status == 0"><b>Estado:</b> En Proceso </b-row>
		  				<b-row v-else><b>Estado:</b> Terminado</b-row>
		  				<b-row v-if="row.item.rating == 1"><b>Mayor de 18 : </b>Si</b-row>
		  				<b-row v-else><b>Mayor de 18 :</b> No</b-row>
		  				<b-row><i>Actualizada {{ row.item.date }}</i></b-row>
					</b-col>
		  		</b-row>
		  	</template>
		  	<template slot="acciones" class="text-center" slot-scope="row">
		  		<div class="row">
					<label style="margin-right:15px; margin-top: 5px;"><b>Publicado:</b></label>
				  	<div class="checkbox checbox-switch switch-primary">
					    <label>
					        <input type="checkbox" class="check" @click="privateSummernote(row.item)" :checked="! row.item.private" >
					        <span></span>                                        
					    </label>
					</div>
		  		</div>
		  		<div class="row">
		  			<label style="margin-right:12px; margin-top: 5px;"><b>Terminado: </b></label>
		  			<div class="checkbox checbox-switch switch-primary">
					    <label>
					        <input type="checkbox" class="check" @click.stop="statusSummernote(row.item)" :checked="row.item.status" >
					        <span></span>                                        
					    </label>
					</div>
		  		</div>
		  		<div class="row">
                    <div class="social">
	                    <li class="Editar" @click="redirect('/summernote/'+row.item.id+'/edit')" v-b-tooltip.hover.left title="Editar Información"><span><i class="fa fa-edit fa-2x"></i></span></li>
	                    <li class="SegEs" @click="redirect('/summernote/'+ row.item.id + '/edit/content')" v-b-tooltip.hover.bottom title="Seguir Escribiendo"><span><i class="material-icons">more_horiz</i></span></li>
	                    <li class="Eliminar" @click.stop="infoModalDelete(row.item)" v-b-tooltip.hover.right title="Eliminar"><span><i class="material-icons fa-2x">delete_sweep</i></span></li>
                    	<li class="PDF" @click="pdf(row.item.id)" v-b-tooltip.hover.bottom title="Exportar a PDF"><span><i class="material-icons fa-2x">picture_as_pdf</i></span></li>
                    </div>
		  		</div>
		  		
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
                <b-pagination :total-rows="totalRows" :per-page="perPage" v-model="currentPage" class="my-0" />
            </b-col>
            <b-col md="6" class="my-1">
                <b-form-group horizontal label="Per page" class="mb-0">
                    <b-form-select :options="pageOptions" v-model="perPage" />
                </b-form-group>
            </b-col>

        </b-row>   
   

	</div>
	<b-modal ref="modalSummernoteDelete" id="modalSummernoteDelete" @ok="deleteOk" @hide="resetModal">
           <p><img src="https://img.icons8.com/color/48/000000/warning-shield.png">¿Estas seguro de querer eliminar a este Libro?</p>
           <label style="visibility: hidden">id :{{ modalSummernoteDelete.objectSummernote.id }}</label>
           <p><b>Nombre: </b>{{modalSummernoteDelete.objectSummernote.name  }}</p>
           <p align="justify"><b>Descripcion: </b>{{ modalSummernoteDelete.objectSummernote.abstract  }}</p>
           <label visible:=false value=""></label>  
        </b-modal>
	</div>
 	
</template>

<script>
export default {
	props: ['id'],
  data () {
    return {
    	summernotes:[],
    	idSummernoteDelete:0,
    	modalSummernoteDelete:{
			objectSummernote:{},
		},
		currentPage: 1,
        perPage: 5,
        pageOptions: [ 5, 10, 15 ],
        totalRows: 0,
      fields: {
            name: {
            key: 'obras',
            label: 'Mis Obras',
            sortable: true
            },
            acciones: {
              label: 'Acciones',
              sortable: false
            },
		 },
		 filter: null,    
    }
  },
  mounted(){
  	this.getSummernotes();
  },
  methods:{  
  	redirect(route){
  		window.location.href = route;
  	},
  	pdf(idSummernote){
  		window.open('/exportPdf/'+idSummernote);  		
  	},
  	statusSummernote(summernote , button){
  		axios.post('/statusSummernote',{
            idSummernote: summernote.id,
            status : summernote.status	                
        }).then(response =>{
        	console.log(response.data);
        	this.getSummernotes();

        }).catch(error =>{
            console.log(error.response)
        });
  	},
  	privateSummernote(summernote){
  		axios.post('/publicarSummernote',{
            idSummernote: summernote.id,
            private : summernote.private	                
        }).then(response =>{
        	console.log(response.data);
        	if(response.data != 0 && response.data != 1){
        		 alert(response.data);
        		 this.getSummernotes();

        	}
        	this.getSummernotes();

        }).catch(error =>{
            console.log(error.response)
        });
  	},	
  	 getSummernotes(){
        axios.get('/summernotes/Data/'+this.id).then(response =>{ //NO TRAER EL CONTENIDO DEL LIBRO
            console.log(response)
            this.summernotes=response.data
            this.totalRows=response.data.length
        })  	
    },
     infoModalDelete (item, index, button) {
	      this.item=JSON.parse(JSON.stringify(item))
	      this.modalSummernoteDelete.objectSummernote = this.item
	      this.idSummernoteDelete=this.item.id
	      this.$root.$emit('bv::show::modal', 'modalSummernoteDelete', button)
	    },
	    resetModal () {
	      this.modalSummernoteDelete.objectSummernote=''
	      this.idSummernoteDelete=0
	    },
	    deleteOk(evt){
	        axios.delete('/summernote/'+this.idSummernoteDelete).then(response=>{
	            console.log(response);
	            this.getSummernotes();
	        }).catch(error=>{
	            console.log(error);
	        })
	    },
		onFiltered (filteredItems) {
          // Trigger pagination to update the number of buttons/pages due to filtering
          this.totalRows = filteredItems.length
          this.currentPage = 1
        },

  }
};
</script>
<style >
	thead{
		background-color: #e6bc53;
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
	.material-icons.md-10 { 
		font-size: 13px; 
	}

	/*panel*/
	.social {
	    position: relative;
	    height: 1em;
	    width: 10.5em;
	    margin-top: 50px;
	    margin-left: 40px;
	}

	.social li {
	    display: block;
	    height: 3em;
	    line-height: 4em;
	    margin: -2.2em;
	    position: absolute;
	    -webkit-transition: -webkit-transform .7s;
	    -moz-transition: -moz-transform .7s;
	    -ms-transition: -ms-transform .7s;
	    -o-transition: -o-transform .7s;
	    transition: transform .7s;
	    -webkit-transform: rotate(45deg);
	    -moz-transform: rotate(45deg);
	    -ms-transform: rotate(45deg);
	    -o-transform: rotate(45deg);
	    transform: rotate(45deg);
	    text-align: center;
	    width: 3em;
	    cursor: pointer;

	}

	.social span {
	    color: #fffdf0;
	    display: block;
	    height: 30px;
	    text-align: center;
	    -webkit-transform: rotate(-45deg);
	    -moz-transform: rotate(-45deg);
	    -ms-transform: rotate(-45deg);
	    -o-transform: rotate(-45deg);
	    transform: rotate(-45deg);
	    width: 36px; 
	  
	}

	.social li:hover {
	  -webkit-transform: scale(1.1,1.1) rotate(45deg);;
	    -moz-transform: scale(1.1,1.1) rotate(45deg);;
	  -ms-transform: scale(1.1,1.1) rotate(45deg);;
	    -o-transform: scale(1.1,1.1) rotate(45deg);;
	  transform: scale(1.1,1.1) rotate(45deg);;
	}
	.Editar {
	    background: #155b9d;
	    left: 0;
	    top: 0%;
	}

	.SegEs {
	    background: #1a9ec4;
	    bottom: 0;
	    left: 25%;
	}
	.Eliminar {
	    background: #e11a30;
	    left: 50%;
	    top: 0%;
	}
	.PDF{
	    background: #3f7aa3;
	    bottom: 0;
	    left: 75%;
	}
	.tooltip {
	    max-width: 200px;
	    padding: 3px 8px;
	    color: #fff;
	    text-align: center;
	    background-color: #000;
	    border-radius: .25rem;
	}
</style>