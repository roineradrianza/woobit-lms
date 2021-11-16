
                  <v-row class="d-flex justify-center">
                    <h3 class="text-h4 text-center">Progreso de los estudiantes</h3>
                    <v-col cols="12" md="11">
                      <v-toolbar class="bg-transparent d-flex justify-end" flat>
                        <v-dialog v-model="dialog" max-width="60%" @click:outside="alert = false">
                          <template v-slot:activator="{ on, attrs }">
                            <v-btn color="secondary" dark pill class="mb-2" v-bind="attrs" v-on="on">
                              <v-icon>mdi-plus</v-icon>
                              Actualizar lista
                            </v-btn>
                          </template>
                          <v-card>
                            <v-toolbar class="gradient" elevation="0">
                              <v-toolbar-title class="white--text">Progreso del estudiante</v-toolbar-title>
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
                                  </v-row>
                                </v-container>
                              </v-card-text>
                            </v-form>
                            <v-divider></v-divider>
                          </v-card>
                        </v-dialog>
                      </v-toolbar>
                      <v-data-table :headers="students_enrolled.headers" :search="students_enrolled.search" :items="students_enrolled.items" sort-by="full_name" class="elevation-1" :loading="students_enrolled.loading">
                        <template v-slot:top>
                          <v-text-field class="mx-4 v-normal-input" label="Buscar estudiante" v-model="students_enrolled.search" append-icon="mdi-magnify" single-line hide-details></v-text-field>
                        </template>
                        <template v-slot:item.actions="{ item }">
                          <v-icon md @click="remindUsersCourseProgress(item, false)" color="secondary">
                            mdi-bell
                          </v-icon>
                          <v-icon md @click="deleteItem(item)" color="#F44336">
                            mdi-account-remove
                          </v-icon>
                        </template>
                        <template v-slot:item.location="{ item }">
                          {{ item.meta.country }}, {{ item.meta.state }}
                        </template>
                        <template v-slot:no-data>
                          No se encontraron estudiantes registrados en el curso
                        </template>
                      </v-data-table>
                    </v-col> 
                  </v-row>
                  