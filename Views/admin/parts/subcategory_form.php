
            <template>
              <v-toolbar class="bg-transparent" flat>
                <v-spacer></v-spacer>
                <v-dialog v-model="subCategoryDialog" max-width="50%" @click:outside="subCategoryDialog = false">
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn color="secondary" dark pill class="mb-2" v-bind="attrs" v-on="on">
                          <v-icon>mdi-plus</v-icon>
                          Añadir subcategoría
                        </v-btn>
                    </template>
                  <v-card>
                    <v-toolbar class="gradient" elevation="0">
                      <v-toolbar-title class="white--text">{{ subCategoryFormTitle }}</v-toolbar-title>
                      <v-spacer></v-spacer>
                      <v-toolbar-items>
                      <v-btn icon dark @click="subCategory = false">
                        <v-icon color="white">mdi-close</v-icon>
                      </v-btn>
                      </v-toolbar-items>
                    </v-toolbar>
                    
                    <v-divider></v-divider>
                    <v-form v-model="validSubCategory" lazy-validation>
                      <v-card-text>
                        <v-container>
                          <v-row>
                            <v-col cols="12" md="6">
                              <label class="body-1 font-weight-thin pl-1">Categoría</label>
                              <v-select class="mt-3 fl-text-input pt-select" v-model="subcategories.editedItem.category_id" :items="categories.items" item-text="name" item-value="category_id" :rules="validations.requiredRules" filled rounded dense></v-select>
                            </v-col>
                            <v-col cols="12" md="6">
                              <label class="body-1 font-weight-thin pl-1">Înregistrare</label>
                              <v-text-field type="text" v-model="subcategories.editedItem.name" class="mt-3 fl-text-input" :rules="validations.requiredRules" filled rounded dense></v-text-field>
                            </v-col>
                          </v-row>
                        </v-container>
                      </v-card-text>

                      <v-card-actions class="px-4">
                        <v-spacer></v-spacer>
                        <v-btn color="secondary white--text" block @click="saveSubCategory" :disabled="!validSubCategory" :loading="subcategories.loading">
                          Guardar
                        </v-btn>
                      </v-card-actions>
                    </v-form>
                  </v-card>
                </v-dialog>
                <v-dialog v-model="subCategoryDialogDelete" max-width="50%">
                  <v-card>
                    <v-card-title class="headline d-flex justify-center">¿Estás seguro de que quieres eliminar esta subcategoría?</v-card-title>
                    <v-card-actions>
                      <v-spacer></v-spacer>
                      <v-btn color="primary" text @click="closeSubCategoryDelete">Cancelar</v-btn>
                      <v-btn color="secondary" text @click="deleteSubCategoryItemConfirm">Continuar</v-btn>
                      <v-spacer></v-spacer>
                    </v-card-actions>
                  </v-card>
                </v-dialog>
              </v-toolbar>
            </template>
