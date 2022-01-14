<v-col class="px-6" cols="12">
    <v-row class="pb-4">
        <v-col cols="12">
            <h3 class="text-h5">Întrebări</h3>
            <v-divider></v-divider>
        </v-col>
    </v-row>
    
    <?php if (empty($course['manage_course'])) : ?>
    <template v-if="child_profile.child_selected.hasOwnProperty('user_id')">
        <label class="body-1 pl-1">Lasă întrebarea ta</label>
        <vue-editor id="question_editor" class="mt-3 bg-white" v-model="comment" :editor-toolbar="customToolbar"
            placeholder="Scrieți întrebarea dvs. aici"></vue-editor>
        <v-btn class="primary white--text my-4" @click="saveComment('question')" :disabled="canPost"
            :loading="send_comment_loading">Publică</v-btn>
    </template>
    <?php endif ?>

    <template v-if="recent_questions.length > 0">
        <v-col cols="12">
            <h4 class="text-h5 mb-2">Întrebări tocmai postate de dumneavoastră:</h4>
            <v-sheet class="mb-6" elevation="2" rounded class="mx-auto" v-for="item in recent_questions"
                v-if="item.comment_type == 'question'">
                <v-col class="px-4" cols="12">
                    <v-avatar size="50">
                        <v-img :src="item.avatar" v-if="null != item.avatar"></v-img>
                        <v-icon color="primary" size="50px" v-else>mdi-account-circle</v-icon>
                    </v-avatar>
                    <span class="primary--text">{{ getFullName(item) }}</span>
                    <div class="mt-4" v-html="item.comment">
                    </div>
                    <v-row class="d-flex align-center">
                        <v-col class="d-flex justify-start primary--text" cols="6">
                            {{ fromNow(item.published_at) }}
                        </v-col>
                        <v-col class="d-flex justify-end" cols="6">
                            <template v-if="item.editable">
                                <v-btn color="primary" @click="item.edit_comment_box = true" text>
                                    <v-icon>mdi-pencil</v-icon>
                                </v-btn>
                                <v-btn color="red" @click="deleteComment(item)" text>
                                    <v-icon>mdi-trash-can</v-icon>
                                </v-btn>
                            </template>
                        </v-col>
                        <v-row class="px-8">
                            <v-col cols="12" v-if="item.edit_comment_box == true">
                                <vue-editor :id="'question_edit_editor' + item.lesson_comment_id" class="mt-3"
                                    v-model="item.edited_comment" :editor-toolbar="toolbar"
                                    placeholder="Scrieți întrebarea dvs. aici">
                                </vue-editor>
                                <v-btn class="primary white--text my-4" @click="editComment(item)"
                                    :loading="item.edit_comment_loading">
                                    Actualizare
                                </v-btn>
                                <v-btn class="red white--text my-4" @click="item.edit_comment_box = false">
                                    Închideți
                                </v-btn>
                            </v-col>
                        </v-row>
                    </v-row>
                </v-col>
            </v-sheet>
        </v-col>
    </template>

    <?= new Controller\Template('course/lesson/zoom/tabs/classroom-tabs/questions/loop', $data) ?>
</v-col>