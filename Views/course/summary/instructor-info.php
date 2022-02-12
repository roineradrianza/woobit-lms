<v-row>
    <v-col cols="12">
        <v-row justify="center">
            <v-col class="d-flex justify-center" cols="12">
                <v-avatar size="150" ref="instructor_avatar">
                    <v-img src="<?= $instructor['avatar'] ?>"></v-img>
                </v-avatar>
            </v-col>
            <v-col class="py-0" cols="12">
                <v-row class="px-md-4">
                    <v-col cols="12">
                        <h4 class="text-h5 text-center">Lectori</h4>
                        <h5 class="text-h6 text-center"><?= "{$instructor['first_name']} {$instructor['last_name']}" ?></h5>
                    </v-col>
                    <v-col class="d-flex justify-center mt-n3" cols="12">
                        <v-rating value="<?= round($instructor['ratings']['average']) ?>" color="amber" dense half-increments readonly size="18">
                        </v-rating>

                        <span class="grey--text">
                            <?= round($instructor['ratings']['total']) ?> de opinii în total
                        </span>
                    </v-col>
                </v-row>
            </v-col>

        </v-row>
    </v-col>

    <v-col cols="12" md="6">
        <v-row>
            <v-col cols="12">
                <h4 class="text-h5">Despre mine</h4>
            </v-col>
            <v-col class="ql-editor" cols="12">
                <?= !empty($instructor['meta']['bio']) ? $instructor['meta']['bio'] : ''?>
            </v-col>
        </v-row>
    </v-col>

    <v-col cols="12" md="6">
        
        <?= new \Controller\Template('course/summary/instructor-info/course-ratings', $data)  ?>

    </v-col>
</v-row>