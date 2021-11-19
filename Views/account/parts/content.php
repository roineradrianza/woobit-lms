<v-col cols="12" md="7" class="white px-12 py-md-8 info-container mx-md-6" v-if="main_container && !courses_container 
&& !profile_container && !orders_container && !grades_container ">

    <v-row v-if="coming_classes.length > 0">
        <v-col class="mb-n8" cols="12">
            <h2 class="text-h4 mb-4">Cursuri live viitoare</h2>
            <v-divider></v-divider>
        </v-col>

        <v-col class="mt-4 px-6" cols="12" v-for="coming_class in coming_classes">
            <v-row class="d-flex align-center gradient">
                <v-col class="py-0 px-0" cols="12" md="3">
                    <v-img :src="coming_class.course_image" width="100%"></v-img>
                </v-col>
                <v-col cols="12" md="6">
                    <span class="text-h6 font-weight-bold white--text">{{ coming_class.course_name }}</span>
                    <br>
                    <span class="text-h7 white--text font-weight-light">{{ coming_class.section_name }}</span>
                    <br>
                    <span class="text-h7 white--text font-weight-light"><b>Clasa:</b>
                        {{ coming_class.lesson_name }}</span>
                    <br>
                    <span class="text-h7 white--text font-weight-light"><b>Data:</b>
                        {{ coming_class.lesson_date }}</span>
                </v-col>
                <v-col cols="12" md="3">
                    <v-btn color="white" class="secondary--text" :href="coming_class.lesson_url" block>
                        Mergeți la clasa
                    </v-btn>
                </v-col>
            </v-row>
        </v-col>
    </v-row>

    <v-row v-if="new_courses.length > 0">
        <v-col class="mb-n8" cols="12">
            <h2 class="text-h4 mb-4">Cursuri noi</h2>
            <v-divider></v-divider>
        </v-col>
        <v-col cols="12" md="4" v-for="course in new_courses">
            <v-card :loading="loading" class="my-12 course-card" max-width="95%" color="primary"
                :href="'<?= SITE_URL ?>/courses/'+course.slug">

                <v-img width="100vw" class="align-end" :src="course.featured_image">
                </v-img>

                <v-card-title class="text-h6 font-weight-normal white--text no-word-break">{{ course.title }}
                </v-card-title>
                <v-col class="px-4 py-0 m-0 mb-4" cols="12">
                    <v-chip class="white primary--text" dark>
                        <template v-if="course.price == 0">
                            GRATIS
                        </template>
                        <template v-else>
                            $ {{ course.price }} USD
                        </template>
                    </v-chip>
                </v-col>

                <v-divider class="mx-4"></v-divider>
            </v-card>
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
    
</v-col>

<?= new Controller\Template('account/parts/private/profile_edit') ?>
<?= new Controller\Template('account/parts/private/courses') ?>
<?= new Controller\Template('account/parts/private/orders') ?>
<?= new Controller\Template('account/parts/private/grades') ?>