<v-row class="px-md-16">
    <v-col class="pr-12 mb-n8" cols="12">
        <h3 class="text-h4 grey--text mb-6">Recomendados para ti</h3>
        <v-divider></v-divider>
    </v-col>
    <?php foreach ($data as $course): ?>
    <v-col cols="12" md="4" sm="12" class="d-flex">
        <v-card :loading="loading" class="my-12 course-card flex-grow-1"
            href="<?= SITE_URL . '/courses/' . $course['slug'] ?>" max-width="95%">

            <v-img width="100vw" height="27vh" class="align-end" src="<?= $course['featured_image'] ?>">
                <v-card-title class="category-label float-left mb-6 font-weight-bold">
                    <?= $course['category'] ?>
                </v-card-title>
            </v-img>

            <v-card-title class="text-h6 font-weight-normal no-word-break"><?= $course['title'] ?></v-card-title>

            <v-card-text class="grey--text text--lighten-1">
                <?php if (!empty($course['description'])): ?>
                <div class="truncate-overflow mb-0"><?= $course['description'] ?></div>
                <?php endif ?>
                <?php if (!empty($course['total_enrolled'])): ?>
                <div class="d-block">
                    <v-icon class="grey--text text--lighten-1">mdi-account</v-icon>
                    <?= $course['total_enrolled'] ?>
                </div>
                <?php endif ?>
                <v-chip class="secondary mt-2" dark>
                    <?php if (!empty($course['price'])): ?>
                    <?= '$ ' . $course['price'] . ' USD'?>
                    <?php else: ?>
                    GRATIS
                    <?php endif ?>
                </v-chip>
            </v-card-text>

            <v-divider class="mx-4"></v-divider>

            <v-card-text class="pb-md-10 pb-lg-5">
                <?php if (empty($course['hide_avatar_preview']) ) : ?>
                <v-avatar class="teacher-course-avatar">
                    <?php if ($course['platform_owner']): ?>
                    <img src="<?= SITE_URL ?>/img/avatar-logo.png" width="20px" height="20px" alt="FL">
                    <?php else: ?>
                    <img src="<?= $course['avatar'] ?>" width="20px" height="20px"
                        alt="<?= $course['full_name'] ?>">
                    <?php endif?>
                </v-avatar>
                <?php if ($course['platform_owner']) : ?>
                <span class="subtitle-2 font-weight-bold">Full Learning</span class="subtitle-2 text-primary">
                <?php else: ?>
                <span class="font-weight-normal">Por </span><span class="subtitle-2 font-weight-bold">
                    <?= $course['full_name'] ?></span class="subtitle-2 text-primary">
                <?php endif?>
                <?php else: ?>
                <?php if(!empty($course['certified_by'])) : ?>
                <p class="text-center">Certificado por:</p>
                <v-col class="d-flex justify-center mt-n6" cols="12">
                    <?php foreach (json_decode($course['certified_by'], true) as $certified_by): ?>
                    <img src="<?= $certified_by['url'] ?>" style="max-width: 100%"></img>
                    <?php endforeach ?>
                </v-col>
                <?php endif ?>
                <?php endif?>
            </v-card-text>
        </v-card>
    </v-col>
    <?php endforeach ?>
</v-row>