<v-col cols="12">
    <p class="subtitle-1">
        Experiența de voluntariat
    </p>
</v-col>
<template v-for="volunteer, i in <?= !empty($object) ? $object : 'form' ?>.meta.experience.volunteer">
    <v-col class="d-flex justify-end" cols="12" v-if="<?= !empty($object) ? $object : 'form' ?>.status < 0 && <?= !empty($object) ? $object : 'form' ?>.application_id < 0">
        <v-btn color="error" @click="removeItem(<?= !empty($object) ? $object : 'form' ?>.meta.experience.volunteer, i)">Eliminați</v-btn>
    </v-col>

    <v-col cols="12" md="4">
        <label class="body-1 font-weight-thin pl-1">Poziția</label>
        <v-text-field type="text" name="volunteer_position" v-model="volunteer.position"
            :rules="validations.requiredRules" outlined reactive>
        </v-text-field>
    </v-col>

    <v-col cols="12" md="4">
        <label class="body-1 font-weight-thin pl-1">Organizație</label>
        <v-text-field type="text" name="volunteer_company" v-model="volunteer.company"
            :rules="validations.requiredRules" outlined reactive>
        </v-text-field>
    </v-col>

    <v-col cols="12" md="4">
        <label class="body-1 font-weight-thin pl-1">Cauză caritabilă</label>
        <v-text-field type="text" name="volunteer_charitable_cause" v-model="volunteer.charitable_cause" outlined
            reactive>
        </v-text-field>
    </v-col>

    <v-col cols="12">
        <v-row align="center">
            <v-col class="d-flex justify-center" cols="12" md="4">
                <v-checkbox v-model="volunteer.currently_active" label="În prezent sunt voluntar în această poziție"
                    :true-value="1" :false-value="0" reactive></v-checkbox>
            </v-col>

            <v-col cols="12" md="4">
                <v-dialog ref="volunteer_start_dialog" v-model="modals.experience.volunteer.start"
                    :return-value.sync="volunteer.start_date" persistent width="290px">
                    <template #activator="{ on, attrs }">
                        <label class="body-1 font-weight-thin pl-1">Data începerii </label>
                        <v-text-field v-model="volunteer.start_date" :rules="validations.requiredRules" readonly
                            v-bind="attrs" v-on="on" reactive outlined>
                            <template #append>
                                <v-icon v-bind="attrs" v-on="on">mdi-calendar</v-icon>
                            </template>
                        </v-text-field>
                    </template>
                    <v-date-picker v-model="volunteer.start_date" type="month" reactive>
                        <v-spacer></v-spacer>
                        <v-btn text color="primary" @click="modals.experience.volunteer.start = false">
                            Anulează
                        </v-btn>
                        <v-btn text color="primary" @click="$refs.volunteer_start_dialog[i].save(volunteer.start_date)">
                            OK
                        </v-btn>
                    </v-date-picker>
                </v-dialog>
            </v-col>

            <v-col cols="12" md="4" v-if="!volunteer.currently_active">
                <v-dialog ref="volunteer_end_dialog" v-model="modals.experience.volunteer.end"
                    :return-value.sync="volunteer.end_date" persistent width="290px">
                    <template #activator="{ on, attrs }">
                        <label class="body-1 font-weight-thin pl-1">Data terminării</label>
                        <v-text-field v-model="volunteer.end_date" readonly v-bind="attrs" v-on="on" reactive outlined>
                            <template #append>
                                <v-icon v-bind="attrs" v-on="on">mdi-calendar</v-icon>
                            </template>
                        </v-text-field>
                    </template>
                    <v-date-picker v-model="volunteer.end_date" type="month" reactive>
                        <v-spacer></v-spacer>
                        <v-btn text color="primary" @click="modals.experience.volunteer.end = false">
                            Anulează
                        </v-btn>
                        <v-btn text color="primary" @click="$refs.volunteer_end_dialog[i].save(volunteer.end_date)">
                            OK
                        </v-btn>
                    </v-date-picker>
                </v-dialog>
            </v-col>

        </v-row>
    </v-col>

    <v-col cols="12">
        <label class="body-1 font-weight-thin pl-1">Descriere</label>
        <v-textarea name="volunteer_description" v-model="volunteer.description" counter="2000" auto-grow outlined
            reactive>
        </v-textarea>
    </v-col>
</template>
<v-col class="d-flex justify-center py-0" cols="12" v-if="<?= !empty($object) ? $object : 'form' ?>.status < 0 && <?= !empty($object) ? $object : 'form' ?>.application_id < 0">
    <v-btn color="primary" @click="addVolunteer">
        Adăugați
    </v-btn>
</v-col>