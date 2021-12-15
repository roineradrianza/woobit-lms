<v-dialog v-model="children.dialog" max-width="900px">
    <v-card>
        <v-toolbar class="gradient" elevation="0">
            <v-toolbar-title class="white--text">Copii</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-toolbar-items>
                <v-btn icon @click="children.dialog = false" color="transparent">
                    <v-icon color="white">mdi-close</v-icon>
                </v-btn>
            </v-toolbar-items>
        </v-toolbar>

        <v-divider></v-divider>
        <v-card-text v-if="children.dialog">
            <v-container>
                <v-form ref="child_form" v-model="children.form" lazy-validation>
                    <v-row>
                        <v-col cols="12" md="6">
                            <v-text-field v-model="children.child.first_name" name="first_name"
                                label="Prenumele adultului" :rules="validations.nameRules" outlined>
                            </v-text-field>
                        </v-col>

                        <v-col cols="12" md="6">
                            <v-text-field v-model="children.child.last_name" name="last_name"
                                :rules="validations.nameRules" label="Numele de familie a adultului" outlined>
                            </v-text-field>
                        </v-col>

                        <v-col cols="12" md="6">
                            <v-select v-model="children.child.gender" name="gender" label="Sex" :items="genders"
                                :rules="validations.genderRules" outlined></v-select>
                        </v-col>

                        <v-col cols="12" md="6">
                            <v-dialog ref="birthdate_dialog" v-model="birthdate_modal"
                                :return-value.sync="children.child.birthdate" width="20vw">
                                <template #activator="{ on, attrs }">
                                    <v-text-field v-model="children.child.birthdate" label="Data nașterii" readonly
                                        v-bind="attrs" v-on="on" :rules="validations.birthdateRules" outlined>
                                        <template #append>
                                            <v-icon v-bind="attrs" v-on="on">mdi-calendar</v-icon>
                                        </template>
                                    </v-text-field>
                                </template>
                                <v-date-picker v-model="children.child.birthdate" scrollable>
                                    <v-spacer></v-spacer>
                                    <v-btn text color="primary" @click="birthdate_modal = false">
                                        Anulează
                                    </v-btn>
                                    <v-btn text color="primary"
                                        @click="$refs.birthdate_dialog.save(children.child.birthdate)">
                                        OK
                                    </v-btn>
                                </v-date-picker>
                            </v-dialog>
                        </v-col>

                        <v-col cols="12">
                            <v-btn color="primary" @click="$refs.child_form.validate() ? children.save() : ''"
                                :loading="children.loading" :disabled="!children.form" block>
                                Adăugați
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-form>
            </v-container>
        </v-card-text>
    </v-card>
</v-dialog>