<?= new Controller\Template('course/parts/lesson_menu', [
'course_slug' => $course['slug'], 
'sections' => $course['sections']
]) 
?>
<v-row class="px-md-6 pb-16">
    <?= new Controller\Template('course/parts/course_approved', $data['course']) ?>
    <?= new Controller\Template('course/parts/lesson_video_content', $data) ?>
    <?= new Controller\Template('course/parts/lesson_sidebar', $data) ?>
    <?= new Controller\Template('course/parts/footer', [ 'course' => $data['course'], 'curriculum' => $data['curriculum']]) ?>
</v-row>