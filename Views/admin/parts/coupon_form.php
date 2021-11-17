
                      <v-form v-model="valid" lazy-validation>
                        <v-card-text>
                          <v-container>
                            <v-row>

                              <v-col cols="12">
                                <label class="body-1 font-weight-thin pl-1">Curso al que se va a aplicar el cupón</label>
                                <v-select class="mt-3 fl-text-input pt-select" v-model="editedItem.course_id" :items="courses" item-text="title" item-value="course_id" :loading="courses_loading" :rules="validations.requiredRules" filled rounded dense></v-select>
                              </v-col>

                              <v-col cols="12" md="6">
                                <label class="body-1 font-weight-thin pl-1">Înregistrare del cupón</label>
                                <v-text-field type="text" name="coupon_name" v-model="editedItem.coupon_name" class="mt-3 fl-text-input" :rules="validations.nameRules" counter="90" filled rounded dense></v-text-field>
                              </v-col>

                              <v-col cols="12" md="4">
                                <label class="body-1 font-weight-thin pl-1">Rol del Utilizator</label>
                                <v-select class="mt-3 fl-text-input pt-select" v-model="editedItem.student_rol" :items="rol_options" item-text="text" item-value="value" filled rounded dense></v-select>
                              </v-col>


                              <v-col cols="12" md="2">
                                <label class="body-1 font-weight-thin pl-1">Descuento</label>
                                <v-text-field type="number" name="discount" v-model="editedItem.discount" class="mt-3 fl-text-input" :rules="validations.discountRules" suffix="%" filled rounded dense></v-text-field>  
                              </v-col>

                            </v-row>
                          </v-container>
                        </v-card-text>

                        <v-card-actions class="px-8">
                          <v-spacer></v-spacer>
                          <v-btn color="secondary white--text" block @click="save" :disabled="!valid">
                            Guardar
                          </v-btn>
                        </v-card-actions>
                      </v-form>
                      