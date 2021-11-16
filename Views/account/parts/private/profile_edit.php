	      	
	      	<v-col class="white px-12 py-md-8 info-container mt-10 mx-md-6" cols="12" md="7" v-if="profile_container">
	      		<v-row>
							<v-col cols="12" md="6">
		            <label class="body-1 font-weight-thin pl-1">Nombre</label>
		            <v-text-field type="text" name="first_name" v-model="profile.first_name" class="mt-3 fl-text-input" :rules="validations.nameRules" filled rounded dense></v-text-field>
		          </v-col>

		          <v-col cols="12" md="6">
		            <label class="body-1 font-weight-thin pl-1">Apellido</label>
		            <v-text-field type="text" name="last_name" v-model="profile.last_name" class="mt-3 fl-text-input" :rules="validations.nameRules" filled rounded dense></v-text-field>
		          </v-col>

		          <v-col cols="12" md="6">
		            <label class="body-1 font-weight-thin pl-1">Email</label>
		            <v-text-field type="email" name="email" v-model="profile.email" class="mt-3 fl-text-input" :rules="validations.emailRules" filled rounded dense></v-text-field>
		          </v-col>

		          <v-col cols="12" md="6">
		            <label class="body-1 font-weight-thin pl-1">Télefono</label>
								<vue-tel-input-vuetify id="tel-input" class="mt-3 fl-text-input pt-select" v-model="profile.meta.telephone" label='' :rules="validations.telephoneRules" filled rounded dense></vue-tel-input-vuetify>
		          </v-col>

		          <v-col cols="12" md="6">
		            <label class="body-1 font-weight-thin pl-1">Fecha de nacimiento</label>
		            <v-dialog ref="birthdate_dialog" v-model="birthdate_modal" :return-value.sync="profile.birthdate" width="20vw">
		              <template v-slot:activator="{ on, attrs }">
		                <v-text-field class="mt-3 fl-text-input" v-model="profile.birthdate" append-icon="mdi-calendar" readonly v-bind="attrs" v-on="on" :rules="validations.birthdateRules" filled rounded dense></v-text-field>
		              </template>
		              <v-date-picker v-model="profile.birthdate" locale="es" scrollable>
		                <v-spacer></v-spacer>
		                <v-btn text color="primary" @click="birthdate_modal = false">
		                  Cancelar
		                </v-btn>
		                <v-btn text color="primary" @click="$refs.birthdate_dialog.save(profile.birthdate)">
		                  OK
		                </v-btn>
		              </v-date-picker>
		            </v-dialog>
		          </v-col>

		          <v-col cols="12" md="6">
		            <label class="body-1 font-weight-thin pl-1">Sexo</label>
		            <v-select class="mt-3 fl-text-input" v-model="profile.gender" :items="genders" item-text="text" item-value="value" :rules="validations.genderRules" filled rounded dense></v-select>
		          </v-col>

		          <v-col cols="12" md="6">
		            <label class="body-1 font-weight-thin pl-1">País</label>
		            <v-select class="mt-3 fl-text-input" v-model="profile.country_selected" :items="countries" item-text="name" item-value="id" v-on:change="filterStates" :rules="validations.countryRules" filled rounded dense></v-select>
		          </v-col>

		          <v-col cols="12" md="6">
		            <label class="body-1 font-weight-thin pl-1">Ciudad</label>
		            <v-select class="mt-3 fl-text-input" v-model="profile.state_selected" :items="country_states" item-text="name" item-value="id" v-on:change='getLocation' :rules="validations.countryStateRules" filled rounded dense></v-select>
		          </v-col>

		          <v-col cols="12" md="6">
		            <label class="body-1 font-weight-thin pl-1">Contraseña</label>
		            <v-text-field type="password" name="password" v-model="profile.password" class="mt-3 fl-text-input" filled rounded dense></v-text-field>
		          </v-col>

		          <v-col cols="12" md="6">
		            <label class="body-1 font-weight-thin pl-1">Confirmar contraseña</label>
		            <v-text-field type="password" name="password_confirm" v-model="profile.password_confirm" class="mt-3 fl-text-input" :rules="validations.passwordConfirmRules" filled rounded dense></v-text-field>
		          </v-col>

		          <v-col class="d-flex justify-center" cols="12">
		           <?php echo new Controller\Template('components/alert') ?>
		          </v-col>

		          <v-col class="d-flex justify-end" cols="12">
		            <v-btn class="primary white--text" @click="saveProfile" :loading="edit_profile_loading">Guardar</v-btn>
		            <v-btn color="red" @click="profile_container = false" :loading="edit_profile_loading" text>Cerrar</v-btn>
		          </v-col>

	      		</v-row>
	      	</v-col>
