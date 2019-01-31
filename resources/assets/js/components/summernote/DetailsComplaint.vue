<template>
    <b-container fluid>
      <b-row>
         <b-col cols="*" md="3">
          <b-card header="Libro" header-tag="header">
            <b-list-group flush class="text-center">  
            <b-list-group-item > 
                    <p><b>Titulo:</b> {{ summernote.name }}</p>                        
                </b-list-group-item> 
                <b-list-group-item >
                  <p><b>Autor:</b> {{ summernote.user.name_user }}</p>
                </b-list-group-item>               
                <b-list-group-item >
                  <div v-if="summernote.private == 0">
                    <p><b>Publico:</b> Si</p>    
                  </div> 
                  <div v-else>
                    <p><b>Publico:</b> No</p>    
                  </div>                                        
                </b-list-group-item> 
                 <b-list-group-item >
                  <div v-if="summernote.status == 0">
                    <p><b>Estado:</b> En Proceso</p>    
                  </div> 
                  <div v-else>
                    <p><b>Estado:</b> Terminado</p>    
                  </div>                                        
                </b-list-group-item> 
                <b-list-group-item >
                  <div v-if="summernote.rating == 1">
                    <p><b>Mayor de 18:</b> Si</p>    
                  </div> 
                  <div v-else>
                    <p><b>Mayor de 18:</b> No</p>    
                  </div>                                        
                </b-list-group-item>    
                 <b-list-group-item >
                  <p><b>Genero:</b> {{ summernote.genre.name }}</p>
                </b-list-group-item>                     
            </b-list-group>    
             </b-card>
        </b-col>
        <b-col>
           <b-row align-h="end">
            <b-col cols="5">
              <b-button  variant="outline-info"  @click.stop="newWindow('/usuarios/'+summernote.user_id)" ><img src="https://img.icons8.com/small/16/000000/user-typing-using-typewriter.png">Revisar Autor</b-button>
              <b-button  variant="outline-primary"  @click.stop="newWindow('/summernote/'+id)"><img src="https://img.icons8.com/small/16/000000/read.png">Revisar Libro</b-button>
            </b-col>
        </b-row>
         <b-card class=" bg-white">
          <b-tabs>
            <b-tab active> 
            <template slot="title">
               Revisar <b-badge variant="info">{{ totalRowsInpect }}</b-badge>
           </template>               
          <b-row>
            <b-table ref="tableUser" id="tableUser" show-empty
                      stacked="md"
                       :items="inspect"
                       :fields="fieldsInspect"
                       :current-page="currentPageInspect"
                       :per-page="perPageInspect"
              >
                 <template slot="motivation" slot-scope="row">
                    <div v-for="item in motivations" v-if="row.item.pivot.motivation_text_id == item.id">
                      {{ item.name }}
                    </div>                   
               </template>   
                <template slot="accions" slot-scope="row">
                      <b-button size="sm" variant="outline-primary" @click.stop="newWindow('/usuarios/'+ row.item.id)" v-b-tooltip.hover.bottom title="Ver Denunciante"><img src="https://img.icons8.com/small/16/000000/find-user-male.png"></b-button>
                      <b-button size="sm" variant="outline-success" v-if="row.item.pivot.motivation_text_id == 1" @click.stop="modalPlagio(row.item)" v-b-tooltip.hover.bottom title="Aceptar"><img src="https://img.icons8.com/small/16/000000/checked.png"></b-button> <!-- plagio -->
                      <b-button size="sm" variant="outline-success" v-if="row.item.pivot.motivation_text_id == 2" @click.stop="modalGenre(row.item)" v-b-tooltip.hover.bottom title="Aceptar"><img src="https://img.icons8.com/small/16/000000/checked.png"></b-button> <!-- Genero Incorrecto -->
                      <b-button size="sm" variant="outline-success" v-if="row.item.pivot.motivation_text_id == 3"  @click.stop="modalMayor(row.item)" v-b-tooltip.hover.bottom title="Aceptar"><img src="https://img.icons8.com/small/16/000000/checked.png"></b-button> <!-- + 18 -->
                      <b-button size="sm" variant="outline-danger" @click.stop="modalDenied(row.item)" v-b-tooltip.hover.bottom title="Denegar"><img src="https://img.icons8.com/small/16/000000/cancel.png"></b-button>
                </template>
                <template slot="row-details" slot-scope="row">
                  <b-card>
                    <ul>
                      <li v-for="(value, key) in row.item" :key="key">{{ key }}: {{ value}}</li>
                    </ul>
                  </b-card>
                </template>
            </b-table>
          </b-row>
          <b-row>
              <b-col md="6" class="my-1">
                  <b-pagination :total-rows="inspect.length" :per-page="perPageInspect" v-model="currentPageInspect" class="my-0" />
              </b-col>
              <b-col md="6" class="my-1">
                  <b-form-group horizontal label="Per page" class="mb-0">
                      <b-form-select :options="pageOptions" v-model="perPageInspect" />
                  </b-form-group>
              </b-col>
          </b-row>   
            </b-tab>
            <b-tab >
               <template slot="title">
                   En Proceso <b-badge variant="info">{{ totalRowsProcessing }}</b-badge>
               </template>   
              <b-row>
                <b-table ref="tableUser" id="tableUser" show-empty
                          stacked="md"
                           :items="processing"
                           :fields="fieldsProcessing"
                           :current-page="currentPageProcessing"
                           :per-page="perPageProcessing"
                  >
                    <template slot="name_user" slot-scope="row">{{row.value}}</template> 
                     <template slot="motivation" slot-scope="row">
                        <div v-for="item in motivations" v-if="row.item.pivot.motivation_text_id == item.id">
                          {{ item.name }}
                        </div>                   
                   </template> 
                      <template slot="date" slot-scope="row"> 
                          {{ row.value}}
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
              </b-row>
              <b-row>
                <b-col md="6" class="my-1">
                    <b-pagination :total-rows="processing.length" :per-page="perPageProcessing" v-model="currentPageProcessing" class="my-0" />
                </b-col>
                <b-col md="6" class="my-1">
                    <b-form-group horizontal label="Per page" class="mb-0">
                        <b-form-select :options="pageOptions" v-model="perPageProcessing" />
                    </b-form-group>
                </b-col>
          </b-row>   
            </b-tab>
             <b-tab >
               <template slot="title">
                   Solucionados <b-badge variant="info">{{ totalRowsFinished }}</b-badge>
               </template>  
               <b-row>
                  <b-table ref="tableUser" id="tableUser" show-empty
                            stacked="md"
                             :items="finished"
                             :fields="fieldsFinished"
                             :current-page="currentPageFinished"
                             :per-page="perPageFinished"
                    >
                      <template slot="name_user" slot-scope="row">{{row.value}}</template> 
                       <template slot="motivation" slot-scope="row">
                          <div v-for="item in motivations" v-if="row.item.pivot.motivation_text_id == item.id">
                            {{ item.name }}
                          </div>                   
                     </template>  
                      <template slot="accions" slot-scope="row">
                            <b-button size="sm" variant="outline-primary" :href="'/usuarios/'+ row.item.id" v-b-tooltip.hover.right title="Ver Denunciante"><img src="https://img.icons8.com/small/16/000000/find-user-male.png"></b-button>
                      </template>
                       <template slot="denied" slot-scope="row">
                            <div v-if="row.item.pivot.denied == 0">
                              <p>Aceptada</p>
                            </div>
                            <div v-else>
                              Denegada
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
                </b-row>
                <b-row>
                  <b-col md="6" class="my-1">
                      <b-pagination class="my-0" :total-rows="finished.length" :per-page="perPageFinished" v-model="currentPageFinished"  />
                  </b-col>
                  <b-col md="6" class="my-1">
                      <b-form-group horizontal label="Per page" class="mb-0">
                          <b-form-select :options="pageOptions" v-model="perPageFinished" />
                      </b-form-group>
                  </b-col>
            </b-row>   
            </b-tab>            
          </b-tabs>
        </b-card>    
        </b-col>
      </b-row>
        <!-- Modal  -->
        <b-modal id="modalGenre" @cancel="resetModal"  title="Genero al que este libro deberia pertenecer"  @ok="GenreOk">
            <div class="row">
              <div class="col-md-2">
                <img src="https://img.icons8.com/color/48/000000/category.png">
              </div>
              <div class="col-md-10">
                <p><b>¿Estas seguro de querer Aceptar esta Denuncia y que el Genero recomendado es el correcto?</b></p>
              </div>
            </div>
             <p>Una vez que acepte la denuncia por Genero este libro no podra volver a ser Publico hasta que se cambie al Genero indicado</p>  
          </b-modal>

          <b-modal id="modalMayor" @ok="MayorOk" @cancel="resetModal" title="Para Mayores de 18" >
           <p><img src="https://img.icons8.com/color/48/000000/not-suitable-for-children-under-age-x.png">
           <b>¿Estas seguro de querer Aceptar esta Denuncia?</b></p> 
            <p> Al aceptar esta denuncia el libro quedara en modo privado hasta que el autor cambie su obra a mayores de 18</p>    
        </b-modal>

        <b-modal id="modalPlagio" @ok="PlagioOk" @cancel="resetModal" title="Aceptar Plagio" >
           <p><img src="https://img.icons8.com/color/48/000000/copyright.png"><b>¿Estas seguro de querer Aceptar esta Denuncia?</b></p>      
           <p>Una vez que acepte la denuncia por Plagio el este libro nunca mas podra ser Publicado</p>  
        </b-modal>

         <b-modal id="modalDenied" @ok="DeniedOk" @cancel="resetModal" title="Denegar" >
           <p><img src="https://img.icons8.com/color/48/000000/cancel-2.png">
           <b>¿Estas seguro de querer Denegar esta Denuncia?</b></p>    
        </b-modal>
        <!-- modal  -->
    </b-container>


</template>

<script>
export default {
	
	props: ['id'],
    data () {
        return {
          // Note 'isActive' is left out and will not appear in the rendered table
            fieldsInspect: {
                name_user: {
                    key:'name_user',
                  label: 'Usuario Denunciante',
                  sortable: true
                },
                motivation:{
                    // key:'pivot.motivation_user_id',
                    label: 'Denuncia',                    
                    sortable: true
                },  
                description:{
                    key:'pivot.description',
                    label: 'Descripcion',
                    sortable: false
                }, 
                date:{
                    key:'pivot.created_at',
                    label: 'Fecha de Denuncia',
                    sortable: false
                },   
                accions:{
                    key:'accions',
                    label: 'Acciones'
                }
                
            },
            fieldsProcessing: {
                name_user: {
                    key:'name_user',
                  label: 'Nombre Usuario',
                  sortable: true
                },
                motivation:{
                    // key:'pivot.motivation_user_id',
                    label: 'Denuncia',                    
                    sortable: true
                },  
                description:{
                    key:'pivot.description',
                    label: 'Descripcion',
                    sortable: false
                }, 
                date:{
                    key:'pivot.created_at',
                    label: 'Fecha de Denuncia',
                    sortable: false
                }, 
                date2:{
                    key:'pivot.updated_at',
                    label: 'Inicio de Proceso',
                    sortable: false
                },    
                accions:{
                    key:'accions',
                    label: 'Ver'
                }
                
            },
            fieldsFinished: {
                name_user: {
                    key:'name_user',
                  label: 'Nombre Usuario',
                  sortable: true
                },
                denied:{
                    label: 'Resolucion',
                    sortable: true
                },
                motivation:{
                    // key:'pivot.motivation_user_id',
                    label: 'Denuncia',
                    sortable: true
                },                  
                description:{
                    key:'pivot.description',
                    label: 'Descripcion',
                    sortable: false
                }, 
                date:{
                    key:'pivot.created_at',
                    label: 'Fecha de Denuncia',
                    sortable: false
                }, 
                date2:{
                    key:'pivot.updated_at',
                    label: 'Fecha de Resolucion',
                    sortable: false
                },      
                accions:{
                    key:'accions',
                    label: 'Ver'
                }
                
            },
            genres:[],
            complaintSelected:{},
            inspect:[],
            finished:[],
            processing:[],
            motivations: [],
            currentPageInspect: 1,
            perPageInspect: 10,
            pageOptions: [ 10, 25, 50 ],
            totalRowsInpect: 0,
            currentPageFinished: 1,
            perPageFinished: 10,
            totalRowsFinished: 0,
            currentPageProcessing: 1,
            perPageProcessing: 10,
            totalRowsProcessing: 0,
            filter: null,
            idUserDelete: 0,
            summernote:{
              name:'',
              user:{
                id: 0,
                name: '',
                name_user:'',
                sex: '',
                last_name:'',
                role_id:0
            }},
            name: '',
            name_user:'',
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
        this.getMotivations();
        this.getSummernote();
        this.getGenres();
    },
    methods:{
      newWindow(url){
          window.open(url,'_blank');
          
      },
      getGenres(){              
          axios.get('/generos/Data').then(response =>{                  
              this.genres=response.data;                  
          })
      },
      getSummernote(){
        axios.get('/summernote/Data/'+this.id).then(response => {
          console.log(response)
          var summernote = response.data
          this.summernote=summernote
        }).catch(error => {
          console.log(error)
        })
      },
    	 getMotivations(){
            axios.get('/motivos-texto/Data').then(response =>{
                this.motivations=response.data;
            })
        },
        getUsers(){
            axios.get('/complaintSummernotes/Data/' + this.id ).then(response =>{
                // this.users=response.data;
                this.complaints(response.data);
                //this.totalRowsInpect=response.data.length;
            });
        } ,
        complaints(complaints){
          this.inspect = [];
          this.finished = [];
          this.processing = [];
          for (var i = 0; i < complaints.length; i++) {
            switch(complaints[i]['pivot']['status']){
              case 'I':
                this.inspect.push(complaints[i]); 
                  break;
              case 'P':
                this.processing.push(complaints[i]); 
                break;
              case 'F':
                this.finished.push(complaints[i]); 
                break;
            }            
          }
          this.totalRowsInpect = this.inspect.length;
          this.totalRowsProcessing = this.processing.length;
          this.totalRowsFinished = this.finished.length;

        },
        modalGenre (item, index, button) {
          this.complaintSelected= item;
          this.$root.$emit('bv::show::modal', 'modalGenre', button);
        },
        modalDenied (item, index, button) {
          this.complaintSelected= item;
          this.$root.$emit('bv::show::modal', 'modalDenied', button);
        },
        modalMayor (item, index, button) {
          this.complaintSelected= item;
          this.$root.$emit('bv::show::modal', 'modalMayor', button);
        },
         modalPlagio (item, index, button) {
          this.complaintSelected= item;
          this.$root.$emit('bv::show::modal', 'modalPlagio', button);
        },
        resetModal () {
          this.complaintSelected = {};
          this.selected_genre = 0;
        },
        DeniedOk(evt){
          //denuncia a denegar          
          axios.post('/complaintSummernotes/Denied',{
              complaint_id : this.complaintSelected.pivot.id,
          }).then(response =>{
            location.reload();
          }).catch(error =>{
              console.log(error.response)
          });
        },
        PlagioOk(evt){
          // despublicar para siempre el libro y poner solucionado y decir que es aceptado
          //Proceso para cambiar a estado solucionado
          axios.post('/complaintSummernotes/Plagiarism',{
              complaint_id : this.complaintSelected.pivot.id,
          }).then(response =>{
            location.reload();
          }).catch(error =>{
              if(error.response.status){
                alert("No tienes Autorizacion para realizar esta accion")
              }
          });
        },
        GenreOk(evt){
          // despublicar para siempre el libro y poner solucionado y decir que es aceptado          
           axios.post('/complaintSummernotes/Genre',{
              complaint_id : this.complaintSelected.pivot.id,
          }).then(response =>{
            location.reload();
          }).catch(error =>{
              if(error.response.status){
                alert("No tienes Autorizacion para realizar esta accion")
              }
          });
        },
        MayorOk(evt){
          this.complaintSelected; // despublicar para siempre el libro y poner solucionado y decir que es aceptado
          //Proceso para cambiar a estado solucionado
           axios.post('/complaintSummernotes/Adult',{
              complaint_id : this.complaintSelected.pivot.id,
          }).then(response =>{
            location.reload();
          }).catch(error =>{
              if(error.response.status){
                alert("No tienes Autorizacion para realizar esta accion")
              }
          });
        },
        
    }
};
 
</script>
<style>
.card-header {
    padding: 0.75rem 1.25rem;
    margin-bottom: 0;
    background-color: #81c3d7;
    border-bottom: 1px solid rgba(0, 0, 0, 0.125);
}
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