<v-dialog v-model="sponsorViewsStatistics" max-width="800px">
    <template #activator="{ on, attrs }">
        <v-btn class="gradient" v-bind="attrs" v-on="on" dark>Estadísticas de clicks</v-btn>
    </template>
    <v-card>
        <v-toolbar class="gradient">
            <v-toolbar-title class="white--text">Click totales</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-toolbar-items>
                <v-btn icon dark
                    @click="sponsorViewsStatistics = false;">
                    <v-icon color="white">mdi-close</v-icon>
                </v-btn>
            </v-toolbar-items>
        </v-toolbar>

        <v-card-text>
            <v-row>
                <v-col cols="12">
                    <v-data-table :headers="sponsor_statistics.headers" 
                    :items="sponsor_statistics.items" class="elevation-1" loading="sponsor_statistics.loading">  
                    </v-data-table>
                </v-col>
            </v-row>
        </v-card-text>
    </v-card>
</v-dialog>