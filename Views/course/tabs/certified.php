<v-row class="d-flex justify-center">
    <v-col cols="12" md="10" class="p-0">
        <v-row class="d-flex justify-center">
            <template v-if="certified_loading">
                <v-btn color="primary" :loading="true" block text></v-btn>  
            </template>
            <template v-else>
                <?php if (!empty($current_user_has_enroll)): ?>
                <?php if (!empty($meta['paid_certified'])): ?>
                <?php if (empty($data['current_user_has_paid_certified'])): ?>
                <v-col cols="12" md="8" lg="6">
                    <v-alert icon="mdi-certificate" prominent type="secondary">
                        <v-row class="d-flex justify-center">
                            <v-col class="grow">
                                Obtén tu certificado de <b><?php echo $title ?></b> por
                                <b>$<?php echo $meta['certified_price'] ?></b>
                            </v-col>
                            <v-col class="shrink">
                                <v-btn color="white"
                                    href="<?php echo SITE_URL ?>/checkout/?course_id=<?php echo $course_id ?>&course=<?php echo $title ?>&extra=certified"
                                    outlined>Pagar certificado</v-btn>
                            </v-col>
                        </v-row>
                    </v-alert>
                </v-col>
                <?php else: ?>
                <template v-if="my_progress.certified !== ''">
                    <v-col class="d-flex justify-center" cols="12" md="6">
                        <img src="<?php echo SITE_URL ?>/img/certificate-granted.svg" width="60%">
                    </v-col>
                    <v-col cols="12">
                        <h4 class="text-h5 text-center">
                            ¡Felicidades! Puedes descargar tu certificado presionando en el botón.
                        </h4>
                    </v-col>
                    <v-col class="d-flex justify-center" cols="12">
                        <v-btn color="secondary" :loading="certified_loading"
                            @click="saveFile(my_progress.certified, certified_loading)">Descargar certificado</v-btn>
                    </v-col>
                </template>
                <template v-else>
                    <v-col class="d-flex justify-center" cols="12" md="6">
                        <img src="<?php echo SITE_URL ?>/img/no-course-approved.svg" width="60%">
                    </v-col>
                    <v-col cols="12">
                        <h4 class="text-h5 text-center">
                            Se requiere completar todos los quizzes para recibir tu
                            certificado.
                        </h4>
                    </v-col>
                </template>
                <?php endif;?>
                <?php else: ?>
                <template v-if="my_progress.certified !== ''">
                    <v-col class="d-flex justify-center" cols="12" md="6">
                        <img src="<?php echo SITE_URL ?>/img/certificate-granted.svg" width="60%">
                    </v-col>
                    <v-col cols="12">
                        <h4 class="text-h5 text-center">
                            ¡Felicidades! Puedes descargar tu certificado presionando en el botón.
                        </h4>
                    </v-col>
                    <v-col class="d-flex justify-center" cols="12">
                        <v-btn color="secondary" :loading="certified_loading"
                            @click="saveFile(my_progress.certified, certified_loading)">Descargar certificado</v-btn>
                    </v-col>
                </template>
                <template v-else>
                    <v-col class="d-flex justify-center" cols="12" md="6">
                        <img src="<?php echo SITE_URL ?>/img/no-course-approved.svg" width="60%">
                    </v-col>
                    <v-col cols="12">
                        <h4 class="text-h5 text-center">
                            Se requiere completar todos los quizzes para recibir tu
                            certificado.
                        </h4>
                    </v-col>
                </template>
                <?php endif;?>
                <?php else: ?>
                <?php if (!empty($meta['paid_certified'])): ?>
                <v-col cols="12" md="8" lg="6">
                    <v-alert icon="mdi-certificate" prominent type="secondary">
                        <v-row class="d-flex justify-center">
                            <v-col class="grow">
                                Obtén tu certificado de <b><?php echo $title ?></b> por
                                <b>$<?php echo $meta['certified_price'] ?></b>
                            </v-col>
                        </v-row>
                    </v-alert>
                </v-col>
                <?php endif; ?>
                <?php endif; ?>
            </template>
            
        </v-row>
    </v-col>
</v-row>