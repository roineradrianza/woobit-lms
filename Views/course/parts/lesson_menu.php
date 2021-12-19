<v-navigation-drawer class="lesson_sidebar" v-model="drawer" app>
    <v-row class="px-4">
        <v-col cols="12" class="d-flex justify-center px-md-8">
            <v-btn class="mx-2 mt-4" color="error" small fab dark @click="drawer = false">
                <v-icon dark>
                    mdi-close
                </v-icon>
            </v-btn>
        </v-col>
        <v-col cols="12" class="d-flex justify-center px-md-8">
            <v-btn class="mx-2 mt-2 py-2" color="secondary" href="../" dark>
                <v-icon dark>
                    mdi-home
                </v-icon>
                Inicio del curso
            </v-btn>
        </v-col>
        <v-col cols="12">
            <v-expansion-panels <?= count($sections) == 1 ? ':mandatory="true"' : '' ?>>
                <?php if (empty($data['sections'])):?>
                <h3 class="text-center text-uppercase">próximamente</h3>
                <?php else: ?>
                <?php foreach ($data['sections'] as $section_index => $section): ?>

                <v-expansion-panel>
                    <v-expansion-panel-header>
                        <v-row no-gutters>
                            <v-col class="d-flex justify-start p-0" cols="10">
                                <?= $section['section_name'] ?>
                            </v-col>
                            <v-col class="d-flex justify-end p-0" cols="2">
                                <?php if (!empty($section['items']) && isset($section['completed']) && $section['completed']): ?>
                                <v-icon color="success">mdi-check-circle</v-icon>
                                <?php endif ?>
                            </v-col>
                        </v-row>
                    </v-expansion-panel-header>
                    <v-expansion-panel-content>
                        <?php foreach ($section['items'] as $lesson_index => $lesson): ?>
                        <v-expansion-panels class="mb-4">
                            <v-expansion-panel>
                                <v-expansion-panel-header>
                                    <v-row no-gutters>
                                        <?php if (!empty($lesson['meta']) && isset($lesson['meta']['class_type']) && $lesson['meta']['class_type'] == 'zoom_meeting'): ?>
                                        <v-col class="p-0 d-flex justify-end" cols="12">
                                            <p class="subtitle-2 secondary--text font-weight-bold">Inicio:
                                                <?= $lesson['meta']['zoom_date'] . ' ' . $lesson['meta']['zoom_time'] . ' ' . $lesson['meta']['zoom_timezone'] ?>
                                            </p>
                                        </v-col>
                                        <?php endif ?>
                                        <v-col class="d-flex justify-start p-0" cols="9" md="8" lg="9">
                                            <?= $lesson['lesson_name'] ?>
                                        </v-col>
                                        <v-col class="d-flex justify-end p-0" cols="12" md="4" lg="3">
                                            <?php if (isset($lesson['completed']) && $lesson['completed']): ?>
                                            <v-icon color="success">mdi-check-circle</v-icon>
                                            <?php endif ?>
                                            <v-btn class="primary--text"
                                                href="<?= SITE_URL ?>/cursuri/<?= $data['course_slug'] ?>/<?= $lesson['lesson_id'] ?>/"
                                                text>
                                                <?php if ($lesson['lesson_type'] == 2): ?>
                                                Ir al quiz
                                                <?php else: ?>
                                                Ir a clase
                                                <?php endif ?>
                                            </v-btn>
                                        </v-col>

                                    </v-row>
                                </v-expansion-panel-header>
                                <v-expansion-panel-content>
                                    <?php if (isset($lesson['meta']['description'])): ?>

                                    <v-col cols="12">
                                        <?= $lesson['meta']['description'] ?>
                                    </v-col>

                                    <?php endif ?>
                                </v-expansion-panel-content>
                            </v-expansion-panel>
                        </v-expansion-panels>

                        <?php endforeach ?>

                    </v-expansion-panel-content>
                </v-expansion-panel>

                <?php endforeach ?>
                <?php endif ?>
            </v-expansion-panels>
        </v-col>
    </v-row>
</v-navigation-drawer>
<v-row class="d-sm-flex justify-center justify-md-start px-md-8 mb-n8">
    <v-btn class="mx-2 mt-4 gradient" fab dark @click="drawer = true">
        <v-icon dark>
            mdi-menu
        </v-icon>
    </v-btn>
</v-row>