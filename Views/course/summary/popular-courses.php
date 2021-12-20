<v-row>
    <v-col cols="12">
        <h3 class="text-h4 text-center">
            Cursuri de <?= $category ?> populare
        </h3>
    </v-col>
    <v-col class="mt-n10" cols="12">
        <v-row justify="center">
            <v-col class="d-flex" cols="12" md="4" lg="3" v-for="i in 4" :key="i">
                <v-card class="my-12 flex-grow-1" href="<?= SITE_URL?>/cursuri/">
                    <v-img height="200" src="https://picsum.photos/1200/720?random=<?= rand(0, 10000) ?>"></v-img>
                    <v-card-subtitle class="mb-n6"><?= !empty($category) ? $category : '' ?></v-card-subtitle>
                    <v-card-title class="font-weight-bold">Course title</v-card-title>
                    <v-card-text>
                        <v-divider></v-divider>
                    </v-card-text>
                    <v-card-actions class="pt-0">
                        <v-row align="center" class="mx-0">
                            <v-col class="d-flex align-center" cols="12" md="7" lg="8">
                                <v-rating :value="5" color="amber" dense half-increments readonly size="18">
                                </v-rating>

                                <span class="grey--text">
                                    5
                                </span>
                            </v-col>

                            <v-col cols="12" md="5" lg="4">
                                <p class="mt-2">56 RON</p>
                            </v-col>
                        </v-row>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>
    </v-col>
</v-row>