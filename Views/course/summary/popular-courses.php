<?php if(!empty($popular_courses)) : ?>
<v-col cols="12">
    <v-container>
        <v-row>
            <v-col cols="12">
                <h3 class="text-h4 text-center">
                    Cursuri de <?= !empty($category[0]['name']) ? $category[0]['name'] : '' ?> populare
                </h3>
            </v-col>
        </v-row>
        <v-row justify="center">
            <?php foreach ($popular_courses as $course) : ?>
            <?php $course['category'] = !empty($course['category']) ? $course['category'][0]['name'] : '' ?>
            <v-col class="d-flex" cols="12" md="4" lg="3">
                <?= new Controller\Template('courses/course_template', $course) ?>
            </v-col>
            <?php endforeach ?>
        </v-row>
    </v-container>
</v-col>
<?php endif ?>