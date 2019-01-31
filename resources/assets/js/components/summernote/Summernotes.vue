<template>
  <b-container>  
    <div class="row">
      <div class="col-md-10 offset-1 shadow-lg mb-4 bg-white rounded">
        <div class="row" style="background-color: rgba(171, 171, 171, 0.1);">
          <div class="col-md-3" style="margin: 6px 0px 6px 0px; border-right: 1px solid gray;">
            <h5 style="margin: 5px 0px 0px 5px;"><img src="https://img.icons8.com/color/48/000000/sorting-options.png" width="40">F I L T R A D O </h5>
          </div>
          <div class="col-md-9">
            <div class="row" style="margin: 10px 0px 1px 0px;">
              <div class="col-md-4">
                <b-form-select v-model="selected">
                <option value="views">Mas Visitados</option>
                <option value="scores" >Mejores Calificados</option>
                <option value="papers" >Mas Paginas</option>
                <option value="favorites" >Favoritos</option>
              </b-form-select>
              </div>
              <div class="col-md-2" style="padding: 8px 0 0 50px;">
                <p><b>Registros:</b></p>
              </div>
              <div class="col-md-3">
                <b-input class="mb-1 mr-sm-1 mb-sm-0"  size="sm" type="number" style="line-height: 2.0" v-model="limit"></b-input> 
              </div>
              <div class="col-md-3">
                <b-btn id="search" variant="primary" style="height: 34px;" class="col-md-12" v-bind:class="[limit <= 0 ? classButtonSearch : '']" @click.stop="search()" >Buscar</b-btn>
              </div>
            </div>  
          </div>
        </div>    
      </div>  
    </div>  
    <b-row>
      <b-col cols="10" class="offset-1">
        <br>
        <b-row>
          <b-col cols="*" class="my-1">
            <b-form inline>              
              <b-input-group>
                <b-form-input v-model="filter" placeholder="Buscar" />
                <b-input-group-append>
                  <b-btn :disabled="!filter" @click="filter = ''">Limpiar</b-btn>
                </b-input-group-append>
              </b-input-group>
              <label class="mr-sm-2"> &nbsp &nbsp {{ summernotes.length }} resultados encontrados  </label>
              <b-btn @click="excel()" variant="outline-success" v-b-tooltip.hover title="Exportar a Excel"><img src="https://png.icons8.com/color/50/000000/ms-excel.png" width="20"></b-btn>
                <b-btn @click='printFunc()' variant="outline-secondary" v-b-tooltip.hover title="Imprimir"><img src="https://img.icons8.com/color/48/000000/print.png" width="20"></b-btn>
            </b-form>
          </b-col>
        </b-row>
        <b-row>
          <template>
            <b-table responsive ref="tableSummenotes" id="tableSummenotes" show-empty
                    stacked="md"
                     :items="summernotes"
                     :fields="fields"
                     :current-page="currentPage"
                     :per-page="perPage"
                     :filter="filter"
                     @filtered="onFiltered"
            >
              <template slot="id" slot-scope="row">{{row.value}}</template>
              <template slot="name" slot-scope="row">{{row.value}}</template> 
              <template slot="complaint_count" slot-scope="row"> {{ row.value }}</template>             
              <template slot="genre" slot-scope="row"> {{ row.value }}</template>  
              <template slot="rating" slot-scope="row"> 
                <div v-if="row.item.rating == 0">No</div>
                <div v-else>Si</div>
            </template>  
            <template slot="private" slot-scope="row"> 
                <div v-if="row.item.private == 0">Si</div>
                <div v-else>No</div>
            </template>              
              <template slot="accions" slot-scope="row">
                    <b-button size="sm" variant="outline-primary" :href="'/summernote/'+ row.item.id" v-b-tooltip.hover.right title="Ver Libro"><img src="https://img.icons8.com/small/16/000000/view-file.png"></b-button>
                    <!-- <b-button size="sm" @click.stop="info(row.item)" class="mr-1">
                        Eliminar
                    </b-button> -->
               
              </template>
              <template slot="row-details" slot-scope="row">
                <b-card>
                  <ul>
                    <li v-for="(value, key) in row.item" :key="key">{{ key }}: {{ value}}</li>
                  </ul>
                </b-card>
              </template>
        </b-table>
        </template>
        </b-row>
        <b-row>
            <b-col md="6" class="my-1">
                <b-pagination :total-rows="totalRows" :per-page="perPage" v-model="currentPage" class="my-0" />
            </b-col>
            <b-col md="6" class="my-1">
                <b-form-group horizontal class="mb-0">
                  <b-row>
                    <b-col md="6" style="margin-top: 8px;">
                      <p><b>Elementos por página</b></p>
                    </b-col>
                    <b-col md="6">
                      <b-form-select :options="pageOptions" v-model="perPage" />
                    </b-col>
                  </b-row>
                </b-form-group>
            </b-col>

        </b-row>   
      </b-col>
    </b-row>
        <!-- Modal Eliminar -->
        <!-- <b-modal id="modalInfo" @ok="deleteOk" @hide="resetModal" title="Eliminar" >
           <pre>¿Estas seguro de querer eliminar a este Usuario?</pre>
           <pre><b>Nombre de Usuario: </b>{{ modalInfo.name.name_user }}</pre>
           <label visible:=false value=""></label>  
        </b-modal> -->
        <!-- modal eliminar -->
    </b-container>
</template>
<script>
export default {
    data () {
        return {
          // Note 'isActive' is left out and will not appear in the rendered table
            fields: {
                id: {
                  key:'id',
                  label: 'Id',
                  sortable: true
                },
                name: {
                    key:'name',
                    label: 'Nombre',
                    sortable: true
                },
                views:{
                	key:'views',
                	label:'Visitas',
                	sortable:true,
                },
                // complaint_count:{
                //     key:'motivations_count',
                //     label: 'Denuncias',
                //     variant: 'danger',
                //     sortable: true
                // },
                user:{
                	key:'user.name_user',
                  	label: 'Usuario'

                },                
                genre: {
                    key:'genre.name',
                  label: 'Genero',
                  sortable: false
                },
                rating: {
                  label: '+18',
                  sortable: false
                },
                private: {                  
                  label: 'Publico',
                  sortable: false
                },
                accions:{
                    key:'accions',
                    label: 'Ver'
                }
                
            },
            classButtonSearch:{
              disabled:true,              
            }, 
            title:'Libros',
            selected:'views',
            limit:5,
            modalInfo: {name },
            summernotes: [],
            currentPage: 1,
            perPage: 10,
            pageOptions: [ 10, 25, 50 ],
            totalRows: 0,
            filter: null,
            idUserDelete: 0,
            // name: '',
            // name_user:'',
            // last_name:'',
            // role_id:0,
            // sex:'',
           
            
        }
    },
    mounted() {
        this.getViews();
    },
    methods:{
      htmlTable(title , td, title2, td2){
        var html = "";
          html+='<table id="t01">'+
              "<tr>"+
                "<th>Numero</th>"+
                "<th>Titulo</th> ";
          if(title != null){
            html+="<th>"+title+"</th> ";
            if(title2 != null){
              html+="<th>"+title2+"</th> ";
            }
          }

          html +="<th>Estado</th>"+
                "<th>Mayor +18</th>"+
                "<th>Publico</th>"+
                "<th>Autor</th>"+
                "<th>Genero</th>"+
                "<th>Fecha de Creación</th> "+
                "<th>Fecha de Actualización</th> "+
              "</tr>";
          for(var i=0; i<this.summernotes.length; i++){
            html+= "<tr>"+
                    "<td>"+ this.summernotes[i]['id']+"</td>"+  
                    "<td>"+this.summernotes[i]['name']+"</td>";
            if(title != null){
              html+="<td>"+this.summernotes[i][td]+"</td> ";
              if(title2 != null){
                html+="<td>"+this.summernotes[i][td2]+"</td> ";
              }
            }
            if(this.summernotes[i]['status'] == 0){
                html += "<td>En Proceso</td>";
            }else{
                html += "<td>Terminado</td>";
            }
            if(this.summernotes[i]['rating'] == 0){
                html += "<td>No</td>";
            }else{
                html += "<td>Si</td>";
            }
            if(this.summernotes[i]['private'] == 0){
                html += "<td>Si</td>";
            }else{
                html += "<td>No</td>";
            }
            html += "<td>"+this.summernotes[i]['user']['name_user']+"</td>"+
                "<td>"+this.summernotes[i]['genre']['name']+"</td>"+
                "<td>"+this.summernotes[i]['created_at']+"</td>"+ 
                "<td>"+this.summernotes[i]['updated_at']+"</td>"+ 
                "</tr>";
        }  
          html +=  "</table>"; 
        return html;
      },
      printFunc() {       
       
        if(this.summernotes[0]['views'] != null){
            var title = 'Visitas';
            var td = 'views';
        }
        else if (this.summernotes[0]['prom'] != null) {
            var title = 'Calificacion';
            var title2 = 'Calificaciones';
            var td = 'prom';
            var td2 = 'totalScore';
        }
        else if (this.summernotes[0]['papers'] != null) {
           var title = 'Hojas';
            var td = 'papers';
        }
        else if (this.summernotes[0]['favorites'] != null) {
            var title = 'Favoritos';
            var td = 'favorites';
        }
        var newWin = window.open();
        var htmlToPrint = "<tr>"+
                            "<td><p style='text-align:center;'>"+this.title+"</p></td>"+
                            "<td><p style='text-align:right;'> Registros: "+this.summernotes.length+"</p></td>"+
                          "</tr>";
        htmlToPrint += this.htmlTable( title , td, title2, td2);
        newWin.document.write(htmlToPrint);
        var x = document.createElement("STYLE");
        var t = document.createTextNode("table {"+
                                     " width:100%;"+
                                 " }"+
                                 " table, th, td {"+
                                      "border: 1px solid black;"+
                                      "border-collapse: collapse;"+
                                  "}"+
                                 " th, td {"+
                                      "padding: 15px;"+
                                      "text-align: left;"+
                                  "}"+
                                  "table#t01 tr:nth-child(even) {"+
                                      "background-color: #eee;"+
                                  "}"+
                                  "table#t01 tr:nth-child(odd) {"+
                                     "background-color: #fff;"+
                                 " }"+
                                 " table#t01 th {"+
                                     " background-color: black;"+
                                     " color: white;"+
                                  "}");   
        x.appendChild(t);
        newWin.document.head.appendChild(x);       
        newWin.print();
        newWin.close();
      }  ,
      excel(){
        if(this.summernotes.length != 0){  
           axios.post('/excel/summernote/reports',{
                summernotes: this.summernotes,
                title : this.title,                    
            }).then(response =>{
              console.log(response.data)
              window.open('/excel/reports/'+ response.data)
            }).catch(error =>{
                console.log(error.response)
            });
        }


      },
    	search(){
    		if(this.limit > 0){
    			switch(this.selected){
	    			case 'views':
	    				this.getViews();
	    				break;
					case 'scores':
						this.getScores();
						break;
					case 'papers':
						this.getPapers();
						break;
					case 'favorites':
						this.getFavorites();
						break;
    			}
    		} 
        else{
          alert('Debe elegir el numero de Registros que necesitas');
        }   		

    	},
    	getFavorites(){
    		axios.post('/favoritos/report',{
                limit: this.limit                   
            }).then(response =>{
                this.title = 'Los '+this.limit+' libros mas favoritos'
                this.summernotes=response.data
                this.totalRows=response.data.length
                this.fields =  {
	                id: {
	                  key:'id',
	                  label: 'Id',
	                  sortable: true
	                },
	                name: {
	                    key:'name',
	                    label: 'Nombre',
	                    sortable: true
	                },
	                favorites:{
	                	key:'favorites',
	                	label:'Favoritos',
	                	sortable:true,
	                },	                 
	                user:{
	                	key:'user.name_user',
	                  	label: 'Usuario'

	                },                
	                genre: {
	                    key:'genre.name',
	                  label: 'Genero',
	                  sortable: false
	                },
	                rating: {
	                  label: '+18',
	                  sortable: false
	                },
	                private: {                  
	                  label: 'Publico',
	                  sortable: false
	                },
	                accions:{
	                    key:'accions',
	                    label: 'Ver'
	                }}
             }).catch(error =>{
                console.log(error.response)
            });


    	},
    	getPapers(){
    		axios.post('/paper/report',{
                limit: this.limit                   
            }).then(response =>{
              this.title = 'Los '+this.limit+' libros mas Largos'
                this.summernotes=response.data
                this.totalRows=response.data.length
                this.fields =  {
	                id: {
	                  key:'id',
	                  label: 'Id',
	                  sortable: true
	                },
	                name: {
	                    key:'name',
	                    label: 'Nombre',
	                    sortable: true
	                },
	                papers:{
	                	key:'papers',
	                	label:'Paginas',
	                	sortable:true,
	                },	                 
	                user:{
	                	key:'user.name_user',
	                  	label: 'Usuario'

	                },                
	                genre: {
	                    key:'genre.name',
	                  label: 'Genero',
	                  sortable: false
	                },
	                rating: {
	                  label: '+18',
	                  sortable: false
	                },
	                private: {                  
	                  label: 'Publico',
	                  sortable: false
	                },
	                accions:{
	                    key:'accions',
	                    label: 'Ver'
	                }}
             }).catch(error =>{
                console.log(error.response)
            });


    	},
    	getScores(){
    		axios.post('/calificacion/report',{
                limit: this.limit                   
            }).then(response =>{
                this.title = 'Los '+this.limit+' libros mejor calificados'
                this.summernotes=response.data
                this.totalRows=response.data.length
                this.fields =  {
	                id: {
	                  key:'id',
	                  label: 'Id',
	                  sortable: true
	                },
	                name: {
	                    key:'name',
	                    label: 'Nombre',
	                    sortable: true
	                },
	                prom:{
	                	key:'prom',
	                	label:'Calificacion',
	                	sortable:true,
	                },
	                totalScore:{
	                	key:'totalScore',
	                	label:'Cantidad',
	                	sortable:true,
	                }, 
	                user:{
	                	key:'user.name_user',
	                  	label: 'Usuario'

	                },                
	                genre: {
	                    key:'genre.name',
	                  label: 'Genero',
	                  sortable: false
	                },
	                rating: {
	                  label: '+18',
	                  sortable: false
	                },
	                private: {                  
	                  label: 'Publico',
	                  sortable: false
	                },
	                accions:{
	                    key:'accions',
	                    label: 'Ver'
	                }}
             }).catch(error =>{
                console.log(error.response)
            });

    	},
    	getViews(){
    		axios.post('/views/report',{
                limit: this.limit                   
            }).then(response =>{
                this.title = 'Los '+this.limit+' libros mas visitados'
                this.summernotes=response.data
                this.totalRows=response.data.length
                this.fields =  {
	                id: {
	                  key:'id',
	                  label: 'Id',
	                  sortable: true
	                },
	                name: {
	                    key:'name',
	                    label: 'Nombre',
	                    sortable: true
	                },
	                views:{
	                	key:'views',
	                	label:'Visitas',
	                	sortable:true,
	                },	               
	                user:{
	                	key:'user.name_user',
	                  	label: 'Usuario'

	                },                
	                genre: {
	                    key:'genre.name',
	                  label: 'Genero',
	                  sortable: false
	                },
	                rating: {
	                  label: '+18',
	                  sortable: false
	                },
	                private: {                  
	                  label: 'Publico',
	                  sortable: false
	                },
	                accions:{
	                    key:'accions',
	                    label: 'Ver'
	                }}
             }).catch(error =>{
                console.log(error.response)
            });

    	},      
        info (item, index, button) {
          this.item=JSON.parse(JSON.stringify(item))
          this.modalInfo.name = this.item
          this.idUserDelete=this.item.id
          this.$root.$emit('bv::show::modal', 'modalInfo', button)
        },
        resetModal () {
          this.modalInfo.name=''
          this.idUserDelete=0
        },
        onFiltered (filteredItems) {
          // Trigger pagination to update the number of buttons/pages due to filtering
          this.totalRows = filteredItems.length
          this.currentPage = 1
        },
        

    }
};
 
</script>
