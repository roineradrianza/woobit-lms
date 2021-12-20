<v-row class="px-md-16 d-flex justify-center">
    <?php foreach ($data as $course): ?>
    <v-col cols="12" md="4" sm="12">
        <?= new Controller\Template('courses/course_template', $course) ?>
    </v-col>
    <?php endforeach ?>
</v-row>