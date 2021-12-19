<v-sheet id="slide-1" color="#E3E2E0" height="85vh">
    <v-container class="fill-height px-0">
        <v-row class="px-4 px-md-0">
            <v-col class="d-flex align-center" cols="12" md="5" lg="6">
                <v-sheet color="white" rounded="lg">
                    <v-row class="pt-md-3" justify="center">
                        <v-col class="slide_1_text" cols="12">
                            <h1 class="text-center black--text">Toate visurile au un început.</h1>
                            <h2 class="text-center black--text font-weight-normal">De la noi ai cursuri online
                                interactive.</h2>
                        </v-col>
                        <v-col class="px-8 px-md-0" cols="12" md="10">
                            <form :action="'<?= SITE_URL ?>/cursuri/?search=' + search" method="GET">
                                <v-text-field v-model="search" label="Ce dorești să înveți?" light flat outlined solo rounded>
                                    <template #append>
                                        <v-btn class="my-4" color="secondary"
                                            :href="'<?= SITE_URL ?>/cursuri/?search=' + search" text icon>
                                            <v-icon size="35px">mdi-magnify</v-icon>
                                        </v-btn>
                                    </template>
                                </v-text-field>
                            </form>
                        </v-col>
                    </v-row>
                </v-sheet>
            </v-col>
        </v-row>
    </v-container>
</v-sheet>