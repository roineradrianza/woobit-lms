
            <template>
              <v-toolbar class="bg-transparent" flat>
                <v-spacer></v-spacer>
                <v-dialog v-model="dialog" max-width="95%" @click:outside="dialog = false">
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn color="secondary" dark pill class="mb-2" v-bind="attrs" v-on="on">
                          <v-icon>mdi-plus</v-icon>
                          Añadir curso
                        </v-btn>
                    </template>
                  <v-card>
                    <v-toolbar class="gradient" elevation="0">
                      <v-toolbar-title class="white--text">{{ formTitle }}</v-toolbar-title>
                      <v-spacer></v-spacer>
                      <v-toolbar-items>
                      <v-btn icon dark @click="dialog = false">
                        <v-icon color="white">mdi-close</v-icon>
                      </v-btn>
                      </v-toolbar-items>
                    </v-toolbar>
                    
                    <v-divider></v-divider>
                    <v-form v-model="valid" lazy-validation>
                      <v-card-text>
                        <v-container fluid>
                          <v-row>
                          	<v-col cols="12" md="3">
                          		<v-row>
                          			<v-col class="d-flex justify-center" cols="12">

	                          			<v-icon color="primary" style="font-size:15vw" v-if="editedItem.featured_image == null || editedItem.featured_image == ''">mdi-image</v-icon>
							                    <img :src="editedItem.featured_image" width="100%" v-if="previewImage == '' && editedItem.featured_image != ''">
							                    <img :src="previewImage" width="100%" v-if="previewImage != ''">
							                  </v-col>
                          			<v-col cols="12">
                          				<label for="course_featured_image">
																		<p class="white--text text-center py-3 text-uppercase secondary d-block rounded-lg cursor-pointer">Subir portada del curso</p>
																		<input type="file" name="course_featured_image" id="course_featured_image" class="d-none" v-on:change="prevImage"/>
                          				</label>
                          			</v-col>
                                <v-col cols="12" v-if="editedIndex != -1">
                                  <v-btn class="white--text primary" :href="'<?php SITE_URL ?>/courses/edit/'+editedItem.course_id" target="_blank" block>Ir a edición avanzada del curso</v-btn>
                                </v-col>
                          		</v-row>
                          	</v-col>
                          	<v-col cols="12" md="9">
                          		<v-row>
		                            <v-col cols="12" md="6">
		                              <label class="body-1 font-weight-thin pl-1">Título</label>
		                              <v-text-field type="text" name="course_title" v-model="editedItem.title" class="mt-3 fl-text-input" :rules="validations.titleRules" filled rounded dense></v-text-field>
		                            </v-col>

                                <v-col cols="12" md="3">
                                  <label class="body-1 font-weight-thin pl-1">Duración</label>
                                  <v-text-field type="text" v-model="editedItem.duration" class="mt-3 fl-text-input" :rules="validations.requiredRules" hint="Ej: 1h 45 min" filled rounded dense></v-text-field>
                                </v-col>

                                <v-col cols="12" md="3">
                                  <label class="body-1 font-weight-thin pl-1">Precio</label>
                                  <v-text-field type="number" v-model="editedItem.price" class="mt-3 fl-text-input" :rules="validations.requiredRules" hint="Precio en USD" filled rounded dense></v-text-field>
                                </v-col>

                                <v-col cols="12" md="6">
                                  <label class="body-1 font-weight-thin pl-1">Categoría</label>
                                  <v-select class="mt-3 fl-text-input" v-model="editedItem.category_id" :items="categories.items" item-text="name" item-value="category_id" :rules="validations.requiredRules" @change="filterSubcategories" filled rounded dense></v-select>
                                </v-col>

                                <v-col cols="12" md="6" v-if="editedItem.hasOwnProperty('category_id') && editedItem.category_id != ''">
                                  <label class="body-1 font-weight-thin pl-1">Subcategoría</label>
                                  <v-select refs class="mt-3 fl-text-input" v-model="editedItem.subcategory_id" ref="subcategory_select" :items="subcategories.filtered_items" item-text="name" item-value="subcategory_id" filled rounded dense></v-select>
                                </v-col>

		                            <v-col cols="12" md="6">
		                              <label class="body-1 font-weight-thin pl-1">Nivel del curso</label>
		                              <v-select class="mt-3 fl-text-input" v-model="editedItem.level" :items="levels"  :rules="validations.requiredRules" filled rounded dense></v-select>
		                            </v-col>

                                <v-col cols="12" md="6">
                                  <label class="body-1 font-weight-thin pl-1">Estado del curso</label>
                                  <v-select class="mt-3 fl-text-input" v-model="editedItem.active" :items="true_false"  :rules="validations.requiredRules" filled rounded dense></v-select>
                                </v-col>

                                <v-col cols="12" md="6">
                                  <label class="body-1 font-weight-thin pl-1">Propio de la plataforma</label>
                                  <v-select class="mt-3 fl-text-input" v-model="editedItem.platform_owner" :items="true_false"  :rules="validations.requiredRules" filled rounded dense>
                                    <template #selection='{item}'>
                                      <template v-if="item.value == '1'">
                                        Sí
                                      </template>
                                      <template v-if="item.value == '0'">
                                        No
                                      </template>
                                    </template>
                                  </v-select>
                                </v-col>

                                
                                <v-col cols="12" :md="parseInt(editedItem.meta.paid_certified) ? 3: 6">
                                  <label class="body-1 font-weight-thin pl-1">Certificado de pago</label>
                                  <v-select class="mt-3 fl-text-input" v-model="editedItem.meta.paid_certified" :items="true_false"  :rules="validations.requiredRules" filled rounded dense>
                                    <template #selection='{item}'>
                                      <template v-if="item.value == '1'">
                                        Sí
                                      </template>
                                      <template v-if="item.value == '0'">
                                        No
                                      </template>
                                    </template>
                                  </v-select>
                                </v-col>

                                <v-col cols="12" md="3" v-if="parseInt(editedItem.meta.paid_certified)">
                                  <label class="body-1 font-weight-thin pl-1">Precio del Certificado</label>
                                  <v-text-field type="number" v-model="editedItem.meta.certified_price" class="mt-3 fl-text-input" :rules="validations.requiredRules" hint="Precio en USD" filled rounded dense></v-text-field>
                                </v-col>

		                            <v-col cols="12" md="12">
		                              <label class="body-1 font-weight-thin pl-1">Descripción</label>
                                  <vue-editor class="mt-3 fl-text-input" v-model="editedItem.meta.description" placeholder="Descripción del curso" />
		                            </v-col>
                          		</v-row>
                          	</v-col>
                          </v-row>
                        </v-container>
                      </v-card-text>

                      <v-card-actions class="px-4">
                        <v-spacer></v-spacer>
                        <v-btn color="secondary white--text" block @click="save" :disabled="!valid" :loading="loading">
                          {{ formTitle }}
                        </v-btn>
                      </v-card-actions>
                    </v-form>
                  </v-card>
                </v-dialog>
                <v-dialog v-model="dialogDelete" max-width="50%">
                  <v-card>
                    <v-card-title class="headline d-flex justify-center">¿Estás seguro de que quieres eliminar este curso?</v-card-title>
                    <v-card-actions>
                      <v-spacer></v-spacer>
                      <v-btn color="primary" text @click="closeDelete">Cancelar</v-btn>
                      <v-btn color="secondary" text @click="deleteItemConfirm">Continuar</v-btn>
                      <v-spacer></v-spacer>
                    </v-card-actions>
                  </v-card>
                </v-dialog>
              </v-toolbar>
            </template>
