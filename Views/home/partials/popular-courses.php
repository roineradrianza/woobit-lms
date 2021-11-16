<v-row class="px-16 mt-4 d-flex justify-center">
    <v-col class="mw-lg" cols="12">
        <v-row>
            <v-col class="d-md-flex align-end" cols="12" md="8" order="2" order-md="1">
                <h2 class="text-h3 primary--text text-center text-md-left">
                    Cursuri Populare
                </h2>
            </v-col>
            <v-col class="d-flex justify-end" cols="12" md="4" order="1" order-md="2">
                <v-img src="<?php echo SITE_URL ?>/img/home/bubbles-2.svg" max-width="100px"></v-img>
            </v-col>
            <v-col cols="12" md="3" :order="i + 2" v-for="i in 4">
                <v-card class="my-12" max-width="374">

                    <v-img height="200" src="https://cdn.vuetifyjs.com/images/cards/cooking.png"></v-img>
                    <v-card-subtitle class="mb-n6">Cooking</v-card-subtitle>
                    <v-card-title class="font-weight-bold">Basics of Cooking</v-card-title>
                    <v-card-text>
                        <v-divider></v-divider>
                    </v-card-text>
                    <v-card-actions>
                        <v-row align="center" class="mx-0">
                            <v-col class="d-flex align-center" cols="12" md="8" lg="9">
                                <v-rating :value="5" color="amber" dense half-increments readonly size="18">
                                </v-rating>

                                <span class="grey--text">
                                    5
                                </span>
                            </v-col>

                            <v-col cols="12" md="4" lg="3">
                                <p class="mt-2">FREE</p>
                            </v-col>
                        </v-row>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>
    </v-col>
</v-row>