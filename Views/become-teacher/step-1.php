<h2 class="text-3">
    Pasul 1. Completează aplicația
</h2>
<p>
    Toate câmpurile sunt obligatorii. Minimum absolvent de facultate (în orice domeniu) sau curent cu statut
    de student. Vorbitor nativ al limbii române*. Pentru a fi remunerat trebuie să ai un cont de PayPal.
    Trebuie să fii confortabil cu aplicația Zoom. Pentru mai multe detalii citește
</p>
<v-form ref="step1_form" v-model="forms.step1" lazy-validation>
    <v-row>
        <v-col cols="12" md="4">
            <label class="body-1 font-weight-thin pl-1">Nume</label>
            <v-text-field type="text" name="first_name" v-model="form.first_name" class="mt-3"
                :rules="validations.nameRules" outlined
                :disabled="form.hasOwnProperty('status') && !parseInt(form.status)"></v-text-field>
        </v-col>

        <v-col cols="12" md="4">
            <label class="body-1 font-weight-thin pl-1">Numele de familie</label>
            <v-text-field type="text" name="last_name" v-model="form.last_name" class="mt-3"
                :rules="validations.nameRules" outlined
                :disabled="form.hasOwnProperty('status') && !parseInt(form.status)"></v-text-field>
        </v-col>

        <v-col cols="12" md="4">
            <label class="body-1 font-weight-thin pl-1">Email</label>
            <v-text-field type="email" name="email" v-model="form.meta.teacher_email" class="mt-3"
                hint="nu va fi publicată--folosită doar pentru comunicare internă." persistent-hint
                :rules="validations.emailRules" outlined
                :disabled="form.hasOwnProperty('status') && !parseInt(form.status)"></v-text-field>
        </v-col>

        <v-col cols="12" md="4">
            <label class="body-1 font-weight-thin pl-1">Telefon</label>
            <vue-tel-input-vuetify id="tel-input" class="mt-3 pt-select" v-model="form.meta.teacher_telephone" label=''
                mode="international" :inputoptions="{showDialCode: true}" :rules="validations.telephoneRules"
                placeholder="Ingresa un número de télefono" hint="folosit doar în caz de comunicare urgentă."
                persistent-hint @input="getInput" outlined
                :disabled="form.hasOwnProperty('status') && !parseInt(form.status)">
            </vue-tel-input-vuetify>
        </v-col>

        <v-col cols="12" md="4">
            <label class="body-1 font-weight-thin pl-1">Locația</label>
            <v-text-field type="text" name="last_name" v-model="form.meta.teacher_address" class="mt-3"
                hint="orașul și țara." persistent-hint :rules="validations.nameRules" outlined
                :disabled="form.hasOwnProperty('status') && !parseInt(form.status)">
            </v-text-field>
        </v-col>

        <v-col cols="12">
            <v-divider></v-divider>
        </v-col>

        <v-col cols="12">
            <v-row>
                <?php echo new Controller\Template('become-teacher/partials/education') ?>
            </v-row>
        </v-col>

        <v-col cols="12">
            <v-divider></v-divider>
        </v-col>

        <v-col cols="12">
            <?php echo new Controller\Template('become-teacher/partials/experience') ?>
        </v-col>

        <v-col cols="12">
            <v-divider></v-divider>
        </v-col>

        <v-col cols="12">
            <v-row>
                <v-col class="px-0" cols="12">
                    <v-list-item>
                        <v-list-item-content>
                            <v-list-item-title class="no-white-space">Conturile de facebook, instagram și
                                LinkedIN
                            </v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-col>

                <v-col cols="12" md="4">
                    <label class="body-1 font-weight-thin pl-1">Facebook</label>
                    <v-text-field type="url" name="facebook" v-model="form.meta.facebook" :rules="validations.urlRules"
                        outlined :disabled="form.hasOwnProperty('status') && !parseInt(form.status)" reactive>
                        <template #append>
                            <v-icon>mdi-facebook</v-icon>
                        </template>
                    </v-text-field>
                </v-col>

                <v-col cols="12" md="4">
                    <label class="body-1 font-weight-thin pl-1">Instagram</label>
                    <v-text-field type="url" name="instagram" v-model="form.meta.instagram"
                        :rules="validations.urlRules" outlined
                        :disabled="form.hasOwnProperty('status') && !parseInt(form.status)" reactive>
                        <template #append>
                            <v-icon>mdi-instagram</v-icon>
                        </template>
                    </v-text-field>
                </v-col>

                <v-col cols="12" md="4">
                    <label class="body-1 font-weight-thin pl-1">LinkedIn</label>
                    <v-text-field type="url" name="linkedin" v-model="form.meta.linkedin" :rules="validations.urlRules"
                        outlined :disabled="form.hasOwnProperty('status') && !parseInt(form.status)" reactive>
                        <template #append>
                            <v-icon>mdi-linkedin</v-icon>
                        </template>
                    </v-text-field>
                </v-col>
            </v-row>
        </v-col>

        <v-col cols="12">
            <v-divider></v-divider>
        </v-col>

        <v-col cols="12">
            <v-row>
                <v-col class="px-0" cols="12">
                    <v-list-item>
                        <v-list-item-content>
                            <v-list-item-title class="no-white-space">
                                Adresa PayPal unde dorești să fi
                                plătit
                            </v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-col>

                <v-col cols="12" md="4">
                    <label class="body-1 font-weight-thin pl-1">Email paypal</label>
                    <v-text-field type="url" name="facebook" v-model="form.meta.paypal" :rules="validations.emailRules"
                        outlined :disabled="form.hasOwnProperty('status') && !parseInt(form.status)" reactive>
                    </v-text-field>
                </v-col>

            </v-row>
        </v-col>

    </v-row>
</v-form>