<h2 class="text-3">
    Pasul 5. Publicul țintă
</h2>
<v-form ref="step4_form" v-model="forms.step4"
    :<?= !empty($form_mode) ? $form_mode : 'disabled'  ?>="<?= !empty($object) ? $object : 'form' ?>.hasOwnProperty('status') && <?= !empty($object) ? $object : 'form' ?>.status != undefined && <?= !empty($object) ? $object : 'form' ?>.application_id > 0"
    lazy-validation>
    <v-row>
        <v-col class="px-0" cols="12">
            <v-list-item>
                <v-list-item-content>
                    <v-list-item-title class="no-white-space">
                        Scrie-ne la ce categorii de vârstă te-ai gândit pentru cursurile oferite de tine și ce interese
                        ți-ar plăcea să aibă acești cursanți. Algoritmele noastre vor găsi cei mai potriviți
                        participanți la cursurile tale.
                    </v-list-item-title>
                </v-list-item-content>
            </v-list-item>
        </v-col>

        <v-col cols="12">
            <v-row>
                <v-col class="py-0" cols="12">
                    <v-card flat color="transparent">
                        <v-subheader class="d-flex justify-center">Stabiliți grupa de vârstă dorită a elevilor
                        </v-subheader>

                        <v-card-text>
                            <v-row justify="center">
                                <v-col cols="12" md="6" class="px-4">
                                    <v-range-slider v-model="range" :max="max" :min="min" hide-details
                                        class="align-center">
                                        <template #prepend>
                                            <v-text-field v-model="range[0]" class="mt-0 pt-0" outlined dense readonly
                                                type="number" style="width: 60px" @change="$set(range, 0, $event);"
                                                reactive>
                                            </v-text-field>
                                        </template>
                                        <template #append>
                                            <v-text-field v-model="range[1]" class="mt-0 pt-0" outlined dense readonly
                                                type="number" style="width: 60px" @change="$set(range, 1, $event);"
                                                reactive>
                                            </v-text-field>
                                        </template>
                                    </v-range-slider>
                                </v-col>
                            </v-row>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
        </v-col>

    </v-row>
</v-form>