<v-row class="px-6 pb-16 d-flex align-center" style="min-height: 83vh">
    <?= new Controller\Template('course/parts/course_approved', $data['course']) ?>
    <?= new Controller\Template('course/parts/lesson_zoom_content', $data) ?>
    <?= new Controller\Template('course/parts/footer', [ 'course' => $data['course'], 'curriculum' => $data['curriculum']]) ?>
</v-row>