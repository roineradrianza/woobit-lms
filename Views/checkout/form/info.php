<v-row class="px-8 py-4">
    <v-col cols="12">
        <?= new Controller\Template('account/parts/private/children/dialog') ?>
        <v-form lazy-validation>
            <v-row>

                <v-col class="p-0" cols="12">
                    <h5 class="text-h5 font-weight-light">Date de facturare</h5>
                </v-col>

                <v-col cols="12" md="6">
                    <v-text-field v-model="personal_info.first_name" label="Prenumele adultului" outlined>
                    </v-text-field>
                </v-col>

                <v-col cols="12" md="6">
                    <v-text-field v-model="personal_info.last_name" label="Numele de familie a adultului" outlined>
                    </v-text-field>
                </v-col>

                <v-col cols="12" md="7">
                    <v-text-field v-model="personal_info.address" label="Adresa" outlined></v-text-field>
                </v-col>

                <v-col cols="12" md="5">
                    <vue-tel-input-vuetify id="tel-input" v-model="personal_info.telephone" label='Telefon'
                        mode="international" :inputoptions="{showDialCode: true}"
                        placeholder="Adăugați numărul de telefon" @input="getInput" outlined>
                    </vue-tel-input-vuetify>
                </v-col>

                <v-col cols="12">
                    <v-select v-model="info.children" label="Copii" :items="children.items"
                        :item-text=" (e) => e.first_name + ' ' + e.last_name"
                        @change="info.total_pay = initial_pay * info.children.length; getRONtoUSDTax()" multiple
                        return-object outlined>
                        <template #prepend-item>
                            <v-row class="mt-n2">
                                <v-btn color="primary" @click="children.reset(); children.dialog = true;" block>Adăugați
                                </v-btn>
                            </v-row>
                        </template>
                    </v-select>
                    <v-alert border="top" v-if="info.children.length <= 0" colored-border type="info" elevation="2">
                        Trebuie să alegeți cel puțin un elev pentru a procesa plata.
                    </v-alert>
                </v-col>
            </v-row>
        </v-form>
    </v-col>
    <v-col cols="12">
        <v-divider></v-divider>
    </v-col>
    <v-col cols="12">
        <h4 class="text-h4 secondary--text">Metoda de plată</h4>
    </v-col>

    <v-col cols="12">
        <v-radio-group class="mt-n4 mb-n4" v-model="info.payment_method" row>
            <v-row>
                <v-col cols="12">
                    <v-sheet elevation="1" rounded>
                        <v-row class="px-4 py-4">
                            <v-col cols="4">
                                <v-radio label="Paypal" value="Paypal"></v-radio>
                            </v-col>
                            <v-col class="d-flex justify-end" cols="8">
                                <v-img src="<?= SITE_URL?>/img/payment-logos/paypal.svg" max-width="100" contain>
                                </v-img>
                            </v-col>
                        </v-row>
                    </v-sheet>
                </v-col>
            </v-row>
        </v-radio-group>
    </v-col>
    <v-col cols="12">
        <v-row>
            <v-col cols="12" v-if="info.payment_method != '' && info.payment_method != 'Paypal'">
                <v-divider></v-divider>
            </v-col>
        </v-row>
    </v-col>
</v-row>