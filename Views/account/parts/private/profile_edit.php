	      	<v-col class="white px-12 py-md-8 info-container mx-md-6" cols="12" md="7" v-if="profile_container">
	      	    <v-row>
	      	        <v-col cols="12" md="6">
	      	            <label class="body-1 font-weight-thin pl-1">Prenumele adultului</label>
	      	            <v-text-field type="text" name="first_name" v-model="profile.first_name" class="mt-3"
	      	                :rules="validations.nameRules" outlined></v-text-field>
	      	        </v-col>

	      	        <v-col cols="12" md="6">
	      	            <label class="body-1 font-weight-thin pl-1">Numele de familie a adultului</label>
	      	            <v-text-field type="text" name="last_name" v-model="profile.last_name" class="mt-3"
	      	                :rules="validations.nameRules" outlined></v-text-field>
	      	        </v-col>

	      	        <v-col cols="12" md="6">
	      	            <label class="body-1 font-weight-thin pl-1">Email</label>
	      	            <v-text-field type="email" name="email" v-model="profile.email" class="mt-3"
	      	                :rules="validations.emailRules" outlined></v-text-field>
	      	        </v-col>

	      	        <v-col cols="12" md="6">
	      	            <label class="body-1 font-weight-thin pl-1">Telefon</label>
	      	            <vue-tel-input-vuetify id="tel-input" class="mt-3" v-model="profile.meta.telephone"
	      	                :rules="validations.telephoneRules" outlined>
	      	            </vue-tel-input-vuetify>
	      	        </v-col>

	      	        <v-col cols="12" md="6">
	      	            <label class="body-1 font-weight-thin pl-1">Data nașterii</label>
	      	            <v-dialog ref="birthdate_dialog" v-model="birthdate_modal" :return-value.sync="profile.birthdate"
	      	                width="20vw">
	      	                <template #activator="{ on, attrs }">
	      	                    <v-text-field class="mt-3" v-model="profile.birthdate" readonly v-bind="attrs" v-on="on"
	      	                        :rules="validations.birthdateRules" outlined>
	      	                        <template #append>
	      	                            <v-icon v-bind="attrs" v-on="on">mdi-calendar</v-icon>
	      	                        </template>
	      	                    </v-text-field>
	      	                </template>
	      	                <v-date-picker v-model="profile.birthdate" scrollable>
	      	                    <v-spacer></v-spacer>
	      	                    <v-btn text color="primary" @click="birthdate_modal = false">
	      	                        Anulează
	      	                    </v-btn>
	      	                    <v-btn text color="primary" @click="$refs.birthdate_dialog.save(profile.birthdate)">
	      	                        OK
	      	                    </v-btn>
	      	                </v-date-picker>
	      	            </v-dialog>
	      	        </v-col>

	      	        <v-col cols="12" md="6">
	      	            <label class="body-1 font-weight-thin pl-1">Sex</label>
	      	            <v-select class="mt-3" v-model="profile.gender" :items="genders" item-text="text" item-value="value"
	      	                :rules="validations.genderRules" outlined></v-select>
	      	        </v-col>

	      	        <v-col cols="12" md="6">
	      	            <label class="body-1 font-weight-thin pl-1">Țara</label>
	      	            <v-select class="mt-3" v-model="profile.country_selected" :items="countries" item-text="name"
	      	                item-value="id" v-on:change="filterStates" :rules="validations.countryRules" outlined>
	      	            </v-select>
	      	        </v-col>

	      	        <v-col cols="12" md="6">
	      	            <label class="body-1 font-weight-thin pl-1">State</label>
	      	            <v-select class="mt-3" v-model="profile.state_selected" :items="country_states" item-text="name"
	      	                item-value="id" v-on:change='getLocation' :rules="validations.countryStateRules" outlined>
	      	            </v-select>
	      	        </v-col>

	      	        <v-col cols="12" md="6">
	      	            <label class="body-1 font-weight-thin pl-1">Parola</label>
	      	            <v-text-field type="password" name="password" v-model="profile.password" class="mt-3" outlined>
	      	            </v-text-field>
	      	        </v-col>

	      	        <v-col cols="12" md="6">
	      	            <label class="body-1 font-weight-thin pl-1">Confirmați parola</label>
	      	            <v-text-field type="password" name="password_confirm" v-model="profile.password_confirm"
	      	                class="mt-3" :rules="validations.passwordConfirmRules" outlined></v-text-field>
	      	        </v-col>

	      	        <v-col class="d-flex justify-center" cols="12">
	      	            <?= new Controller\Template('components/alert') ?>
	      	        </v-col>

	      	        <v-col class="d-flex justify-end" cols="12">
	      	            <v-btn class="primary white--text" @click="saveProfile" :loading="edit_profile_loading">Salvați
	      	            </v-btn>
	      	            <v-btn color="red" @click="profile_container = false; main_container = true" :loading="edit_profile_loading" text>Închideți
	      	            </v-btn>
	      	        </v-col>

	      	    </v-row>
	      	</v-col>