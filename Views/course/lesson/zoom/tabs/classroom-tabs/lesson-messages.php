<v-col class="px-6" cols="12">
    <?=new Controller\Template('components/snackbar',
        [
            'snackbar' => 'lesson_messages.snackbar',
            'snackbar_timeout' => 'lesson_messages.snackbar_timeout',
            'snackbar_text' => 'lesson_messages.snackbar_text'
        ]
    )
    ?>
    <?php if ($course['manage_course']) : ?>
        <?= new Controller\Template('course/lesson/zoom/tabs/classroom-tabs/lesson-messages/dialog', $data) ?>
        <?= new Controller\Template('course/lesson/zoom/tabs/classroom-tabs/lesson-messages/delete-dialog', $data) ?>
    <?php endif ?>
    <v-row>
        <v-col cols="12">
            <h3 class="text-h5">Mesajele profesorului</h3>
            <v-divider></v-divider>
        </v-col>
        <?php if ($course['manage_course']) : ?>
        <v-container fluid>

            <v-form ref="teacher_message_form">

                <v-row>

                    <v-col cols="12">
                        <label class="body-1">Adăugați unul nou</label>
                        <vue-editor id="lesson_message_editor" v-model="lesson_messages.message.message" class="white mt-3"
                            :editor-toolbar="customToolbar" placeholder="Descrierea clasei" />
                    </v-col>

                    <v-col cols="12">
                        <v-btn color="primary" @click="lesson_messages.save()" :loading="lesson_messages.loading">
                            Postează un mesaj
                        </v-btn>
                    </v-col>

                </v-row>

            </v-form>

        </v-container>

        <?php endif ?>
    </v-row>
</v-col>
<v-col class="px-6" cols="12" v-if="lesson_messages.items_loading">
    <v-skeleton-loader class="mt-8" type="list-item-avatar, divider, list-item-three-line" v-for="i in 3" :key="i">
    </v-skeleton-loader>
</v-col>
<v-col cols="12" v-else>
    <v-row>
        <v-col cols="12">
            <v-list class="pt-3 pb-9" color="transparent" two-line>
                <template v-for="(message, index) in lesson_messages.items">

                    <v-list-item :key="index">
                        <v-list-item-avatar color="primary" size="50">
                            <v-img src="<?= $course['instructor']['avatar'] ?>">
                            </v-img>
                        </v-list-item-avatar>

                        <v-list-item-content>
                            <v-list-item-title class="no-white-space">
                                <?= "{$course['instructor']['first_name']} {$course['instructor']['last_name']}" ?>
                            </v-list-item-title>
                            <v-list-item-subtitle>{{ lesson_messages.fromNow(message.created_at) }}</v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>

                    <?php if ($course['manage_course']) : ?>
                    <div class="d-flex justify-end mt-n4 pl-4">
                        <v-btn color="success" @click="lesson_messages.editDialog(message)" icon>
                            <v-icon>mdi-pencil</v-icon>
                        </v-btn>
                        <v-btn color="error" @click="lesson_messages.deleteDialog(message)" icon>
                            <v-icon>mdi-trash-can</v-icon>
                        </v-btn>
                    </div>
                    <?php endif ?>

                    <div class="quill-editor pl-4 pb-2" v-html="message.message">

                    </div>

                    <v-divider></v-divider>

                </template>
            </v-list>
        </v-col>
    </v-row>
</v-col>