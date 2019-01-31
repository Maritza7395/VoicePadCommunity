<template>
  <b-container>
      <div class="row">
        <div class="col-md-12 shadow-lg mb-4 bg-white rounded">
          <div class="row" style="background-color: rgba(171, 171, 171, 0.1);">
            <div class="col-md-2" style="margin: 6px 0px 6px 0px; padding-left: 2px; border-right: 1px solid gray;">
              <h5 style="margin: 20px 0px 0px 0px;"><img src="https://img.icons8.com/color/48/000000/sorting-options.png" width="40">F I L T R A D O </h5>
            </div>
            <div class="col-md-10">
              <div class="row" style="margin: 10px 0px 1px 0px;">
                <div class="col-md-3">
                  <b-form-radio-group  v-model="selectedRadio">
                      <b-form-radio value="all">Todos</b-form-radio>
                      <b-form-radio value="desc" >Mas Denunciados</b-form-radio>
                      <b-form-radio value="asc" >Menos Denunciados</b-form-radio>
                    </b-form-radio-group>
                </div>
                <div class="col-md-7" style="padding: 0;">
                  <div class="row" v-if="selectedRadio == 'all' " style="margin: 15px 0px 0px 0px;">
                    <div class="col-md-4">
                      <label class="mr-sm-2">Intervalo por fecha de denuncia: </label>  
                    </div>
                    <div class="col-md-8">
                      <div class="row">
                         <b-input id="fechas" class="mb-1 mr-sm-1 mb-sm-0" size="sm" type="date" @change="changeDatess" :max="max" :min="min"  v-model="dateStart"></b-input>
                        <label class="mr-sm-2">-</label>
                        <b-input id="fechas" class="mb-2 mr-sm-2 mb-sm-0" size="sm" type="date" @change="changeDates" :max="max" :min="min" v-model="dateEnd"></b-input>
                      </div>
                      </div>
                    </div>
                  <div class="row"v-if="(selectedRadio !== 'all')" style="margin-top: 17px;">
                    <div class="col-md-4">
                      <label class="mr-sm-2">Registros: </label>
                    </div>
                    <div class="col-md-8">
                      <div class="row">
                         <b-input class="mb-1 mr-sm-1 mb-sm-0"  size="sm" type="number"  @change="changeLimit" :max="totalComplaint"  v-model="limit"></b-input>
                      </div>
                    </div>
                  </div>  
                  </div>
                <div class="col-md-2" style="margin: 15px 0;">
                  <b-btn id="search" variant="primary" class="col-md-12" v-bind:class="[(selectedRadio != 'all' && limit <= 0) ? classButtonSearch : '']" @click.stop="getUsers()" >Buscar</b-btn>
              </div>  
            </div>
          </div>    
        </div>  
      </div> 
       <b-row style="width:100%">
      <b-col cols="12" style="margin-left: 15px;">
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
                <label class="mr-sm-2"> &nbsp &nbsp {{ users.length }} resultados encontrados  </label>
                <b-btn @click="excel()" variant="outline-success" v-b-tooltip.hover title="Exportar a Excel"><img src="https://png.icons8.com/color/50/000000/ms-excel.png" width="20"></b-btn>
                <b-btn @click='printFunc()' variant="outline-secondary" v-b-tooltip.hover.right title="Imprimir"><img src="https://img.icons8.com/color/48/000000/print.png" width="20"></b-btn>
            </b-form>
          </b-col>
        </b-row>
        <b-row >
          <template>
            <b-table ref="tableUser" id="tableUser" show-empty
                          stacked="md"
                           :items="users"
                           :fields="fields"
                           :current-page="currentPage"
                           :per-page="perPage"
                           :filter="filter"
                           @filtered="onFiltered"
                  >

                 <template slot="id" slot-scope="row">{{row.value}}</template>
                    <template slot="name_user" slot-scope="row">{{row.value}}</template> 
                     <template slot="complaint_count" slot-scope="row"> {{ row.value }}</template>             
                    <template slot="email" slot-scope="row"> {{ row.value }}</template>
                    <template slot="sex" slot-scope="row"> {{ row.value }}</template>
                    <template slot="role_id" slot-scope="row">
                        <div v-if="row.value===1">Administrador</div>
                        <div v-else>Escritor</div>
                    </template>
                    <template slot="accions" slot-scope="row">
                      <div v-if="row.item.role_id===2">
                          <b-button size="sm" variant="outline-primary" :href="'/usuarios/'+ row.item.id" v-b-tooltip.hover.left title="Ver Usuario"><img src="https://img.icons8.com/small/16/000000/find-user-male.png"></b-button>
                          <b-button size="sm" variant="outline-warning" @click.stop="detail(row.item.id)" v-b-tooltip.hover.right title="Detalle de Denuncia"><img src="https://img.icons8.com/small/16/000000/view-details.png"></b-button>
                      </div>
                      <div v-else>
                          <b-button size="sm" variant="outline-primary" :href="'/usuarios/'+ row.item.id" v-b-tooltip.hover.left title="Ver Usuario"><img src="https://img.icons8.com/small/16/000000/find-user-male.png"></b-button>
                          <b-button size="sm" variant="outline-warning" @click.stop="detail(row.item.id)" v-b-tooltip.hover.right title="Detalle de Denuncia"><img src="https://img.icons8.com/small/16/000000/view-details.png"></b-button>
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
      </b-row> 
      </div> 
    </b-container>

</template>

<script>
var moment = require('moment')
export default {
    data () {
        return {
          // Note 'isActive' is left out and will not appear in the rendered table
            title: 'Usuarios Denunciados',
            fields: {
                id: {
                  key:'id',
                  label: 'Id',
                  sortable: true
                },
                name_user: {
                    key:'name_user',
                  label: 'Nombre Usuario',
                  sortable: true
                },
                complaint_count:{
                    key:'motivations_count',
                    label: 'Denuncias',
                    variant: 'danger',
                    sortable: true
                },                
                email: {
                    key:'email',
                  label: 'Email',
                  sortable: true
                },
                // created_at:{
                //      key:'created_at',
                //     label: 'Fecha',
                //     sortable: false
                //   },
                // sex: {
                //     key:'sex',
                //   label: 'Sexo',
                //   sortable: false
                // },
                // role_id: {
                //     key:'role_id',
                //   label: 'Rol',
                //   sortable: true
                // },
                accions:{
                    key:'accions',
                    label: 'Acciones'
                }
                
            },
            classButtonSearch:{
              disabled:true,              
            }, 
            totalComplaint:0,
            titleTemp:'',
            title:'Denuncias',
            dateStart:'',
            dateEnd:'',
            selectedRadio:'all',
            limit:0,
            max:0,
            min:0,
            modalInfo: {name },
            users: [],
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
           
            user:{
                id: 0,
                name: '',
                name_user:'',
                sex: '',
                last_name:'',
                role_id:0
            }
        }
    },
    mounted() {
        this.getU(1)
         this.inputDate();
    },
    methods:{
      inputDate(){
        this.max = moment().format('YYYY-MM-DD');
      },
      changeDatess(event){
         if(event == ""){
          this.dateStart = "";
        }
        else{
          if(this.dateStart < this.min){
            this.dateStart = this.min
          }
          else if (this.dateStart > this.max) {
            this.dateStart = this.max
          }
        }        
      },
      changeDates(event){
        if(event == ""){
          this.dateEnd = "";
        }
        else{
           if(this.dateEnd > this.max){
            this.dateEnd = this.max
          }    
           else if (this.dateEnd < this.min) {
            this.dateEnd = this.min
          }  
        }
      },
      changeLimit(){
        if(this.limit > this.totalComplaint){
          this.limit = this.totalComplaint;
        }

      },
      htmlTable(){
        var html = "";
        html+='<table id="t01">'+
              "<tr>"+
                "<th>Numero</th>"+
                "<th>Nombre</th> "+
                "<th>Nombre de Usuario</th>"+
                "<th>Denuncias</th> "+
                "<th>Email</th> "+
                "<th>Rol</th> "+
                "<th>Fecha de Creación</th> "+
                "<th>Fecha de Actualización</th> "+
              "</tr>";
            for(var i=0; i<this.users.length; i++){
              html+= "<tr>"+
                      "<td>"+ this.users[i]['id']+"</td>"+  
                      "<td>"+this.users[i]['name']+"</td>"+ 
                      "<td>"+this.users[i]['name_user']+"</td>"+
                      "<td>"+this.users[i]['motivations_count']+"</td>"+ 
                      "<td>"+this.users[i]['email']+"</td>";
              if(this.users[i]['role_id'] == 1){
                html+= "<td>Administrador</td>";
              }else{
                html+= "<td>Escritor</td>";
              }
              html+=  "<td>"+this.users[i]['created_at']+"</td>"+ 
                      "<td>"+this.users[i]['updated_at']+"</td>"+ 
                    " </tr>" ;                 
            }
          html +=  "</table>"; 
        return html;
      },
      printFunc() {     
        var newWin = window.open();
        var htmlToPrint = "<tr>"+
                            "<td><p style='text-align:center;'>"+this.title+"</p></td>"+
                            "<td><p style='text-align:right;'> Registros: "+this.users.length+"</p></td>"+
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
      excel(){
        if(this.users.length != 0){  
           axios.post('/excel/complaint/users/reports',{
                users: this.users,
                title : this.title,                    
            }).then(response =>{
              console.log(response.data)
              window.open('/excel/reports/'+ response.data)
            }).catch(error =>{
                console.log(error.response)
            });
        }

      },
        detail(id){
          window.open('/complaintUsers/'+id, "directories=no, location=no, menubar=no, scrollbars=yes, statusbar=no, tittlebar=no");
          
        },
        getU(onload){
          axios.post('/complaintUsers/Data',{
                limit: this.limit,
                order :this.selectedRadio,  
                dateStart :this.dateStart,
                dateEnd: this.dateEnd,                      
            }).then(response =>{
                this.min = response.data.dateStart;
                console.log(this.min)
                if(response.data.users != undefined){
                  this.users=response.data.users
                  this.totalRows=response.data.users.length
                }
                else{                  
                  this.users=[]
                  this.totalRows=0
                }
                this.title = this.titleTemp;
                 if(onload == 1){
                    this.totalComplaint = response.data.users.length;
                  }  
             }).catch(error =>{
                console.log(error.response)
            });
           },
        getUsers(){
          if(this.selectedRadio != 'all'){
            this.dateStart = '';
            this.dateEnd = '';
          }
          if(this.selectedRadio == 'all' ){
            this.limit=0;
            if(this.dateStart != '' && this.dateEnd != ''){
               if((this.dateStart > this.dateEnd) || (this.dateStart < this.min) || (this.dateEnd < this.min) || (this.dateStart > this.max) || (this.dateEnd > this.max)){
                  alert("ingrese los valores correctamente")
                  return 
              }
              else{
                this.titleTemp = '{ '+this.dateStart+' , '+this.dateEnd+' }';
              }  
            }
            else{
              this.titleTemp = 'Denuncias';
            }
            this.getU();
          }
          else if(this.selectedRadio == 'desc'){
              this.titleTemp = this.limit+' Usuarios mas Denunciados';
          }
          else{
              this.titleTemp = this.limit+' Usuarios menos Denunciados';
          }
          if(this.selectedRadio !== 'all' &&  this.limit <= 0){
            alert('Elige cuantos registros quieres ver');
          }  
          else{
            this.getU();
          }        
           
        } ,
        
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