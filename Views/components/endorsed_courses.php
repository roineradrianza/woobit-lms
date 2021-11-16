	      <v-row class="px-16 mt-4">
	      	<v-col cols="12" sm="12">
	      		<h2 class="text-h4 font-weight-bold primary--text text-center text-md-left">Cursos Avalados</h2>
	      		<h3 class="subtitle-desc d-block d-md-inline text-center text-md-left" v-if="1 == 2">Aquí un texto que explique qué son los cursos avalados</h3>
	      		<v-row class="d-flex justify-center justify-md-end">
		      		<v-btn class="px-10 py-0 mr-md-5 mt-4 mt-md-0 rounded-pill secondary--text float-right font-weight-light" outlined>Ver más</v-btn>	      			
	      		</v-row>
	      	</v-col>
	      </v-row>
	      <v-row class="px-16">
	      	<v-col cols="12" md="4" sm="12" v-for="i in 3">
	      		<v-card :loading="loading" class="my-12 course-card" max-width="95%">
					    <template slot="progress">
					      <v-progress-linear color="deep-purple" height="10" indeterminate ></v-progress-linear>
					    </template>

					    <v-img width="100vw" class="align-end" src="/img/cursos/cursos-avalados.png" >
					    	<v-card-title class="category-label float-left mb-6 font-weight-bold">
					    		<ul class="list">
					    			<li><span>Fotografía</span></li>
					    		</ul>
					    	</v-card-title>
					    </v-img>

					    <v-card-title class="text-h6 font-weight-normal">Título detallado del curso</v-card-title>

					    <v-card-text class="grey--text text--lighten-1">
					      <div>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
					      tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
					      quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
					      consequat.</div>
					      <div class="d-block mt-3 mb-2">
					      	<v-icon class="grey--text text--lighten-1">mdi-account</v-icon> 20
					      </div>
					      <v-chip class="secondary" dark >$10.99 USD</v-chip>
					    </v-card-text>

					    <v-divider class="mx-4"></v-divider>

					    <v-card-text class="pb-md-10 pb-lg-5">
					    <v-avatar class="teacher-course-avatar">
					      <img src="/img/avatar/profesores1.png" width="20px" height="20px" alt="John">
					    </v-avatar>
					    <span class="font-weight-normal">By </span><span class="subtitle-2 font-weight-bold"> Alexandra Rincones</span class="subtitle-2 text-primary">
					      <v-chip class="primary aval-button float-right mt-md-2" dark >Ava.</v-chip>
					    </v-card-text>
					  </v-card>
	      	</v-col>
	      </v-row>