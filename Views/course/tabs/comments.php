<v-row class="d-flex justify-center">
    <v-col cols="12" md="10" class="p-0">
        <v-row v-if="rating.loading">
            <v-col cols="12" md="4" v-for="i in 3">
                <v-skeleton-loader class="full-height" width="100%" type="image"></v-skeleton-loader>
            </v-col>
        </v-row>
        <v-row class="d-flex justify-center" v-else>
            <?php if(!empty($_SESSION['user_id'])): ?>
            <v-col cols="10" v-if="!rating.myCommentIsPublished">
                <v-form ref="rating_form" v-model="rating.form_valid" lazy-validation>
                    <v-row class="d-flex align-center">
                        <v-col class="d-flex justify-center" cols="12" md="2" lg="1">
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
                        <v-col class="d-flex justify-center" cols="12" md="10" lg="11">
                            <v-textarea v-model="rating.form.comment" class="fl-text-input" label="Deja tu comentario"
                                :rules="rating.form_rules.comment" rows="1" auto-grow filled rounded>
                            </v-textarea>
                        </v-col>
                        <v-col class="d-flex justify-center mt-n10" cols="12">
                            <v-rating v-model="rating.form.stars" background-color="primary" color="primary" large>
                            </v-rating>
                        </v-col>
                        <v-col class="d-flex justify-center mt-n4" cols="12">
                            <v-btn color="primary"
                                @click="rating.form.hasOwnProperty('course_rating_id') ? editMyRating() : saveRating()"
                                :disabled="!rating.form_valid" :loading="rating.form_loading">
                                Publicar</v-btn>
                        </v-col>
                    </v-row>
                </v-form>
            </v-col>
            <v-col cols="12" v-else>
                <v-row class="d-flex justify-center">
                    <v-col cols="12">
                        <h5 class="text-h6 text-center">Tu comentario</h5>
                    </v-col>
                    <v-col cols="12" md="5">
                        <v-card class="mx-auto gradient" dark>

                            <v-card-text class="body-1 font-weight-bold">
                                {{ rating.my_rating.comment }}
                            </v-card-text>

                            <v-card-actions>
                                <v-list-item class="grow">
                                    <v-list-item-avatar color="white darken-3">
                                        <?php if (!empty($_SESSION['avatar'])): ?>

                                        <v-img class="elevation-6" src="<?php echo $_SESSION['avatar'] ?>"
                                            alt="<?php echo $_SESSION['first_name'] ?>">
                                        </v-img>

                                        <?php else: ?>

                                        <v-icon color="primary">mdi-account-circle</v-icon>
                                        <?php endif ?>
                                    </v-list-item-avatar>

                                    <v-list-item-content>
                                        <v-list-item-title><?php echo $_SESSION['first_name'] ?>
                                            <?php echo $_SESSION['last_name'] ?></v-list-item-title>
                                    </v-list-item-content>

                                    <v-row align="center" justify="end">
                                        <v-icon class="mr-1" @click="deleteMyRating()">
                                            mdi-trash-can
                                        </v-icon>
                                        <v-icon class="mr-1"
                                            @click="rating.myCommentIsPublished = false; rating.form = rating.my_rating">
                                            mdi-pencil
                                        </v-icon>
                                        <v-icon class="mr-1">
                                            mdi-star
                                        </v-icon>
                                        <span class="subheading mr-2">{{ rating.my_rating.stars }}</span>
                                    </v-row>
                                </v-list-item>
                            </v-card-actions>
                        </v-card>
                    </v-col>
                    <v-col cols="12">
                        <h5 class="text-h6 text-center">Otros comentarios</h5>
                    </v-col>
                </v-row>
            </v-col>
            <?php endif ?>
            <v-col cols="12" v-if="rating.items.length < 1">
                <v-row class="d-flex justify-center">
                    <v-col class="d-flex justify-center" cols="12" md="6">
                        <img src="<?php echo SITE_URL?>/img/no-comments.svg" width="60%">
                    </v-col>
                    <v-col cols="12">
                        <h4 class="text-h5 text-center">No hay comentarios aún por parte de los estudiantes del curso</h4>
                    </v-col>
                </v-row>
            </v-col>
            <v-col cols="12" md="4" v-for="(item, i) in rating.items">
                <v-card class="mx-auto gradient" dark>

                    <v-card-text class="body-1 font-weight-bold">
                        {{ item.comment }}
                    </v-card-text>

                    <v-card-actions>
                        <v-list-item class="grow">
                            <v-list-item-avatar color="white darken-3">
                                <template v-if="item.avatar !== null">
                                    <v-img class="elevation-6" :src="item.avatar">
                                    </v-img>
                                </template>
                                <template v-else>
                                    <v-icon color="primary">mdi-account-circle</v-icon>
                                </template>
                            </v-list-item-avatar>

                            <v-list-item-content>
                                <v-list-item-title>{{ item.first_name + ' ' + item.last_name }}</v-list-item-title>
                            </v-list-item-content>

                            <v-row align="center" justify="end">
                                <?php if (!empty($_SESSION['user_id']) && $_SESSION['user_type'] == 'administrador'): ?>
                                <v-icon class="mr-1" @click="deleteRating(item, i)">
                                    mdi-trash-can
                                </v-icon>
                                <?php endif ?>
                                <v-icon class="mr-1">
                                    mdi-star
                                </v-icon>
                                <span class="subheading mr-2">{{ item.stars }}</span>
                            </v-row>
                        </v-list-item>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>
    </v-col>
</v-row>