<v-row justify="center">
    <v-col cols="12">
        <h3 class="text-h4 text-center">Orele disponibile</h3>
    </v-col>
    <v-col cols="12" md="3" v-for="i in 4" :key="i">
        <v-card>
            <v-card-title class="text-center" primary-title>
                <div>
                    <div class="headline">Următorul luni, 10 ianuarie 2022</div>
                </div>
            </v-card-title>
            <v-card-text>
                <v-list-item>
                    <v-list-item-content>
                        <v-list-item-title class="text-center">Se întâlnește o dată pe săptămână</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>

                <v-list-item>
                    <v-list-item-content>
                        <v-list-item-title class="text-center">5am - 5:45am</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-card-text>
            <v-card-actions class="d-flex justify-center">
                <v-btn class="py-6 px-6" color="primary" block>Înscrieți-vă la</v-btn>
            </v-card-actions>
        </v-card>
    </v-col>
</v-row>