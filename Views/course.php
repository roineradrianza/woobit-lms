<v-container class="px-8 px-md-0">
    <v-row course_id="<?= $course_id ?>" ref="course_container">
        <v-row>
            <v-col cols="12" md="6">
                <v-row>
                    <v-col cols="12">
                        <span
                            class="font-weight-light text-h6"><?= !empty($data['category'][0]['name']) ? $data['category'][0]['name'] : '' ?></span>
                        <h1 class="text-h3 font-weight-light">
                            <?= $title ?>
                        </h1>
                    </v-col>

                    <?php if (!empty($meta['description'])): ?>
                    <v-col class="ql-editor" cols="12" md="9">
                        <?= $meta['description'] ?>
                    </v-col>
                    <?php endif?>

                    <?= new Controller\Template('course/summary/instructor', $instructor) ?>
                    <v-col cols="12">
                        <p class="primary--text">
                            <v-icon class="mr-2" color="primary">mdi-tag</v-icon>Pret total: <span
                                class="font-weight-light black--text"><?= $price ?> RON per cursant</span>
                        </p>
                        <p class="primary--text">
                            <v-icon class="mr-2" color="primary">mdi-clock</v-icon>Durata: <span
                                class="font-weight-light black--text"><?= $duration ?></span>
                        </p>
                        <p class="primary--text">
                            <v-icon class="mr-2" color="primary">mdi-calendar</v-icon>Cursuri: <span
                                class="font-weight-light black--text"><?= $classes['total'] ?></span>
                        </p>
                        <p class="primary--text">
                            <v-icon class="mr-2" color="primary">mdi-account-group</v-icon>Numar de cursanti: <span
                                class="font-weight-light black--text">1 - 10</span>
                        </p>
                        <p class="primary--text">
                            <v-icon class="mr-2" color="primary">mdi-cake</v-icon>Varsta: <span
                                class="font-weight-light black--text">10 - 15</span>
                        </p>
                    </v-col>

                </v-row>
            </v-col>
            <v-col cols="12" md="6">
                <v-row>
                    <v-col cols="12">
                        <img src="<?= $featured_image ?>" width="100%"></img>
                    </v-col>
                    <v-col class="px-0" cols="12">
                        <?php // new Controller\Template('course/summary/enrollment', $data) ?>
                    </v-col>
                </v-row>
            </v-col>
            <?php if(!empty($meta['long_description'])) ?>
            <v-col class="quill-editor" cols="12">
                <?= $meta['long_description'] ?>
            </v-col>
            <?php if(!empty($current_user_has_enroll) || $manage_course) : ?>
            <v-col cols="12">
                <?=
                new Controller\Template('course/summary/curriculum', [
                    'course_slug' => $course_slug,
                    'sections' => empty($manage_course) ? $sections_student_listed : $sections
                ]) 
            ?>
            </v-col>
            <v-col cols="12">
                <v-divider></v-divider>
            </v-col>
            <?php endif ?>
            <v-col cols="12">
                <?= new Controller\Template('course/summary/editions', $data) ?>
            </v-col>
            <v-col cols="12">
                <v-divider></v-divider>
            </v-col>
            <v-col cols="12">
                <?= new Controller\Template('course/summary/instructor-info', $instructor) ?>
            </v-col>
            <v-col cols="12">
                <v-divider></v-divider>
            </v-col>
            <?php if(!empty($instructor['courses'])) : ?>
            <v-col cols="12">
                <h3 class="text-h4 text-center font-weight-light">
                    Alte cursuri oferite de <?= "{$instructor['first_name']} {$instructor['last_name']}"  ?>
                </h3>
            </v-col>
            <v-col cols="12">
                <v-container>
                    <v-row justify="center">
                        <?php foreach ($instructor['courses'] as $course) : ?>
                        <?php $course['category'] = !empty($course['category']) ? $course['category'][0]['name'] : '' ?>
                        <v-col class="d-flex" cols="12" md="4" lg="3">
                            <?= new Controller\Template('courses/course_template', $course) ?>
                        </v-col>
                        <?php endforeach ?>
                    </v-row>
                </v-container>
            </v-col>
            <v-col cols="12">
                <v-divider></v-divider>
            </v-col>
            <?php endif?>
            <?= new Controller\Template('course/summary/popular-categories', $data) ?>
            <v-col cols="12">
                <v-divider></v-divider>
            </v-col>
            <?= new Controller\Template('course/summary/popular-courses', 
                [
                    'category' => !empty($category[0]['name']) ? $category[0]['name'] : '',
                ]
            ) ?>
        </v-row>
    </v-row>
</v-container>