<v-col cols="12" md="8">
    <v-col cols="12">
        <h3 class="text-h4 text-center">Lista de oyentes</h3>
    </v-col>
    <v-data-table :headers="listeners.headers" :search="listeners.search" :items="listeners.items" sort-by="full_name"
        class="elevation-1" :loading="listeners.loading">
        <template #top v-if="listeners.items.length > 0">
            <v-text-field class="mx-4 v-normal-input" label="Buscar estudiante" v-model="listeners.search"
                append-icon="mdi-magnify" single-line hide-details></v-text-field>
        </template>
        <template #item.actions="{ item }">
            <v-icon md @click="deleteItem(item, 'oyente')" color="#F44336">
                mdi-account-remove
            </v-icon>
        </template>
        <template #no-data>
            No se encontraron Oyentes en el curso
        </template>
    </v-data-table>
</v-col>