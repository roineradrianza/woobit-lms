<v-col class="white px-12 py-md-8 info-container mx-md-6" cols="12" md="7" v-if="courses_container">
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

    <v-row v-if="my_courses.length > 0">
        <v-col class="mb-n8" cols="12">
            <h2 class="text-h4 mb-4">Cursuri dobândite</h2>
            <v-divider></v-divider>
        </v-col>
        <v-col cols="12" md="4" v-for="course in my_courses">
            <v-card :loading="loading" class="my-12 course-card" max-width="95%" color="secondary"
                :href="'<?= SITE_URL ?>/courses/'+course.slug">

                <v-img width="100vw" class="align-end" :src="course.featured_image">
                </v-img>

                <v-card-title class="text-h6 font-weight-normal white--text no-word-break">{{ course.title }}
                </v-card-title>

                <v-divider class="mx-4"></v-divider>
            </v-card>
        </v-col>
    </v-row>
    <v-row class="px-16" v-else>
        <v-col class="d-flex justify-center" cols="12">
            <v-img src="<?= SITE_URL ?>/img/no-courses.svg" max-width="50%"></v-img>
        </v-col>
        <v-col class="m-0" cols="12">
            <h3 class="text-h4 text-center">Se pare că nu v-ați înscris încă la un curs, vă rugăm să căutați un curs și
                să vă înscrieți.</h3>
        </v-col>
        <v-col class="m-0 d-flex justify-center" cols="12">
            <v-btn class="secondary white--text" href="<?= SITE_URL ?>/courses">Vezi cursuri</v-btn>
        </v-col>
    </v-row>
</v-col>