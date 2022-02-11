<v-row class="px-3 px-md-10">

<?= new \Controller\Template('components/snackbar') ?>

    <v-col cols="12">
        <h4 class="text-h5">Actualizarea listei de profesori de pe pagina principală</h4>
    </v-col>

    <v-col cols="12" :md="instructors_selected.length > 0 ? 6 : 12">
        <v-data-table :headers="headers" :items="items" v-model="instructors_selected" sort-by="full_name" class="elevation-1" :search="search"
            :loading="table_loading" item-key="user_id" multiple show-select>
            <template #top>
                <v-text-field type="text" placeholder="Căutați..." v-model="search" append-icon="mdi-magnify"
                    outlined></v-text-field>
            </template>
        </v-data-table>
    </v-col>

    <v-col cols="12" :md="instructors_selected.length > 0 ? 6 : 12" v-if="instructors_selected.length > 0">
        <v-data-table :headers="headers" :items="instructors_selected" sort-by="full_name" class="elevation-1" :search="search"
            :loading="table_loading">
            <template #top>
                <h4 class="text-h5 px-4 py-7">Profesori selectați</h4>
            </template>
        </v-data-table>
    </v-col>

    <v-col cols="12">
        <v-btn color="primary" @click="save" :loading="loading" block>Salvați</v-btn>
    </v-col>
</v-row>