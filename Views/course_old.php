<v-row course_id="<?= $course_id ?>" ref="course_container">
    <?php if (!empty($current_user_has_enroll) && empty($_COOKIE["modalv1_course_${data['course_id']}"])): ?>
    <?= new Controller\Template('course/parts/enrollment_successful', $data) ?>
    <?php endif?>
    <v-col class="course-details" cols="12">
        <?php if (isset($manage_course) && $manage_course): ?>
        <v-btn class="primary white--text" href="<?= SITE_URL ?>/courses/edit/<?= $course_id ?>" block>
            Editar curso</v-btn>
        <?php endif?>
        <v-img class="grey darken-3 <?php if (!isset($meta['title_off']) || $meta['title_off'] !== '1') {echo "overlay-img";}
;?> d-flex align-center" src="<?= $featured_image ?>" width="100%"
            <?php if (isset($meta['image_size_type']) && intval($meta['image_size_type'])): ?> <?php else: ?>
            max-height="60vw" <?php endif;?>>
            <v-col class="px-16 mt-n16" cols="10" md="7">
                <?php if (!isset($meta['title_off']) || $meta['title_off'] !== '1'): ?>
                <h3 class="mt-md-16 text-md-h1 text-sm-h3 white--text category"><?= $title ?></h3>
                <?php endif;?>
            </v-col>
        </v-img>
        <v-tabs class="course-tabs border-top" v-model="course_tab" fixed-tabs centered show-arrows ref="tabs_section">
            <v-tab class="pt-6 white--text font-weight-light" href="#description">Descriere</v-tab>

            <?php if (!empty($instructors)): ?>
            <v-tab class="pt-6 white--text font-weight-light" href="#instructors">Profesori</v-tab>
            <?php endif?>

            <v-tab class="pt-6 white--text font-weight-light" style="text-transform: initial !important;"
                href="#curriculum">Intrarea în clasă</v-tab>

            <?php if (isset($meta['faq'])): ?>
            <v-tab class="pt-6 white--text font-weight-light" href="#faq">FAQ</v-tab>
            <?php endif?>

            <?php if (isset($manage_course) && $manage_course): ?>
            <v-tab class="pt-6 white--text font-weight-light" href="#list" @click="getCourseTotalViews">Lista
            </v-tab>
            <?php endif?>

            <v-tab class="pt-6 white--text font-weight-light" href="#certified"
                <?php if (!empty($current_user_has_enroll)): ?> @click="initializeCourseProgress" <?php endif ?>>
                Certificat</v-tab>

            <v-tab class="pt-6 white--text font-weight-light" href="#comments">Comentarii</v-tab>

            <v-tab-item class="px-14 pt-5 description-container ql-editor fl-background" value="description">
                <v-row class="d-flex justify-center">
                    <v-col class="p-0" cols="8" md="2">
                        <v-img src="<?= SITE_URL ?>/img/full-learning-logo.png"></v-img>
                    </v-col>
                </v-row>
                <v-img></v-img>
                <?php if (!empty($meta['description'])): ?>
                <?= $meta['description'] ?>
                <?php endif?>
            </v-tab-item>

            <?php if (!empty($instructors)): ?>
            <v-tab-item class="px-14 py-10" value="instructors">
                <?= new Controller\Template('course/tabs/instructors', $instructors) ?>
            </v-tab-item>
            <?php endif?>

            <v-tab-item class="px-14 py-10" value="curriculum">
                <?= new Controller\Template('course/tabs/curriculum', [
                    'course_slug' => $data['slug'],
                    'current_user_has_enroll' => !empty($current_user_has_enroll) ? $current_user_has_enroll : false,
                    'manage_course' => !empty($manage_course) ? $manage_course : false,
                    'sections' => $data['sections'],
                ]) ?>
            </v-tab-item>

            <?php if (isset($meta['faq'])): ?>
            <v-tab-item class="px-14 py-10" value="faq">
                <?= new Controller\Template('course/tabs/FAQ', json_decode($meta['faq'], true)) ?>
            </v-tab-item>
            <?php endif?>

            <?php if (isset($manage_course) && $manage_course): ?>
            <v-tab-item class="px-14 py-10" value="list">
                <?= new Controller\Template('course/tabs/list') ?>
            </v-tab-item>
            <?php endif?>

            <v-tab-item class="px-14 py-10" value="certified">
                <?= new Controller\Template('course/tabs/certified', $data) ?>
            </v-tab-item>

            <v-tab-item class="px-14 py-10" value="comments">
                <?= new Controller\Template('course/tabs/comments') ?>
            </v-tab-item>

        </v-tabs>
        <v-sheet class="gradient" height="2vw"></v-sheet>
    </v-col>
    <?= new Controller\Template('course/parts/sidebar', $data) ?>
</v-row>