<v-row id="hero" class="mt-n12 mt-md-n8 pt-6">
    <?= new Controller\Template('home/partials/carousel') ?>
</v-row>

<?= new Controller\Template('home/partials/how-works') ?>
<v-container class="px-4 px-md-0 mb-16">
    <v-row justify="center">
        <v-col cols="12" md="4">
            <v-card color="primary" flat>
                <v-card-text class="px-0 py-0">
                    <h3 class="text-h4 text-center white--text">Cursuri</h3>
                    <v-img src="<?= SITE_URL ?>/img/home/cursuri.jpg" width="100%" max-width="100vw" contain>
                    </v-img>
                </v-card-text>
            </v-card>
        </v-col>
        <v-col cols="12" md="4">
            <v-card color="primary" flat>
                <v-card-text class="px-0 py-0">
                    <h3 class="text-h4 text-center white--text">Lectori</h3>
                    <v-img src="<?= SITE_URL ?>/img/home/lectori.jpg" width="100%" max-width="100vw" 
                    :max-height="$vuetify.breakpoint.mdAndDown ? $vuetify.breakpoint.smOnly ? '100%' : '236px' : '316px'">
                    </v-img>
                </v-card-text>
            </v-card>
        </v-col>
        <v-col cols="12" md="4">
            <v-card color="primary" flat>
                <v-card-text class="px-0 py-0">
                    <h3 class="text-h4 text-center white--text">Despre noi</h3>
                    <v-img src="<?= SITE_URL ?>/img/home/despre-noi.png" width="100%" max-width="100vw" contain>
                    </v-img>
                </v-card-text>
            </v-card>
        </v-col>
    </v-row>
</v-container>
<?= new Controller\Template('home/partials/instructors') ?>
<?= new Controller\Template('home/partials/popular-courses', $data) ?>