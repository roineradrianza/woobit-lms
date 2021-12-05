<h2 class="text-3">
    Pasul 5. Publicul țintă
</h2>
<v-form ref="step4_form" v-model="forms.step4" :<?= !empty($form_mode) ? $form_mode : 'disabled'  ?>="<?= !empty($object) ? $object : 'form' ?>.hasOwnProperty('status') && <?= !empty($object) ? $object : 'form' ?>.status != undefined && <?= !empty($object) ? $object : 'form' ?>.application_id > 0" lazy-validation>
    <v-row>
        <v-col class="px-0" cols="12">
            <v-list-item>
                <v-list-item-content>
                    <v-list-item-title class="no-white-space">
                        Scrie-ne ce categorii de vârstă ai in minte pentru cursurile oferite de tine și ce interese
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
                                        class="align-center"
                                        >
                                        <template #prepend>
                                            <v-text-field v-model="range[0]" class="mt-0 pt-0" outlined
                                                
                                                dense readonly type="number" style="width: 60px"
                                                @change="$set(range, 0, $event);" reactive>
                                            </v-text-field>
                                        </template>
                                        <template #append>
                                            <v-text-field v-model="range[1]" class="mt-0 pt-0" outlined
                                                
                                                dense readonly type="number" style="width: 60px"
                                                @change="$set(range, 1, $event);" reactive>
                                            </v-text-field>
                                        </template>
                                    </v-range-slider>
                                </v-col>
                            </v-row>
                        </v-card-text>
                    </v-card>
                </v-col>
                <v-col class="px-0 mt-n6" cols="12">
                    <v-list-item>
                        <v-list-item-content>
                            <v-list-item-title class="no-white-space">
                                Interese
                            </v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-col>
                <v-col cols="12" v-if="<?= !empty($object) ? $object : 'form' ?>.meta.students_interests.length > 0">
                    <template v-for="item, i in <?= !empty($object) ? $object : 'form' ?>.meta.students_interests">
                        <v-chip class="ma-2" color="secondary" close close-icon="mdi-delete"
                            v-if="<?= !empty($object) ? $object : 'form' ?>.status < 0 && <?= !empty($object) ? $object : 'form' ?>.application_id < 0"
                            @click:close="removeItem(<?= !empty($object) ? $object : 'form' ?>.meta.students_interests, i)">
                            {{ item }}
                        </v-chip>
                        <v-chip class="ma-2" color="secondary" v-else>
                            {{ item }}
                        </v-chip>
                    </template>
                </v-col>

                <v-col cols="12" md="4"
                    v-if="<?= !empty($object) ? $object : 'form' ?>.meta.students_interests.length <= 15 && <?= !empty($object) ? $object : 'form' ?>.status < 0 && <?= !empty($object) ? $object : 'form' ?>.application_id < 0">
                    <v-text-field type="text" name="interes" label="Interes" v-model="student_interest" class="mt-3"
                        hint="Introduceți până la 15 articole" persistent-hint outlined>
                        <template #append>
                            <v-btn class="mt-n4 mr-n3 py-7" color="primary"
                                @click="<?= !empty($object) ? $object : 'form' ?>.meta.students_interests.push(student_interest)"
                                :<?= !empty($form_mode) ? $form_mode : 'disabled'  ?>="student_interest == ''">
                                Adăugați
                            </v-btn>
                        </template>
                    </v-text-field>
                </v-col>
            </v-row>
        </v-col>

    </v-row>
</v-form>