<v-card class="my-12 flex-grow-1" href="<?= SITE_URL?>/cursuri/<?= $slug?>">

    <v-img height="200" src="<?= $featured_image ?>"></v-img>
    <v-card-subtitle class="mb-n6"><?= $category ?></v-card-subtitle>
    <v-card-title class="font-weight-bold"><?= $title ?></v-card-title>
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
                <p class="mt-2"><?= empty($price) ? 'FREE' : "$price RON" ?></p>
            </v-col>
        </v-row>
    </v-card-actions>
</v-card>