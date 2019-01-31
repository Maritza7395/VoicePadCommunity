<template>
	<b-container>
		<b-row>
	    	<b-col class="text-center">
	    		<label >No Leidas</label>
	    		<b-card class=" bg-white">
		          <b-tabs>
		            <b-tab active> 
			            <template slot="title">
			               Comunidad
			           </template>
			           <b-list-group flush>
			           		<b-list-group-item button variant="primary" @click="markAsReadAll()">Marcar todas como leidas
			  				</b-list-group-item>
           					<b-list-group-item   v-for="notification in unreadNotifications" :key="notification.id" v-if="notification.type !== 'App\\Notifications\\AdministrativeNotification'" v-bind:class="[notification.type == 'App\\Notifications\\Complaint' ? 'bgColor' :'']" style="padding: 0;">{{ moment(notification.created_at).format('DD/MM/YYYY')}}  {{ notification.data.message }}	
           					<b-btn variant="link" @click="markAsRead(notification)" v-b-popover.hover="'marcar como leida'">
           						<img src="https://img.icons8.com/small/16/000000/checkmark.png">
           					</b-btn>
           					<b-btn variant="link" @click="markAsRead(notification,'go')" v-b-popover.hover="'ir'"  >
           						<img src="https://img.icons8.com/small/16/000000/circled-chevron-right.png">
           					</b-btn>
			  				</b-list-group-item>
						</b-list-group>
		           </b-tab>
		            <b-tab v-if="userAuth.role_id == 1" active> 
			            <template slot="title">
			               Administrativas
			           </template>
			           <b-list-group flush>
			           		<b-list-group-item button @click="markAsReadAll('admin')" variant="primary">Marcar todas como leidas
			  				</b-list-group-item>
           					<b-list-group-item  v-for="notification in unreadNotifications"  :key="notification.id" v-if="notification.type === 'App\\Notifications\\AdministrativeNotification'" style="padding: 0;">{{ moment(notification.created_at).format('DD/MM/YYYY')}}  {{ notification.data.message }}	
           					<b-btn variant="link" @click="markAsRead(notification)" v-b-popover.hover="'marcar como leida'">
           						<img src="https://img.icons8.com/small/16/000000/checkmark.png">
           					</b-btn>
           					<b-btn variant="link" @click="markAsRead(notification,'go')" v-b-popover.hover="'ir'"  >
           						<img src="https://img.icons8.com/small/16/000000/circled-chevron-right.png">
           					</b-btn>
			  				</b-list-group-item>
						</b-list-group>									           
		           </b-tab>
		           </b-tabs>
	           	</b-card> 
	    	</b-col>
	    	<b-col class="text-center">
	    		<label >Leidas</label>
	    		<b-card class=" bg-white">
		          <b-tabs>
		            <b-tab active> 
			            <template slot="title">
			               Comunidad
			           </template>
			           <b-list-group flush v-for="notification in readNotifications" :key="notification.id" v-if="notification.type !== 'App\\Notifications\\AdministrativeNotification'">
						  	<b-list-group-item   v-bind:class="[notification.type == 'App\\Notifications\\Complaint' ? 'bgColor' :'']" style="padding: 0;" >
						  		{{ moment(notification.created_at).format('DD/MM/YYYY')}}  {{ notification.data.message }}
						  		<b-btn variant="link" @click="markAsRead(notification,'go')" v-b-popover.hover="'ir'"  >
           							<img src="https://img.icons8.com/small/16/000000/circled-chevron-right.png">
           						</b-btn>
						  	</b-list-group-item>
						</b-list-group>
		           </b-tab>
		            <b-tab v-if="userAuth.role_id == 1" active> 
			            <template slot="title">
			               Administrativas
			           </template>
			            <b-list-group flush v-for="notification in readNotifications" :key="notification.id" v-if="notification.type === 'App\\Notifications\\AdministrativeNotification'" style="padding: 0;">
						  	<b-list-group-item >
						  		{{ moment(notification.created_at).format('DD/MM/YYYY')}}  {{ notification.data.message }}
						  		<b-btn variant="link" @click="markAsRead(notification,'go')" v-b-popover.hover="'ir'"  >
           						<img src="https://img.icons8.com/small/16/000000/circled-chevron-right.png">
           					</b-btn>
						  	</b-list-group-item>
						</b-list-group>
		           </b-tab>
		           </b-tabs>
	           	</b-card> 
	    	</b-col>
	    </b-row>
	</b-container>
	
</template>
<script>
	export default{
		mounted(){
			this.getNotificationsUnread();
			this.getNotificationsread();
			this.getUserAuth();
		},
		data(){
			return{
				unreadNotifications:[],
				readNotifications:[],
				userAuth:{},
			}
		},
		methods:{
			markAsReadAll(admin){
				this.unreadNotifications.forEach(function (item) {	
					if(admin === 'admin'){
						if(item.type == 'App\\Notifications\\AdministrativeNotification'){
							axios.patch('/notificaciones/'+ item.id+'/leer').then(response =>{

				           	}).catch(error => {
								console.log(error)
							})
						}

					}else{
						if(item.type != 'App\\Notifications\\AdministrativeNotification'){
							axios.patch('/notificaciones/'+ item.id+'/leer').then(response =>{

				           	}).catch(error => {
								console.log(error)
							})
						}
						
					}
					
				})
				location.reload();
   				// this.getNotificationsUnread();
   				// this.getNotificationsread();

			},
			getNotificationsUnread(){
	            axios.get('/notificaciones/unread/data').then(response =>{
	                console.log(response.data)
	                this.unreadNotifications=response.data
	            })
	        },
	        getNotificationsread(){
	            axios.get('/notificaciones/read/data').then(response =>{
	                console.log(response.data)
	                this.readNotifications=response.data
	            })
	        },
	        markAsRead(notification, go){
	        	axios.patch('/notificaciones/'+ notification.id+'/leer').then(response =>{

	           	}).catch(error => {
					console.log(error)
				})
				if(go === 'go'){
					console.log("redireccion");
	        		window.location.href=notification.data.link;
	        	}
	        	else{
	        		location.reload();	
	        	}
	        	
				// this.getNotificationsUnread();
				// this.getNotificationsread();
	        },
	          getUserAuth(){
		        axios.get('/usuarioAutenticado').then(response => {
		          console.log(response)
		          this.userAuth = response.data
		        }).catch(error => {
		          console.log(error)
		        })
		      },
		}
	};

</script>
<style>
	.bgColor
	{
	    background-color: #ff000066;
	}
   
</style>