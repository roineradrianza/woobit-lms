<v-row class="register-container gradient py-16" justify="center">
    <v-col class="px-md-16 pt-16 white my-12 rounded-xl register-container mb-16" cols="11" md="8" md="7"
        v-if="loading">
        <v-row>
            <v-col cols="6" v-for="i in 20">
                <v-skeleton-loader class="mt-3" type="text"></v-skeleton-loader>
            </v-col>
        </v-row>
    </v-col>
    <v-col class="px-md-16 pt-16 white my-12 rounded-xl register-container" cols="11" md="8" md="7" v-else>
        <h3 class="text-h3">Înregistrare</h3>
        <p class="text-h6 text-center mb-n1 pr-md-10">Utilizați: </p>
        <v-row class="d-flex justify-center pr-md-10">
            <v-btn class="ma-2 white--text padding- py-6" @click="googleSignIn">
                <v-img class="myGoogleButton" src="<?= SITE_URL ?>/img/google-logo.png" width="1vw">
                </v-img>
            </v-btn>
            <v-btn class="ma-2 white--text py-6">
                <v-img src="<?= SITE_URL ?>/img/facebook-logo.svg" width="1vw"></v-img>
            </v-btn>
        </v-row>
        <v-form ref="form" v-model="valid" lazy-validation>
            <v-row class="pr-md-10">

                <v-col cols="12" md="6">
                    <label class="body-1 font-weight-thin pl-1">Prenumele adultului</label>
                    <v-text-field type="text" name="first_name" v-model="form.first_name" class="mt-3"
                        :rules="validations.nameRules" outlined></v-text-field>
                </v-col>

                <v-col cols="12" md="6">
                    <label class="body-1 font-weight-thin pl-1">Numele de familie a adultului</label>
                    <v-text-field type="text" name="last_name" v-model="form.last_name" class="mt-3"
                        :rules="validations.nameRules" outlined></v-text-field>
                </v-col>

                <v-col cols="12" md="6">
                    <label class="body-1 font-weight-thin pl-1">Adresa de email</label>
                    <v-text-field type="email" name="email" v-model="form.email" class="mt-3"
                        :rules="validations.emailRules" outlined></v-text-field>
                </v-col>

                <v-col class="dialog-mobile" cols="12" md="6">
                    <label class="body-1 font-weight-thin pl-1">Data nașterii</label>
                    <v-dialog ref="birthdate_dialog" class="" v-model="birthdate_modal"
                        :return-value.sync="form.birthdate" width="20vw">
                        <template #activator="{ on, attrs }">
                            <v-text-field class="mt-3 pt-select" v-model="form.birthdate" readonly v-bind="attrs"
                                v-on="on" :rules="validations.birthdateRules" outlined>
                                <template #append>
                                    <v-icon v-bind="attrs" v-on="on">
                                        mdi-calendar
                                    </v-icon>
                                </template>
                            </v-text-field>
                        </template>
                        <v-date-picker v-model="form.birthdate" scrollable>
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
                    <v-select class="mt-3 pt-select" v-model="form.gender" :items="gender" item-text="text"
                        item-value="value" :rules="validations.genderRules" outlined>
                    </v-select>
                </v-col>

                <v-col cols="12" md="6">
                    <label class="body-1 font-weight-thin pl-1">Telefon</label>
                    <vue-tel-input-vuetify id="tel-input" class="mt-3 pt-select" v-model="form.meta.telephone" label=''
                        mode="international" :inputoptions="{showDialCode: true}" :rules="validations.telephoneRules"
                        placeholder="Adăugați numărul de telefon" hint="Ej: +58 4245887477" persistent-hint
                        @input="getInput" outlined>
                    </vue-tel-input-vuetify>
                </v-col>

                <v-col cols="12" md="6">
                    <label class="body-1 font-weight-thin pl-1">Țara</label>
                    <v-select class="mt-3 pt-select" v-model="form.country_selected" :items="countries" item-text="name"
                        item-value="id" v-on:change="filterStates" :rules="validations.countryRules" outlined>
                    </v-select>
                </v-col>

                <v-col cols="12" md="6">
                    <label class="body-1 font-weight-thin pl-1">State</label>
                    <v-select class="mt-3 pt-select" v-model="form.state_selected" :items="country_states"
                        item-text="name" item-value="id" v-on:change='getLocation'
                        :rules="validations.countryStateRules" outlined></v-select>
                </v-col>

                <v-col cols="12" md="6">
                    <label class="body-1 font-weight-thin pl-1">Parola</label>
                    <v-text-field type="password" name="password" v-model="form.password" class="mt-3"
                        :rules="validations.passwordRules" outlined></v-text-field>
                </v-col>

                <v-col cols="12" md="6">
                    <label class="body-1 font-weight-thin pl-1">Confirmați parola</label>
                    <v-text-field type="password" name="password_confirm" v-model="form.password_confirm" class="mt-3"
                        outlined></v-text-field>
                </v-col>

                <v-col cols="12">
                    <v-checkbox v-model="form.agreement" :rules="validations.requiredRules">
                        <template #label>
                            <div>
                                Sunt de acord cu
                                <v-tooltip bottom>
                                    <template #activator="{ on }">
                                        <a target="_blank" href="<?= SITE_URL ?>/terms-and-conditions" @click.stop
                                            v-on="on">
                                            Termenii și condițiile
                                        </a>
                                    </template>
                                    Deschideți într-o fereastră nouă
                                </v-tooltip>
                                Woobit și cu Politica datelor cu caracter personal.
                            </div>
                        </template>
                    </v-checkbox>
                </v-col>
                <?= new Controller\Template('components/alert') ?>
                <v-col cols="12">
                    <v-row class="px-10 d-flex align-center">
                        <v-col cols="12" md="4"></v-col>
                        <v-col cols="12" md="4">
                            <v-btn class="white--text secondary font-weight-bold rounded-pill mb-6 mt-4 py-6"
                                @click="save" :disabled="!valid" :loading="save_loading" block>Înregistrare</v-btn>
                        </v-col>
                    </v-row>
                </v-col>

            </v-row>
        </v-form>
    </v-col>
</v-row>