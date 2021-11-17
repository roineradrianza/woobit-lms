<v-container class="px-8 px-md-0">
    <v-row course_id="<?php echo $course_id ?>" ref="course_container">
        <?php if (!empty($current_user_has_enroll) && empty($_COOKIE["modalv1_course_${data['course_id']}"])): ?>
        <?php echo new Controller\Template('course/parts/enrollment_successful', $data) ?>
        <?php endif?>
        <v-row>
            <v-col cols="12" md="6">
                <v-row>
                    <v-col cols="12">
                        <span class="font-weight-light text-h6"><?php echo $data['category'][0]['name'] ?></span>
                        <h1 class="text-h3 font-weight-light">
                            <?php echo $title ?>
                        </h1>
                    </v-col>
                    <?php echo new Controller\Template('course/summary/instructor', $instructor) ?>
                    <v-col cols="12">
                        <p class="primary--text">
                            <v-icon class="mr-2" color="primary">mdi-tag</v-icon>Pret total: <span
                                class="font-weight-light black--text"><?php echo $price ?> RON per cursant</span>
                        </p>
                        <p class="primary--text">
                            <v-icon class="mr-2" color="primary">mdi-clock</v-icon>Durata: <span
                                class="font-weight-light black--text"><?php echo $duration ?></span>
                        </p>
                        <p class="primary--text">
                            <v-icon class="mr-2" color="primary">mdi-calendar</v-icon>Cursuri: <span
                                class="font-weight-light black--text"><?php echo $classes['total'] ?></span>
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
                    <?php if (!empty($meta['description'])): ?>
                    <v-col class="ql-editor" cols="12" md="9">
                        <?php echo $meta['description'] ?>
                    </v-col>
                    <?php endif?>

                </v-row>
            </v-col>
            <v-col cols="12" md="6">
                <v-row>
                    <v-col cols="12">
                        <img src="<?php echo $featured_image ?>" width="100%"></img>
                    </v-col>
                    <v-col class="px-0" cols="12">
                        <?php echo new Controller\Template('course/summary/enrollment', $data) ?>
                    </v-col>
                </v-row>
            </v-col>
            <v-col cols="12">
                <h3 class="text-h4 text-center font-weight-light">
                    Alte cursuri oferite de <?php echo "{$instructor['first_name']} {$instructor['last_name']}"  ?>
                </h3>
            </v-col>
            <v-col cols="12">
                <v-row justify="center">
                    <?php for ($i=0; $i < 3; $i++) : ?>
                        <v-col class="px-md-4 px-lg-8" cols="12" md="4" lg="3">
                            <?php echo new Controller\Template('courses/course_template') ?>
                        </v-col>
                    <?php endfor ?>
                </v-row>
            </v-col>
        </v-row>
    </v-row>
</v-container>