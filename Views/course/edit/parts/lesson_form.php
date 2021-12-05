<template>
    <v-toolbar class="bg-transparent" flat>
        <v-dialog v-model="<?= !empty($dialog) ? $dialog: 'dialog' ?>" max-width="95%"
            @click:outside="<?= !empty($dialog) ? $dialog: 'dialog' ?> = false">
            <v-card>
                <v-toolbar class="gradient" elevation="0">
                    <v-toolbar-title class="white--text">Editați clasa</v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-toolbar-items>
                        <v-btn icon @click="<?= !empty($dialog) ? $dialog: 'dialog' ?> = false">
                            <v-icon color="white">mdi-close</v-icon>
                        </v-btn>
                    </v-toolbar-items>
                </v-toolbar>

                <v-divider></v-divider>
                <v-form>
                    <v-card-text>
                        <v-row>
                            <v-col cols="12">
                                <template v-if="lessons.item.lesson_type == 1">
                                    <?= new Controller\Template('course/edit/parts/class_form', $data) ?>
                                </template>
                                <template v-if="lessons.item.lesson_type == 2">
                                    <?= new Controller\Template('course/edit/parts/quiz_form', $data) ?>
                                </template>
                                <template v-if="lessons.item.lesson_type == 4">
                                    <?= new Controller\Template('course/edit/parts/resources_form', $data) ?>
                                </template>
                            </v-col>
                        </v-row>
                    </v-card-text>
                    <v-card-actions class="px-4">
                        <v-row>
                            <template v-if="percent_loading_active">
                                <v-col class="p-0 mb-n6" cols="12">
                                    <p class="text-center" v-if="percent_loading < 100">Încărcarea date către server</p>
                                    <p class="text-center" v-else>Date trimise, așteptând răspunsul serverului...</p>
                                </v-col>
                                <v-col class="p-0" cols="12">
                                    <v-progress-linear :active="percent_loading_active" :value="percent_loading">
                                    </v-progress-linear>
                                </v-col>
                            </template>
                            <v-col class="p-0" cols="12">
                                <v-btn color="secondary white--text" block @click="updateLessonMeta"
                                    :loading="curriculum.update_lesson_meta_loading">
                                    Guadar și finalizare
                                </v-btn>
                            </v-col>
                        </v-row>
                    </v-card-actions>
                </v-form>
            </v-card>
        </v-dialog>
    </v-toolbar>
</template>