<v-sheet id="slide-4" color="#fde86a" height="100%">
    <v-row class="fill-height px-4 px-md-16">
        <v-col class="d-flex align-center" cols="12" md="5" lg="6">
            <v-row class="pt-md-15" justify="center">
                <v-col cols="12" md="10">
                    <form :action="'<?php echo SITE_URL ?>/courses/?search=' + search" method="GET">
                        <v-text-field v-model="search" label="Ce dorești să înveți?" light flat dense solo>
                            <template #append>
                                <v-btn class="my-4 mx-6 mx-md-0" color="secondary"
                                    :href="'<?php echo SITE_URL ?>/courses/?search=' + search" text icon>
                                    <v-icon size="35px">mdi-magnify</v-icon>
                                </v-btn>
                            </template>
                        </v-text-field>
                    </form>
                </v-col>
            </v-row>
        </v-col>
        <v-col class="d-flex justify-center mb-n3 mb-lg-n0" cols="12" md="6" lg="6">
            <img src="<?php echo SITE_URL ?>/img/home/slider/4/image-1.png" class="img-slide-4"></img>
        </v-col>
    </v-row>
</v-sheet>