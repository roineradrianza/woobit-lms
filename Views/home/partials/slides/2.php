<v-sheet id="slide-2" color="#FFFFFF" height="100%">
    <v-row class="fill-height px-4 px-md-10" style="border: 10px solid #8ca2ac">
        <v-col class="d-flex align-center" cols="12" md="5" lg="6">
            <v-row class="pt-md-15" justify="center">
                <v-col cols="12">
                    <h1 class="text-center black--text text-h3">Toate visurile au un început.</h1>
                    <h2 class="text-center black--text font-weight-light text-h4">De la noi ai cursuri online
                        interactive.</h2>
                </v-col>
                <v-col cols="12" md="10">
                    <form :action="'<?= SITE_URL ?>/courses/?search=' + search" method="GET">
                        <v-text-field v-model="search" label="Ce dorești să înveți?" light flat dense solo outlined>
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
            <img src="<?= SITE_URL ?>/img/home/slider/2/image-1.png"></img>
        </v-col>
    </v-row>
</v-sheet>