<h2 class="text-3">
    Pasul 4. Cursurile tale
</h2>
<v-form ref="step4_form" v-model="forms.step4" :<?= !empty($form_mode) ? $form_mode : 'disabled'  ?>="<?= !empty($object) ? $object : 'form' ?>.hasOwnProperty('status') && <?= !empty($object) ? $object : 'form' ?>.status != undefined && <?= !empty($object) ? $object : 'form' ?>.application_id > 0" lazy-validation>
    <v-row>
        <v-col class="px-0" cols="12">
            <v-list-item>
                <v-list-item-content>
                    <v-list-item-title class="no-white-space">
                        Descrie domeniile tale de interes și subiectele pe care le stăpânești cel mai bine. Fă o listă
                        cu diferite cursuri pe care ți le-ai dori să le predai și disponibilitatea ta. Nu uita, fii cât
                        se poate de creativ și gândește în afara restricțiilor impuse de sistemul convențional!
                        Creativitatea e contagioasă!
                    </v-list-item-title>
                </v-list-item-content>
            </v-list-item>
        </v-col>

        <v-col cols="12">
            <v-row>
                <v-col class="px-0" cols="12">
                    <v-list-item>
                        <v-list-item-content>
                            <v-list-item-title class="no-white-space">
                                Interese
                            </v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-col>

                <v-col cols="12" v-if="<?= !empty($object) ? $object : 'form' ?>.meta.interests.length > 0">
                    <template v-for="item, i in <?= !empty($object) ? $object : 'form' ?>.meta.interests">
                        <v-chip class="ma-2" color="secondary"
                            v-if="<?= !empty($object) ? $object : 'form' ?>.status < 0 && <?= !empty($object) ? $object : 'form' ?>.application_id < 0" close
                            close-icon="mdi-delete" @click:close="removeItem(<?= !empty($object) ? $object : 'form' ?>.meta.interests, i)">
                            {{ item }}
                        </v-chip>
                        <v-chip class="ma-2" color="secondary" v-else>
                            {{ item }}
                        </v-chip>
                    </template>
                </v-col>

                <v-col cols="12" md="4"
                    v-if="<?= !empty($object) ? $object : 'form' ?>.meta.interests.length <= 15 && <?= !empty($object) ? $object : 'form' ?>.status < 0 && <?= !empty($object) ? $object : 'form' ?>.application_id < 0">
                    <v-text-field type="text" name="interes" label="Interes" v-model="interest" class="mt-3"
                        hint="Introduceți până la 15 articole" persistent-hint outlined
                        >
                        <template #append>
                            <v-btn class="mt-n4 mr-n3 py-7" color="primary" @click="<?= !empty($object) ? $object : 'form' ?>.meta.interests.push(interest)"
                                :<?= !empty($form_mode) ? $form_mode : 'disabled'  ?>="interest == ''">
                                Adăugați
                            </v-btn>
                        </template>
                    </v-text-field>
                </v-col>

                <v-col cols="12">
                    <v-divider></v-divider>
                </v-col>

                <v-col cols="12">
                    <v-row>
                        <?= new Controller\Template('become-teacher/partials/courses', $data) ?>
                    </v-row>
                </v-col>
            </v-row>
        </v-col>

    </v-row>
</v-form>