<v-col cols="12">
    <p class="subtitle-1">
        Experiența de muncă
    </p>
</v-col>
<template v-for="work, i in <?= !empty($object) ? $object : 'form' ?>.meta.experience.work">
    <v-col class="d-flex justify-end" cols="12" v-if="<?= !empty($object) ? $object : 'form' ?>.status < 0 && <?= !empty($object) ? $object : 'form' ?>.application_id < 0">
        <v-btn color="error" @click="removeItem(<?= !empty($object) ? $object : 'form' ?>.meta.experience.work, i)">Eliminați</v-btn>
    </v-col>

    <v-col cols="12" md="4">
        <label class="body-1 font-weight-thin pl-1">Poziția</label>
        <v-text-field type="text" name="work_position" v-model="work.position" :rules="validations.requiredRules"
            outlined reactive>
        </v-text-field>
    </v-col>

    <v-col cols="12" md="4">
        <label class="body-1 font-weight-thin pl-1">Tipul de muncă</label>
        <v-select :items="employment_types" name="work_employment_type" v-model="work.employment_type"
            :rules="validations.requiredRules" outlined reactive>
        </v-select>
    </v-col>

    <v-col cols="12" md="4">
        <label class="body-1 font-weight-thin pl-1">Compania</label>
        <v-text-field type="text" name="work_ompany" v-model="work.company" :rules="validations.requiredRules" outlined
            reactive>
        </v-text-field>
    </v-col>

    <v-col cols="12" md="4">
        <label class="body-1 font-weight-thin pl-1">Locația</label>
        <v-text-field type="text" name="work_location" v-model="work.location" outlined reactive>
        </v-text-field>
    </v-col>

    <v-col cols="12">
        <v-row align="center">
            <v-col class="d-flex justify-center" cols="12" md="4">
                <v-checkbox v-model="work.currently_active" label="În prezent dețin această poziție" :true-value="1"
                    :false-value="0" reactive></v-checkbox>
            </v-col>

            <v-col cols="12" md="4">
                <v-dialog ref="work_start_dialog" v-model="modals.experience.work.start"
                    :return-value.sync="work.start_date" persistent width="290px">
                    <template #activator="{ on, attrs }">
                        <label class="body-1 font-weight-thin pl-1">Data începerii </label>
                        <v-text-field v-model="work.start_date" :rules="validations.requiredRules" readonly
                            v-bind="attrs" v-on="on" reactive outlined>
                            <template #append>
                                <v-icon v-bind="attrs" v-on="on">mdi-calendar</v-icon>
                            </template>
                        </v-text-field>
                    </template>
                    <v-date-picker v-model="work.start_date" type="month" reactive>
                        <v-spacer></v-spacer>
                        <v-btn text color="primary" @click="modals.experience.work.start = false">
                            Anulează
                        </v-btn>
                        <v-btn text color="primary" @click="$refs.work_start_dialog[i].save(work.start_date)">
                            OK
                        </v-btn>
                    </v-date-picker>
                </v-dialog>
            </v-col>

            <v-col cols="12" md="4" v-if="!work.currently_active">
                <v-dialog ref="work_end_dialog" v-model="modals.experience.work.end" :return-value.sync="work.end_date"
                    persistent width="290px">
                    <template #activator="{ on, attrs }">
                        <label class="body-1 font-weight-thin pl-1">Data terminării</label>
                        <v-text-field v-model="work.end_date" readonly v-bind="attrs" v-on="on" reactive outlined>
                            <template #append>
                                <v-icon v-bind="attrs" v-on="on">mdi-calendar</v-icon>
                            </template>
                        </v-text-field>
                    </template>
                    <v-date-picker v-model="work.end_date" type="month" reactive>
                        <v-spacer></v-spacer>
                        <v-btn text color="primary" @click="modals.experience.work.end = false">
                            Anulează
                        </v-btn>
                        <v-btn text color="primary" @click="$refs.work_end_dialog[i].save(work.end_date)">
                            OK
                        </v-btn>
                    </v-date-picker>
                </v-dialog>
            </v-col>

        </v-row>
    </v-col>

    <v-col cols="12">
        <label class="body-1 font-weight-thin pl-1">Descriere</label>
        <v-textarea name="work_description" v-model="work.description" :rules="validations.descriptionRules" auto-grow
            counter="2000" outlined reactive>
        </v-textarea>
    </v-col>

</template>

<v-col class="d-flex justify-center py-0" cols="12" v-if="<?= !empty($object) ? $object : 'form' ?>.status < 0 && <?= !empty($object) ? $object : 'form' ?>.application_id < 0">
    <v-btn color="primary" @click="addWork">
        Adăugați
    </v-btn>
</v-col>