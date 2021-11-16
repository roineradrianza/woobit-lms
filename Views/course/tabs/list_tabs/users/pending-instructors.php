<v-col cols="12">
    <h3 class="text-h4 text-center">Profesores pendientes por inscribirse</h3>
</v-col>
<v-col cols="12" md="8">
    <v-row class="d-flex justify-end pr-4">
        <v-btn color="secondary" dark pill class="mb-2" :loading="reminder_loading" @click="remindInstructors([], true)"
            right>
            <v-icon class="mr-2">mdi-bell-alert</v-icon>
            Enviar recordatorio
        </v-btn>
    </v-row>
    <v-data-table :headers="instructors_pendings.headers" :search="instructors_pendings.search"
        :items="instructors_pendings.items" sort-by="full_name" class="elevation-1"
        :loading="students_pendings.loading">
        <template #top v-if="instructors_pendings.items.length > 0">
            <v-text-field class="mx-4 v-normal-input" label="Buscar estudiante" v-model="instructors_pendings.search"
                append-icon="mdi-magnify" single-line hide-details></v-text-field>
        </template>
        <template #item.reminder="{ item }">
            <v-icon md @click="remindInstructors(item, false)" color="primary">
                mdi-bell-alert
            </v-icon>
        </template>
        <template #no-data>
            No se encontraron profesores pendientes por registrarse en el curso
        </template>
    </v-data-table>
</v-col>