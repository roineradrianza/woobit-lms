<v-container>
    <v-row class="px-4 px-md-0 mt-4 d-flex justify-center">
        <v-col cols="12">
            <v-row>
                <v-col class="d-md-flex align-end" cols="12" md="8">
                    <h2 class="text-h3 primary--text text-center text-md-left">
                        Cursuri Populare
                    </h2>
                </v-col>

                <v-col class="d-flex justify-center justify-md-end" cols="12" md="4">
                    <v-btn color="secondary">Continuă</v-btn>
                </v-col>
                <?php if(!empty($courses)) : ?>
                <v-col class="d-block d-md-none" cols="12">
                    <v-carousel class="no-ha custom_carousel" delimiter-icon="mdi-circle" cycle :show-arrows="false"
                        hide-delimiter-background>
                        <?php foreach($courses as $course) : ?>
                        <v-carousel-item>
                            <v-col cols="12">
                                <?= new Controller\Template('courses/course_template', $course) ?>
                            </v-col>
                        </v-carousel-item>
                        <?php endforeach ?>
                    </v-carousel>
                </v-col>
                <v-col class="d-none d-md-block" cols="12">
                    <v-row justify="center">
                        <?php foreach($courses as $course) : ?>
                        <v-col class="d-flex" cols="12" md="4" lg="3">
                            <?= new Controller\Template('courses/course_template', $course) ?>
                        </v-col>
                        <?php endforeach ?>
                    </v-row>
                </v-col>
                <?php endif ?>
            </v-row>
        </v-col>
    </v-row>
</v-container>