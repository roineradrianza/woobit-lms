
            <template>
              <v-toolbar class="bg-transparent" flat>
                <v-spacer></v-spacer>
                <v-dialog v-model="categoryDialog" max-width="50%" @click:outside="categoryDialog = false">
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn color="secondary" dark pill class="mb-2" v-bind="attrs" v-on="on">
                          <v-icon>mdi-plus</v-icon>
                          Añadir categoría
                        </v-btn>
                    </template>
                  <v-card>
                    <v-toolbar class="gradient" elevation="0">
                      <v-toolbar-title class="white--text">{{ categoryFormTitle }}</v-toolbar-title>
                      <v-spacer></v-spacer>
                      <v-toolbar-items>
                      <v-btn icon dark @click="categoryDialog = false">
                        <v-icon color="white">mdi-close</v-icon>
                      </v-btn>
                      </v-toolbar-items>
                    </v-toolbar>
                    
                    <v-divider></v-divider>
                    <v-form v-model="validCategory" lazy-validation>
                      <v-card-text>
                        <v-container>
                          <v-row>
                            <v-col cols="12">
                              <label class="body-1 font-weight-thin pl-1">Nombre</label>
                              <v-text-field type="text" v-model="categories.editedItem.name" class="mt-3 fl-text-input" :rules="validations.requiredRules" filled rounded dense></v-text-field>
                            </v-col>
                          </v-row>
                        </v-container>
                      </v-card-text>

                      <v-card-actions class="px-4">
                        <v-spacer></v-spacer>
                        <v-btn color="secondary white--text" block @click="saveCategory" :disabled="!validCategory" :loading="categories.loading">
                          Guardar
                        </v-btn>
                      </v-card-actions>
                    </v-form>
                  </v-card>
                </v-dialog>
                <v-dialog v-model="categoryDialogDelete" max-width="50%">
                  <v-card>
                    <v-card-title class="headline d-flex justify-center">¿Estás seguro de que quieres eliminar esta categoría?</v-card-title>
                    <v-card-actions>
                      <v-spacer></v-spacer>
                      <v-btn color="primary" text @click="closeCategoryDelete">Cancelar</v-btn>
                      <v-btn color="secondary" text @click="deleteCategoryItemConfirm">Continuar</v-btn>
                      <v-spacer></v-spacer>
                    </v-card-actions>
                  </v-card>
                </v-dialog>
              </v-toolbar>
            </template>
