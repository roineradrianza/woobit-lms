<v-row>
    <v-col cols="12" v-if="loading">
        <?= new Controller\Template('my-courses/partials/loader') ?>
    </v-col>
    <v-col cols="12" v-else>
        <template v-if="courses.length <= 0">
            <?= new Controller\Template('my-courses/partials/empty') ?>
        </template>
        <template v-else>
            <v-row>
                <v-col class="px-0" cols="12">
                    <v-btn color="primary" href="<?= SITE_URL ?>/ghid-curs-nou">Ghid curs nou</v-btn>
                    <v-btn class="my-6" color="primary" href="<?= SITE_URL ?>/cursuri/adauga-curs">Adaugă curs nou
                    </v-btn>
                    <v-btn class="my-6" color="primary" text>Cursurile tale
                    </v-btn>
                </v-col>
                <v-col md="8">
                    <h4 class="text-h4 font-weight-bold">
                        Cursurile mele
                    </h4>
                </v-col>
                <v-col class="d-flex justify-end" md="4">
                    <v-btn color="primary" href="<?= SITE_URL ?>/cursuri/adauga-curs">Adaugă curs nou</v-btn>
                </v-col>
            </v-row>
            <?= new Controller\Template('my-courses/partials/courses') ?>
            <template v-if="filtered_courses.length <= 0">
                <v-row class="py-5 py-md-10" align="center">
                    <v-col class="d-flex justify-center" md="6">
                        <v-img src="<?= SITE_URL ?>/img/no-courses.svg" max-width="400px" contain></v-img>
                    </v-col>
                    <v-col md="6">
                        <v-row>
                            <v-col cols="12">
                                <h3 class="text-h4 text-center">
                                    Nu s-au găsit rezultate
                                </h3>
                            </v-col>
                            <v-col class="d-flex justify-center">
                                <v-btn color="primary" href="<?= SITE_URL ?>/cursuri/adauga-curs">Adaugă curs nou
                                </v-btn>
                            </v-col>
                        </v-row>
                    </v-col>
                </v-row>
            </template>
        </template>
    </v-col>
</v-row>