<v-row class="px-16 mt-4 d-flex justify-center">
    <v-col class="mw-lg" cols="12">
        <v-row>
            <v-col class="d-flex justify-end mb-4" cols="12">
                <v-img src="<?= SITE_URL ?>/img/home/bubbles-2.svg" max-width="100px"></v-img>
            </v-col>

            <v-col class="d-md-flex align-end" cols="12" md="8">
                <h2 class="text-h3 primary--text text-center text-md-left">
                    Cursuri Populare
                </h2>
            </v-col>
            
            <v-col class="d-flex justify-end" cols="12" md="4">
                <v-btn color="secondary">Continuă</v-btn>
            </v-col>
        <?php if(!empty($courses)) : ?>
            <v-col cols="12">
                <v-row justify="center">
                    <?php foreach($courses as $course) : ?>
                    <v-col class="px-md-2 px-lg-6 d-flex" cols="12" md="4" lg="3">
                        <?= new Controller\Template('courses/course_template', $course) ?>
                    </v-col>
                    <?php endforeach ?>
                </v-row>
            </v-col>
        <?php endif ?>
        </v-row>
    </v-col>
</v-row>