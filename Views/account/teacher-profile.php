<v-row class="px-8 py-8 px-md-0 gradient">
    <v-container>
        <v-sheet color="white" rounded="xl">
            <v-row class="px-6 px-md-12">
                <v-col class="d-flex justify-center mt-5"
                    v-if="preview_avatar_image != null && preview_avatar_image != ''">
                    <v-avatar class="avatar" size="120">
                        <img :src="preview_avatar_image">
                    </v-avatar>
                </v-col>

                <v-col class="d-flex justify-center mt-5" cols="12" v-else>
                    <v-icon class="avatar-icon" color="secondary">mdi-account-circle</v-icon>
                </v-col>

                <v-col class="d-flex justify-center mt-2" cols="12">
                    <v-row>
                        <template v-if="image_btns && !avatar_loading">
                            <v-col class="d-flex justify-end py-0" cols="6">
                                <v-btn color="success" @click="updateAvatarImage" text>
                                    <v-icon>mdi-check</v-icon>
                                </v-btn>
                            </v-col>
                            <v-col class="d-flex justify-start py-0" cols="6">
                                <v-btn color="error" @click="undoImagePreview" text>
                                    <v-icon>mdi-close</v-icon>
                                </v-btn>
                            </v-col>
                        </template>
                        <v-col class="d-flex justify-center py-0" cols="12" v-if="avatar_loading">
                            <v-btn color="warning" @click="undoImagePreview" :loading="avatar_loading"></v-btn>
                        </v-col>
                        <v-col class="d-flex justify-center py-0" cols="12">
                            <template v-if="image_upload_btn && !avatar_loading">
                                <label for="avatar_image">
                                    <p class="text-uppercase cursor-pointer secondary--text">Selectați imaginea</p>
                                    <input type="file" name="avatar_image" id="avatar_image" class="d-none"
                                        accept="image/*" v-on:change="prevImage" />
                                </label>
                            </template>
                            <v-btn color="primary" v-if="!image_upload_btn && !avatar_loading"
                                @click="image_upload_btn = true" text>Actualizați imaginea</v-btn>
                        </v-col>
                    </v-row>
                </v-col>
                <v-row>
                    <v-col cols="12" md="6">
                        <label class="body-1 font-weight-thin pl-1">Prenumele adultului</label>
                        <v-text-field type="text" name="first_name" v-model="profile.first_name" class="mt-3"
                            :rules="validations.nameRules" outlined></v-text-field>
                    </v-col>

                    <v-col cols="12" md="6">
                        <label class="body-1 font-weight-thin pl-1">Numele de familie a adultului</label>
                        <v-text-field type="text" name="last_name" v-model="profile.last_name" class="mt-3"
                            :rules="validations.nameRules" outlined></v-text-field>
                    </v-col>

                    <v-col cols="12" md="6">
                        <label class="body-1 font-weight-thin pl-1">Email</label>
                        <v-text-field type="email" name="email" v-model="profile.meta.teacher_email" class="mt-3"
                            :rules="validations.emailRules" outlined></v-text-field>
                    </v-col>

                    <v-col cols="12" md="6">
                        <label class="body-1 font-weight-thin pl-1">Telefon</label>
                        <vue-tel-input-vuetify id="tel-input" class="mt-3" v-model="profile.meta.teacher_telephone"
                            :rules="validations.telephoneRules" outlined>
                        </vue-tel-input-vuetify>
                    </v-col>

                    <v-col cols="12">
                        <label class="body-1 font-weight-thin pl-1">Biografie</label>
                        <vue-editor id="bio_editor" class="mt-3" v-model="profile.meta.bio"
                            :editor-toolbar="customToolbar" placeholder="Scrieți-vă biografia aici" />
                    </v-col>

                    <v-col class="d-flex justify-center" cols="12">
                        <v-btn class="primary white--text" @click="saveProfile" :loading="edit_profile_loading">Salvați
                        </v-btn>
                    </v-col>

                    <v-col class="d-flex justify-center" cols="12">
                        <?= new Controller\Template('components/alert') ?>
                    </v-col>

                </v-row>
            </v-row>
        </v-sheet>

    </v-container>
</v-row>