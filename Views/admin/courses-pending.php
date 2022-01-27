<v-row>
    <?= new Controller\Template('components/snackbar') ?>

    <v-col class="px-10" cols="12">
        <v-data-table :headers="headers" :items="courses" sort-by="title" class="elevation-1" :search="search"
            :loading="table_loading">
            <template #top>
                <v-text-field type="text" placeholder="Căutați..." v-model="search" append-icon="mdi-magnify" outlined>
                </v-text-field>
            </template>
            <template #item.actions="{ item }">
                <v-btn :href="'<?= SITE_URL?>/cursuri/' + item.slug + '/'" target="_blank" icon small>
                    <v-icon md color="primary">
                        mdi-eye
                    </v-icon>
                </v-btn>

                <v-btn icon small>
                    <v-icon md color="#00BFA5" @click="updateCourseStatus(1, item)">
                        mdi-check-circle
                    </v-icon>
                </v-btn>

                <v-btn icon small>
                    <v-icon md color="#F44336" @click="updateCourseStatus(0, item)">
                        mdi-close-circle
                    </v-icon>
                </v-btn>
            </template>
        </v-data-table>
    </v-col>
</v-row>