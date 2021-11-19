<v-row class="mt-n3">
    <?= new Controller\Template('home/partials/carousel') ?>
</v-row>

<v-row class="px-16 mt-4 d-flex justify-center mb-16">
    <v-col class="mw-md" cols="12">
        <v-row>
            <v-col cols="12" md="4">
                <v-card color="primary" flat>
                    <v-card-text class="px-0 py-0">
                        <h3 class="text-h4 text-center white--text">Cursuri</h3>
                        <v-img src="https://picsum.photos/1200/720?random=<?= rand(0, 10000) ?>"></v-img>
                    </v-card-text>
                </v-card>
            </v-col>
            <v-col cols="12" md="4">
                <v-card color="primary" flat>
                    <v-card-text class="px-0 py-0">
                        <h3 class="text-h4 text-center white--text">Lectori</h3>
                        <v-img src="https://picsum.photos/1200/720?random=<?= rand(0, 10000) ?>"></v-img>
                    </v-card-text>
                </v-card>
            </v-col>
            <v-col cols="12" md="4">
                <v-card color="primary" flat>
                    <v-card-text class="px-0 py-0">
                        <h3 class="text-h4 text-center white--text">Despre noi</h3>
                        <v-img src="https://picsum.photos/1200/720?random=<?= rand(0, 10000) ?>"></v-img>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-col>
</v-row>
<?= new Controller\Template('home/partials/how-works') ?>
<?= new Controller\Template('home/partials/instructors') ?>
<?= new Controller\Template('home/partials/popular-courses', $data) ?>