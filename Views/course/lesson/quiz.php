<?= new Controller\Template('course/parts/lesson_menu', [
'course_slug' => $course['slug'], 
'sections' => $course['sections']
]) 
?>
<v-row class="px-md-6 pb-16">
    <?php if (isset($lesson['lesson_active']['lesson_meta_val']) && intval($lesson['lesson_active']['lesson_meta_val']) == 0): ?>
    <?= new Controller\Template('course/parts/inactive_lesson', $data) ?>
    <?php else: ?>
    <?= new Controller\Template('course/parts/course_approved', $data['course']) ?>
    <?= new Controller\Template('course/parts/lesson_quiz_content', $data) ?>
    <?php endif ?>
    <?= new Controller\Template('course/parts/footer', [ 'course' => $data['course'], 'curriculum' => $data['curriculum']]) ?>
</v-row>