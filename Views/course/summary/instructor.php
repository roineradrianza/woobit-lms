<v-col cols="12" md="10" lg="9">
    <v-card class="gradient">
        <v-card-text>

            <v-row justify="center" align="center">
                <v-col class="d-flex justify-center align-center" cols="12">
                    <v-avatar size="80" ref="instructor_avatar">
                        <v-img src="<?= $avatar ?>"></v-img>
                    </v-avatar>
                    <p class="white--text mb-0 ml-2">
                        <v-row>
                            <v-col cols="12">
                                <span class="body-1">
                                    <?= $first_name ?>
                                    <?= $last_name ?>
                                </span>
                                <br>
                                <span>
                                    Lectori
                                </span>
                                <br>
                                <span>
                                    <v-rating class="d-inline" value="<?= round($ratings['average']) ?>" color="amber" dense half-increments
                                        readonly>
                                    </v-rating>
                                    <strong>
                                    <?= empty($ratings['total']) ? 'N/A' : $ratings['total'] ?>
                                    </strong>
                                </span>
                            </v-col>
                        </v-row>
                        <v-btn class="primary--text" color="white"
                            @click="$refs.instructor_avatar.$el.scrollIntoViewIfNeeded()">
                            Despre Mine
                            <v-icon>
                                mdi-play-circle
                            </v-icon>
                        </v-btn>
                    </p>
                </v-col>
            </v-row>
        </v-card-text>
    </v-card>
</v-col>