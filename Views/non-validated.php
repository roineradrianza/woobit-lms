<v-container class="py-12">
    <v-row align="center">
        <v-col cols="12" md="5">
            <v-img src="<?= SITE_URL ?>/img/verification-required.svg"></v-img>
        </v-col>
        <v-col cols="12" md="7">
            <h1 class="text-h4 text-center mb-6">Autorizare cont.</h1>
            <h3 class="text-h6 text-center mb-6">Verifică-ți emailul pentru a crea contul Woobit. Dacă nu reușești să
                vezi emailul de verificare poți să soliciți un alt email folosind butonul de mai jos.</h3>
            <v-row justify="center">
                <v-btn color="primary" @click="requestVerification">Trimite din nou</v-btn>
            </v-row>

            <?= new Controller\Template('components/alert') ?>
        </v-col>
    </v-row>
</v-container>