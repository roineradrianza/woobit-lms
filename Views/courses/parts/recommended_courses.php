<v-row class="px-md-16">
    <v-col class="pr-12 mb-n8" cols="12">
        <h3 class="text-h4 grey--text mb-6">Cursuri publicate recent</h3>
        <v-divider></v-divider>
    </v-col>
    <?php foreach ($data as $course): ?>
    <v-col cols="12" md="4" sm="12" class="d-flex">
        <?= new Controller\Template('courses/course_template', $course) ?>
    </v-col>
    <?php endforeach ?>
</v-row>