<v-row id="hero" class="mt-n12 mt-md-n8 pt-6">
    <?= new Controller\Template('home/partials/carousel') ?>
</v-row>

<?= new Controller\Template('home/partials/how-works') ?>
<v-container id="container_1" class="px-4 px-md-16 d-flex justify-center mb-16">
    <v-row>
        <v-col cols="12">
            <v-row>
                <v-col cols="12" md="4">
                    <v-card color="primary" flat>
                        <v-card-text class="px-0 py-0">
                            <h3 class="text-h4 text-center white--text">Cursuri</h3>
                            <v-img src="https://picsum.photos/1200/720?random=<?= rand(0, 10000) ?>" max-width="100vw">
                            </v-img>
                        </v-card-text>
                    </v-card>
                </v-col>
                <v-col cols="12" md="4">
                    <v-card color="primary" flat>
                        <v-card-text class="px-0 py-0">
                            <h3 class="text-h4 text-center white--text">Lectori</h3>
                            <v-img src="https://picsum.photos/1200/720?random=<?= rand(0, 10000) ?>" max-width="100vw">
                            </v-img>
                        </v-card-text>
                    </v-card>
                </v-col>
                <v-col cols="12" md="4">
                    <v-card color="primary" flat>
                        <v-card-text class="px-0 py-0">
                            <h3 class="text-h4 text-center white--text">Despre noi</h3>
                            <v-img src="https://picsum.photos/1200/720?random=<?= rand(0, 10000) ?>" max-width="100vw">
                            </v-img>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
        </v-col>
    </v-row>
</v-container>
<?= new Controller\Template('home/partials/instructors') ?>
<?= new Controller\Template('home/partials/popular-courses', $data) ?>