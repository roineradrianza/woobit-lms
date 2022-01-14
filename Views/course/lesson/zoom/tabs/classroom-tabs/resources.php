<v-col class="px-6" cols="12">
    <v-row>
        <v-col cols="12">
            <h3 class="text-h5">Materiale de clasă</h3>
            <v-divider></v-divider>
        </v-col>
    </v-row>
    <?= new Controller\Template('course/lesson/zoom/tabs/classroom-tabs/resources/preview') ?>
    <v-col class="d-flex align-end px-0" cols="12" md="4">
        <v-btn color="primary"
            @click="resources.unshift({name: '', preview_only: '0', edit: true, file: undefined, url: '', loading: false, percent_loading_active: false, percent_loading: 0})"
            block dark>Adăugați material</v-btn>
    </v-col>
    <v-row>
        <template v-for="resource, index in resources">
            <v-col cols="12" md="6">
                <template v-if="!resource.edit">
                    <?= new Controller\Template('course/lesson/zoom/tabs/classroom-tabs/resources/show', 
                        [
                            'show_edit_btns' => true,
                            'manage_course' => $course['manage_course']
                        ]
                    ) ?>
                </template>
                <?php if($course['manage_course']): ?>
                <template v-else>
                    <?= new Controller\Template('course/lesson/zoom/tabs/classroom-tabs/resources/edit') ?>
                </template>
                <?php endif ?>
            </v-col>
        </template>
    </v-row>
</v-col>