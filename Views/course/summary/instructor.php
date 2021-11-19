<v-col cols="12" md="10" lg="9">
    <v-card class="gradient">
        <v-card-text>

            <v-row justify="center" align="center">
                <v-col class="d-flex justify-center align-center" cols="12">
                    <v-avatar size="80">
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
                                    Economist
                                </span>
                                <br>
                                <span>
                                    <v-icon color="yellow darken-3" v-for="i in 5">
                                        mdi-star
                                    </v-icon>
                                    <strong>
                                        5
                                    </strong>
                                </span>
                            </v-col>
                        </v-row>
                        <v-btn class="primary--text" color="white">
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