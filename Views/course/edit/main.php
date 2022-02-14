<v-container class="px-6 px-md-0">
    <?= new Controller\Template('course/edit/parts/lesson_form', ['mode' => 'edit']) ?>
    <v-form ref="course_container" course-id="<?= $course_id ?>">
        <v-row v-if="page_loading">
            <v-col cols="12">
                <v-skeleton-loader type="card"></v-skeleton-loader>
            </v-col>
        </v-row>
        <v-row v-else>
            <v-col cols="12">
                <h1 class="text-h4">Cursuri creative, în direct, pentru minți luminoase</h1>
            </v-col>
            <v-col cols="12">
                <v-form ref="course_form" lazy-validation>
                    <v-row>

                        <?= new Controller\Template('course/edit/partials/general_information', [
							'featured_image' => 'new_featured_image'
						]) ?>

                        <v-col md="12">
                            <?= new Controller\Template('course/edit/partials/curriculum') ?>
                        </v-col>
                        <v-col cols="12">
                            <v-divider></v-divider>
                        </v-col>
                        <v-col class="d-flex justify-center" cols="12">
                            <v-btn class="secondary white--text" @click="$refs.course_form.validate() ? save() : ''"
                                :disabled="saved" :loading="loading">
                                Salvați cursul</v-btn>
                        </v-col>
                        <v-col class="d-flex justify-center" cols="12">
                            <v-alert prominent :type="alert_type" v-if="alert">
                                <v-row align="center">
                                    <v-col class="grow">
                                        {{ alert_message }}
                                    </v-col>
                                    <v-col class="shrink" v-if="course.slug != ''">
                                        <v-btn v-btn :href="'<?= SITE_URL ?>/cursuri/' + course.slug">Mergeți la curs
                                        </v-btn>
                                    </v-col>
                                </v-row>
                            </v-alert>
                        </v-col>
                    </v-row>
                </v-form>

            </v-col>
        </v-row>
    </v-form>
</v-container>