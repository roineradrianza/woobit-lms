<v-row>
    <v-col class="px-10" cols="12">
        <v-toolbar class="bg-transparent" flat>
            <v-spacer></v-spacer>
            <v-dialog v-model="dialog" max-width="1200px">
                <v-card>
                    <v-toolbar class="gradient" elevation="0">
                        <v-toolbar-title class="white--text">Detalii despre aplicație</v-toolbar-title>
                        <v-spacer></v-spacer>
                        <v-toolbar-items>
                            <v-btn icon @click="dialog = false">
                                <v-icon color="white">mdi-close</v-icon>
                            </v-btn>
                        </v-toolbar-items>
                    </v-toolbar>

                    <v-divider></v-divider>
                    <?= new Controller\Template('admin/parts/teachers_application_form') ?>
                </v-card>
            </v-dialog>
            <v-dialog v-model="dialogDelete" max-width="1200px">
                <v-card>
                    <v-card-title class="headline">¿Sunteți sigur că doriți să eliminați această aplicație?
                    </v-card-title>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="blue darken-1" text @click="closeDelete">Anulează</v-btn>
                        <v-btn color="blue darken-1" text @click="deleteItemConfirm">Continuă</v-btn>
                        <v-spacer></v-spacer>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-toolbar>
        <v-data-table :headers="headers" :items="items" sort-by="full_name" class="elevation-1" :search="search"
            :loading="table_loading">
            <template #top>
                <v-text-field type="text" placeholder="Căutați..." v-model="search" append-icon="mdi-magnify"
                    outlined></v-text-field>
            </template>
            <template #item.status_text="{ item }">
                <v-chip :color="getStatusType(item.status)">
                    {{ item.status_text }}
                </v-chip>
            </template>
            <template #item.actions="{ item }">
                <v-icon md @click="editItem(item)" color="primary">
                    mdi-eye
                </v-icon>
                <v-icon md @click="deleteItem(item)" color="#F44336">
                    mdi-delete
                </v-icon>
            </template>
        </v-data-table>
    </v-col>
</v-row>