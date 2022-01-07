<v-row justify="center">
    <v-col cols="12">
        <h3 class="text-h4 text-center">Orarul cursului:</h3>
    </v-col>
    <?php foreach($sections as $section): ?>
    <v-col class="d-flex" cols="12" md="3">
        <v-card class="flex-grow-1">
            <v-card-title class="headline no-word-break text-center justify-center" primary-title>
                <?= Carbon\Carbon::createFromDate($section['start_date'])->locale(APP_LANGUAGE)->isoFormat('dddd, MMMM Do YYYY')?>
            </v-card-title>
            <v-card-text>
                <v-list-item>
                    <v-list-item-content>
                        <v-list-item-title class="text-center no-white-space">
                            <?= \Model\Section::frecuency_text($section['frecuency'], $section['classes']) ?>
                        </v-list-item-title>
                    </v-list-item-content>
                </v-list-item>

                <v-list-item>
                    <v-list-item-content>
                        <v-list-item-title class="text-center">
                            <?= "{$section['start_time']} - {$section['end_time']}" ?></v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-card-text>
            <v-card-actions class="d-flex justify-center">
                <v-btn class="py-6 px-6" color="primary" href="<?= SITE_URL ?>/checkout/get?<?= "course_id=${course_id}&course=${title}&section={$section['section_id']}" ?>" block>Înscrie-te!</v-btn>
            </v-card-actions>
        </v-card>
    </v-col>
    <?php endforeach ?>
</v-row>