<v-container class="py-12">
    <v-row v-if="loading">
        <v-col cols="12" md="5">
            <v-skeleton-loader class="mx-auto" type="card"></v-skeleton-loader>
        </v-col>
        <v-col cols="12" md="7">
            <v-skeleton-loader class="mx-auto" type="text"></v-skeleton-loader>
            <v-skeleton-loader class="mx-auto" type="text"></v-skeleton-loader>
            <v-skeleton-loader class="mx-auto" type="text"></v-skeleton-loader>
            <v-skeleton-loader class="mx-auto" type="text"></v-skeleton-loader>
            <v-skeleton-loader class="mx-auto" type="text"></v-skeleton-loader>
            <v-skeleton-loader class="mx-auto" type="text"></v-skeleton-loader>
        </v-col>
    </v-row>
    <v-row align="center" v-else>
        <v-col cols="12" md="5">
            <v-img src="<?= SITE_URL ?>/img/account-confirmation.svg"></v-img>
        </v-col>
        <v-col cols="12" md="7">
            <?= new Controller\Template('components/alert') ?>
        </v-col>
    </v-row>
</v-container>