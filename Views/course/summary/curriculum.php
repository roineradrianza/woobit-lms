<v-row class="d-flex justify-center">
    <v-col cols="12">
        <v-expansion-panels <?= count($sections) == 1 ? ':mandatory="true"' : '' ?>>
            <?php if (!empty($sections)):?>
            <?php foreach ($sections as $section_index => $section): ?>

            <v-expansion-panel key="<?= $section_index ?>">
                <v-expansion-panel-header>
                    <v-row no-gutters>
                        <v-col class="d-flex justify-start p-0" cols="10">
                            <?= $section['section_name'] ?>
                        </v-col>
                    </v-row>
                </v-expansion-panel-header>
                <v-expansion-panel-content>
                    <v-row>
                        <v-col cols="12" md="3">
                            <p>
                                <v-icon>mdi-calendar</v-icon>
                                <?= Carbon\Carbon::createFromDate($section['start_date'])->locale(APP_LANGUAGE)->isoFormat('dddd, MMMM Do YYYY')?>
                            </p>
                        </v-col>

                        <v-col cols="12" md="3">
                            <p>
                                <v-icon>mdi-calendar-clock</v-icon>
                                <?= \Model\Section::frecuency_text($section['frecuency'], $section['classes']) ?>
                            </p>
                        </v-col>

                        <v-col cols="12" md="3">
                            <p>
                                <v-icon>mdi-clock</v-icon>
                                <?= "{$section['start_time']} - {$section['end_time']}" ?>
                            </p>
                        </v-col>
                    </v-row>
                    <?php foreach ($section['items'] as $lesson_index => $lesson): ?>
                    <v-expansion-panels class="mb-4">
                        <v-expansion-panel>
                            <v-expansion-panel-header>
                                <v-row no-gutters>
                                    <v-col class="p-0 mb-n2 d-flex justify-end" cols="12">
                                        <p class="subtitle-2 secondary--text font-weight-bold">Data cursului:
                                            <?= $lesson['meta']['zoom_date'] . ' ' . $lesson['meta']['zoom_time'] . ' ' . $lesson['meta']['zoom_timezone'] ?>
                                        </p>
                                    </v-col>
                                    <v-col class="d-flex justify-start p-0" cols="9">
                                        <?= $lesson['lesson_name'] ?>
                                    </v-col>
                                    <v-col class="d-flex justify-end p-0" cols="12" md="3">
                                        <v-btn class="primary--text"
                                            href="<?= SITE_URL ?>/cursuri/<?= $data['course_slug'] ?>/<?= $lesson['lesson_id'] ?>/"
                                            text>
                                                INTRĂ ÎN CLASSROM
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