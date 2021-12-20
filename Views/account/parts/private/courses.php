<v-col class="white px-12 py-md-8 info-container mx-md-6" cols="12" md="7" v-if="courses_container">
    <v-row>
        <v-col class="d-flex justify-end" cols="12">
            <v-btn color="primary" href="<?= SITE_URL ?>/cursuri/get?search=" text>
                <v-icon>mdi-magnify</v-icon>
                Căutați cursuri
            </v-btn>
        </v-col>
    </v-row>
    
    <v-row v-if="coming_classes.length > 0">
        <v-col class="mb-n8" cols="12">
            <h2 class="text-h4 mb-4">Cursuri live viitoare</h2>
            <v-divider></v-divider>
        </v-col>

        <v-col class="mt-4 px-6" cols="12" v-for="coming_class in coming_classes">
            <v-row class="d-flex align-center gradient">
                <v-col class="py-0 px-0" cols="12" md="3">
                    <v-img :src="coming_class.course_image"></v-img>
                </v-col>
                <v-col cols="12" md="7">
                    <span class="text-h5 font-weight-bold white--text">{{ coming_class.course_name }}</span>
                    <br>
                    <span class="text-h6 white--text">{{ coming_class.section_name }}</span>
                    <br>
                    <span class="text-h6 white--text"><b>Clase:</b> {{ coming_class.lesson_name }}</span>
                    <br>
                    <span class="text-h6 white--text"><b>Fecha:</b> {{ coming_class.lesson_date }}</span>
                </v-col>
                <v-col cols="12" md="2">
                    <v-btn color="white" class="secondary--text" :href="coming_class.lesson_url" block>Mergeți la clasa
                    </v-btn>
                </v-col>
            </v-row>
        </v-col>
    </v-row>

    <v-row>
        <v-col cols="12">
            <label>Selectați un copil</label>
            <v-select v-model="child_selected" :items="children.items"
                :item-text=" (e) => e.first_name + ' ' + e.last_name" @change="loadMyCourses" outlined return-object>
            </v-select>
        </v-col>
    </v-row>

    <template v-if="child_selected.hasOwnProperty('children_id')">
        <v-row v-if="my_courses_loading">
            <v-col cols="12" md="4" v-for="i in 6" :key="i">
                <v-skeleton-loader type="card"></v-skeleton-loader>
            </v-col>
        </v-row>

        <v-row v-else-if="!my_courses_loading && my_courses.length > 0">
            <v-col class="mb-n8" cols="12">
                <h2 class="text-h4 mb-4">Cursuri înscrise</h2>
                <v-divider></v-divider>
            </v-col>
            <v-col cols="12" md="4" v-for="course in my_courses">
                <v-card :loading="loading" class="my-12 course-card" max-width="95%" color="secondary"
                    :href="'<?= SITE_URL ?>/cursuri/'+course.slug">

                    <v-img width="100vw" class="align-end" :src="course.featured_image">
                    </v-img>

                    <v-card-title class="text-h6 font-weight-normal white--text no-word-break">{{ course.title }}
                    </v-card-title>

                    <v-divider class="mx-4"></v-divider>
                </v-card>
            </v-col>
        </v-row>

        <v-row class="px-16" v-else-if="!my_courses_loading && my_courses.length <= 0">
            <v-col class="d-flex justify-center" cols="12">
                <v-img src="<?= SITE_URL ?>/img/no-courses.svg" max-width="50%"></v-img>
            </v-col>
            <v-col class="m-0" cols="12">
                <h3 class="text-h4 text-center">Se pare că el/ea nu s-a înscris încă la un curs, puteți căuta un curs și
                    înregistra copilul.</h3>
            </v-col>
            <v-col class="m-0 d-flex justify-center" cols="12">
                <v-btn class="secondary white--text" href="<?= SITE_URL ?>/cursuri">Vezi cursuri</v-btn>
            </v-col>
        </v-row>
    </template>

</v-col>