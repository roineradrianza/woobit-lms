<v-row>
    <v-col cols="12">
        <v-card class="grey lighten-4" style="overflow-wrap: normal;" flat>
            <v-tabs ref="tabs_section" background-color="transparent" fixed-tabs centered show-arrows>

                <v-tab href="#clasroom-teacher-messages">Mesajele profesorului</v-tab>

                <v-tab href="#classroom-questions">Întrebări</v-tab>

                <v-tab href="#classroom-resources">Materiale</v-tab>


                <v-tab-item class="grey lighten-4" value="clasroom-teacher-messages">
                    <?= new Controller\Template('course/lesson/zoom/tabs/classroom-tabs/lesson-messages', $data) ?>
                </v-tab-item>

                <v-tab-item class="grey lighten-4" value="classroom-questions">
                    <?= new Controller\Template('course/lesson/zoom/tabs/classroom-tabs/questions', $data) ?>
                </v-tab-item>

                <v-tab-item class="grey lighten-4" value="classroom-resources">
                    <?= new Controller\Template('course/lesson/zoom/tabs/classroom-tabs/resources', $data) ?>
                </v-tab-item>

            </v-tabs>

        </v-card>

    </v-col>

</v-row>