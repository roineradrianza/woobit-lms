
                  <v-row class="d-flex justify-center">
                    <h3 class="text-h4 text-center">Quizzes de los estudiantes</h3>
                    <v-col cols="12" md="11">
                      <v-data-table id="quiz_table" :headers="quizzes.headers" :search="quizzes.search" :items="quizzes.students" sort-by="full_name" class="elevation-1" :loading="quizzes.loading">
                        <template v-slot:top>
                          <v-row class="d-flex align-center">
                            <v-col cols="12" md="11">
                              <v-text-field class="mx-4 v-normal-input" label="Buscar estudiante" v-model="quizzes.search" append-icon="mdi-magnify" single-line hide-details></v-text-field>
                            </v-col>
                            <v-col cols="12" md="1">
                              <download-excel :data="quizzes.excel.students" :fields="quizzes.excel.header" worksheet="Quiz" name="Quizzes de los Estudiantes.xls">
                                <v-btn color="#1d6f42" dark right>
                                  <v-icon>mdi-file-excel</v-icon>
                                </v-btn>
                              </download-excel>
                            </v-col>
                          </v-row>
                        </template>
                        <template v-slot:item.actions="{ item }" v-if="1 == 2">
                        </template>
                        <template v-slot:no-data>
                          No se encontraron información sobre quizzes en el curso
                        </template>
                      </v-data-table>
                    </v-col> 
                  </v-row>
                  