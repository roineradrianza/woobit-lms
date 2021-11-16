<v-col cols="12">
    <h3 class="text-h4 text-center">Estudiantes pendientes por inscribirse</h3>
</v-col>
<v-col cols="12" md="8">
    <v-row class="d-flex justify-end pr-4">
        <v-btn color="secondary" dark pill class="mb-2" :loading="reminder_loading" @click="remindUsers([], true)"
            right>
            <v-icon class="mr-2">mdi-bell-alert</v-icon>
            Enviar recordatorio
        </v-btn>
    </v-row>
    <v-data-table :headers="students_pendings.headers" :search="students_pendings.search"
        :items="students_pendings.items" sort-by="full_name" class="elevation-1" :loading="students_pendings.loading">
        <template #top v-if="students_pendings.items.length > 0">
            <v-text-field class="mx-4 v-normal-input" label="Buscar estudiante" v-model="students_pendings.search"
                append-icon="mdi-magnify" single-line hide-details></v-text-field>
        </template>
        <template #item.reminder="{ item }">
            <v-icon md @click="remindUsers(item, false)" color="primary">
                mdi-bell-alert
            </v-icon>
        </template>
        <template #no-data>
            No se encontraron estudiantes pendientes por registrarse en el curso
        </template>
    </v-data-table>
</v-col>