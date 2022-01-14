<v-col cols="12">
    <?php if(empty($hideAddButton)): ?>
    <v-col class="d-flex align-end px-0" cols="12" md="4">
        <v-btn color="primary"
            @click="lesson_materials_sent.unshift({name: '', sender: '<?= $sender ?>', edit: true, file: undefined, url: '', loading: false, percent_loading_active: false, percent_loading: 0})"
            block dark>Adăugați material</v-btn>
    </v-col>
    <?php endif ?>
    <v-row>
        <template v-for="resource, index in lesson_materials_sent">
            <v-col cols="12" md="6" v-if="resource.sender != '<?= $excluded_sender?>'">
                <template v-if="!resource.edit">
                    <?= new Controller\Template('course/lesson/zoom/tabs/instructor/show', 
                        [
                            'canEdit' => !empty($canEdit) ? $canEdit : false,
                            'excluded_sender' => $excluded_sender
                        ]
                    ) ?>
                </template>
                <?php if(!empty($canEdit)): ?>
                <template v-else>
                    <?= new Controller\Template('course/lesson/zoom/tabs/instructor/edit', [
                        'child_id' => $child_id
                    ]) ?>
                </template>
                <?php endif ?>
            </v-col>
        </template>
    </v-row>
</v-col>