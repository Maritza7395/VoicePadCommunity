<template>
    <b-container fluid>        
       <div class="row">
        <div class="col-md-12">
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
                        <form  v-on:submit.prevent="createCommand"  class="form-horizontal" >
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
                              <b-btn @click='printFunc()' variant="outline-secondary" style="margin-top: -4px;" v-b-tooltip.hover.bottom title="Imprimir"><img src="https://img.icons8.com/color/48/000000/print.png" width="25"></b-btn>
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
                <b-table ref="tableCommand" id="tableCommand" show-empty
                    stacked="md"
                     :items="commands"
                     :fields="fields"
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
        </div>
        <!-- Modal Eliminar -->
        <b-modal ref="modalDelete" id="modalDelete" @ok="deleteOk" @hide="resetModal">
          <p><img src="https://img.icons8.com/color/48/000000/warning-shield.png"><b>¿Seguro que quieres eliminar este Genero?</b></p>
           <p><b>Nombre: </b>{{ modalDelete.name.name }}</p>
           <p><b>Descripcion: </b>{{ modalDelete.name.description }}</p>
           <label visible:=false value=""></label>  
        </b-modal>
        <!-- modal eliminar -->
        <!-- Modal Editar -->
        <b-modal ref="modal" id="modalEdit" @ok="editOk" @hide="resetModal" title="Editar" >
            <b-container fluid>
                <form @submit.stop.prevent="editCommand">
                  <b-row>
                    <b-col cols="3" style="margin-top: -12px;"><img src="https://img.icons8.com/color/48/000000/edit-property.png"></b-col>
                    <b-col class="justify-content-md-center"><h4>Editar</h4></b-col>
                  </b-row>
                <b-row>
                    <b-col cols="3">Nombre</b-col>
                    <b-col class="justify-content-md-center">
                        <b-row ><b-form-input type="text" placeholder="Nombre" v-model="nameEdit" ></b-form-input></b-row>
                        <b-row class="justify-content-md-center" ><span v-if="errorsEdit.name" class="alert alert-danger">{{ errorsEdit.name[0] }}</span></b-row>                        
                    </b-col>
                </b-row>
                <br>
                <b-row>
                    <b-col cols="3">Descripcion</b-col>
                        <b-col class="justify-content-md-center">
                        <b-row ><b-form-input type="text" placeholder="Descripcion" v-model="descriptionEdit" ></b-form-input></b-row>
                        <b-row class="justify-content-md-center" ><span v-if="errorsEdit.description" class="error">{{ errorsEdit.description[0] }}</span></b-row>                        
                    </b-col>                    
                </b-row>
          </form>
            </b-container>
            
        </b-modal>
        <!-- modal Editar -->
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
            modalDelete: {name },
            modalEdit: {name },
            commands: [],
            currentPage: 1,
            perPage: 10,
            pageOptions: [ 10, 25, 50 ],
            totalRows: 0,
            filter: null,
            idCommandDelete: 0,
            idCommandEdit: 0,            
            command:{
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
        this.getCommands()
    },
    methods:{
       htmlTable(){
        var html = "";
        html+='<table id="t01">'+
            "<tr>"+
              "<th>Numero</th>"+
              "<th>Nombre</th> "+
              "<th>Descripcion</th>"+      
              "<th>Fecha de Creación</th> "+
              "<th>Fecha de Actualización</th> "+
            "</tr>";
        for(var i=0; i<this.commands.length; i++){
          html+= "<tr>"+
                  "<td>"+ this.commands[i]['id']+"</td>"+  
                  "<td>"+this.commands[i]['name']+"</td>"+  
                  "<td>"+this.commands[i]['description']+"</td>"+
                  "<td>"+this.commands[i]['created_at']+"</td>"+ 
                  "<td>"+this.commands[i]['updated_at']+"</td>"+ 
                  "</tr>";              
        }  
        html +=  "</table>"; 
        return html;
      },
      printFunc() {       
       
        var newWin = window.open();
        var htmlToPrint = "<tr>"+
                            "<td><p style='text-align:center;'>Comandos</p></td>"+
                            "<td><p style='text-align:right;'> Registros: "+this.commands.length+"</p></td>"+
                          "</tr>";
        htmlToPrint += this.htmlTable();
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
        getCommands(){
            this.errorsCreate=[],
            this.errorsEdit=[],
            axios.get('/comandos/Data').then(response =>{
                console.log(response)
                this.commands=response.data
                this.totalRows=response.data.length
            })
        },
        info (item, index, button) {
          this.item=JSON.parse(JSON.stringify(item))
          this.modalDelete.name = this.item
          this.idCommandDelete=this.item.id
          this.$root.$emit('bv::show::modal', 'modalDelete', button)
        },
         edit (item, index, button) {
          this.item=JSON.parse(JSON.stringify(item))
          this.modalEdit.name = this.item
          this.nameEdit=this.modalEdit.name.name
          this.descriptionEdit=this.modalEdit.name.description
          this.idCommandEdit=this.item.id
          this.$root.$emit('bv::show::modal', 'modalEdit', button)
        },
        resetModal () {
          this.modalDelete.name=''
          this.modalEdit.name=''
          this.errorsEdit=[],
          //this.idCategoryEdit=0
          this.idCommandDelete=0
        },
        onFiltered (filteredItems) {
          // Trigger pagination to update the number of buttons/pages due to filtering
          this.totalRows = filteredItems.length
          this.currentPage = 1
        },
        deleteOk(evt){
            axios.delete('/comandos/'+this.idCommandDelete).then(response=>{
                console.log(response);
                this.getCommands();
            }).catch(error=>{
                console.log(error);
                if(error.response.status==500){
                    this.$refs.modal.hide();
                    alert("no se ha podido realizar esta accion");
                }
            })
        },
        createCommand: function(){
            axios.post('/comandos',{
                name: this.name,
                description:this.description
            }).then(response =>{
                this.name='';
                this.description='';
                this.getCommands();
            }).catch(error =>{
                console.log(error.response)
                if(error.response.status==422){
                    this.errorsCreate=error.response.data.errors
                }
                else if(error.response.status==500){
                    alert("no se ha podido realizar esta accion");
                }
            });
        },
        editCommand: function(){
            axios.put('/comandos/'+this.idCommandEdit,{
                name: this.nameEdit,
                description:this.descriptionEdit
            }).then(response =>{
                this.name='';
                this.description='';
                //this.getCategories();
                this.$refs.modal.hide();
                this.getCommands();
            }).catch(error =>{
                //console.log(error.response.status);
                if(error.response.status==422){
                    this.errorsEdit=error.response.data.errors;
                }
                else if(error.response.status==500){
                    alert("no se ha podido realizar esta accion");
                }
                
            });
        },
        editOk (evt) {
          // Prevent modal from closing
          evt.preventDefault()
          if (!this.nameEdit && !this.descriptionEdit ) {
            alert('Ingrese todos los datos')
          } 
          else {
            this.editCommand();
            this.getCommands();
            
          }
        }
        

    }
}
 
</script>
