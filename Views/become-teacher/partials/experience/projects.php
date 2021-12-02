<v-col cols="12">
    <p class="subtitle-1">
        Proiecte
    </p>
</v-col>
<template v-for="project, i in form.meta.experience.projects">
    <v-col class="d-flex justify-end" cols="12" v-if="form.hasOwnProperty('status') && parseInt(form.status) != 0">
        <v-btn color="error" @click="removeItem(form.meta.experience.projects, i)">Eliminați</v-btn>
    </v-col>

    <v-col cols="12" md="4">
        <label class="body-1 font-weight-thin pl-1">Denumirea proiectului</label>
        <v-text-field type="text" name="project_position" v-model="project.name" :rules="validations.requiredRules"
            outlined :disabled="form.hasOwnProperty('status') && !parseInt(form.status)" reactive>
        </v-text-field>
    </v-col>

    <v-col cols="12" md="4">
        <label class="body-1 font-weight-thin pl-1">URL-ul proiectului</label>
        <v-text-field type="url" name="project_url" v-model="project.url" :rules="validations.urlRules" outlined
            :disabled="form.hasOwnProperty('status') && !parseInt(form.status)" reactive>
        </v-text-field>
    </v-col>

    <v-col cols="12">
        <v-row align="center">
            <v-col class="d-flex justify-center" cols="12" md="4">
                <v-checkbox v-model="project.currently_active" label="În prezent lucrez la acest proiect"
                    :true-value="1" :false-value="0" :disabled="form.hasOwnProperty('status') && !parseInt(form.status)" reactive></v-checkbox>
            </v-col>

            <v-col cols="12" md="4">
                <v-dialog ref="project_start_dialog" v-model="modals.experience.project.start"
                    :return-value.sync="project.start_date" persistent width="290px">
                    <template #activator="{ on, attrs }">
                        <label class="body-1 font-weight-thin pl-1">Acasă</label>
                        <v-text-field v-model="project.start_date" :rules="validations.requiredRules" readonly
                            v-bind="attrs" v-on="on" reactive outlined
                            :disabled="form.hasOwnProperty('status') && !parseInt(form.status)">
                            <template #append>
                                <v-icon v-bind="attrs" v-on="on">mdi-calendar</v-icon>
                            </template>
                        </v-text-field>
                    </template>
                    <v-date-picker v-model="project.start_date" type="month" reactive>
                        <v-spacer></v-spacer>
                        <v-btn text color="primary" @click="modals.experience.project.start = false">
                            Anulează
                        </v-btn>
                        <v-btn text color="primary" @click="$refs.project_start_dialog[i].save(project.start_date)">
                            OK
                        </v-btn>
                    </v-date-picker>
                </v-dialog>
            </v-col>

            <v-col cols="12" md="4" v-if="!project.currently_active">
                <v-dialog ref="project_end_dialog" v-model="modals.experience.project.end"
                    :return-value.sync="project.end_date" persistent width="290px">
                    <template #activator="{ on, attrs }">
                        <label class="body-1 font-weight-thin pl-1">Culminare</label>
                        <v-text-field v-model="project.end_date" readonly v-bind="attrs" v-on="on" reactive outlined
                            :disabled="form.hasOwnProperty('status') && !parseInt(form.status)">
                            <template #append>
                                <v-icon v-bind="attrs" v-on="on">mdi-calendar</v-icon>
                            </template>
                        </v-text-field>
                    </template>
                    <v-date-picker v-model="project.end_date" type="month" reactive>
                        <v-spacer></v-spacer>
                        <v-btn text color="primary" @click="modals.experience.project.end = false">
                            Anulează
                        </v-btn>
                        <v-btn text color="primary" @click="$refs.project_end_dialog[i].save(project.end_date)">
                            OK
                        </v-btn>
                    </v-date-picker>
                </v-dialog>
            </v-col>

        </v-row>
    </v-col>

    <v-col cols="12">
        <label class="body-1 font-weight-thin pl-1">Descriere</label>
        <v-textarea name="project_description" v-model="project.description" counter="2000"
            :rules="validations.descriptionRules" outlined
            :disabled="form.hasOwnProperty('status') && !parseInt(form.status)" reactive>
        </v-textarea>
    </v-col>

</template>
<v-col class="d-flex justify-center py-0" cols="12" v-if="form.hasOwnProperty('status') && parseInt(form.status) != 0">
    <v-btn color="primary" @click="addProject">
        Adăugați
    </v-btn>
</v-col>