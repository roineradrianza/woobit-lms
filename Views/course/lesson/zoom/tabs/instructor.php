<v-col class="px-6" cols="12">
    <v-row>
        <v-col class="d-flex justify-center" cols="12">
            <v-avatar size="150">
                <v-img src="<?= $instructor['avatar'] ?>"></v-img>
            </v-avatar>
        </v-col>
        <v-col cols="12">
            <p class="text-h4 text-center"><?= "{$instructor['first_name']} {$instructor['last_name']}" ?></p>
            <v-divider></v-divider>
        </v-col>
    </v-row>

    <v-row>
        <v-col cols="12">
            <p>Selectați un elev pentru a vizualiza materialele primite și trimise.</p>
            <v-data-table v-model="students_selected" class="elevation-1" :headers="student_materials_headers"
                :items="classmates" sort-by="full_name" item-key="user_id" :loading="classmates_loading" show-select
                single-select sort-desc>
            </v-data-table>
        </v-col>
    </v-row>
    <template v-if="lesson_materials_sent_loading">
        <v-row>
            <v-col cols="12" md="6" v-for="i in 4" :key="i">
                <v-skeleton-loader type="card"></v-skeleton-loader>
            </v-col>
        </v-row>
    </template>
    <template v-else>
        <v-row
            v-if="child_profile.student_materials_selected.hasOwnProperty('user_id') || child_profile.child_id != null">

            <v-col cols="12">
                <h4 class="text-h5">
                    <?= $manage_course ? 'Materiale trimise studentului' : 'Materiale primite de către profesor' ?>
                </h4>
            </v-col>

            <v-col class="mt-n4" cols="12">
                <v-row>
                    <?= new Controller\Template('course/lesson/zoom/tabs/instructor/loop', [
                   'hideAddButton' => $manage_course ? false : true,
                   'canEdit' => $manage_course,
                   'sender' => '2',
                   'excluded_sender' => '1',
                   'child_id' => $manage_course ? 'student_selected.user_id' : 'child_profile.child_id'
                ])?>
                </v-row>
            </v-col>

            <v-col cols="12">
                <v-divider></v-divider>
            </v-col>
        </v-row>

        <v-row
            v-if="child_profile.student_materials_selected.hasOwnProperty('user_id') || child_profile.child_id != null">
            <v-col cols="12">
                <h4 class="text-h5">
                    <?= $manage_course ? 'Materiale primite de către student' : 'Materiale trimise profesorului' ?>
                </h4>
            </v-col>
            <v-col class="mt-n4" cols="12">
                <v-row>
                    <?= new Controller\Template('course/lesson/zoom/tabs/instructor/loop', [
                   'hideAddButton' => $manage_course,
                   'canEdit' => $manage_course ? false : true,
                   'sender' => '1',
                   'excluded_sender' => '2',
                   'child_id' => $manage_course ? 'selected_student.user_id' : 'child_profile.child_id'
                ])?>
                </v-row>
            </v-col>
        </v-row>
    </template>
</v-col>