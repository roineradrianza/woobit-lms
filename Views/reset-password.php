<v-row style="padding: 14vh 0 15vh 0">
    <v-col class="px-md-16 pt-16 white my-12 rounded-xl elevation-2" cols="8" offset="2">
        <h3 class="text-h3 text-center mb-4">Resetare parola</h3>
        <v-form ref="form" v-model="valid" lazy-validation>
            <v-row class="pr-md-10">

                <v-col cols="12" md="6">
                    <label class="body-1 font-weight-thin pl-1">Parola</label>
                    <v-text-field type="password" name="password" v-model="password" class="mt-3 fl-text-input"
                        :rules="validations.passwordRules" filled rounded dense></v-text-field>
                </v-col>

                <v-col cols="12" md="6">
                    <label class="body-1 font-weight-thin pl-1">Confirmați parola</label>
                    <v-text-field type="password" name="password_confirm" v-model="password_confirm"
                        class="mt-3 fl-text-input" filled rounded dense></v-text-field>
                </v-col>
                <v-col cols="12">
                    <v-row class="px-md-10 d-flex align-center">
                        <v-col cols="12" md="4"></v-col>
                        <v-col cols="12" md="4">
                            <v-btn class="white--text secondary font-weight-bold rounded-pill mb-6 mt-4 py-6"
                                @click="resetPassword" :disabled="!valid" :loading="loading" block>Resetare parolă
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-col>
                <?= new Controller\Template('components/alert') ?>

            </v-row>
        </v-form>
    </v-col>
</v-row>