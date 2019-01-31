<template>
<div>

       <div id="multi-item-example" class="carousel slide carousel-multi-item  " data-ride="carousel">
        <!--/.Indicators-->

        <!--Slides-->
        <br>
        <h4>Mejores Calificados</h4>
        <div class="carousel-inner col-md-12 " role="listbox">
            <!--First slide-->
            <div class="carousel-item active ">
                <b-card-group deck class="mb-3 tile__media">
                     <a class="btn-floating" href="#multi-item-example" data-slide="prev"><i class="fa fa-chevron-left"></i></a>                
                     <b-card class="tile" overlay style="cursor:pointer;"  @click="card(calification.id)"  border-variant="primary" v-for="(calification , i) in califications" :key="i" v-if="i < 5"
                            :img-src="calification.route"
                            img-alt="Card Image"
                            img-top
                            img-fluid>
                            <b-card-body class="tile__details">
                                  <div class="tile__title" style="margin: 100px 0;">
                                    <p class="mytitle text-uppercase"><b>{{ calification.name }}</b></p>
                                    <label v-if="calification.abstract.slice(0, 100).length < calification.abstract.length" style="color:white;"> {{ calification.abstract.slice(0, 100)+"..."}} </label>
                                    <label v-else style="color:white;"> {{ calification.abstract}} </label>
                                    <b-badge pill variant="warning">{{ calification.genre.name }}</b-badge>
                                    <b-badge pill variant="primary" v-for="category in calification.categories" :key="i">{{ category.name }}</b-badge>
                                  </div>       
                            </b-card-body>

                            <div class="foot" slot="footer">
                                <b-form-radio-group  :disabled="scored" class="score" buttons  button-variant="invisible" id="radios2"  name="radioSubComponent">
                                    <b-form-radio v-bind:class="[calification.calification >= 5 ? 'starCheck' : '']" value="5" >★</b-form-radio>
                                    <b-form-radio v-bind:class="[calification.calification >= 4 ? 'starCheck' : '']" value="4">★</b-form-radio>
                                    <b-form-radio v-bind:class="[calification.calification >= 3 ? 'starCheck' : '']" value="3">★</b-form-radio>
                                    <b-form-radio v-bind:class="[calification.calification >= 2 ? 'starCheck' : '']" value="2">★</b-form-radio>
                                    <b-form-radio v-bind:class="[calification.calification >= 1 ? 'starCheck' : '']" value="1">★</b-form-radio>                                
                                  </b-form-radio-group>
                            </div> 
                    </b-card>
                     <a class="btn-floating" href="#multi-item-example" data-slide="next"><i class="fa fa-chevron-right"></i></a>
                </b-card-group>
               
            </div>
            <div class="carousel-item">
                <b-card-group deck class="mb-3 tile__media" > 
                    <a class="btn-floating" href="#multi-item-example" data-slide="prev"><i class="fa fa-chevron-left"></i></a>                
                     <b-card class="tile" overlay  style="cursor:pointer;"  @click="card(calification.id)"  border-variant="primary" v-for="(calification , i) in califications" :key="i" v-if="i >= 5"
                            :img-src="calification.route"
                            img-alt="Img"
                            img-top
                            img-fluid>
                            <b-card-body class="tile__details">
                                  <div class="tile__title" style="margin: 100px 0;">
                                    <p class="mytitle text-uppercase"><b>{{ calification.name }}</b></p>
                                    <label v-if="calification.abstract.slice(0, 100).length < calification.abstract.length" style="color:white;"> {{ calification.abstract.slice(0, 100)+"..."}} </label>
                                    <label v-else style="color:white;"> {{ calification.abstract}} </label>
                                    <b-badge pill variant="warning">{{ calification.genre.name }}</b-badge>
                                    <b-badge pill variant="primary" v-for="category in calification.categories" :key="i">{{ category.name }}</b-badge>
                                  </div>       
                            </b-card-body>
                            <div class="foot" slot="footer">
                                  <b-form-radio-group  :disabled="scored" class="score" buttons  button-variant="invisible" id="radios2"  name="radioSubComponent">
                                    <b-form-radio v-bind:class="[calification.calification >= 5 ? 'starCheck' : '']" value="5" >★</b-form-radio>
                                    <b-form-radio v-bind:class="[calification.calification >= 4 ? 'starCheck' : '']" value="4">★</b-form-radio>
                                    <b-form-radio v-bind:class="[calification.calification >= 3 ? 'starCheck' : '']" value="3">★</b-form-radio>
                                    <b-form-radio v-bind:class="[calification.calification >= 2 ? 'starCheck' : '']" value="2">★</b-form-radio>
                                    <b-form-radio v-bind:class="[calification.calification >= 1 ? 'starCheck' : '']" value="1">★</b-form-radio>                                
                                  </b-form-radio-group>
                            </div>                            
                    </b-card>
                    <a class="btn-floating" href="#multi-item-example" data-slide="next"><i class="fa fa-chevron-right"></i></a>
                </b-card-group>
            </div>
        </div>
    </div>

    <div id="multi-item-example2" class="carousel slide carousel-multi-item" data-ride="carousel">
        <h4>Ultimas Tendencias</h4>
        <div class="carousel-inner col-md-12" role="listbox">
            <!--First slide-->
            <div class="carousel-item active">
                <b-card-group deck class="mb-3 tile__media">
                     <a class="btn-floating" href="#multi-item-example2" data-slide="prev"><i class="fa fa-chevron-left"></i></a>                
                     <b-card class="tile" style="cursor:pointer;"  @click="card(summernote.id)" overlay  border-variant="primary" v-for="(summernote , i) in weekViews" :key="i" v-if="i < 5"
                            :img-src="summernote.route"
                            img-alt="Img"
                            img-top
                            img-fluid>
                            <b-card-body class="tile__details">
                                  <div class="tile__title" style="margin: 100px 0;">
                                    <p class="mytitle text-uppercase"><b>{{ summernote.name }}</b></p>
                                    <label v-if="summernote.abstract.slice(0, 100).length < summernote.abstract.length" style="color:white;"> {{ summernote.abstract.slice(0, 100)+"..."}} </label>
                                    <label v-else style="color:white;"> {{ summernote.abstract}} </label>
                                    <b-badge pill variant="warning">{{ summernote.genre.name }}</b-badge>
                                    <b-badge pill variant="primary" v-for="category in summernote.categories" :key="i">{{ category.name }}</b-badge>
                                  </div>       
                            </b-card-body>
                            <div class="foot" slot="footer">
                                <p class="myviews">{{summernote.views +" views" }}</p>
                            </div>
                    </b-card>
                     <a class="btn-floating" href="#multi-item-example2" data-slide="next"><i class="fa fa-chevron-right"></i></a>
                </b-card-group>
               
            </div>
            <div class="carousel-item ">
                <b-card-group deck class="mb-3"> 
                    <a class="btn-floating" href="#multi-item-example2" data-slide="prev"><i class="fa fa-chevron-left"></i></a>                
                     <b-card class="tile" overlay  style="cursor:pointer;"  @click="card(summernote.id)" border-variant="primary" v-for="(summernote , i) in weekViews" :key="i" v-if="i >= 5"
                            :img-src="summernote.route"
                            img-alt="Img"
                            img-top
                            img-fluid>
                            <b-card-body class="tile__details">
                                  <div class="tile__title" style="margin: 100px 0;">
                                    <p class="mytitle text-uppercase"><b>{{ summernote.name }}</b></p>
                                    <label v-if="summernote.abstract.slice(0, 100).length < summernote.abstract.length" style="color:white;"> {{ summernote.abstract.slice(0, 100)+"..."}} </label>
                                    <label v-else style="color:white;"> {{ summernote.abstract}} </label>
                                    <b-badge pill variant="warning">{{ summernote.genre.name }}</b-badge>
                                    <b-badge pill variant="primary" v-for="category in summernote.categories" :key="i">{{ category.name }}</b-badge>
                                  </div>       
                            </b-card-body>
                            <div class="foot" slot="footer">
                                  <p class="myviews">{{summernote.views +" views" }}</p>
                            </div>                              
                    </b-card>
                    <a class="btn-floating" href="#multi-item-example2" data-slide="next"><i class="fa fa-chevron-right"></i></a>
                </b-card-group>
            </div>
        </div>
    </div>

    <div id="multi-item-example3" class="carousel slide carousel-multi-item" data-ride="carousel">
        <h4>Mas Visitados</h4>
        <div class="carousel-inner col-md-12" role="listbox">
            <!--First slide-->
            <div class="carousel-item active">
                <b-card-group deck class="mb-3">
                     <a class="btn-floating" href="#multi-item-example3" data-slide="prev"><i class="fa fa-chevron-left"></i></a>                
                     <b-card class="tile" style="cursor:pointer;"  @click="card(summernote.id)" overlay  border-variant="primary" v-for="(summernote , i) in globalViews" :key="i" v-if="i < 5"
                            :img-src="summernote.route"
                            img-alt="Img"
                            img-top
                            img-fluid>
                            <b-card-body class="tile__details">
                                  <div class="tile__title" style="margin: 100px 0;">
                                    <p class="mytitle text-uppercase"><b>{{ summernote.name }}</b></p>
                                    <label v-if="summernote.abstract.slice(0, 100).length < summernote.abstract.length" style="color:white;"> {{ summernote.abstract.slice(0, 100)+"..."}} </label>
                                    <label v-else style="color:white;"> {{ summernote.abstract}} </label>
                                    <b-badge pill variant="warning">{{ summernote.genre.name }}</b-badge>
                                    <b-badge pill variant="primary" v-for="category in summernote.categories" :key="i">{{ category.name }}</b-badge>
                                  </div>       
                            </b-card-body>
                            <div class="foot" slot="footer">
                                <p class="myviews">{{summernote.views +" views" }}</p>
                            </div>
                    </b-card>
                     <a class="btn-floating" href="#multi-item-example3" data-slide="next"><i class="fa fa-chevron-right"></i></a>
                </b-card-group>
               
            </div>
            <div class="carousel-item ">
                <b-card-group deck class="mb-3"> 
                    <a class="btn-floating" href="#multi-item-example3" data-slide="prev"><i class="fa fa-chevron-left"></i></a>                
                     <b-card class="tile" overlay style="cursor:pointer;"  @click="card(summernote.id)" border-variant="primary" v-for="(summernote , i) in globalViews" :key="i" v-if="i >= 5"
                            :img-src="summernote.route"
                            img-alt="Img"
                            img-top
                            img-fluid>
                            <b-card-body class="tile__details">
                                  <div class="tile__title" style="margin: 100px 0;">
                                    <p class="mytitle text-uppercase"><b>{{ summernote.name }}</b></p>
                                    <label v-if="summernote.abstract.slice(0, 100).length < summernote.abstract.length" style="color:white;"> {{ summernote.abstract.slice(0, 100)+"..."}} </label>
                                    <label v-else style="color:white;"> {{ summernote.abstract}} </label>
                                    <b-badge pill variant="warning">{{ summernote.genre.name }}</b-badge>
                                    <b-badge pill variant="primary" v-for="category in summernote.categories" :key="i">{{ category.name }}</b-badge>
                                  </div>       
                            </b-card-body>                            
                            <div class="foot" slot="footer">
                                  <p class="myviews">{{summernote.views +" views" }}</p>
                            </div>
                                                            
                    </b-card>
                    <a class="btn-floating" href="#multi-item-example3" data-slide="next"><i class="fa fa-chevron-right"></i></a>
                </b-card-group>
            </div>
        </div>
    </div>
</div>
</template>
<script>

	export default{
		mounted(){
			this.getSummernotes();
		},
		data(){
			return{
				califications:[],
				globalViews:[],
				weekViews:[],
                starCheck:'starCheck',
                scored:true,
				// slide: 0,
    //   			sliding: null


			}
		},
		methods:{
            card(idSummernote){
                window.location.href='/summernote/'+idSummernote;
            },
			getSummernotes(){
				axios.get('/home').then(response => {
					this.califications=response.data.califications;
					this.globalViews = response.data.globalViews;
					this.weekViews = response.data.weekViews;
				}).catch(error => {
					console.log(error)
				})
			},
			// onSlideStart (slide) {
		 //      this.sliding = true
		 //    },
		 //    onSlideEnd (slide) {
		 //      this.sliding = false
		 //    }
		}
	};
</script>
<style>
.img-fluid{
    height: 280px;
}
.transparent{
    background-color: rgba(0,0,255,0.2)
}
#form {
      width: 250px;
          margin: 0 auto;
          height: 50px;
    }
    #form p {
      text-align: center;
    }
    #form label {
      font-size: 20px;
    }
    .score {
      direction: rtl;
      unicode-bidi: bidi-override;
      text-align: left;
    }
    .star:hover,
    .star:hover ~ .star {
      color: orange;
    }
    .starCheck{
        color: orange;
    }

/*netflix*/
a:link,
a:hover,
a:active,
a:visited {
  transition: color 150ms;
  color: #95a5a6;
  text-decoration: none;
}
a:hover {
  color: #7f8c8d;
  text-decoration: underline;
}

P.mytitle {
    text-align: left;
    color: white;
    font-size: 14px;
}
P.myviews {
    text-align: center;
    color: gray;
    font-size: 14px;
}
.tile {
  position: relative;
  display: inline-block;
  /*width: 250px;*/
  height: 350px;
  margin-right: 10px;
  font-size: 20px;
  cursor: pointer;
  transition: 450ms all;
  transform-origin: center left;
}
.tile__img {
  width: 250px;
  height: 350px;
  object-fit: cover;
}
.tile__details {
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  top: 0;
  font-size: 12px;
  opacity: 0;
  background: linear-gradient(to top, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0.8) 100%);
  transition: 550ms opacity;
}
.tile__details:after,
.tile__details:before {
  content: '';
  position: absolute;
  top: 50%;
  left: 50%;
  display: #000;
}
/*.tile__details:after {
  margin-top: -25px;
  margin-left: -25px;
  width: 50px;
  height: 50px;
  border: 3px solid #ecf0f1;
  line-height: 50px;
  text-align: center;
  border-radius: 100%;
  background: rgba(0,0,0,0.5);
  z-index: 1;
}*/
/*.tile__details:before {
  content: '▶';
  left: 0;
  width: 100%;
  font-size: 30px;
  margin-left: 7px;
  margin-top: -18px;
  text-align: center;
  z-index: 2;
}*/
.tile:hover .tile__details {
  opacity: 1;
}
.tile:hover .foot {
  display: none; 
}

.tile__title {
  position: absolute;
  bottom: 0;
  padding: 10px;

}

.tile:hover ~ .tile {
  transform: translate3d(25px, 0, 0);
}


</style>