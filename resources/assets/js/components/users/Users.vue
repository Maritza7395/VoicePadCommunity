<template>
    <b-container>
      <div class="row">
        <div class="col-md-12 shadow-lg mb-4 bg-white rounded">
          <div class="row" style="background-color: rgba(171, 171, 171, 0.1);">
            <div class="col-md-2" style="margin: 6px 0px 6px 0px; padding-left: 2px; border-right: 1px solid gray;">
              <h5 style="margin: 5px 0px 0px 0px;"><img src="https://img.icons8.com/color/48/000000/sorting-options.png" width="40">F I L T R A D O </h5>
            </div>
            <div class="col-md-10">
              <div class="row" style="margin: 10px 0px 1px 0px;">
                <div class="col-md-3">
                  <b-form-select v-model="selected" class="mb-3">
                    <option value="all">Todos</option>
                    <option value="follows" >Seguidos</option>
                    <option value="quantitySummernotes" >Cantidad de libros</option>
                  </b-form-select>
                </div>
                <div class="col-md-7" v-if="selected !== 'follows' && selected !== 'quantitySummernotes'">
                  <div class="row">
                    <div class="col-md-4">
                      <label class="mr-sm-2" v-if="selected == 'all' || selected == 'quantitySummernotes' ">Intervalo por fecha de registro: </label>  
                    </div>
                    <div class="col-md-8">
                      <div class="row">
                        <b-input id="fechas" class="mb-1 mr-sm-1 mb-sm-0" size="sm" type="date" @change="changeDatess" :max="max" :min="min"  v-model="dateStart"></b-input>
                        <label class="mr-sm-2">-</label>
                        <b-input id="fechas" class="mb-2 mr-sm-2 mb-sm-0" size="sm" type="date" @change="changeDates" :max="max" :min="min"  v-model="dateEnd"></b-input>
                        </div>
                      </div>
                    </div>  
                  </div>
                  <div class="col-md-3" style="padding: 0;" v-if="selected !== 'all'">
                    <b-form-radio-group  v-model="selectedRadio">
                      <b-form-radio value="all">Todos</b-form-radio>
                      <b-form-radio value="desc" v-if="selected == 'follows'">Mas Seguidos</b-form-radio>
                      <b-form-radio value="desc" v-if="selected == 'quantitySummernotes'">Mas Libros</b-form-radio>
                    </b-form-radio-group>
                  </div>
                  <div class="col-md-4" v-if="(selected !== 'all' ) && ((selected == 'follows' || selected == 'quantitySummernotes') && selectedRadio !== 'all') ">
                    <div class="row">
                      <div class="col-md-4">
                        <label class="mr-sm-2"><b>Registros:</b></label>
                      </div>
                      <div class="col-md-8">
                        <b-input class="mb-1 mr-sm-1 mb-sm-0"  size="sm" type="number" @change="changeLimit" :max="totalUsers" v-model="limit"></b-input> 
                      </div>
                    </div>
                  </div>
                <div class="col-md-2">
                  <b-btn id="search" variant="primary" v-bind:class="[ (selected == 'follows' || selected == 'quantitySummernotes') && ( selectedRadio == '' || (limit <= 0 && selectedRadio !== 'all')) ? classButtonSearch : '']" @click.stop="search()">Buscar</b-btn>
                </div>
              </div>  
            </div>
          </div>    
        </div>  
      </div> 
       <b-row>
      <b-col cols="12">
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
                <b-btn @click='printFunc()' variant="outline-secondary" v-b-tooltip.hover title="Imprimir"><img src="https://img.icons8.com/color/48/000000/print.png" width="20"></b-btn>
            </b-form>
          </b-col>
        </b-row>
        <b-row >
          <template>
            <b-table ref="tableUser" show-empty thead-class="hidden_header"
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
             <!--      <template slot="created_at"  slot-scope="row">{{row.value}}</template> -->
                  <template slot="followCount"  slot-scope="row"> {{ row.value }}</template>
                  <template slot="countSummernotes"  slot-scope="row"> {{ row.value }}</template>
                  <template slot="name"  slot-scope="row"> {{ row.value }}</template>
                  <template slot="last_name" slot-scope="row"> {{ row.value }}</template>
                  <template slot="email" slot-scope="row"> {{ row.value }}</template>
                  <template slot="sex" slot-scope="row"> {{ row.value }}</template>
                  <template slot="role_id" slot-scope="row">
                      <div v-if="row.value===1">Administrador</div>
                      <div v-else>Escritor</div>
                  </template>
                  <template slot="accions" slot-scope="row">
                    <div v-if="row.item.role_id===2">
                        <b-button size="sm" variant="outline-primary" :href="'/usuarios/'+ row.item.id" v-b-tooltip.hover.right title="Ver Usuario">
                          <img src="https://img.icons8.com/small/16/000000/find-user-male.png"></b-button>                        
                    </div>
                    <div v-else>
                        <b-button size="sm" variant="outline-primary" :href="'/usuarios/'+ row.item.id" v-b-tooltip.hover.right title="Ver Usuario">
                          <img src="https://img.icons8.com/small/16/000000/find-user-male.png">
                        </b-button>
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
    </b-container>


</template>

<script>
var moment = require('moment')
export default {
    data () {
        return {
            titleTemp:'',
            title:'Usuarios Registrados',
            items:users,
            selected:'all',
            selectedRadio:'all',
            dateStart:"",
            dateEnd:"",
            limit:0,           
            classButtonSearch:{
              disabled:true,              
            },          
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
                created_at:{
                   key:'created_at',
                  label: 'Fecha',
                  sortable: false
                },
                email: {
                    key:'email',
                  label: 'Email',
                  sortable: false
                },               
                accions:{
                    key:'accions',
                    label: 'Ver'
                }
            },
            modalInfo: {name },
            users: [],
            currentPage: 1,
            perPage: 10,
            pageOptions: [ 10, 25, 50 ],
            totalRows: 0,
            filter: null,
            idUserDelete: 0,
             limit:0,
            max:0,
            min:0,
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
        this.getUsers();
        this.inputDate();
    },
    methods:{ 
      inputDate(){
        console.log(moment().format('YYYY-MM-DD'));
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
        if(this.limit > this.totalUsers){
          this.limit = this.totalUsers;
        }

      }, 
      htmlTable(title , td){
        var html = "";
        if(title == null){
          html+='<table id="t01">'+
              "<tr>"+
                "<th>Numero</th>"+
                "<th>Nombre</th> "+
                "<th>Nombre de Usuario</th>"+
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
                    "<td>"+this.users[i]['email']+"</td>";
            if(this.users[i]['role_id'] == 1){
              html+= "<td>Administrador</td>";
            }else{
              html+= "<td>Escritor</td>";
            }
            html+=  "<td>"+this.users[i]['created_at']+"</td>"+ 
                    "<td>"+this.users[i]['updated_at']+"</td>"+ 
                 " </tr>"  ; 
            }
        }
        else{
           html+='<table id="t01">'+
              "<tr>"+
                "<th>Numero</th>"+
                "<th>Nombre</th> "+
                "<th>Nombre de Usuario</th>"+
                "<th>"+title+"</th> "+
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
                      "<td>"+this.users[i][td]+"</td>"+ 
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

        }
        html += "</table>"; 
        return html;

      },
      printFunc() {
      // var divToPrint = document.getElementById('printarea');
      // for(var x=0; x<this.users.length; x++){


      // }
      if(this.users[0]['followCount'] != null){
        var title = 'Seguidores';
        var th= 'followCount';
                                  
      }
      else if(this.users[0]['countSummernotes'] != null){
        var title = 'Seguidores';
        var td= 'followCount';
      }
      

      // newWin = window.open("");
      var newWin = window.open();
      var htmlToPrint = "<tr>"+
                           "<td><h2 style='text-align:center;'>"+this.title+"</h2></td>"+
                          "<td><p style='text-align:right;'> Registros: "+this.users.length+"</p></td>"+
                        "</tr>";
      htmlToPrint += this.htmlTable( title , th);
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
                                "}");   
      x.appendChild(t);
      newWin.document.head.appendChild(x);       
      newWin.print();
      newWin.close();
      }  ,
      excel(){
        if(this.users.length != 0){  
           axios.post('/excel/user/reports',{
                title : this.title,
                users: this.users                    
            }).then(response =>{
              console.log(response.data)
              window.open('/excel/reports/'+ response.data)
            }).catch(error =>{
                console.log(error.response)
            });
        }

      },
      search(){
        if( !(
              ((this.selected == 'follows' || this.selected == 'quantitySummernotes') && ( this.selectedRadio == '' || (this.limit <= 0 && this.selectedRadio !== 'all')))
            )){        

          switch(this.selected){
            case 'quantitySummernotes':
              if(this.selectedRadio != ""){
                  //verificacion de que cuando se eligan todos los registros limit sea 0
                  if(this.selectedRadio != 'all' && this.limit <= 0){
                    alert("Elige cuantos registros quieres ver")
                  }
                  else{
                    if(this.limit != 0 && this.selectedRadio == 'all'){
                      this.limit=0;                     
                    }
                    if(this.selectedRadio == 'desc'){
                      this.title = 'Los '+this.limit+' usuarios con mas Libros'
                    } 
                    else{
                       this.title='Numero de libros por Usuario';
                    }              
                    axios.post('/usuarios/reportsSummernotes',{
                        limit: this.limit,
                        order :this.selectedRadio,                    
                    }).then(response =>{
                      this.titleTemp=this.title;
                      console.log(response.data)  
                      
                      this.fields={
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
                        countSummernotes:{
                           key:'countSummernotes',
                          label: 'Libros',
                          sortable: false
                        },
                        email: {
                            key:'email',
                          label: 'Email',
                          sortable: false
                        },
                        sex: {
                            key:'sex',
                          label: 'Sexo',
                          sortable: false
                        },
                        accions:{
                          key:'accions',
                          label: 'Ver'
                        }
                      }               
                     this.users = response.data
                    }).catch(error =>{
                        console.log(error.response)
                    });
                  }
                }
                else{
                  alert("seleccione una opcion");
                }
                 break;   
            case 'all':
              if(this.dateStart != "" && this.dateEnd != ""){
                this.titleTemp = '{ '+this.dateStart+','+this.dateEnd+' } ';
              }
              else{
                this.titleTemp = 'Usuarios Registrados';
              }
              axios.post('/usuarios/reports',{
                  dateStart :this.dateStart,
                  dateEnd: this.dateEnd,
              
              }).then(response =>{
                this.title = this.titleTemp;
                console.log(response.data)  
                this.fields={
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
                  created_at:{
                     key:'created_at',
                    label: 'Fecha',
                    sortable: false
                  },
                  email: {
                      key:'email',
                    label: 'Email',
                    sortable: false
                  },
                  sex: {
                      key:'sex',
                    label: 'Sexo',
                    sortable: false
                  },
                  accions:{
                    key:'accions',
                    label: 'Ver'
                  }

                }                        
                this.users = response.data                         
               
              }).catch(error =>{
                  console.log(error.response)
              });
                

                break;
            case 'follows':
                if(this.selectedRadio != ""){
                  //verificacion de que cuando se eligan todos los registros limit sea 0
                  if(this.selectedRadio != 'all' && this.limit <= 0){
                    alert("Elige cuantos registros quieres ver")
                  }
                  else{
                    this.titleTemp = 'Los '+this.limit+ ' usuarios mas seguidos';
                    if(this.limit != 0 && this.selectedRadio == 'all'){
                      this.limit=0;                     
                    }
                    if(this.limit == 0 && this.selectedRadio =='all'){
                       this.titleTemp = 'Usuarios Seguidos';
                    }
                    axios.post('/follows/reports',{
                      limit: this.limit,
                      order :this.selectedRadio,              
                    }).then(response =>{
                      this.title = this.titleTemp;
                      console.log(response.data)
                      this.fields= 
                           {
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
                            followCount: {
                                key:'followCount',
                              label: 'Seguidores',
                              sortable: true
                            }, 
                            email: {
                                key:'email',
                              label: 'Email',
                              sortable: false
                            }, 
                            role_id: {
                                key:'role_id',
                              label: 'Rol',
                              sortable: true
                            },  
                            accions:{
                                key:'accions',
                                label: 'Ver'
                            }     
                          } 
                      this.users = response.data
                    }).catch(error =>{
                        console.log(error.response)
                    });
                  }
                }
                else{
                  alert("seleccione una opcion");
                }
                 break;
          }

        }              
        //))
          // [selected == 'all' && ( dateStart == '' || dateEnd == '' ) ? classButtonSearch : '' , selected == 'follows' && ( selectedRadio == '' || (limit <= 0 && selectedRadio !== 'all')) ? classButtonSearch : '']

      },
      follows(){
        axios.post('/follows/reports',{
          dateStart :this.dateStart,
          dateFinish: this.dateFinish,
          limit: this.limit,
          order :this.order,              
              }).then(response =>{
                console.log(response.data)
                this.users = response.data
              }).catch(error =>{
                  console.log(error.response)
              });

        },
        getUsers(){
            axios.get('/Data/usuarios').then(response =>{
                console.log(response)
                this.users=response.data.users
                this.totalRows=response.data.users.length
                this.totalUsers = response.data.users.length
                this.min = response.data.dateStart;
            });

        } ,        
        resetModal () {
          this.modalInfo.name=''
          this.idUserDelete=0
        },
        onFiltered (filteredItems) {
          console.log(filteredItems);
          // Trigger pagination to update the number of buttons/pages due to filtering
          this.totalRows = filteredItems.length
          this.currentPage = 1
        },
        
        

    }
};
 
</script>
<style type="text/css">
  .btn.btn-primary#search {
      background: #9b111e none repeat scroll 0 0;
      border-color: #f0ad4e;
      color: #ffffff;
      font-size: 14px;
      width: 100%;
      height: 30px;
      padding: 0;
    }
  .form-control#fechas{
    width: 43% !important;
  }
</style>