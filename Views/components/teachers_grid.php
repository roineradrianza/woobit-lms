
	     	<v-row class="px-md-16 mt-4 teachers">
	     		<v-col cols="12" sm="12" class="mt-4">
	      		<h2 class="text-h4 font-weight-bold secondary--text text-center text-md-left">Profesores</h2>
	      		<h3 class="subtitle-desc text-center text-md-left" v-if="1 == 2">Aquí un texto descriptivo sobre la sección</h3>
	      	</v-col>
	      	<v-row class="px-10 px-md-16 d-flex justify-center">

		      	<v-col cols="12" md="3">
		      		<v-card :loading="loading" class="my-12 teacher-card" max-width="95%">
						    <template slot="progress">
						      <v-progress-linear color="deep-purple" height="10" indeterminate ></v-progress-linear>
						    </template>

						    <v-img width="50vw" height="30vw" class="align-end" src="<?= SITE_URL ?>/img/avatar/ximena.jpg" >
						    	<v-card-title class="d-block font-weight-bold card-teacher-title white--text no-word-break">
						    			<h4 class="text-h5">Ximena Sanchez</h4>
						    			<h5 class="font-weight-light">Profesora de Comunicación social de la UCAB</h5>
						    			<p class="subtitle-2" v-if="1 == 2">134 seguidores</p>
						    			<v-btn class="teacher-button-card py-2 px-6 rounded-pill white--text"><v-icon class="white--text mr-2">mdi-plus-circle</v-icon> Seguir</v-btn>
						    	</v-card-title>
						    </v-img>
						  </v-card>
		      	</v-col>
		      	<v-col cols="12" md="3">
		      		<v-card :loading="loading" class="my-12 teacher-card" max-width="95%">
						    <template slot="progress">
						      <v-progress-linear color="deep-purple" height="10" indeterminate ></v-progress-linear>
						    </template>

						    <v-img width="50vw" height="30vw" class="align-end" src="<?= SITE_URL ?>/img/avatar/ruth.jpg" >
						    	<v-card-title class="d-block font-weight-bold card-teacher-title white--text no-word-break">
						    			<h4 class="text-h5">Ruth Velazquez</h4>
						    			<h5 class="font-weight-light">Profesora</h5>
						    			<p class="subtitle-2" v-if="1 == 2">134 seguidores</p>
						    			<v-btn class="teacher-button-card py-2 px-6 rounded-pill white--text"><v-icon class="white--text mr-2">mdi-plus-circle</v-icon> Seguir</v-btn>
						    	</v-card-title>
						    </v-img>
						  </v-card>
		      	</v-col>
		      	
	      	</v-row>
	     	</v-row>
	     	