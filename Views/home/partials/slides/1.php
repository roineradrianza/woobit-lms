<v-sheet id="slide-1" color="#E3E2E0" height="100%">
    <v-row class="fill-height px-4 px-md-16">
        <v-col class="d-flex align-center" cols="12" md="5" lg="6">
            <v-row class="pt-md-15" justify="center">
                <v-col class="slide_1_text" cols="12">
                    <h1 class="text-center black--text">Toate visurile au un început.</h1>
                    <h2 class="text-center black--text font-weight-normal">De la noi ai cursuri online
                        interactive.</h2>
                </v-col>
                <v-col cols="12" md="10">
                    <form :action="'<?= SITE_URL ?>/courses/?search=' + search" method="GET">
                        <v-text-field v-model="search" label="Ce dorești să înveți?" light flat dense solo>
                            <template #append>
                                <v-btn class="my-4 mx-6 mx-md-0" color="secondary"
                                    :href="'<?= SITE_URL ?>/courses/?search=' + search" text icon>
                                    <v-icon size="35px">mdi-magnify</v-icon>
                                </v-btn>
                            </template>
                        </v-text-field>
                    </form>
                </v-col>
            </v-row>
        </v-col>
        <v-col class="d-flex justify-center mb-n3 mb-lg-n0" cols="12" md="6" lg="6">
            <img src="<?= SITE_URL ?>/img/home/slider/1/image-1.png" class="img-slide-1 d-block d-md-none"></img>
        </v-col>
    </v-row>
</v-sheet>