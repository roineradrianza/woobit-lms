                  <v-row class="d-flex justify-center" v-if="sections.length > 0">
                    <template>
                      <v-dialog v-model="class_views.total_views_dialog" max-width="75%" @click:outside="class_views.total_views_dialog = false; class_views.editedItem = {section_name: '', items: []}">
                        <v-card>
                          <v-toolbar class="gradient" elevation="0">
                            <v-toolbar-title class="white--text">{{ class_views.editedItem.section_name }}</v-toolbar-title>
                            <v-spacer></v-spacer>
                            <v-toolbar-items>
                            <v-btn icon dark @click="class_views.total_views_dialog = false; class_views.editedItem = {section_name: '', items: []}">
                              <v-icon color="white">mdi-close</v-icon>
                            </v-btn>
                            </v-toolbar-items>
                          </v-toolbar>
                          
                          <v-divider></v-divider>
                          <v-card-text>
                            <v-container fluid>
                              <v-row>
                                <v-col cols="12">
                                  <v-data-table :headers="class_views.total_views_headers"  :items="class_views.editedItem.items" class="elevation-1" :loading="class_views.total_views_loading">
                                    <template #top>
                                      <v-row class="d-flex align-center px-2">
                                        <v-col cols="12" md="11">
                                          <h5 class="text-h5">Vistas totales</h5>
                                        </v-col>
                                        <v-col cols="12" md="1">
                                          <download-excel :data="class_views.editedItem.items" :fields="class_views.excel.total_views_headers" worksheet="Vistas totales" name="Reportes de vistas.xls">
                                            <v-btn color="#1d6f42" dark right>
                                              <v-icon>mdi-file-excel</v-icon>
                                            </v-btn>
                                          </download-excel>
                                        </v-col>
                                      </v-row>
                                    </template>
                                  </v-data-table>
                                  
                                  <v-data-table :headers="class_views.quizzes_done_headers"  :items="class_views.editedItem.quizzes" class="elevation-1 mt-4" :loading="class_views.quizzes_loading">
                                    <template #top>
                                      <v-row class="d-flex align-center px-2">
                                        <v-col cols="12" md="11">
                                          <h5 class="text-h5">Quizzes realizados</h5>
                                        </v-col>
                                        <v-col cols="12" md="1">
                                          <download-excel :data="class_views.editedItem.quizzes" :fields="class_views.excel.total_quizzes_header" worksheet="Quizzes realizados" name="Reportes de quizzes.xls">
                                            <v-btn color="#1d6f42" dark right>
                                              <v-icon>mdi-file-excel</v-icon>
                                            </v-btn>
                                          </download-excel>
                                        </v-col>
                                      </v-row>
                                    </template>
                                  </v-data-table>
                                </v-col>
                              </v-row>
                            </v-container>
                          </v-card-text>
                        </v-card>
                      </v-dialog>
                    </template>
                    <v-col cols="12" md="10">
                      <v-row class="d-flex justify-center">
                        <v-col cols="12" md="3">
                          <v-alert color="primary" icon="mdi-overscan" border="left" dark prominent>
                            Vistas totales en zoom<template v-if="!class_views.total_course_loading">: {{ class_views.total_course_zoom }}</template>
                            <template v-else>
                              <br>
                              <v-btn color="white" :loading="true" text small fab></v-btn>
                            </template>
                          </v-alert>
                        </v-col>
                        <v-col cols="12" md="3">
                          <v-alert color="secondary" icon="mdi-video" border="left" dark prominent>
                            Vistas totales en video<template v-if="!class_views.total_course_loading">: {{ class_views.total_course_video }}</template>
                            <template v-else>
                              <br>
                              <v-btn color="white" :loading="true" text small fab></v-btn>
                            </template>
                          </v-alert>
                        </v-col>
                        <v-col cols="12" md="3">
                          <v-alert color="success" icon="mdi-text-box-check" border="left"dark  prominent>
                            Quizzes realizados<template v-if="!class_views.total_course_loading">: {{ class_views.total_quizzes_done }}</template>
                            <template v-else>
                              <br>
                              <v-btn color="white" :loading="true" text small fab></v-btn>
                            </template>
                          </v-alert>
                        </v-col>
                      </v-row>
                    </v-col>
                    <v-col cols="12" md="10">
                      <v-expansion-panels>
                        <template>
                          <v-expansion-panel v-for="(section, section_index) in sections" :key="section.section_id">
                            <v-expansion-panel-header>
                              <v-row no-gutters>
                                <v-col class="d-flex justify-start p-0" cols="8" lg="9" xl="10">
                                  {{ section.section_name }}
                                </v-col>
                                <v-col class="d-flex justify-center p-0" cols="4" lg="3" xl="2">
                                  <v-btn color="secondary" @click.stop="getSectionTotalViews(section)">Vistas totales</v-btn>
                                </v-col>
                              </v-row>
                            </v-expansion-panel-header>
                            <v-expansion-panel-content>
                              <template>
                                <v-expansion-panels class="mb-4">
                                  <v-expansion-panel v-for="(lesson,index) in section.items" :key="lesson.lesson_id">
                                    <v-expansion-panel-header @click="getLessonViews(lesson)">
                                      <v-row no-gutters>
                                        <v-col class="d-flex justify-start p-0" cols="9">
                                          {{ lesson.lesson_name }}
                                        </v-col>
                                      </v-row>
                                    </v-expansion-panel-header>
                                    <v-expansion-panel-content>
                                      <v-data-table :headers="class_views.headers" :search="class_views.search" :items="class_views.items" sort-by="full_name" class="elevation-1" :loading="class_views.loading">
                                        <template v-slot:top>
                                          <v-row class="d-flex align-center">
                                            <v-col cols="12" md="11">
                                              <v-text-field class="mx-4 v-normal-input" label="Buscar estudiante" v-model="class_views.search" append-icon="mdi-magnify" single-line hide-details></v-text-field>
                                              
                                            </v-col>
                                            <v-col cols="12" md="1">
                                              <download-excel :data="class_views.excel.students" :fields="class_views.excel.header" worksheet="Vistas" name="Vistas.xls">
                                                <v-btn color="#1d6f42" dark right>
                                                  <v-icon>mdi-file-excel</v-icon>
                                                </v-btn>
                                              </download-excel>
                                            </v-col>
                                          </v-row>
                                        </template>
                                        <template v-slot:item.zoom="{ item }">
                                          <v-icon md color="success" v-if="parseInt(item.zoom_view)">
                                            mdi-check
                                          </v-icon>
                                          <v-icon md color="#F44336" v-else="parseInt(item.zoom_view)">
                                            mdi-close
                                          </v-icon>
                                        </template>
                                        <template v-slot:item.video="{ item }">
                                          <v-icon md color="success" v-if="parseInt(item.video_view)">
                                            mdi-check
                                          </v-icon>
                                          <v-icon md color="#F44336" v-else="parseInt(item.video_view)">
                                            mdi-close
                                          </v-icon>
                                        </template>
                                        <template v-slot:no-data>
                                          No se encontraron vistas para esta clase
                                        </template>
                                      </v-data-table>
                                      <!--TABLA DE VISTAS POR ZOOM-->
                                        
                                    </v-expansion-panel-content>
                                  </v-expansion-panel>
                                </v-expansion-panels>
                              </template>
                            </v-expansion-panel-content>
                          </v-expansion-panel>
                        </template>

                      </v-expansion-panels>
                    </v-col>
                  </v-row>
