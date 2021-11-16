<?php echo new Controller\Template('course/parts/lesson_menu', [
'course_slug' => $course['slug'], 
'sections' => $course['sections']
]) 
?>
<v-row class="px-md-6 pb-16">
    <?php if (isset($lesson['lesson_active']['lesson_meta_val']) && intval($lesson['lesson_active']['lesson_meta_val']) == 0): ?>
    <?php echo new Controller\Template('course/parts/inactive_lesson', $data) ?>
    <?php else: ?>
    <?php echo new Controller\Template('course/parts/course_approved', $data['course']) ?>
    <?php echo new Controller\Template('course/parts/lesson_quiz_content', $data) ?>
    <?php endif ?>
    <?php echo new Controller\Template('course/parts/footer', [ 'course' => $data['course'], 'curriculum' => $data['curriculum']]) ?>
</v-row>