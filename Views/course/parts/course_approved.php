<v-dialog v-model="certified_approved_dialog" max-width="500px" transition="dialog-transition">
    <v-card v-if="!parseInt(requireCertifiedPaid)">
        <v-toolbar class="gradient" elevation="0">
            <v-toolbar-title class="white--text">¡Felicitaciones!</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-toolbar-items>
                <v-btn icon dark @click="certified_approved_dialog = false;">
                    <v-icon color="white">mdi-close</v-icon>
                </v-btn>
            </v-toolbar-items>
        </v-toolbar>
        <v-card-text>
            <v-row>
                <v-col class="d-flex justify-center" cols="12" md="11">
                    <img src="<?= SITE_URL ?>/img/certificate-granted.svg" width="70%">
                </v-col>
                <v-col cols="12">
                    <h4 class="text-h5 text-center">
                        ¡Felicidades por haber aprobado el curso!
                    </h4>
                </v-col>
                <v-col class="d-flex justify-center" cols="12">
                    <v-btn color="primary" href="<?= SITE_URL . "/cursuri/$slug?course_tab=comments"?>">
                        Calificar curso</v-btn>
                </v-col>
                <v-col class="d-flex justify-center" cols="12">
                    <v-btn color="secondary" :loading="certified_loading"
                        @click="saveFile(certified_url, certified_loading)">Descargar Certificado</v-btn>
                </v-col>
            </v-row>
        </v-card-text>
    </v-card>
    <v-card v-else>
        <v-toolbar class="gradient" elevation="0">
            <v-toolbar-title class="white--text">¡Felicitaciones!</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-toolbar-items>
                <v-btn icon dark @click="certified_approved_dialog = false;">
                    <v-icon color="white">mdi-close</v-icon>
                </v-btn>
            </v-toolbar-items>
        </v-toolbar>
        <v-card-text>
            <v-row>
                <v-col class="d-flex justify-center" cols="12" md="11">
                    <img src="<?= SITE_URL ?>/img/certificate-granted.svg" width="70%">
                </v-col>
                <v-col cols="12">
                    <h4 class="text-h5 text-center">
                        ¡Felicidades por haber aprobado el curso!
                    </h4>
                </v-col>
                <v-col class="d-flex justify-center" cols="12">
                    <v-btn color="primary" href="<?= SITE_URL . "/cursuri/$slug?course_tab=comments"?>">
                        Calificar curso</v-btn>
                </v-col>
                <v-col class="d-flex justify-center" cols="12">
                    <v-btn color="secondary" href="<?= SITE_URL . "/checkout/?course_id=$course_id&course=$title&extra=certified"?>">Adquirir Certificado</v-btn>
                </v-col>
            </v-row>
        </v-card-text>
    </v-card>
</v-dialog>