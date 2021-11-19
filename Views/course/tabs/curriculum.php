<v-row class="d-flex justify-center">
    <v-col cols="12" md="10">
        <v-expansion-panels <?= count($sections) == 1 ? ':mandatory="true"' : '' ?> >
            <?php if (empty($sections)):?>
            <h3 class="text-center text-uppercase">próximamente</h3>
            <?php else: ?>
            <?php foreach ($sections as $section_index => $section): ?>

            <v-expansion-panel key="<?= $section_index ?>">
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
                                    <v-col class="d-flex justify-start p-0" cols="9">
                                        <?= $lesson['lesson_name'] ?>
                                    </v-col>
                                    <v-col class="d-flex justify-end p-0" cols="12" md="3">
                                        <?php if (isset($lesson['completed']) && $lesson['completed']): ?>
                                        <v-icon color="success">mdi-check-circle</v-icon>
                                        <?php endif ?>
                                        <?php if ($data['current_user_has_enroll'] || $data['manage_course']): ?>
                                        <v-btn class="primary--text"
                                            href="<?= SITE_URL ?>/courses/<?= $data['course_slug'] ?>/<?= $lesson['lesson_id'] ?>/"
                                            text>
                                            <?php if ($lesson['lesson_type'] == 2): ?>
                                            Ir al quiz
                                            <?php else: ?>
                                            Ir a clase
                                            <?php endif ?>
                                        </v-btn>
                                        <?php endif ?>
                                        <?php if (empty($_SESSION['user_id'])): ?>
                                        <v-btn class="primary--text"
                                            href="<?= SITE_URL ?>/login/?redirect_url=<?= SITE_URL ?>/courses/<?= $data['course_slug'] ?>/<?= $lesson['lesson_id'] ?>/"
                                            text>Iniciar Sesión</v-btn>
                                        <?php endif ?>
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
                            <?php if (!empty($lesson['teacher'])): ?>

                            <v-col cols="12">
                                <v-row class="d-flex justify-end align-center px-10">

                                    <v-avatar color="primary" class="mr-2">
                                        <?php if (!empty($lesson['teacher']['avatar'])): ?>
                                        <v-img src="<?= $lesson['teacher']['avatar'] ?>"></v-img>
                                        <?php else: ?>
                                        <v-icon dark>
                                            mdi-account-circle
                                        </v-icon>
                                        <?php endif ?>
                                    </v-avatar>


                                    <?= $lesson['teacher']['first_name'] . ' ' . $lesson['teacher']['last_name'] ?>
                                </v-row>
                            </v-col>

                            <?php endif ?>
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