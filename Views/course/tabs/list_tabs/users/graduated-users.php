<v-col cols="12" md="8">
    <v-col cols="12">
        <h3 class="text-h4 text-center">Estudiantes Graduados</h3>
    </v-col>
    <v-data-table :headers="gratuated_students.headers" :search="gratuated_students.search" :items="gratuated_students.items" sort-by="full_name"
        class="elevation-1" :loading="gratuated_students.loading">
        <template #top v-if="gratuated_students.items.length > 0">
            <v-text-field class="mx-4 v-normal-input" label="Buscar estudiante" v-model="gratuated_students.search"
                append-icon="mdi-magnify" single-line hide-details></v-text-field>
        </template>
        <template #item.actions="{ item }">
            <v-btn class="gradient white--text" @click="saveFile(item.certified_url)" small>
                Descargar certificado
            </v-btn>
        </template>
        <template #no-data>
            No se encontraron estudiantes graduados en el curso
        </template>
    </v-data-table>
</v-col>