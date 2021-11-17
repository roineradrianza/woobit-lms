<v-card class="my-12">

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