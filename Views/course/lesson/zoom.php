<v-row ref="lesson_container" class="pb-16 d-flex align-center" data-course-id="<?= $course['course_id'] ?>" style="min-height: 83vh">
    <?= new Controller\Template('course/lesson/partials/select-child', ['students_enrolled' => $course['students_enrolled']]) ?>
    <?= new Controller\Template('course/lesson/zoom/content', $data) ?>
    <?php /* new Controller\Template('course/parts/footer', [ 'course' => $course, 'curriculum' => $curriculum]) */ ?>
</v-row>