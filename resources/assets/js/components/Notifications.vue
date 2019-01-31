<template>
	  <b-dropdown id="notificacion" right size="" variant="warning" style="display: inline;margin-top: 12px;">
	  	<template  slot="button-content">
	  		<img src="https://img.icons8.com/ios/25/000000/alarm.png">
	  		<b-badge v-if="notifications.length" v-text="notifications.length" style="background-color:#ffc107;"></b-badge>
	  	</template>
	  	<div v-if="notifications.length == 0">
	  		<b-dropdown-item-button class="text-center" >
	  	 		Sin Notificaciones
	  	 	</b-dropdown-item-button>
	  	</div>	
	  	<div v-else>
	  		<b-dropdown-item-button active="true" class="dropdown-item active text-center" @click.stop="markAsReadAll()" >
	  			Marcar todas como leidas
	  		</b-dropdown-item-button>
  		 	<div v-for="(notification, index) in notifications">
		  	 	<b-dropdown-item-button append="true" @click.stop="markAsRead(notification)" >
		  	 		<b-row>
					<b-col cols="2">
						<b-img left class="imgRedondaNot" :src='notification.data.routePictureUser'/> 
					</b-col>
		 			<b-col cols="10" style="white-space: normal;">
		 				<p class="text-justify">{{ notification.data.message }}</p>
		 			</b-col>
		 		</b-row>
		  	 	</b-dropdown-item-button>
		  	 	<b-dropdown-divider v-if="index !== notifications.length-1"></b-dropdown-divider>
	  	 	</div>
	  	 <!-- 	<b-dropdown-item class="dropdown-item text-center"> -->
	  	 	
	  	</div>
	  	<div class="row">
	  	 		<div class="col-sm-3 offset-sm-4" style="text-align: center;"> 
	  	 			<b-link @click.stop="redirect()" class="btnNotification">Ver Todo</b-link>	
	  	 		</div>
	  	 	</div>
	  	
	  	 </b-dropdown>  

</template>
<script>
	export default{
		mounted(){
			this.getNotificationsUnread();
		},
		data(){
			return{
				notifications:[],

			}
		},
		methods:{
			redirect(){
				window.location.href='/notificaciones';
			},
			markAsReadAll(){
				this.notifications.forEach(function (item) {				 
					axios.patch('/notificaciones/'+ item.id+'/leer').then(response =>{
		                
		           	}).catch(error => {
						console.log(error)
					})
				})
				location.reload();
   				// this.getNotificationsUnread();

			},
			getNotificationsUnread(){
	            axios.get('/notificaciones/unread/data').then(response =>{
	                console.log(response.data)
	                this.notifications=response.data
	            })
	        },
	        markAsRead(notification){
	        	axios.patch('/notificaciones/'+ notification.id+'/leer').then(response =>{

	           	}).catch(error => {
					console.log(error)
				})
				window.location.href=notification.data.link;
				
	        }
	        
		}
	};

</script>
<style type="text/css">
	.dropdown#notificacion .btn{
		background-color: #a73939;
	}
	.dropdown#notificacion .dropdown-menu{
		width: 450px!important;
	}
	.imgRedondaNot {
	    width: 40px!important;
	    height: 40px!important;
	    border: 1px solid #C0C0C0;
	    object-fit: cover;
	    margin-right: 10px;
	}
	.btnNotification{
		color: blue!important;
		text-align: center;
	}

</style>