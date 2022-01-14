<v-col cols="12">
    <v-row>
        <v-col class="d-flex justify-start align-center" cols="6">
            <?php if (!empty($data['curriculum']['prev_lesson'])): ?>
            <a
                :href="'<?= SITE_URL ?>/cursuri/<?= $data['course']['slug'] ?>/<?= $data['curriculum']['prev_lesson']['lesson_id'] ?>' +
				(child_profile.child_id != null ? '/selected?child_id=' + child_profile.child_id : '')">
                <h4 class="text-h5 primary--text">
                    <v-icon color="primary" x-large>mdi-arrow-left</v-icon>
                    <?= $data['curriculum']['prev_lesson']['lesson_name'] ?>
                </h4>
            </a>
            <?php endif ?>
        </v-col>
        <v-col class="d-flex justify-end align-center" cols="6">
            <?php if (!empty($data['curriculum']['next_lesson'])): ?>
            <a
                :href="'<?= SITE_URL ?>/cursuri/<?= $data['course']['slug'] ?>/<?= $data['curriculum']['next_lesson']['lesson_id'] ?>' +
				(child_profile.child_id != null ? '/selected?child_id=' + child_profile.child_id : '')">
                <h4 class="text-h5 secondary--text"><?= $data['curriculum']['next_lesson']['lesson_name'] ?> <v-icon
                        color="secondary" x-large>mdi-arrow-right</v-icon>
                </h4>
            </a>
            <?php endif ?>
        </v-col>
    </v-row>
</v-col>