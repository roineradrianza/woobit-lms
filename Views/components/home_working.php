
	      <template v-if="1 == 2">
		      <v-row class="px-16 d-flex align-center">
		      	<v-col class="pl-16"  cols="12" md="5">
		      		<v-img src="<?php echo SITE_URL ?>/img/personas-escritorio.jpg" width="100%" height="30vw"></v-img>
		      	</v-col>
		      	<v-col cols="12" md="7">
		      		<h3 class="grey--text text-h3">Bienvenidos a Full Learning</h3>
		      		<v-col class="pl-0" cols="7">
			      		<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Similique, quia. Rem odit ut quo, mollitia ipsum magnam, explicabo cupiditate corporis perferendis nobis delectus beatae commodi vel voluptas doloribus, iste perspiciatis!</p>
		      		</v-col>

		      		<v-col class="pl-0" cols="9">
		      			<h4 class="font-weight-light text-h5 grey--text text--lighten-1">Contribuimos con el próposito de tu vida</h4>
			      		<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Similique, quia. Rem odit ut quo, mollitia ipsum magnam, explicabo cupiditate corporis perferendis nobis delectus beatae commodi vel voluptas doloribus, iste perspiciatis!</p>
		      		</v-col>
		      	</v-col>
		      </v-row>
		      <v-row class="px-16 mt-12 mb-16 d-flex align-center">
		      	<v-col cols="12" md="4">
		      		<v-col cols="12" v-if="skills_container">
		      			<h3 class="secondary--text text-h4 text-center mb-10">Habilidades</h3>
			      		<p class="font-weight-light">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsum saepe, doloremque mollitia, alias iusto repudiandae dicta. Sapiente aliquid fugiat minus! Accusamus dolore earum, omnis est nisi minus ad numquam culpa?</p>		      			
			      		<p class="font-weight-light">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsum saepe, doloremque mollitia, alias iusto repudiandae dicta. Sapiente aliquid fugiat minus! Accusamus dolore earum, omnis est nisi minus ad numquam culpa?</p>			      			
			      		<p class="font-weight-light">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsum saepe, doloremque mollitia, alias iusto repudiandae dicta. Sapiente aliquid fugiat minus! Accusamus dolore earum, omnis est nisi minus ad numquam culpa?</p>  			
		      		</v-col>
		      		<v-col cols="12" transition="scroll-y-reverse-transition" v-else>
		      			<h3 class="secondary--text text-h4 text-center mb-10" 
		      			>Contáctanos</h3>
		      			<p class="font-weight-light">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsum saepe, doloremque mollitia,</p>
		      			<p class="font-weight-light">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsum saepe, doloremque mollitia,</p>
		      			<p class="font-weight-light">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsum saepe, doloremque mollitia,</p>
		      		</v-col>
		      	</v-col>
		      	<v-col class="pl-16"  cols="12" md="4">
		      		<v-img src="<?php echo SITE_URL ?>/img/persona-escritorio.jpg" width="100%" height="30vw"></v-img>
		      	</v-col>
		      	<v-col cols="12" md="4" v-on:click="hideSkills">
		      		<h3 class="grey--text text-h4 text-center">Contáctanos</h3>
		      	</v-col>
		      	<v-col class="mt-10" cols="12">
		      		<v-divider></v-divider>
		      	</v-col>
		      </v-row>
	      </template>
	      <v-row class="px-16 mb-16" v-if="1 == 2">
	      	<v-col cols="12">
	      	<h3 class="grey--text text--lighten-1 text-h4">Certificaciones</h3>
	      	</v-col>
	      	<v-col cols="12" md="4">
	      		<v-img src="<?php echo SITE_URL ?>/img/certificado-plantilla.jpg"></v-img>
	      		<p class="body-1 mt-3">Certficado de Google</p>
	      	</v-col>
	      	<v-col cols="12" md="4">
	      		<v-img src="<?php echo SITE_URL ?>/img/certificado-plantilla.jpg"></v-img>
	      		<p class="body-1 mt-3">Certficado de Google</p>
	      	</v-col>
	      	<v-col cols="12" md="4">
	      		<v-img src="<?php echo SITE_URL ?>/img/certificado-plantilla.jpg"></v-img>
	      		<p class="body-1 mt-3">Certficado de Google</p>
	      	</v-col>	
	      </v-row>