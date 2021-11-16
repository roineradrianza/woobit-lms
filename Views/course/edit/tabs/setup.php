
                	<v-form>
                		<v-row>
			                <v-col cols="12" md="6">
			                  <label class="body-1 font-weight-thin pl-1">Zoom JWT</label>
			                  <v-text-field type="text" v-model="course.meta.zoom_jwt" class="mt-3 fl-text-input" hint="Token para conectarse a la cuenta y crear las clases de zoom " filled rounded dense></v-text-field>
			                </v-col>

			                <v-col cols="12" md="6">
			                  <label class="body-1 font-weight-thin pl-1">Host Email</label>
			                  <v-text-field type="text" v-model="course.meta.zoom_host" class="mt-3 fl-text-input" hint="Host de las clases por zoom (Tiene que pertenecer a la misma cuenta y tener una licencia)" filled rounded dense></v-text-field>
			                </v-col>
			                <v-col cols="12">
			                	<v-btn class="secondary white--text" :loading="setup_loading" @click="saveSetup" block>Actualizar configuraciones</v-btn>
			                </v-col>
                		</v-row>
              		</v-form>
              		