		
				<v-row class="px-16 pb-16 mt-12" v-if="page_loading">
					<v-col cols="12" >
						<v-skeleton-loader type="card-avatar, article, actions" min-height="40vh"></v-skeleton-loader>
					</v-col>

					<v-col cols="12" >
						<v-skeleton-loader type="article, actions" min-height="40vh"></v-skeleton-loader>
					</v-col>
				</v-row>
				<v-row class="px-4 px-md-16 pb-16 mt-12" v-else>
					<v-col class="course-details" cols="12" >
				    <v-snackbar v-model="reminder" timeout="1600000" color="primary">
				      Cada sección se guarda individualmente, no te olvides de presionar el botón de guardado en cada una que modifiques.
				      <template v-slot:action="{ attrs }">
				        <v-btn color="white" text v-bind="attrs" @click="reminder = false" >
				          Cerrar
				        </v-btn>
				      </template>
				    </v-snackbar>
				    <v-row class="d-flex justify-md-end justify-center px-3 mb-3">
              <label for="course_featured_image">
								<p class="white--text text-center py-2 text-uppercase primary  rounded-pill px-6 cursor-pointer upload-button mb-3 mb-md-0 ml-2 ml-md-0">Actualizar portada del curso</p>
								<input type="file" name="course_featured_image" id="course_featured_image" class="d-none" v-on:change="prevImage"/>
      				</label>
      				<template v-if="previewImage != currentImage && !image_loading">
					    	<v-btn class="white--text ml-md-3 success" @click="saveFeaturedImage"><v-icon>mdi-check</v-icon></v-btn>
					    	<v-btn class="white--text ml-3 error" @click="resetImage"><v-icon>mdi-close</v-icon></v-btn>
      				</template>
				    	<v-btn class="white--text ml-3 warning" :loading="image_loading" v-if="image_loading"></v-btn>
				    </v-row>
						<v-img class="grey darken-3 overlay-img d-flex align-center" :src="previewImage" width="100%" max-height="60vw">
							<v-col class="px-16 mt-md-16" cols="7">
								<h3 class="mt-md-16 text-md-h1 text-sm-h3 white--text category">{{ course.title }}</h3>
							</v-col>
						</v-img>
						  <v-tabs class="mt-n16" fixed-tabs>
						    <v-tab class="py-6 white--text font-weight-light">General</v-tab>
						    <v-tab class="py-6 white--text font-weight-light">Profesores</v-tab>
						    <v-tab class="py-6 white--text font-weight-light">Clases</v-tab>
						    <v-tab class="py-6 white--text font-weight-light">FAQ</v-tab>
						    <v-tab class="py-6 white--text font-weight-light">Configuración</v-tab>
						    <v-tab-item class="px-md-14 px-7 py-10">
						    <?php echo new Controller\Template('course/edit/tabs/general') ?>
						    </v-tab-item>
						    <v-tab-item class="px-md-14 px-7 py-10">
						    <?php echo new Controller\Template('course/edit/tabs/instructors') ?>
						    </v-tab-item>
						    <v-tab-item class="px-md-14 px-7 py-10">
						    <?php echo new Controller\Template('course/edit/tabs/curriculum') ?>
						    </v-tab-item>
						    <v-tab-item class="px-md-14 px-7 py-10">
						    <?php echo new Controller\Template('course/edit/tabs/FAQ') ?>
						    </v-tab-item>
						    <v-tab-item class="px-md-14 px-7 py-10">
						    <?php echo new Controller\Template('course/edit/tabs/setup') ?>
						    </v-tab-item>
						  </v-tabs>
					</v-col>
					<?php echo new Controller\Template('course/edit/parts/sidebar') ?>
				</v-row>
