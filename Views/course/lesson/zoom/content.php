<?php if($course['manage_course']): ?>
<v-col ref="alert_lesson_status" cols="12" initial-status="<?= $lesson['lesson_status'] ?>">
    <v-alert prominent :type="getLessonStatusColor()">
        <v-row align="center">
            <v-col class="grow">
                <template v-if="lesson_status == 2">
                    Această clasă este în curs de revizuire
                </template>
                <template v-if="lesson_status == 1">
                    Acest curs este aprobat în prezent.
                </template>
                <template v-if="lesson_status == 0">
                    Această clasă nu este aprobată în prezent
                </template>
            </v-col>

            <?php if($_SESSION['user_type'] == 'administrator'): ?>

            <v-col class="shrink">
                <v-btn class="white success--text" @click="updateLessonStatus('1')" v-if="lesson_status == 2" :loading="lesson_status_loading">Aprobați</v-btn>
                <v-btn class="white warning--text" @click="updateLessonStatus('2')" v-if="lesson_status == 1" :loading="lesson_status_loading">Pus sub revizuire</v-btn>
                <v-btn class="white success--text" @click="updateLessonStatus('1')" v-if="lesson_status == 0" :loading="lesson_status_loading">Aprobați</v-btn>
            </v-col>
            <v-col class="shrink">
                <v-btn class="white error--text" @click="updateLessonStatus('0')" v-if="lesson_status == 2" :loading="lesson_status_loading">Dezaprobă</v-btn>
                <v-btn class="white error--text" @click="updateLessonStatus('0')"  v-if="lesson_status == 1" :loading="lesson_status_loading">Dezaprobă</v-btn>
                <v-btn class="white warning--text" @click="updateLessonStatus('2')" v-if="lesson_status == 0" :loading="lesson_status_loading">Pus sub revizuire</v-btn>
            </v-col>

            <?php endif?>

        </v-row>
    </v-alert>
</v-col>

<?php endif ?>

<v-sheet color="secondary" min-width="100%">
    <v-container>
        <v-row align="center">
            <v-col cols="12" md="9">
                <h4 class="text-h5 white--text"><?= $course['title'] ?></h4>
                <h3 class="text-h4 white--text font-weight-bold"><?= $lesson['lesson_name'] ?></h4>
            </v-col>
            <v-col cols="12" md="3">
                <v-img src="<?= SITE_URL . "{$course['featured_image']}" ?>"></v-img>
            </v-col>
        </v-row>
    </v-container>
</v-sheet>

<v-container fluid>
    <?= new Controller\Template('course/parts/lesson_menu', [
        'course_slug' => $course['slug'], 
        'sections' => $course['manage_course'] ? $course['sections'] : $course['sections_student_listed']
        ]) 
    ?>
</v-container>

<v-container class="px-4 px-md-0">
    <?= new Controller\Template('components/snackbar') ?>
    <v-col class="lesson" cols="12">
        <v-row>
            <v-col class="px-0 pr-md-4" cols="12" md="8">
                <v-card class="grey lighten-4" style="overflow-wrap: normal;" flat>
                    <v-tabs ref="tabs_section" background-color="transparent" fixed-tabs centered show-arrows>

                        <v-tab href="#overview">Rezumat</v-tab>

                        <v-tab href="#classroom">Sala de clasă</v-tab>

                        <v-tab href="#instructor">Lectori</v-tab>


                        <v-tab-item class="grey lighten-4" value="overview">
                            <?= new Controller\Template('course/lesson/zoom/tabs/overview', $data) ?>
                        </v-tab-item>

                        <v-tab-item class="grey lighten-4" value="classroom">
                            <?= new Controller\Template('course/lesson/zoom/tabs/classroom', $data) ?>
                        </v-tab-item>

                        <v-tab-item class="grey lighten-4" value="instructor">
                            <?= new Controller\Template('course/lesson/zoom/tabs/instructor', 
                                    [
                                        'instructor' => $course['instructor'],
                                        'manage_course' => $course['manage_course']
                                    ]
                                ) 
                            ?>
                        </v-tab-item>
                    </v-tabs>

                </v-card>

            </v-col>
            <v-col cols="12" md="4">
                <v-row>
                    <?= new Controller\Template('course/lesson/partials/sidebar', $data) ?>
                </v-row>
            </v-col>
        </v-row>
    </v-col>
    <?= new Controller\Template('course/parts/resources/preview') ?>
</v-container>