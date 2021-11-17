
                	<v-form v-model="valid" lazy-validation>
                		<v-row>
			                <v-col cols="12" md="6">
			                  <label class="body-1 font-weight-thin pl-1">Título</label>
			                  <v-text-field type="text" v-model="course.title" class="mt-3 fl-text-input" :rules="validations.titleRules" filled rounded dense></v-text-field>
			                </v-col>

	                    <v-col cols="12" md="3">
	                      <label class="body-1 font-weight-thin pl-1">Duración</label>
	                      <v-text-field type="text" v-model="course.duration" class="mt-3 fl-text-input" :rules="validations.requiredRules" hint="Ej: 1h 45 min" filled rounded dense></v-text-field>
	                    </v-col>

	                    <v-col cols="12" md="3">
	                      <label class="body-1 font-weight-thin pl-1">Precio</label>
	                      <v-text-field type="number" v-model="course.price" class="mt-3 fl-text-input" :rules="validations.requiredRules" hint="Precio en USD" filled rounded dense></v-text-field>
	                    </v-col>

	                    <v-col cols="12" md="6">
	                      <label class="body-1 font-weight-thin pl-1">Categoría</label>
	                      <v-select class="mt-3 fl-text-input" v-model="course.category_id" :items="categories" item-text="name" item-value="category_id" :rules="validations.requiredRules" @change="filterSubcategories" filled rounded dense></v-select>
	                    </v-col>

	                    <v-col cols="12" md="6">
	                      <label class="body-1 font-weight-thin pl-1">Subcategoría</label>
	                      <v-select class="mt-3 fl-text-input" v-model="course.subcategory_id" ref="subcategory_select" :items="filtered_subcategories" item-text="name" item-value="subcategory_id" filled rounded dense></v-select>
	                    </v-col>

	                    <v-col cols="12" md="6">
	                      <label class="body-1 font-weight-thin pl-1">Nivel del curso</label>
	                      <v-select class="mt-3 fl-text-input" v-model="course.level" :items="levels" item-text="text" item-value="value" :rules="validations.requiredRules" filled rounded dense></v-select>
	                    </v-col>

	                    <v-col cols="12" md="6">
	                      <label class="body-1 font-weight-thin pl-1">Estado del curso</label>
	                      <v-select class="mt-3 fl-text-input" v-model="course.active" :items="true_false" item-text="text" item-value="value" :rules="validations.requiredRules" filled rounded dense></v-select>
	                    </v-col>

			                <v-col cols="12">
			                	<label class="body-1 font-weight-thin pl-1">Descriere</label>
			                  <vue-editor class="mt-3 fl-text-input" v-model="course.meta.description" placeholder="Descriere del curso"/>
			                </v-col>

			                <v-col class="d-flex justify-center" cols="12">
	                      <v-btn color="secondary white--text" block @click="saveGeneral" :disabled="!valid" :loading="general_loading">
	                        Guardar información general
	                      </v-btn>
			                </v-col>
                		</v-row>
              		</v-form>
              		