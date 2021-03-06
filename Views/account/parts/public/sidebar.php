				
				<v-row class="register-container">
					<v-col class="px-16 pt-16 white my-12 rounded-xl register-container" cols="8" offset="2">
						<h2 class="text-h2">Înregistrare.</h2>
						<v-col class="pl-0" cols="8">
							<p class="font-weight-light">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ducimus, dignissimos, dolor. Animi eveniet vitae beatae, reiciendis praesentium aliquid temporibus soluta fugit fuga, distinctio mollitia.</p>
						</v-col>
						<v-form ref="form" v-model="valid" lazy-validation>
							<v-row class="pr-16">

								<v-col cols="12" md="6">
									<label class="body-1 font-weight-thin pl-1">Prenumele adultului</label>
									<v-text-field type="text" name="first_name" v-model="form.first_name" class="mt-3 fl-text-input" :rules="validations.nameRules" filled rounded dense></v-text-field>
								</v-col>

								<v-col cols="12" md="6">
									<label class="body-1 font-weight-thin pl-1">Numele de familie a adultului</label>
									<v-text-field type="text" name="last_name" v-model="form.last_name" class="mt-3 fl-text-input" :rules="validations.nameRules" filled rounded dense></v-text-field>
								</v-col>

								<v-col cols="12" md="6">
									<label class="body-1 font-weight-thin pl-1">Email</label>
									<v-text-field type="email" name="email" v-model="form.email" class="mt-3 fl-text-input" :rules="validations.emailRules" filled rounded dense></v-text-field>
								</v-col>

								<v-col cols="12" md="6">
									<label class="body-1 font-weight-thin pl-1">Data nașterii</label>
		              <v-dialog ref="birthdate_dialog" v-model="birthdate_modal" :return-value.sync="form.birthdate" width="20vw">
                    <template v-slot:activator="{ on, attrs }">
                      <v-text-field class="mt-3 fl-text-input" v-model="form.birthdate" append-icon="mdi-calendar" readonly v-bind="attrs" v-on="on" :rules="validations.birthdateRules" filled rounded dense></v-text-field>
                    </template>
                    <v-date-picker v-model="form.birthdate" locale="es" scrollable>
                      <v-spacer></v-spacer>
                      <v-btn text color="primary" @click="birthdate_modal = false">
                        Anulează
                      </v-btn>
                      <v-btn text color="primary" @click="$refs.birthdate_dialog.save(form.birthdate)">
                        OK
                      </v-btn>
                    </v-date-picker>
                  </v-dialog>
								</v-col>

								<v-col cols="12" md="6">
									<label class="body-1 font-weight-thin pl-1">Sex</label>
                  <v-select class="mt-3 fl-text-input pt-select" v-model="form.gender" :items="gender" item-text="text" item-value="value" :rules="validations.genderRules" filled rounded dense></v-select>
								</v-col>


								<v-col cols="12" md="6">
									<label class="body-1 font-weight-thin pl-1">Telefon</label>
									<vue-tel-input-vuetify id="tel-input" class="mt-3 fl-text-input pt-select" v-model="form.meta.telephone" label='' mode="international" :inputoptions="{showDialCode: true}" :rules="validations.telephoneRules" @input="getInput" filled rounded dense></vue-tel-input-vuetify>
								</v-col>

								<v-col cols="12" md="6">
									<label class="body-1 font-weight-thin pl-1">Țara</label>
                  <v-select class="mt-3 fl-text-input pt-select" v-model="form.country_selected" :items="countries" item-text="name" item-value="id" v-on:change="filterStates" :rules="validations.countryRules" filled rounded dense></v-select>
								</v-col>

								<v-col cols="12" md="6">
									<label class="body-1 font-weight-thin pl-1">Orașul</label>
                  <v-select class="mt-3 fl-text-input pt-select" v-model="form.state_selected" :items="country_states" item-text="name" item-value="id" v-on:change='getLocation' :rules="validations.countryStateRules" filled rounded dense></v-select>
								</v-col>

								<v-col cols="12" md="6">
									<label class="body-1 font-weight-thin pl-1">Parola</label>
									<v-text-field type="password" name="password" v-model="form.password" class="mt-3 fl-text-input" :rules="validations.passwordRules" filled rounded dense></v-text-field>
								</v-col>

								<v-col cols="12" md="6">
									<label class="body-1 font-weight-thin pl-1">Confirmați parola</label>
									<v-text-field type="password" name="password_confirm" v-model="form.password_confirm" class="mt-3 fl-text-input" filled rounded dense></v-text-field>
								</v-col>
								<?= new Controller\Template('components/alert') ?>
								<v-col cols="12">
									<v-row class="px-10 d-flex align-center">
										<v-col cols="12" md="4"><a class="secondary--text font-weight-bold" href="<?= SITE_URL ?>">Volver</a></v-col>
										<v-col cols="12" md="4"></v-col>
										<v-col cols="12" md="4">
											<v-btn class="white--text secondary font-weight-bold rounded-pill mb-6 mt-4 py-6" @click="save" :disabled="!valid" block>Înregistrare</v-btn>
										</v-col>
									</v-row>									
								</v-col>

							</v-row>
						</v-form>
					</v-col>
				</v-row>