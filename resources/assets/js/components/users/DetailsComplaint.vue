<template>
    <b-container fluid>
    <b-row>
      <b-col>
       <b-card header="Usuario" header-tag="header" class="mb-10 text-center">
        <b-row>
          <b-col>
            <b-list-group >  
            <b-list-group-item class="text-center"> 
                    <p><b>Nombre de Usuario:</b> {{ user.name_user }}</p>                        
                </b-list-group-item>                
                <b-list-group-item > 
                    <p><b>Nombre:</b> {{ user.name }}</p>                        
                </b-list-group-item>
                <b-list-group-item > 
                    <p><b>Email:</b> {{ user.email }}</p>                        
                </b-list-group-item>                             
            </b-list-group>  
            </b-col>
            <b-col>  
            <b-list-group class="text-center" >
                <b-list-group-item > 
                    <p><b>Edad:</b> {{ user.birthdate }} Años</p>                        
                </b-list-group-item> 
                 <b-list-group-item > 
                    <p><b>Registrado:</b> {{ user.created_at }} </p>                        
                </b-list-group-item> 
                <b-list-group-item  v-if="user.sex==='M'"> 
                    <p><b>Sexo:</b> Masculino</p>                        
                </b-list-group-item>
                <b-list-group-item  v-else >
                    <p><b>Sexo:</b> Femenino</p>
                </b-list-group-item>                             
            </b-list-group>  
            </b-col>  
                 </b-row> 
          </b-card>
      </b-col>     
      <b-col>
        <b-card  header="Alertas Enviadas" header-tag="header" class="mb-10 text-center">
        <b-table ref="tableAlerts" id="tableAlerts" show-empty
                    stacked="md"
                     :items="alerts"
                     :fields="fieldsAlerts"
            >              
              <template slot="row-details" slot-scope="row">
                <b-card>
                  <ul>
                    <li v-for="(value, key) in row.item" :key="key">{{ key }}: {{ value}}</li>
                  </ul>
                </b-card>
              </template>
        </b-table>
      </b-card>
      </b-col>
    </b-row>
    <br>
      <b-row>
        </b-col>
        <b-col>
          <b-card>
              <b-row>
              <b-col md="6" class="my-1">
                <b-form-group horizontal label="Filtrar" class="mb-0">
                  <b-input-group>
                    <b-form-input v-model="filter" placeholder="Buscar" />
                    <b-input-group-append>
                      <b-btn style=" background: #088A85" :disabled="!filter" @click="filter = ''">Limpiar</b-btn>
                    </b-input-group-append>
                  </b-input-group>
                </b-form-group>
              </b-col>
              <b-col md="6" class="my-1">
                <label>cantidad de registros: {{ users.length }}</label>
                <b-btn variant="outline-danger" @click.stop="setAlerts()"><img src="https://img.icons8.com/small/16/000000/alarm.png" style="margin: -2px 5px 0 0px;">Enviar Alerta</b-btn>

                <!-- <b-button size="sm" variant="outline-danger" @click.stop="info(row.item)" class="mr-1">
                                <img src="https://png.icons8.com/metro/16/e74c3c/delete.png" width="20" height="20">
                            </b-button> -->
                <b-btn variant="outline-info" @click.stop="info(user)"><img src="https://img.icons8.com/small/16/000000/unfriend-male.png" style="margin: -2px 5px 0 0px;">Bloquear Usuario</b-btn>
              </b-col>
            </b-row>
            <b-table ref="tableUser" id="tableUser" show-empty
                        stacked="md"
                         :items="users"
                         :fields="fields"
                         :current-page="currentPage"
                         :per-page="perPage"
                         :filter="filter"
                         @filtered="onFiltered"
                >
                   <template slot="motivation" slot-scope="row">
                      <div v-for="item in motivations" v-if="row.item.pivot.motivation_user_id == item.id">
                        {{ item.name }}
                      </div>
                     
                 </template>             
                  <template slot="role_id" slot-scope="row">
                      <div v-if="row.value===1">Administrador</div>
                      <div v-else>Escritor</div>
                  </template>
                  <template slot="accions" slot-scope="row">
                        <b-button size="sm" variant="outline-primary" :href="'/usuarios/'+ row.item.id" v-b-tooltip.hover.right title="Ver Usuario"><img src="https://img.icons8.com/small/16/000000/find-user-male.png"></b-button>
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
                   <b-row>
                    <b-col md="6" style="margin-top: 8px;">
                      <p><b>Elementos por página</b></p>
                    </b-col>
                    <b-col md="6">
                      <b-form-select :options="pageOptions" v-model="perPage" />
                    </b-col>
                  </b-row>
                </b-col>
            </b-row> 
            </b-card>
            </b-col>
          </b-row>

        
        
        <!-- Modal Eliminar -->
        <b-modal id="modalInfo" @ok="deleteOk" @hide="resetModal">
          <p><img src="https://img.icons8.com/color/48/000000/unfriend-male.png">
           ¿Estas seguro de querer bloquear a este Usuario?</p>
           <center><p><b>Nombre de Usuario: </b>{{ modalInfo.name.name_user }}</p></center>
           <label visible:=false value=""></label>  
        </b-modal>
        <!-- modal eliminar -->
    </b-container>


</template>

<script>
export default {
	
	props: ['id'],
    data () {
        return {
          // Note 'isActive' is left out and will not appear in the rendered table
            fieldsAlerts:{
              date:{
                key:'pivot.created_at',
                label:'Fecha',
              },
              admin:{
                key:'name_user',
                label:'Administrador',
              }
            },
            fields: {                
                name_user: {
                    key:'name_user',
                  label: 'Usuario Denunciante',
                  sortable: true
                },
                motivation:{
                    // key:'pivot.motivation_user_id',
                    label: 'Motivo de Denuncia',
                    sortable: false
                },  
                date:{
                    key:'pivot.created_at',
             //         formatter: (value, key, item) => {
			          //   return (new Date()).getDate() - item.pivot.created_at
			          // },
                    label: 'Fecha',
                    sortable: false
                },               
                // email: {
                //     key:'email',
                //   label: 'Email',
                //   sortable: true
                // },
                accions:{
                    key:'accions',
                    label: 'Ver'
                }
                
            },
            modalInfo: {name },
            users: [],
            alerts: [],
            motivations: [],
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
                role_id:0,
                birthdate:'',
            }
        }
    },
    mounted() {      
        this.getUsers();
        this.getMotivations();
        this.getUser();
        this.getAlerts();
    },
    methods:{
      getAlerts(){
          axios.get('/alerts/user/'+this.id).then(response => {
          console.log(response.data)
          this.alerts = response.data
        }).catch(error => {
          console.log(error)
        })
      },
      setAlerts(){
        axios.post('/alerts',{
                user_id: this.id,
            }).then(response =>{                
                if(response.data == 'ok'){
                   alert('Alerta correctamente enviada');
                    this.getAlerts();
                }
                else{
                    alert('Se puede enviar solo una alerta al dia');       
                }
               
            }).catch(error =>{
              if(error.response.status == 404){
                alert('No esta autorizado para realizar esta accion');     
              }
              else{
                alert('No se ah podido realizar esta accion');         
              }
              
            });
      },
      getUser(){
        axios.get('/usuarios/Data/'+this.id).then(response => {
          console.log(response)
          this.user = response.data
        }).catch(error => {
          console.log(error)
        })
      },
    	 getMotivations(){
            axios.get('/motivos-usuario/Data').then(response =>{
                this.motivations=response.data;
            })
        },
        getUsers(){
            axios.get('/complaintUsers/Data/' + this.id ).then(response =>{
                this.users=response.data;
                this.totalRows=response.data.length;
            });
        } ,
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
        deleteOk(evt){
            axios.delete('/usuarios/'+this.idUserDelete).then(response=>{
              console.log(response.data);
              if(response.data == 'ok'){
                location.href = '/complaintUsers';
              }
              else{
                alert('Se necesitan 3 o mas alertas enviadas para que el usuario pueda ser Bloqueado');
              }
            }).catch(error=>{
               if(error.response.status == 404){
                alert('No esta autorizado para realizar esta accion');     
              }
              else{
                alert('No se ah podido realizar esta accion');         
              }
            })
        }
        

    }
};
 
</script>
<style>
.page-item.active .page-link {
    z-index: 1;
    color: #fff;
    background-color: rgba(23, 162, 184, 0.5);
    border-color: rgba(23, 162, 184, 0.5);
}
.custom-control-input:checked ~ .custom-control-label::before {
    color: #fff;
    background-color: rgba(23, 162, 184, 0.5);
}
</style>