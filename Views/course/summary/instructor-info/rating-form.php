<v-col cols="12" v-if="!rating.myCommentIsPublished">
    <v-form ref="rating_form" v-model="rating.form_valid" lazy-validation>
        <v-row>
            <v-col class="d-flex justify-center" cols="12" md="2">
                <v-avatar>
                    <?php if (!empty($_SESSION['avatar'])): ?>

                    <v-img class="elevation-6" src="<?php echo $_SESSION['avatar'] ?>"
                        alt="<?php echo $_SESSION['first_name'] ?>">
                    </v-img>

                    <?php else: ?>
                    <v-icon color="primary">mdi-account-circle</v-icon>
                    <?php endif ?>
                </v-avatar>
            </v-col>
            <v-col class="d-flex justify-center" cols="12" md="10">
                <v-textarea v-model="rating.form.comment" class="fl-text-input" label="Lasă un comentariu"
                    :rules="rating.form_rules.comment" rows="1" auto-grow filled rounded>
                </v-textarea>
            </v-col>
            <v-col class="d-flex justify-center mt-n10" cols="12">
                <v-rating v-model="rating.form.stars" background-color="amber" color="amber">
                </v-rating>
            </v-col>
            <v-col class="d-flex justify-center mt-n4" cols="12">
                <v-btn color="primary"
                    @click="rating.form.hasOwnProperty('course_rating_id') ? rating.editMyRating() : rating.save()"
                    :disabled="!rating.form_valid" :loading="rating.form_loading">
                    Publică</v-btn>
            </v-col>
        </v-row>
    </v-form>
</v-col>
<v-col cols="12" v-else>
    <v-row class="d-flex justify-center">
        <v-col cols="12">
            <h5 class="text-h6 text-center">Comentariul dumneavoastră</h5>
        </v-col>
        <v-col cols="12">
            <v-sheet color="#F6F6F8" rounded="xl">
                <v-row class="px-6">
                    <v-col cols="12">
                        <v-rating :value="rating.my_rating.stars" color="amber" dense half-increments readonly
                            size="18">
                        </v-rating>
                        <p class="grey--text lighten-2 subtitle-1">
                            {{ rating.formatDate(rating.my_rating.published_at, 'll') }}</p>
                        <p>{{ rating.my_rating.comment }}</p>
                        <v-row>
                            <v-col cols="10">
                                <?php if (!empty($_SESSION['avatar'])): ?>

                                <v-avatar size="42">
                                    <v-img src="<?= $_SESSION['avatar'] ?>" alt="<?php echo $_SESSION['first_name'] ?>">
                                    </v-img>
                                </v-avatar>

                                <?php else: ?>

                                <v-icon color="primary">mdi-account-circle</v-icon>
                                <?php endif ?>

                                <a
                                    href="#"><strong><?= "{$_SESSION['first_name']} {$_SESSION['last_name']}" ?></strong></a>
                            </v-col>
                            <v-col cols="2">
                                <v-icon class="mr-1" @click="rating.deleteMyRating()">
                                    mdi-trash-can
                                </v-icon>
                                <v-icon class="mr-1"
                                    @click="rating.myCommentIsPublished = false; rating.form = rating.my_rating">
                                    mdi-pencil
                                </v-icon>
                            </v-col>
                        </v-row>

                    </v-col>
                </v-row>
            </v-sheet>
        </v-col>
        <v-col cols="12">
            <v-divider></v-divider>
        </v-col>
    </v-row>
</v-col>