<v-row class="px-16 mt-4 d-flex justify-center">
    <v-col class="mw-lg" cols="12">
        <v-row class="d-flex">
            <v-col class="d-flex justify-end mb-4" cols="12">
                <v-img src="<?= SITE_URL ?>/img/home/bubbles.svg" max-width="100px"></v-img>
            </v-col>

            <v-col class="d-md-flex align-end" cols="12" md="8">
                <h2 class="text-h3 primary--text text-center text-md-left">
                    Lectori
                </h2>
            </v-col>

            <v-col class="d-flex justify-center justify-md-end" cols="12" md="4">
                <v-btn color="secondary">Continuă</v-btn>
            </v-col>

            <v-col cols="12" order="3">
                <v-row class="d-block d-md-none">
                    <v-carousel class="custom_carousel no-ha pb-4" cycle :show-arrows="false" hide-delimiter-background>
                        <v-carousel-item>
                            <v-col cols="12">
                                <div class="d-flex justify-center">
                                    <v-avatar size="150px">
                                        <img class="mb-6 obj-cover" src="<?= SITE_URL ?>/img/avatar/01.jpg"></img>
                                    </v-avatar>
                                </div>
                                <h4 class="text-center font-weight-bold text-h6">Nancy Michel</h4>
                                <p class="text-center font-weight-bold">Teacher</p>
                                <p class="text-center">
                                    <v-icon color="yellow darken-3" v-for="i in 4">
                                        mdi-star
                                    </v-icon>
                                    <v-icon class="ml-n1" color="yellow darken-3">
                                        mdi-star-half-full
                                    </v-icon>
                                    <strong>
                                        4.5
                                    </strong>
                                </p>
                                <p class="grey--text lighten-1 text-center mt-n3">
                                    18 reviews
                                </p>
                            </v-col>
                        </v-carousel-item>

                        <v-carousel-item>
                            <v-col cols="12">
                                <div class="d-flex justify-center">
                                    <v-avatar size="150px">
                                        <img class="mb-6 obj-cover" src="<?= SITE_URL ?>/img/avatar/02.jpg"></img>
                                    </v-avatar>
                                </div>
                                <h4 class="text-center font-weight-bold text-h6">Laura Branch</h4>
                                <p class="text-center font-weight-bold">Teacher</p>
                                <p class="text-center">
                                    <v-icon color="yellow darken-3" v-for="i in 5">
                                        mdi-star
                                    </v-icon>
                                    <strong>
                                        5
                                    </strong>
                                </p>
                                <p class="grey--text lighten-1 text-center mt-n3">
                                    130 reviews
                                </p>
                            </v-col>
                        </v-carousel-item>

                        <v-carousel-item>
                            <v-col cols="12">
                                <div class="d-flex justify-center">
                                    <v-avatar size="150px">
                                        <img class="mb-6 obj-cover" src="<?= SITE_URL ?>/img/avatar/03.jpg"></img>
                                    </v-avatar>
                                </div>
                                <h4 class="text-center font-weight-bold text-h6">Randy Alleyne</h4>
                                <p class="text-center font-weight-bold">Teacher</p>
                                <p class="text-center">
                                    <v-icon color="yellow darken-3" v-for="i in 5">
                                        mdi-star
                                    </v-icon>
                                    <strong>
                                        5
                                    </strong>
                                </p>
                                <p class="grey--text lighten-1 text-center mt-n3">
                                    120 reviews
                                </p>
                            </v-col>
                        </v-carousel-item>

                        <v-carousel-item>
                            <v-col cols="12">
                                <div class="d-flex justify-center">
                                    <v-avatar size="150px">
                                        <img class="mb-6 obj-cover" src="<?= SITE_URL ?>/img/avatar/04.jpg"></img>
                                    </v-avatar>
                                </div>
                                <h4 class="text-center font-weight-bold text-h6">Jon Leyba</h4>
                                <p class="text-center font-weight-bold">Teacher</p>
                                <p class="text-center">
                                    <v-icon color="yellow darken-3" v-for="i in 5">
                                        mdi-star
                                    </v-icon>
                                    <strong>
                                        5
                                    </strong>
                                </p>
                                <p class="grey--text lighten-1 text-center mt-n3">
                                    53 reviews
                                </p>
                            </v-col>
                        </v-carousel-item>

                        <v-carousel-item>
                            <v-col cols="12">
                                <div class="d-flex justify-center">
                                    <v-avatar size="150px">
                                        <img class="mb-6 obj-cover" src="<?= SITE_URL ?>/img/avatar/05.jpg"></img>
                                    </v-avatar>
                                </div>
                                <h4 class="text-center font-weight-bold text-h6">Joasia Kamińska</h4>
                                <p class="text-center font-weight-bold">Teacher</p>
                                <p class="text-center">
                                    <v-icon color="yellow darken-3" v-for="i in 5">
                                        mdi-star
                                    </v-icon>
                                    <strong>
                                        5
                                    </strong>
                                </p>
                                <p class="grey--text lighten-1 text-center mt-n3">
                                    53 reviews
                                </p>
                            </v-col>
                        </v-carousel-item>

                    </v-carousel>
                </v-row>

                <v-row class="d-none d-md-flex" justify="space-between">

                    <v-col cols="12" md="2">
                        <div class="d-flex justify-center">
                            <v-avatar size="150px">
                                <img class="mb-6 obj-cover" src="<?= SITE_URL ?>/img/avatar/01.jpg"></img>
                            </v-avatar>
                        </div>
                        <h4 class="text-center font-weight-bold text-h6">Nancy Michel</h4>
                        <p class="text-center font-weight-bold">Teacher</p>
                        <p class="text-center">
                            <v-icon color="yellow darken-3" v-for="i in 4">
                                mdi-star
                            </v-icon>
                            <v-icon class="ml-n1" color="yellow darken-3">
                                mdi-star-half-full
                            </v-icon>
                            <strong>
                                4.5
                            </strong>
                        </p>
                        <p class="grey--text lighten-1 text-center mt-n3">
                            18 reviews
                        </p>
                    </v-col>
                    <v-col cols="12" md="2">
                        <div class="d-flex justify-center">
                            <v-avatar size="150px">
                                <img class="mb-6 obj-cover" src="<?= SITE_URL ?>/img/avatar/02.jpg"></img>
                            </v-avatar>
                        </div>
                        <h4 class="text-center font-weight-bold text-h6">Laura Branch</h4>
                        <p class="text-center font-weight-bold">Teacher</p>
                        <p class="text-center">
                            <v-icon color="yellow darken-3" v-for="i in 5">
                                mdi-star
                            </v-icon>
                            <strong>
                                5
                            </strong>
                        </p>
                        <p class="grey--text lighten-1 text-center mt-n3">
                            130 reviews
                        </p>
                    </v-col>
                    <v-col cols="12" md="2">
                        <div class="d-flex justify-center">
                            <v-avatar size="150px">
                                <img class="mb-6 obj-cover" src="<?= SITE_URL ?>/img/avatar/03.jpg"></img>
                            </v-avatar>
                        </div>
                        <h4 class="text-center font-weight-bold text-h6">Randy Alleyne</h4>
                        <p class="text-center font-weight-bold">Teacher</p>
                        <p class="text-center">
                            <v-icon color="yellow darken-3" v-for="i in 5">
                                mdi-star
                            </v-icon>
                            <strong>
                                5
                            </strong>
                        </p>
                        <p class="grey--text lighten-1 text-center mt-n3">
                            120 reviews
                        </p>
                    </v-col>
                    <v-col cols="12" md="2">
                        <div class="d-flex justify-center">
                            <v-avatar size="150px">
                                <img class="mb-6 obj-cover" src="<?= SITE_URL ?>/img/avatar/04.jpg"></img>
                            </v-avatar>
                        </div>
                        <h4 class="text-center font-weight-bold text-h6">Jon Leyba</h4>
                        <p class="text-center font-weight-bold">Teacher</p>
                        <p class="text-center">
                            <v-icon color="yellow darken-3" v-for="i in 5">
                                mdi-star
                            </v-icon>
                            <strong>
                                5
                            </strong>
                        </p>
                        <p class="grey--text lighten-1 text-center mt-n3">
                            53 reviews
                        </p>
                    </v-col>
                    <v-col cols="12" md="2">
                        <div class="d-flex justify-center">
                            <v-avatar size="150px">
                                <img class="mb-6 obj-cover" src="<?= SITE_URL ?>/img/avatar/05.jpg"></img>
                            </v-avatar>
                        </div>
                        <h4 class="text-center font-weight-bold text-h6">Joasia Kamińska</h4>
                        <p class="text-center font-weight-bold">Teacher</p>
                        <p class="text-center">
                            <v-icon color="yellow darken-3" v-for="i in 5">
                                mdi-star
                            </v-icon>
                            <strong>
                                5
                            </strong>
                        </p>
                        <p class="grey--text lighten-1 text-center mt-n3">
                            53 reviews
                        </p>
                    </v-col>
                </v-row>
            </v-col>
        </v-row>
    </v-col>
</v-row>