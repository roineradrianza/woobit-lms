<v-row>
    <v-col cols="12">
        <v-row justify="center">
            <v-col class="d-flex justify-center" cols="12">
                <v-avatar size="150" ref="instructor_avatar">
                    <v-img src="<?= $avatar ?>"></v-img>
                </v-avatar>
            </v-col>
            <v-col class="py-0" cols="12">
                <v-row class="px-md-4">
                    <v-col cols="12">
                        <h4 class="text-h5 text-center">Lectori</h4>
                        <h5 class="text-h6 text-center"><?= "{$first_name} {$last_name}" ?></h5>
                    </v-col>
                    <v-col class="d-flex justify-center mt-n3" cols="12">
                        <v-rating :value="5" color="amber" dense half-increments readonly size="18">
                        </v-rating>

                        <span class="grey--text">
                            120 de opinii în total
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
                <?= !empty($meta['bio']) ? $meta['bio'] : ''?>
            </v-col>
        </v-row>
    </v-col>

    <v-col cols="12" md="6">
        <v-row>
            <v-col class="justify-center" cols="12">
                <h4 class="text-h5 text-center text-md-left">80 Recenzii</h4>
                <v-rating class="d-flex d-md-inline justify-center" :value="5" color="amber" dense half-increments readonly size="36">
                </v-rating>
            </v-col>
        </v-row>

        <v-row>
            <v-col v-for="i in 6" cols="12" :key="i">
                <v-sheet color="#F6F6F8" rounded="xl">
                    <v-row class="px-6">
                        <v-col cols="12">
                            <v-rating :value="5" color="amber" dense half-increments readonly size="18">
                            </v-rating>
                            <p class="grey--text lighten-2 subtitle-1">Dec 7, 2022</p>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsam doloremque repudiandae
                                possimus molestias. Commodi sequi ullam explicabo placeat similique aperiam excepturi
                                beatae quasi suscipit asperiores, iste laudantium nemo autem laboriosam.</p>
                            <v-avatar size="42">
                                <v-img src="<?= SITE_URL ?>/img/avatar/01.jpg"></v-img>
                            </v-avatar>
                            <a href="#"><strong>Nancy Michel</strong></a>
                        </v-col>
                    </v-row>
                </v-sheet>
            </v-col>
        </v-row>

    </v-col>
</v-row>