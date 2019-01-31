<template>
     <b-container>   
      <section id="Pestañas">

      <div class="row">
        <div class="col-md-12">
        <nav>
          <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Añadir nuevos géneros</a>
            <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Filtrado</a>
          </div>
        </nav>
        <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
          <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
            <b-row>
              <div class="col-md-12 shadow-lg mb-4 bg-white rounded">
                <div class="row" style="background-color: rgba(171, 171, 171, 0.1);">
                  <div class="col-md-2" style="margin: 6px 0px 6px 0px; padding: 0; border-right: 1px solid gray;">
                    <h5 style="margin: 5px 0px 0px 20px;"><img src="https://img.icons8.com/color/48/000000/plus-2-math.png" width="40">A Ñ A D I R</h5>
                  </div>
                  <div class="col-md-10" style="padding: 0;">
                    <div class="row" style="margin: 10px 0px 1px 0px;">
                      <b-col md="3">
                        <b-input-group>
                          <b-form-input v-model="filter" placeholder="Buscar" />
                          <b-input-group-append>
                            <b-btn :disabled="!filter" @click="filter = ''">Limpiar</b-btn>
                          </b-input-group-append>
                        </b-input-group>
                      </b-col>
                      <b-col md="9">
                        <form  v-on:submit.prevent="createGenre"  class="form-horizontal" >
                          <div class="row">
                            <label class="control-label" style="margin-top: 8px;" for="name"><b>Nombre:</b></label>
                            <div class="col-md-3">
                                <input type="text" class="form-control" placeholder="Nombre" id="name" name="name" v-model="name">
                                <span v-if="errorsCreate.name" class="error">{{ errorsCreate.name[0] }}</span>
                            </div>

                             <label class="control-label" style="color:black; margin-top: 8px;" for="description"><b>Descripcion:</b></label>
                            <div class="col-md-3">
                                <input type="text" class="form-control" placeholder="Descripcion" id="description" name="description" v-model="description">
                                <span v-if="errorsCreate.description" class="error">{{ errorsCreate.description[0] }}</span>
                            </div>
                            <div class="col-md-1" style="margin: -5px 0 0 8px; padding: 0;">
                              <button type="submit" style="height: 35px;" class="btn bg-blue fs-it-btn"><i class="fa fa-plus" aria-hidden="true"></i><span class="fs-it-btn-vertical-line"></span>Añadir</button>
                            </div>
                            <div class="col-md-1" style="margin: 5px 0 0 12px;">
                              <b-btn @click='printFunc("Generos")' variant="outline-secondary" style="margin-top: -4px;" v-b-tooltip.hover.bottom title="Imprimir"><img src="https://img.icons8.com/color/48/000000/print.png" width="25"></b-btn>
                            </div>
                            <div class="col-sm-1" style="margin-top: 1px;">
                              <b-btn @click="excel('Generos')" variant="outline-success" v-b-tooltip.hover.bottom title="Exportar a Excel"><img src="https://png.icons8.com/color/50/000000/ms-excel.png" width="25"></b-btn>
                            </div>
                          </div>
                        </form>
                      </b-col>
                    </div>
                  </div>
                </div>  
              </div>
            </b-row>
              <b-col cols="12">
                <b-table ref="tableGenre" id="tableGenre" show-empty
                            stacked="md"
                             :items="genres"
                             :fields="fieldsAdd"
                             :current-page="currentPage"
                             :per-page="perPage"
                             :filter="filter"
                             @filtered="onFiltered"
                    >
                    <template slot="id" slot-scope="row">{{row.value}}</template>
                    <template slot="name" slot-scope="row">{{ row.value }}</template>
                    <template slot="description" slot-scope="row">
                    <div v-if="row.value==null">Sin Descripcion</div>
                    <div v-else>{{ row.value }}</div> 
                    </template>
                    <template slot="accions" slot-scope="row">
                      <b-button @click.stop="edit(row.item)" class="btn-outline-primary" v-b-tooltip.hover.bottom title="Editar"><img src="https://img.icons8.com/small/16/000000/edit.png"></b-button>
                      <b-btn @click.stop="info(row.item)" class="btn-outline-danger" v-b-tooltip.hover.bottom title="Eliminar"><img src="https://img.icons8.com/small/16/000000/delete.png"></b-btn>
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
                      <b-form-group horizontal class="mb-0">
                           <b-row>
                            <b-col md="6" style="margin-top: 8px; padding: 0;">
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
          </div>


          <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
            <div class="row">
              <div class="col-md-10 offset-1 shadow-lg mb-4 bg-white rounded">
                <div class="row" style="background-color: rgba(171, 171, 171, 0.1);">
                  <div class="col-md-3" style="margin: 6px 0px 6px 0px; border-right: 1px solid gray;">
                    <h5 style="margin: 5px 0px 0px 5px;"><img src="https://img.icons8.com/color/48/000000/sorting-options.png" width="40">F I L T R A D O </h5>
                  </div>
                  <div class="col-md-9">
                    <div class="row" style="margin: 10px 0px 1px 0px;">
                      <div class="col-md-4">
                        <b-form-select v-model="selected" class="mb-3">
                          <option value="all">Todos</option>
                          <option value="desc">Mas utilizados</option>
                          <option value="asc">Menos utilizados</option>
                        </b-form-select>
                      </div>
                      <div class="col-md-5"  v-if="selected != 'all'" >
                        <div class="row">
                          <div class="col-md-3"  style="padding: 8px 0 0 0px;">
                            <label><b>Registros:</b></label>
                          </div>
                          <div class="col-md-9">
                            <b-input class="mb-1 mr-sm-1 mb-sm-0" style="height: 35px;" size="sm" type="number" v-model="limit"></b-input> 
                          </div>                          
                        </div>
                      </div>
                      <div class="col-md-3">
                        <b-btn variant="primary" style="height: 34px;" id="search" class="col-md-12" v-bind:class="[(limit <= 0) && (selected != 'all') ? classButtonSearch : '']" @click.stop="search()" >Buscar</b-btn>
                      </div>
                       <div class="col-md-1" style="margin: 5px 0 0 12px;">
                          <b-btn @click='printFunc()' variant="outline-secondary" style="margin-top: -4px;" v-b-tooltip.hover.bottom title="Imprimir"><img src="https://img.icons8.com/color/48/000000/print.png" width="25"></b-btn>
                        </div>
                        <div class="col-sm-1" style="margin-top: 1px;">
                          <b-btn @click="excel()" variant="outline-success" v-b-tooltip.hover.bottom title="Exportar a Excel"><img src="https://png.icons8.com/color/50/000000/ms-excel.png" width="25"></b-btn>
                        </div>
                </div>  
                  </div>
                </div>    
              </div>  
            </div>
            <b-row>
              <b-col cols="10" class="offset-1">
                <b-table ref="tableGenre" id="tableGenre" show-empty
                            stacked="md"
                             :items="genresFilter"
                             :fields="fieldsFilter"
                             :current-page="currentPage"
                             :per-page="perPage"
                             :filter="filter"
                             @filtered="onFiltered">
                      <template slot="id" slot-scope="row">{{row.value}}</template>
                      <template slot="name" slot-scope="row">{{ row.value }}</template>
                      <template slot="description" slot-scope="row">
                      <div v-if="row.value==null">Sin Descripcion</div>
                      <div v-else>{{ row.value }}</div> 
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
                      <b-form-group horizontal class="mb-0">
                          <b-row>
                            <b-col md="6" style="margin-top: 8px; padding: 0;">
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
          </div>
         </div>
        </div>
      </div>
    </section>

        <!-- Modal Eliminar -->
        <b-modal ref="modalDelete" id="modalDelete" @ok="deleteOk" @hide="resetModal">
          <p><img src="https://img.icons8.com/color/48/000000/warning-shield.png"><b>¿Seguro que quieres eliminar este Genero?</b></p>
           <p><b>Nombre: </b>{{ modalDelete.name.name }}</p>
           <p><b>Descripcion: </b>{{ modalDelete.name.description }}</p>
           <label visible:=false value=""></label>  
        </b-modal>
        <!-- modal eliminar -->
        <!-- Modal Editar -->
        <b-modal ref="modal" id="modalEdit" @ok="editOk" @hide="resetModal">
          <form @submit.stop.prevent="editGenre">
            <b-row>
              <b-col cols="3" style="margin-top: -12px;"><img src="https://img.icons8.com/color/48/000000/edit-property.png"></b-col>
              <b-col class="justify-content-md-center"><h4>Editar</h4></b-col>
            </b-row>
            <b-row>
              <b-col cols="3"><b>Nombre:</b></b-col>
              <b-col class="justify-content-md-center">
                  <b-row style="width: 90%;"><b-form-input type="text" placeholder="Nombre" v-model="nameEdit" ></b-form-input></b-row>
                  <b-row class="justify-content-md-center" ><span v-if="errorsEdit.name" class="alert alert-danger">{{ errorsEdit.name[0] }}</span></b-row>         
              </b-col>
            </b-row>
            <br>
            <b-row>
                <b-col cols="3"><b>Descripcion:</b></b-col>
                    <b-col class="justify-content-md-center">
                    <b-row style="width: 90%;"><b-form-input type="text" placeholder="Descripcion" v-model="descriptionEdit" ></b-form-input></b-row>
                    <b-row class="justify-content-md-center" ><span v-if="errorsEdit.description" class="error">{{ errorsEdit.description[0] }}</span></b-row>                        
                </b-col>                    
            </b-row>
          </form>
        </b-modal>
        <!-- modal Editar -->
    </b-container>
</template>

<script>
export default {
    data () {
        return {            
          // Note 'isActive' is left out and will not appear in the rendered table
            title: 'Generos',
            fieldsAdd: {
                id: {
                  key:'id',
                  label: 'Id',
                  sortable: true
                },
                name: {
                    key:'name',
                  label: 'Nombre ',
                  sortable: true
                },
                description: {
                    key:'description',
                  label: 'Descripcion',
                  sortable: false
                },
                accions:{
                    key:'accions',
                    label: 'Acciones'
                }
            },
            fieldsFilter:{
                id: {
                  key:'id',
                  label: 'Id',
                  sortable: true
                },
                name: {
                    key:'name',
                  label: 'Nombre ',
                  sortable: true
                },
                countGenre: {
                    key:'countGenre',
                  label: 'utilizacion ',
                  sortable: true
                },
                description: {
                    key:'description',
                  label: 'Descripcion',
                  sortable: false
                },               
              },
             classButtonSearch:{
              disabled:true,              
            }, 
            titleTemp : '',
            title : 'Generos',
            limit:0,
            selected:'all',
            modalDelete: {name },
            modalEdit: {name },
            genres: [],
            genresFilter: [],
            currentPage: 1,
            perPage: 10,
            pageOptions: [ 10, 25, 50 ],
            totalRows: genres.length,
            filter: null,
            idGenreDelete: 0,
            idGenreEdit: 0,            
            genre:{
                id: 0,
                name: '',
                description:''
            },
            nameEdit:'',
            name:'',
            description:'',
            descriptionEdit:'',
            errorsCreate:[],
            errorsEdit:[],
            errors:[]
        }
    },
    mounted() {
        this.getGenres();
        this.search();
    },
    methods:{
       htmlTable(title , td , genres){
        var html = "";
          html+='<table id="t01">'+
              "<tr>"+
                "<th>Numero</th>"+
                "<th>Nombre</th> "+
                "<th>Descripcion</th>";
          if(title != null){
            html+="<th>"+title+"</th> ";
          }
          html+="<th>Fecha de Creación</th> "+
                "<th>Fecha de Actualización</th> "+
              "</tr>";
          for(var i=0; i<genres.length; i++){
            html+= "<tr>"+
                    "<td>"+ genres[i]['id']+"</td>"+  
                    "<td>"+genres[i]['name']+"</td>"+  
                    "<td>"+genres[i]['description']+"</td>";
            if(title != null){
              html+="<td>"+genres[i][td]+"</td> ";
            }            
            html+=  "<td>"+genres[i]['created_at']+"</td>"+ 
                    "<td>"+genres[i]['updated_at']+"</td>"+ 
                    "</tr>";              
          }  
          html +=  "</table>"; 
        return html;
      },
      printFunc(titleTemp) { 
        var newWin = window.open();
        if(titleTemp == 'Generos'){
            var htmlToPrint = "<tr>"+
                        "<td><p style='text-align:center;'>"+'Generos'+"</p></td>"+
                        "<td><p style='text-align:right;'> Registros: "+this.genres.length+"</p></td>"+
                        "</tr>";
            var td = null;
            var title = null;
            htmlToPrint += this.htmlTable( title , td, this.genres);
        }else{
            var title = 'Utilizado';
            var td= 'countGenre'; 
            var htmlToPrint = "<tr>"+
                          "<td><p style='text-align:center;'>"+this.title+"</p></td>"+
                          "<td><p style='text-align:right;'> Registros: "+this.genresFilter.length+"</p></td>"+
                        "</tr>";  
             htmlToPrint += this.htmlTable( title , td  ,  this.genresFilter);          
        }       
       
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
       excel(title){
          if(title == 'Generos'){
            var genres = this.genres;
          }else{            
             title = this.title;
            var genres = this.genresFilter;
          }
          if(this.genres.length != 0){  
             axios.post('/excel/genres/reports',{
                  title : title,
                  genres: genres                    
              }).then(response =>{
                console.log(response.data)
                window.open('/excel/reports/'+ response.data)
              }).catch(error =>{
                  console.log(error.response)
              });
          }

        },
      search(){
          if(this.selected == 'all'){
            this.limit = 0;
            this.titleTemp = 'Utilizacion de Generos';
          }
          else if (this.selected == 'desc'){
            this.titleTemp = 'Los '+this.limit +' Generos mas utilizados';
          }
          else{
            this.titleTemp = 'Los '+this.limit +' Generos menos utilizados';
          }

          if((this.limit > 0 && this.selected != 'all' )|| this.selected == 'all'){
            axios.post('/generos/report',{
                limit: this.limit,
                selected: this.selected                   
            }).then(response =>{
              this.title = this.titleTemp;
              // this.title = 'Los '+this.limit+' libros mas Largos'
                this.genresFilter=response.data
                this.totalRows=response.data.length                
             }).catch(error =>{
                console.log(error.response)
            });

          }

        },
        getGenres(){
            this.errorsCreate=[],
            this.errorsEdit=[],
            axios.get('/generos/Data').then(response =>{
                console.log(response)
                this.genres=response.data
                this.totalRows=response.data.length
                 this.fields =  
                  {
                    id: {
                      key:'id',
                      label: 'Id',
                      sortable: true
                    },
                    name: {
                        key:'name',
                      label: 'Nombre ',
                      sortable: true
                    },
                    description: {
                        key:'description',
                      label: 'Descripcion',
                      sortable: false
                    },
                    accions:{
                        key:'accions',
                        label: 'Acciones'
                    }
                }
            })
        },
        info (item, index, button) {
          this.item=JSON.parse(JSON.stringify(item))
          this.modalDelete.name = this.item
          this.idGenreDelete=this.item.id
          this.$root.$emit('bv::show::modal', 'modalDelete', button)
        },
         edit (item, index, button) {
          this.item=JSON.parse(JSON.stringify(item))
          this.modalEdit.name = this.item
          this.nameEdit=this.modalEdit.name.name
          this.descriptionEdit=this.modalEdit.name.description
          this.idGenreEdit=this.item.id
          this.$root.$emit('bv::show::modal', 'modalEdit', button)
        },
        resetModal () {
          this.modalDelete.name=''
          this.modalEdit.name=''
          this.errorsEdit=[],
          this.idGenreDelete=0
        },
        onFiltered (filteredItems) {
          // Trigger pagination to update the number of buttons/pages due to filtering
          this.totalRows = filteredItems.length
          this.currentPage = 1
        },
        deleteOk(evt){
            axios.delete('/generos/'+this.idGenreDelete).then(response=>{
                console.log(response);
                location.reload();
            }).catch(error=>{
                console.log(error);
                if(error.response.status==500){
                    this.$refs.modal.hide();
                    alert("Este Genero no puede ser Eliminada");
                }
            })
        },
        createGenre: function(){
            axios.post('/generos',{
                name: this.name,
                description:this.description
            }).then(response =>{
                this.name='';
                this.description='';
                this.getGenres();
            }).catch(error =>{
                console.log(error.response)
                if(error.response.status==422){
                    this.errorsCreate=error.response.data.errors
                }
            });
        },
        editGenre: function(){
            axios.put('/generos/'+this.idGenreEdit,{
                name: this.nameEdit,
                description:this.descriptionEdit
            }).then(response =>{
                this.name='';
                this.description='';
                this.$refs.modal.hide();
               location.reload();
            }).catch(error =>{
                //console.log(error.response.status);
                if(error.response.status==422){
                    this.errorsEdit=error.response.data.errors;

                }
                
            });
        },
        editOk (evt) {
          // Prevent modal from closing
          evt.preventDefault()
          if (!this.nameEdit ) {
            alert('Ingrese el nombre')
          } 
          else {
            this.editGenre();
            this.getGenres();
            
          }
        }
        

    }
};
 
</script>
