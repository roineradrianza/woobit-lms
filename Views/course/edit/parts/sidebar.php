					<v-col cols="12">
						<v-sheet class="extra-info-container">
							<v-col class="primary" cols="12">
								<p class="white--text text-center text-h5 pt-2" block color="primary">Full Learning</p>
								
							</v-col>
							<v-row>
								<v-col cols="12" md="8">
									<v-row>
										<v-col cols="12" md="4">
											<v-list-item append-icon="mdi-account-group">
									      <v-list-item-content>
									        <v-list-item-title class="grey--text text--darken-1">Inscrito: <span class="font-weight-light">200 estudiantes</span>
							          	</v-list-item-title>
									      </v-list-item-content>
									    </v-list-item>
								  	</v-col>
										<v-col cols="12" md="4">
											<v-list-item>
									      <v-list-item-content>
									        <v-list-item-title class="grey--text text--darken-1">Horas en video: <span class="font-weight-light">{{ course.duration }}</span></v-list-item-title>
									      </v-list-item-content>
									    </v-list-item>
								  	</v-col>
										<v-col cols="12" md="4">
											<v-list-item>
									      <v-list-item-content>
									        <v-list-item-title class="grey--text text--darken-1">Clases: <span class="font-weight-light">40 clases</span></v-list-item-title>
									      </v-list-item-content>
									    </v-list-item>
								  	</v-col>
										<v-col cols="12" md="4">
											<v-list-item>
									      <v-list-item-content>
									        <v-list-item-title class="grey--text text--darken-1">Nivel: <span class="font-weight-light text-capitalize">{{ course.level }}</span></v-list-item-title>
									      </v-list-item-content>
									    </v-list-item>
								  	</v-col>
										<v-col cols="12" md="4">
											<v-list-item>
									      <v-list-item-content>
									        <v-list-item-title class="grey--text text--darken-1">
									        	<template v-if="parseInt(course.platform_owner)">
									        		Por <span class="primary--text">Full Learning</span>
									        	</template>
									        	<template v-else>
									        		Profesor: <span class="font-weight-light">Marcel Marin</span>	
									        	</template>
									        </v-list-item-title>
									      </v-list-item-content>
									    </v-list-item>
								  	</v-col>
										<v-col cols="12" md="4" v-if="course.hasOwnProperty('category_id') && course.category_id != ''">
											<v-list-item>
									      <v-list-item-content>
									        <v-list-item-title class="grey--text text--darken-1">Categoría: <span class="font-weight-light">{{ getCategory(course.category_id) }} <template v-if="course.hasOwnProperty('subcategory_id') && course.subcategory_id != ''">{{ getSubCategory(course.subcategory_id) }}</template></span></v-list-item-title>
									      </v-list-item-content>
									    </v-list-item>
								  	</v-col>
									</v-row>
								</v-col>
								<v-col cols="12" md="4">
									<v-row>	
										<v-col cols="12">
											<label for="course_certified_by_image">
												<p class="white--text text-center py-2 text-uppercase primary rounded-pill px-6 cursor-pointer upload-button mb-3 mb-md-0 ml-2 ml-md-0">Actualizar institución certificada</p>
												<input type="file" name="course_certified_by_image" id="course_certified_by_image" class="d-none" accept="image/png, image/jpeg, image/bmp" @change="prevCertifiedByImage"/>
				      				</label>
		                </v-col>
										<v-col class="mb-2 d-flex justify-center" cols="12">
											<template v-if="previewCertifiedBy != course.meta.certified_by && !image_certified_by_loading">
									    	<v-btn class="white--text ml-md-3 success" @click="saveCertifiedByImage"><v-icon>mdi-check</v-icon></v-btn>
									    	<v-btn class="white--text ml-3 error" @click="resetCertifiedByImage"><v-icon>mdi-close</v-icon></v-btn>
											</template>
								    	<v-btn class="white--text ml-3 warning" :loading="image_certified_by_loading" v-if="image_certified_by_loading"></v-btn>
		                </v-col>
									</v-row>
									<v-list-item v-if="previewCertifiedBy != ''">
							      <v-list-item-content class="d-flex justify-center">
							        <v-list-item-title class="text-center">Certificado por:</v-list-item-title>
							        <v-img :src="previewCertifiedBy" max-width="100%"></v-img>
							      </v-list-item-content>
							    </v-list-item>
							    <v-col class="d-flex justify-center mt-n4" cols="12">
									  <v-btn class="secondary white--text py-8 px-8" rounded pill>Obtén el curso <br>${{ course.price }}</v-btn>
							    </v-col>
								</v-col>
							</v-row>
						</v-sheet>
					</v-col>