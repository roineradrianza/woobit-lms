

      
      <!-- Sizes your content based upon application components -->
        <v-row >
          <v-col class="px-10" cols="12">
            <v-row>
              <v-col cols="12">
                <label class="body-1 font-weight-normal pl-1">Seleccione el tipo de correo a enviar</label>
                <v-select class="mt-3 fl-text-input pt-select" v-model="optionSelected" :items="email_options" item-text="text" item-value="value" filled rounded dense></v-select>
              </v-col>
              <template v-if="optionSelected == 0 || optionSelected == 2">
                <v-col cols="12">
                  <label class="body-1 font-weight-normal pl-1">Seleccione el curso</label>
                  <v-select class="mt-3 fl-text-input pt-select" v-model="course" :items="courses" item-text="title" :loading="courses_loading" @change="loadCoupons" filled rounded dense return-object></v-select>
                </v-col>

                <v-col cols="12" v-if="optionSelected == 0 && course.hasOwnProperty('course_id')">
                  <h4 class="text-h5 font-weight-normal">Seleccione el cupón para el curso "{{ course.title }}"</h4>
                  <v-data-table v-model="coupon_selected" :headers="headers" :items="coupons" sort-by="coupon_name" class="elevation-1" item-key="coupon_id" :loading="coupons_table_loading" single-select show-select>
                    <template v-slot:item.discount ="{ item }">
                      {{ item.discount }} %
                    </template>
                  </v-data-table>
                </v-col>
              </template>

              <template v-if="openList || optionSelected == 1 || optionSelected == 2">

                <v-col cols="12" md="6">
                  <label class="body-1 font-weight-normal pl-1">Tipo de selección de usuarios</label>
                  <v-select class="mt-3 fl-text-input pt-select" v-model="userOptionSelected" :items="user_options" item-text="text" item-value="value" :loading="courses_loading" @change="studentsSelected = []" filled rounded dense ></v-select>
                </v-col>

                <v-col cols="12" md="6" v-if="userOptionSelected == 0">
                  <label class="body-1 font-weight-normal pl-1">Seleccione el rol al que se le enviará el correo</label>
                  <v-select class="mt-3 fl-text-input pt-select" v-model="userRolOptionSelected" :items="rol_options" item-text="text" item-value="value" :loading="courses_loading" filled rounded dense></v-select>
                </v-col>

                <v-col cols="12" md="6" v-if="userOptionSelected == 1">
                  <label class="body-1 font-weight-normal pl-1">Seleccione los usuarios a los que se enviará el correo</label>
                  <v-select class="mt-3 fl-text-input pt-select" v-model="studentsSelected" :item-text="item => displayItem(item)" :items="students" :loading="students_loading"  multiple filled rounded dense return-object>
                    <template #selection="{ item }">
                      <v-chip color="primary" class="mb-2">{{ displayItem(item) }}</v-chip>
                    </template>
                  </v-select>
                  <template v-if="optionSelected == 1">
                     <label class="body-1 font-weight-normal pl-1">Añadir correo manualmente</label>
                    <v-text-field class="mt-3 fl-text-input" v-model="new_email" filled rounded dense >
                      <template #append-outer>
                        <v-btn class="primary white--text" @click="addEmail" fab> <v-icon>mdi-plus</v-icon></v-btn>
                      </template>
                    </v-text-field>
                  </template>
                </v-col>

                <v-col cols="12" md="6" v-if="userOptionSelected == 2">
                  <label class="body-1 font-weight-normal pl-1">Añada el archivo de excel</label>
                  <v-file-input type="file" v-model="user_xlsx" class="mt-3 fl-text-input pt-select" prepend-icon="" hint="Se leerá automáticamente el archivo" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" @change="readStudentsXLSX" persistent-hint filled rounded dense clearable></v-file-input>
                </v-col>

                <template v-if="emailFieldActivate">
                  <v-col cols="12">
                    <label class="body-1 font-weight-normal pl-1">Título del mensaje de correo</label>
                    <v-text-field class="mt-3 fl-text-input" name="email_title" v-model="email.title" filled rounded dense ></v-text-field>
                  </v-col>
                  <v-col cols="12">
                    <label class="body-1 font-weight-normal pl-1">Mensaje del correo electrónico (Opcional)</label>
                    <vue-editor class="mt-3 fl-text-input" name="email_content" v-model="email.content" placeholder="Mensaje del correo electrónico" :editor-toolbar="customToolbar"/>
                  </v-col>
                  <v-col cols="12">
                    <label class="body-1 font-weight-normal pl-1">Archivo a adjuntar (Opcional)</label>
                    <v-file-input type="file" name="email_attachment" v-model="email.attachment" class="mt-3 fl-text-input pt-select" prepend-icon="" filled rounded dense clearable></v-file-input>
                  </v-col>
                  <?php echo new Controller\Template('components/alert') ?>
                  <v-col class="d-flex justify-center" cols="12" v-if="optionSelected == 0">
                    <v-btn class="primary white--text" @click="sendCoupons()" :loading="send_loading">Enviar correo</v-btn>
                  </v-col>
                  <v-col class="d-flex justify-center" cols="12" v-if="optionSelected == 1">
                    <v-btn class="primary white--text" @click="sendCustomEmail()" :loading="send_loading">Enviar correo</v-btn>
                  </v-col>
                  <v-col class="d-flex justify-center" cols="12" v-if="optionSelected == 2">
                    <v-btn class="primary white--text" @click="sendCertifiedEmail()" :loading="send_loading">Enviar correo</v-btn>
                  </v-col>
                </template>

              </template>
            </v-row>
          </v-col>          
        </v-row>

                      