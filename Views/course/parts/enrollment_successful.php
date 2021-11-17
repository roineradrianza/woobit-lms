<v-dialog v-model="modal_course" fullscreen hide-overlay transition="dialog-bottom-transition">
    <v-card>
        <v-toolbar class="gradient" dark>
            <v-toolbar-title>Antes de continuar...</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-toolbar-items>
                <v-btn icon dark @click="setCookie">
                    <v-icon>mdi-close</v-icon>
                </v-btn>
            </v-toolbar-items>
        </v-toolbar>
        <v-col class="d-flex justify-center" cols="12">
            <v-col cols="12" md="8">
                <v-sheet class="gradient py-3 py-md-10" height="100%" elevation="24" rounded>
                    <v-row>
                        <v-row class="px-16" cols="12">
                            <v-col class="d-flex justify-center" cols="12">
                                <v-img src="<?php echo SITE_URL ?>/img/white-logo.png" width="150px"
                                    height="150px" contain></v-img>
                            </v-col>
                            <v-col cols="12">
                                <div class="text-md-h3 text-h5 text-center white--text">
                                    Felicidades por inscribirte a <br>
                                    <b><?php echo $data['title'] ?></b>
                                </div>
                            </v-col>
                        </v-row>
                    </v-row>
                </v-sheet>
            </v-col>
        </v-col>
        <v-col cols="12">
            <h3 class="text-h4 text-center primary--text">Tutorial</h3>
        </v-col>
        <v-col class="d-flex justify-center" cols="12">
            <v-stepper v-model="stepper" vertical>
                <v-stepper-step :complete="stepper > 1" step="1">
                    ¿Cómo entrar a clase?
                </v-stepper-step>

                <v-stepper-content step="1">
                    <p>Puedes acceder a la clase a través de la pestaña <b class="secondary--text">"Entrar a la
                            clase"</b></p>
                    <v-col cols="12">
                        <v-card color="grey lighten-2" class="mb-4">
                            <v-tabs fixed-tabs centered show-arrows ref="tabs_section">
                                <v-tab class="py-6 primary--text" href="#description">Descriere</v-tab>

                                <?php if (!empty($data['instructors'])): ?>
                                <v-tab class="py-6 primary--text" href="#instructors">Profesores</v-tab>
                                <?php endif ?>

                                <v-tab class="py-6 primary--text" href="#curriculum">Entrar a clase</v-tab>

                                <?php if (isset($data['meta']['faq'])): ?>
                                <v-tab class="py-6 primary--text" href="#faq">FAQ</v-tab>
                                <?php endif ?>

                                <?php if (isset($data['manage_course']) && $data['manage_course']): ?>
                                <v-tab class="py-6 primary--text" href="#list">Lista</v-tab>
                                <?php endif ?>

                                <v-tab class="py-6 primary--text" href="#comments">Comentarios</v-tab>

                                <v-tab class="py-6 primary--text" href="#digital-expo" v-if="sponsors.length">Expo
                                    Digital</v-tab>
                            </v-tabs>
                        </v-card>
                    </v-col>
                    Una vez en la pestaña, encontrarás el listado de las secciones y dentro de ellas tendrás el
                    siguiente botón: <v-btn color="primary" text>Ir a clase</v-btn> al hacer click te llevará a la
                    clase.
                    <br>
                    <v-btn color="primary" @click="stepper = 2">
                        Siguiente
                    </v-btn>
                </v-stepper-content>

                <v-stepper-step :complete="stepper > 2" step="2">
                    ¿Cómo saber si ya la clase está completada?
                </v-stepper-step>

                <v-stepper-content step="2">
                    <p>Es importante que hayas completado cada clase para aumentar tu progreso durante el curso.</p>
                    Puedes revisar las clases completadas accediendo de igual manera a la pestaña <b
                        class="secondary--text">"Entrar a la clase"</b>, en cada clase a la que tú hayas asistido o
                    visto, te aparecerá de la siguiente manera una vez completada:
                    <br>

                    <v-row class="d-flex justify-center">
                        <v-col cols="12" md="10">
                            <v-expansion-panels>
                                <v-expansion-panel>
                                    <v-expansion-panel-header>
                                        <v-row no-gutters>
                                            <v-col class="d-flex justify-start p-0" cols="10">
                                                Sección 1
                                            </v-col>
                                            <v-col class="d-flex justify-end p-0" cols="2">
                                                <v-icon color="success">mdi-check-circle</v-icon>
                                            </v-col>
                                        </v-row>
                                    </v-expansion-panel-header>
                                    <v-expansion-panel-content>
                                        <v-expansion-panels class="mb-4">
                                            <v-expansion-panel>
                                                <v-expansion-panel-header>
                                                    <v-row no-gutters>
                                                        <v-col class="d-flex justify-start p-0" cols="12" md="9">
                                                            Înregistrare de la clase
                                                        </v-col>
                                                        <v-col class="d-flex justify-end p-0" cols="12" md="3">
                                                            <v-icon color="success">mdi-check-circle</v-icon>
                                                            <v-btn class="primary--text" text>Ir a clase</v-btn>
                                                        </v-col>

                                                    </v-row>
                                                </v-expansion-panel-header>
                                                <v-expansion-panel-content>
                                                </v-expansion-panel-content>
                                            </v-expansion-panel>
                                        </v-expansion-panels>
                                    </v-expansion-panel-content>
                                </v-expansion-panel>

                            </v-expansion-panels>
                        </v-col>
                    </v-row>
                    <v-btn text @click="stepper = 1">
                        Atrás
                    </v-btn>
                    <?php if ($has_live_classes): ?>
                    <v-btn color="primary" @click="stepper = 3">
                        Siguiente
                    </v-btn>
                    <?php else:?>
                    <v-btn color="primary" @click="setCookie">
                        Continuar al curso
                    </v-btn>
                    <?php endif ?>
                </v-stepper-content>

                <?php if ($has_live_classes): ?>

                <v-stepper-step :complete="stepper > 3" step="3">
                    Avisos sobre clases en vivo
                </v-stepper-step>
                <v-stepper-content step="3">
                    <p>Para nuestras clases en vivos, les estaremos notificando vía correo electrónico, a través de las
                        notificaciones de la página y en tu <a href="<?php echo SITE_URL ?>/profile/"
                            target="_blank">perfil</a> podrás tener un apartado de clases en vivo desde la cual podrás
                        acceder como se muestra a continuación:</p>
                    <v-col class="mt-4" cols="12">
                        <v-row class="d-flex align-center gradient">
                            <v-col class="py-0 px-0" cols="12" md="3">
                                <v-img src="<?php echo $data['featured_image'] ?>"></v-img>
                            </v-col>
                            <v-col cols="12" md="7">
                                <span class="text-h5 font-weight-bold white--text"><?php echo $data['title'] ?></span>
                                <br>
                                <span class="text-h6 white--text">Sección 1</span>
                                <br>
                                <span class="text-h6 white--text"><b>Clase:</b> Înregistrare de la clase</span>
                                <br>
                                <span class="text-h6 white--text"><b>Fecha:</b> 2021-03-15 19:00 America/Caracas</span>
                            </v-col>
                            <v-col cols="12" md="2">
                                <v-btn class="secondary--text" color="white" block secondary>Mergeți la clasa</v-btn>
                            </v-col>
                        </v-row>
                    </v-col>
                    <v-btn text @click="stepper = 2">
                        Atrás
                    </v-btn>
                    <v-btn color="primary" @click="setCookie">
                        Continuar al curso
                    </v-btn>
                </v-stepper-content>

                <?php endif ?>
            </v-stepper>

        </v-col>

    </v-card>
</v-dialog>