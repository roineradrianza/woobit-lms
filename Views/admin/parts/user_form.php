<v-form v-model="valid" lazy-validation>
    <v-card-text>
        <v-container>
            <v-row>
                <v-col cols="12" md="6">
                    <label>Tipo de membru</label>
                    <v-select class="mt-3 fl-text-input" v-model="editedItem.user_type" :items="user_types"
                        :rules="validations.selectRules" outlined></v-select>
                </v-col>
                <v-col cols="12" md="6">
                    <label class="body-1 font-weight-thin pl-1">Prenumele adultului</label>
                    <v-text-field type="text" name="first_name" v-model="editedItem.first_name"
                        class="mt-3 fl-text-input" :rules="validations.nameRules" outlined></v-text-field>
                </v-col>

                <v-col cols="12" md="6">
                    <label class="body-1 font-weight-thin pl-1">Numele de familie a adultului</label>
                    <v-text-field type="text" name="last_name" v-model="editedItem.last_name" class="mt-3 fl-text-input"
                        :rules="validations.nameRules" outlined></v-text-field>
                </v-col>

                <v-col cols="12" md="6">
                    <label class="body-1 font-weight-thin pl-1">Email</label>
                    <v-text-field type="email" name="email" v-model="editedItem.email" class="mt-3 fl-text-input"
                        :rules="validations.emailRules" outlined></v-text-field>
                </v-col>

                <v-col cols="12" md="6">
                    <label class="body-1 font-weight-thin pl-1">Telefon</label>
                    <vue-tel-input-vuetify id="tel-input" class="mt-3 fl-text-input pt-select"
                        v-model="editedItem.meta.telephone" label='' mode="international"
                        :rules="validations.telephoneRules" @input="getInput" outlined>
                    </vue-tel-input-vuetify>
                </v-col>

                <v-col cols="12" md="6">
                    <label class="body-1 font-weight-thin pl-1">Data nașterii</label>
                    <v-dialog ref="birthdate_dialog" v-model="birthdate_modal" :return-value.sync="editedItem.birthdate"
                        width="20vw">
                        <template v-slot:activator="{ on, attrs }">
                            <v-text-field class="mt-3 fl-text-input" v-model="editedItem.birthdate" readonly
                                v-bind="attrs" v-on="on" :rules="validations.birthdateRules" outlined>
                                <template #append>
                                    <v-icon v-bind="attrs" v-on="on">
                                        mdi-calendar
                                    </v-icon>
                                </template>
                            </v-text-field>
                        </template>
                        <v-date-picker v-model="editedItem.birthdate" scrollable>
                            <v-spacer></v-spacer>
                            <v-btn text color="primary" @click="birthdate_modal = false">
                                Anulează
                            </v-btn>
                            <v-btn text color="primary" @click="$refs.birthdate_dialog.save(editedItem.birthdate)">
                                OK
                            </v-btn>
                        </v-date-picker>
                    </v-dialog>
                </v-col>

                <v-col cols="12" md="6">
                    <label class="body-1 font-weight-thin pl-1">Sex</label>
                    <v-select class="mt-3 fl-text-input" v-model="editedItem.gender" :items="gender" item-text="text"
                        item-value="value" :rules="validations.genderRules" outlined></v-select>
                </v-col>

                <v-col cols="12" md="6">
                    <label class="body-1 font-weight-thin pl-1">Țara</label>
                    <v-select class="mt-3 fl-text-input" v-model="editedItem.country_selected" :items="countries"
                        item-text="name" item-value="id" v-on:change="filterStates" :rules="validations.countryRules"
                        outlined></v-select>
                </v-col>

                <v-col cols="12" md="6">
                    <label class="body-1 font-weight-thin pl-1">State</label>
                    <v-select class="mt-3 fl-text-input" v-model="editedItem.state_selected" :items="country_states"
                        item-text="name" item-value="id" v-on:change='getLocation'
                        :rules="validations.countryStateRules" outlined></v-select>
                </v-col>

                <v-col cols="12" md="6">
                    <label class="body-1 font-weight-thin pl-1">Parola</label>
                    <v-text-field type="password" name="password" v-model="editedItem.password"
                        class="mt-3 fl-text-input" outlined></v-text-field>
                </v-col>

                <v-col cols="12" md="6">
                    <label class="body-1 font-weight-thin pl-1">Confirmați parola</label>
                    <v-text-field type="password" name="password_confirm" v-model="editedItem.password_confirm"
                        class="mt-3 fl-text-input" outlined></v-text-field>
                </v-col>
            </v-row>
        </v-container>
    </v-card-text>

    <v-card-actions class="px-8">
        <v-spacer></v-spacer>
        <v-btn color="secondary white--text" block @click="save" :disabled="!valid">
            Salvați
        </v-btn>
    </v-card-actions>
</v-form>