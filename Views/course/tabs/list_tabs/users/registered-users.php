<h3 class="text-h4 text-center">Estudiantes registrados</h3>
<v-col cols="12" md="11">
    <v-toolbar class="bg-transparent d-flex justify-end" flat>
        <v-btn color="secondary" class="mb-2 mr-md-2 d-block" @click="remindUsersCourseProgress([], true)"
            :loading="reminder_loading" dark pill>
            <v-icon class="mr-2">mdi-bell-alert</v-icon>
            Enviar recordatorio de curso
        </v-btn>
        <v-dialog v-model="dialog" max-width="60%" @click:outside="alert = false">
            <template #activator="{ on, attrs }">
                <v-btn color="secondary" dark pill class="mb-2" v-bind="attrs" v-on="on">
                    <v-icon>mdi-plus</v-icon>
                    Añadir Utilizator
                </v-btn>
            </template>
            <v-card>
                <v-toolbar class="gradient" elevation="0">
                    <v-toolbar-title class="white--text">Añadir estudiante al curso</v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-toolbar-items>
                        <v-btn icon dark @click="dialog = false">
                            <v-icon color="white">mdi-close</v-icon>
                        </v-btn>
                    </v-toolbar-items>
                </v-toolbar>
                <v-form lazy-validation>
                    <v-card-text>
                        <v-container>
                            <v-row class="d-flex justify-center">
                                <v-col cols="11">
                                    <label class="body-1 font-weight-thin pl-1">Buscar por Utilizator o correo</label>
                                    <v-text-field type="text" name="search_user" v-model="user_search"
                                        class="mt-3 fl-text-input" @keyup.enter.preventDefault
                                        :loading="search_user_loading" filled rounded dense>
                                        <template #append-outer>
                                            <div class="fl-append-outer">
                                                <v-btn primary text @click="searchUser">Buscar</v-btn>
                                            </div>
                                        </template>
                                    </v-text-field>
                                </v-col>
                                <v-col cols="11" v-if="searched">
                                    <v-row>
                                        <v-col cols="12">
                                            <label class="body-1 font-weight-thin pl-1">Seleccionar el Utilizator</label>
                                            <v-select class="mt-3 fl-text-input" v-model="user_selected"
                                                :items="users_list" :disabled="search_user_loading" return-object filled
                                                rounded dense>
                                                <template #item="{ item }">
                                                    {{ item.first_name }} {{ item.last_name }} <span
                                                        class="secondary--text" v-if="null === item.username">
                                                        ({{ item.email }})</span><span class="secondary--text" v-else>
                                                        ({{ item.username }})</span>
                                                </template>
                                                <template #selection="{ item }">
                                                    {{ item.first_name }} {{ item.last_name }} <span
                                                        class="secondary--text" v-if="null === item.username">
                                                        ({{ item.email }})</span><span class="secondary--text" v-else>
                                                        ({{ item.username }})</span>
                                                </template>
                                            </v-select>
                                        </v-col>
                                        <v-col cols="12">
                                            <v-select class="mt-3 fl-text-input" v-model="rol_selected"
                                                :items="rol_list" item-text="text" item-text="value"
                                                :rules="requiredField" filled rounded dense></v-select>
                                        </v-col>
                                    </v-row>
                                    <v-btn class="primary" v-if="user_selected != '' && rol_selected != ''"
                                        :loading="add_loading" @click="addUser" block>Añadir Utilizator al curso</v-btn>
                                </v-col>
                                <?php echo new Controller\Template('components/alert') ?>
                            </v-row>
                        </v-container>
                    </v-card-text>
                </v-form>
                <v-divider></v-divider>
            </v-card>
        </v-dialog>
        <v-dialog v-model="dialogDelete" max-width="1200px">
            <v-card>
                <v-card-title class="headline">¿Estás seguro de que quieres eliminar este miembro?</v-card-title>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click="closeDelete">Cancelar</v-btn>
                    <v-btn color="blue darken-1" text @click="deleteItemConfirm">Continuar</v-btn>
                    <v-spacer></v-spacer>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-dialog v-model="dialogUserRemove" max-width="1200px">
            <v-card>
                <v-card-title class="headline">¿Estás seguro de que quieres remover este estudiante del curso?
                </v-card-title>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click="closeDelete">Cancelar</v-btn>
                    <v-btn color="blue darken-1" text @click="deleteItemConfirm">Continuar</v-btn>
                    <v-spacer></v-spacer>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-toolbar>
    <v-data-table :headers="students_enrolled.headers" :search="students_enrolled.search"
        :items="students_enrolled.items" sort-by="full_name" class="elevation-1" :loading="students_enrolled.loading">
        <template #top>
            <v-text-field class="mx-4 v-normal-input" label="Buscar estudiante" v-model="students_enrolled.search"
                append-icon="mdi-magnify" single-line hide-details></v-text-field>
        </template>
        <template #item.actions="{ item }">
            <v-icon md @click="remindUsersCourseProgress(item, false)" color="secondary">
                mdi-bell
            </v-icon>
            <v-icon md @click="deleteItem(item)" color="#F44336">
                mdi-account-remove
            </v-icon>
        </template>
        <template #item.location="{ item }">
            {{ item.meta.country }}, {{ item.meta.state }}
        </template>
        <template #no-data>
            No se encontraron estudiantes registrados en el curso
        </template>
    </v-data-table>
</v-col>