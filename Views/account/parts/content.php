<v-col cols="12" md="7" class="white px-12 py-md-8 info-container mt-10 mx-md-6" v-if="main_container && !courses_container 
&& !profile_container && !orders_container && !grades_container ">

    <v-row v-if="coming_classes.length > 0">
        <v-col class="mb-n8" cols="12">
            <h2 class="text-h4 mb-4">Próximas clases en vivo</h2>
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
                    <span class="text-h7 white--text font-weight-light"><b>Clase:</b>
                        {{ coming_class.lesson_name }}</span>
                    <br>
                    <span class="text-h7 white--text font-weight-light"><b>Fecha:</b>
                        {{ coming_class.lesson_date }}</span>
                </v-col>
                <v-col cols="12" md="3">
                    <v-btn color="white" class="secondary--text" :href="coming_class.lesson_url" block>Ir a la
                        clase</v-btn>
                </v-col>
            </v-row>
        </v-col>
    </v-row>

    <v-row v-if="new_courses.length > 0">
        <v-col class="mb-n8" cols="12">
            <h2 class="text-h4 mb-4">Cursos Nuevos</h2>
            <v-divider></v-divider>
        </v-col>
        <v-col cols="12" md="4" v-for="course in new_courses">
            <v-card :loading="loading" class="my-12 course-card" max-width="95%" color="primary"
                :href="'<?php echo SITE_URL ?>/courses/'+course.slug">

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
            <h2 class="text-h4 mb-4">Cursos adquiridos</h2>
            <v-divider></v-divider>
        </v-col>
        <v-col cols="12" md="4" v-for="course in my_courses">
            <v-card :loading="loading" class="my-12 course-card" max-width="95%" color="secondary"
                :href="'<?php echo SITE_URL ?>/courses/'+course.slug">

                <v-img width="100vw" class="align-end" :src="course.featured_image">
                </v-img>

                <v-card-title class="text-h6 font-weight-normal white--text no-word-break">{{ course.title }}
                </v-card-title>

                <v-divider class="mx-4"></v-divider>
            </v-card>
        </v-col>
    </v-row>

    <template v-if="1 == 2">
        <h2 class="text-h3 mb-8">Lorem ipsum</h2>
        <p class="font-weight-light mb-10">Lorem ipsum dolor sit amet consectetur adipisicing elit. Rem,
            similique, assumenda cumque saepe, ex rerum culpa, neque ipsa aut a modi natus voluptate ea.
            Necessitatibus eum libero inventore odio atque. Lorem ipsum dolor sit, amet, consectetur adipisicing
            elit. Perspiciatis dignissimos doloremque recusandae consectetur! Veritatis, laborum veniam dolor
            accusamus velit illum qui praesentium esse cupiditate nemo facere deleniti, officia, perspiciatis
            inventore.</p>
        <h3 class="grey--text text--darken-1 text-h4">Portafolio</h3>
        <v-row class="d-flex align-center px-4">
            <v-col cols="12" md="3" sm="4">
                <v-card class="" max-width="100%">
                    <v-img height="250" src="https://cdn.vuetifyjs.com/images/cards/cooking.png" width="100%">
                    </v-img>
                </v-card>
            </v-col>
            <v-col cols="12" md="3" sm="4">
                <v-card class="" max-width="100%">
                    <v-img height="250" src="https://cdn.vuetifyjs.com/images/cards/cooking.png" width="100%">
                    </v-img>
                </v-card>
            </v-col>
            <v-col cols="12" md="3" sm="4">
                <v-img src="<?php echo SITE_URL ?>/img/flecha.svg" width="80%"></v-img>
            </v-col>
        </v-row>
        <h3 class="grey--text text--darken-1 text-h4 mt-10">Alguna otra cosa</h3>
        <p class="font-weight-light mt-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Rem,
            similique, assumenda cumque saepe, ex rerum culpa, neque ipsa aut a modi natus voluptate ea.
            Necessitatibus eum libero inventore odio atque. Lorem ipsum dolor sit, amet, consectetur adipisicing
            elit. Perspiciatis dignissimos doloremque recusandae consectetur! Veritatis, laborum veniam dolor
            accusamus velit illum qui praesentium esse cupiditate nemo facere deleniti, officia, perspiciatis
            inventore.</p>
    </template>
</v-col>

<?php echo new Controller\Template('account/parts/private/profile_edit') ?>
<?php echo new Controller\Template('account/parts/private/courses') ?>
<?php echo new Controller\Template('account/parts/private/orders') ?>
<?php echo new Controller\Template('account/parts/private/grades') ?>