
<?= new Controller\Template('course/lesson/partials/current-child') ?>
<v-sheet color="grey lighten-4" min-width="100%" rounded="lg">
    <v-col cols="12">
        <h5 class="text-h6">
        <?= $course['manage_course'] ? 'Lista studenților' : 'Colegi de clasă' ?> ({{  classmates.length  }})
        </h5>
        <template v-if="classmates_loading">
            <v-skeleton-loader class="mt-2" type="list-item-avatar" v-for="i in 3" :key="i"></v-skeleton-loader>
        </template>
        <template v-else>
            <v-list class="pt-3 pb-9" color="transparent" two-line>
                <template v-for="(classmate, index) in classmates">

                    <v-list-item :key="index">
                        <v-list-item-avatar :color="classmate.gender == 'M' ? 'primary' : '#e70f66'" size="40">
                            <v-icon color="white" size="30">
                                {{ classmate.gender == 'M' ? 'mdi-face-man' : 'mdi-face-woman' }}
                            </v-icon>
                        </v-list-item-avatar>

                        <v-list-item-content>
                            <v-list-item-title class="no-white-space">
                                {{ classmate.first_name + ' ' + classmate.last_name }}
                            </v-list-item-title>
                            <v-list-item-subtitle></v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>

                    <v-divider></v-divider>

                </template>
            </v-list>
        </template>
    </v-col>
</v-sheet>