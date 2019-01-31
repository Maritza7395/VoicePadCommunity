<template>
    <b-container fluid>   
      <div class="row">
        <div class="col-md-12 shadow-lg mb-4 bg-white rounded">
          <div class="row" style="background-color: rgba(171, 171, 171, 0.1);">
            <div class="col-md-3" style="margin: 6px 0px 6px 0px; border-right: 1px solid gray;">
              <h5 style="margin: 5px 0px 0px 5px;"><img src="https://img.icons8.com/color/48/000000/sorting-options.png" width="40">F I L T R A D O </h5>
            </div>
            <div class="col-md-9">
              <div class="row" style="margin: 10px 0px 1px 0px;">
                <div class="col-md-4">
                  <b-input-group>
                    <b-form-input v-model="filter" placeholder="Buscar" />
                    <b-input-group-append>
                      <b-btn :disabled="!filter" @click="filter = ''">Limpiar</b-btn>
                    </b-input-group-append>
                  </b-input-group>
                </div>
                <div class="col-md-7">
                  <form  v-on:submit.prevent="createAdministrator"  class="form-horizontal" >
                    <div class="row">
                        <label class="control-label col-md-2" style="margin-top: 8px;" for="email"><b>Email:</b></label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="Email" id="email" name="email" v-model="email">
                            <span v-if="errorsCreate.email" class="error">{{ errorsCreate.email[0] }}</span>
                        </div>
                        <div class="col-md-4">
                          <button type="submit" style="height: 35px; margin-top: -1px;" class="btn bg-blue fs-it-btn"><i class="fa fa-plus" aria-hidden="true"></i><span class="fs-it-btn-vertical-line"></span>Añadir Email</button>
                        </div>
                    </div>    
                  </form>
                </div>
                <div class="col-md-1" style="padding: 0;">
                  <b-btn @click='printFunc()' variant="outline-secondary" v-b-tooltip.hover title="Imprimir"><img src="https://img.icons8.com/color/48/000000/print.png" width="20"></b-btn>
                </div>
              </div>  
            </div>
          </div>    
        </div>  
      </div>  
      <div class="row">
        <b-alert :show="showDismissibleAlert" dismissible fade variant="success" style="width:100%;">Correo enviado exitosamente a {{ emailAlert }}</b-alert>     
      </div>
        <b-table ref="tableAdministrators" id="tableAdministrators" show-empty
                    stacked="md"
                     :items="administrators"
                     :fields="fields"
                     :current-page="currentPage"
                     :per-page="perPage"
                     :filter="filter"
                     @filtered="onFiltered"
            >

              <template slot="id" slot-scope="row">{{row.value}}</template>
              <template slot="email" slot-scope="row">{{ row.value }}</template>
              <template slot="registered" slot-scope="row">
              <div v-if="row.value == 0">No</div>
              <div v-else>Si</div> 
              </template>
              <template slot="accions" slot-scope="row">
                    <b-button size="sm" @click.stop="edit(row.item)"  class="btn-outline-primary" v-b-tooltip.hover.bottom title="Editar"><img src="https://img.icons8.com/small/16/000000/edit.png"></b-button>
                    <b-button size="sm" @click.stop="info(row.item)" v-if="userAuth.email !== row.item.email" class="btn-outline-danger" v-b-tooltip.hover.bottom title="Eliminar"><img src="https://img.icons8.com/small/16/000000/delete.png"></b-button>
                    <b-button size="sm" v-if="row.item.registered == 0" @click.stop="sendEmail(row.item)" class="btn-outline-success" v-b-tooltip.hover.bottom title="Reenviar Email"><img src="https://img.icons8.com/small/16/000000/forward-message.png"></b-button>
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
        
        <!-- Modal Eliminar -->
        <b-modal ref="modalDelete" id="modalDelete" @ok="deleteOk" @hide="resetModal">
           <p><img src="https://img.icons8.com/color/48/000000/warning-shield.png">Si lo eliminas este Usuario dejara de ser Administrador</p>
           <div class="col-md-8 offset-2">
              <p><b>id: </b>{{ modalDelete.name.id }}</p>
              <p><b>Email: </b>{{ modalDelete.name.email }}</p>
              <p><b>Descripcion: </b>{{ modalDelete.name.registered }}</p>
              <label visible:=false value=""></label>  
           </div>
        </b-modal>
        <!-- modal eliminar -->
        <!-- Modal Editar -->
        <b-modal ref="modal" id="modalEdit" @ok="editOk" @hide="resetModal" title="Editar" >
            <b-container fluid>
                <form @submit.stop.prevent="editAdministrator">
                  <b-row>
                    <b-col cols="3" style="margin-top: -12px;"><img src="https://img.icons8.com/color/48/000000/edit-property.png"></b-col>
                    <b-col class="justify-content-md-center"><h4>Editar</h4></b-col>
                  </b-row>
                  <br>
                <b-row>
                    <b-col cols="3" style="margin-top: 8px;"><b>Email:</b></b-col>
                    <b-col class="justify-content-md-center">
                        <b-row ><b-form-input type="text" placeholder="Email" v-model="emailEdit" ></b-form-input></b-row>
                        <b-row class="justify-content-md-center" ><span v-if="errorsEdit.email" class="alert alert-danger">{{ errorsEdit.email[0] }}</span></b-row>                        
                    </b-col>
                </b-row>
                <br>
                <!-- <b-row>
                    <b-col cols="3">Registrado</b-col>
                        <b-col class="justify-content-md-center">
                        <b-row ><b-form-input type="text" placeholder="registered" v-model="descriptionEdit" ></b-form-input></b-row>
                        <b-row class="justify-content-md-center" ><span v-if="errorsEdit.registered" class="error">{{ errorsEdit.registered[0] }}</span></b-row>                        
                    </b-col>                    
                </b-row> -->
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
                email: {
                    key:'email',
                  label: 'Email ',
                  sortable: true
                },
                registered: {
                    key:'registered',
                  label: 'Registrado',
                  sortable: false
                },
                accions:{
                    key:'accions',
                    label: 'Acciones'
                }
            },
            userAuth:[],
            modalDelete: {name:'' },
            modalEdit: {name:'' },
            administrators: [],
            currentPage: 1,
            perPage: 10,
            pageOptions: [ 10, 25, 50 ],
            totalRows:0,
            filter: null,
            idAdministratorDelete: 0,
            idAdministratorEdit: 0,            
            administrator:{
                id: 0,
                email: '',
                registered:''
            },
            emailEdit:'',
            email:'',
            // descriptionEdit:'',
            errorsCreate:[],
            errorsEdit:[],
            errors:[],
            showDismissibleAlert:false,
            emailAlert:'',
        }
    },
    mounted() {
        this.getAdministrators();
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
       htmlTable(){
        var html = "";
        html+='<table id="t01">'+
            "<tr>"+
              "<th>Numero</th>"+
              "<th>email</th> "+
              "<th>Registrado</th>"+           
              "<th>Fecha de Creación</th> "+
              "<th>Fecha de Actualización</th> "+
            "</tr>";
        for(var i=0; i<this.administrators.length; i++){
          html+= "<tr>"+
                  "<td>"+ this.administrators[i]['id']+"</td>"+  
                  "<td>"+this.administrators[i]['email']+"</td>";
                  if(this.administrators[i]['registered'] == 1){
                    html += "<td>Si</td>";
                  }
                  else{
                    html += "<td>No</td>";
                  }                   
                  html += "<td>"+this.administrators[i]['created_at']+"</td>"+ 
                  "<td>"+this.administrators[i]['updated_at']+"</td>"+ 
                  "</tr>";              
        }  
        html +=  "</table>"; 
        return html;
      },
      printFunc() {   
        var newWin = window.open();
        var htmlToPrint = "<tr>"+
                            "<td><p style='text-align:center;'>Administradores</p></td>"+
                            "<td><p style='text-align:right;'> Registros: "+this.administrators.length+"</p></td>"+
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
        sendEmail(item, index, button){
          axios.post('/sendEmail',{
                email: item.email,
            }).then(response =>{
              if(response.data == 'failed'){
                alert("No se puede realizar esta accion");
              }
              else{
                this.emailAlert=response.data;
                this.showDismissibleAlert=true;                
                this.getAdministrators();
              }
              
            }).catch(error =>{
                console.log(error.response)               
            });

        },
        getAdministrators(){
            this.errorsCreate=[],
            this.errorsEdit=[],
            axios.get('/administradores/Data').then(response =>{
                console.log(response)
                this.administrators=response.data
                this.totalRows=response.data.length
            })
        },
        info (item, index, button) {
          this.item=JSON.parse(JSON.stringify(item))
          this.modalDelete.name = this.item
          this.idAdministratorDelete=this.item.id
          this.$root.$emit('bv::show::modal', 'modalDelete', button)
        },
         edit (item, index, button) {
          this.item=JSON.parse(JSON.stringify(item))
          this.modalEdit.name = this.item
          this.emailEdit=this.modalEdit.name.email
          this.idAdministratorEdit=this.item.id
          this.$root.$emit('bv::show::modal', 'modalEdit', button)
        },
        resetModal () {
          this.modalDelete.name=''
          this.modalEdit.name=''
          this.errorsEdit=[],
          //this.idCategoryEdit=0
          this.idAdministratorDelete=0
        },
        onFiltered (filteredItems) {
          // Trigger pagination to update the number of buttons/pages due to filtering
          this.totalRows = filteredItems.length
          this.currentPage = 1
        },
        deleteOk(evt){
            axios.delete('/administradores/'+this.idAdministratorDelete).then(response=>{
                if(response.data == 'ok'){
                  location.reload();
                }
                else{
                  alert('No tienes autorizacion para realizar esta accion');
                }
                
            }).catch(error=>{
                console.log(error);
                if(error.response.status==500){
                    this.$refs.modal.hide();
                    alert("Este Administrator no puede ser Eliminado");
                }
            })
        },
        createAdministrator: function(){
            axios.post('/administradores',{
                email: this.email,
            }).then(response =>{ 
                  this.email='';
                  this.showDismissibleAlert=true;
                  this.emailAlert=response.data;
                  this.getAdministrators();
                
                
            }).catch(error =>{
                console.log(error.response)
                if(error.response.status==422){
                    this.errorsCreate=error.response.data.errors
                }
                else{
                  alert('No se ah podido realizar esta accion');
                }
            });
        },
        editAdministrator: function(){
            axios.put('/administradores/'+this.idAdministratorEdit,{
                email: this.emailEdit,
            }).then(response =>{
                if(response.data == 'failed'){
                  alert('No tienes autorizacion para realizar esta accion');
                }
                else{
                  this.email='';
                  this.$refs.modal.hide();
                  this.getAdministrators();
                }
            }).catch(error =>{
                if(error.response.status==422){
                    this.errorsEdit=error.response.data.errors;

                }
                
            });
        },
        editOk (evt) {
          // Prevent modal from closing
          evt.preventDefault()
          if (!this.emailEdit ) {
            alert('Ingrese el email')
          } 
          else {
            this.editAdministrator();
            this.getAdministrators();
            
          }
        }
        

    }
};
 
</script>
<style>
.error{
  color:red;
}
</style>
