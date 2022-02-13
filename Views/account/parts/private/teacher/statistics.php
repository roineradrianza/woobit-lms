<v-container class="px-4 px-md-0">
    <template v-if="loading">
        <v-row justify="center">
            <v-col cols="12" md="4">
                <v-skeleton-loader type="card"></v-skeleton-loader>
            </v-col>
            <v-col cols="12" md="4">
                <v-skeleton-loader type="card"></v-skeleton-loader>
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="12" md="6">
                <v-skeleton-loader type="image"></v-skeleton-loader>
            </v-col>
            <v-col cols="12" md="6">
                <v-skeleton-loader type="image"></v-skeleton-loader>
            </v-col>
        </v-row>
    </template>
    <template v-else>
        <v-row align="center">
            <v-col cols="12" md="4">
                <h1 class="text-h3 font-weight-bold accent--text">Retrospectiva</h1>
            </v-col>
            <v-col cols="12" md="8">
                <v-divider color="#0976c2"></v-divider>
            </v-col>
        </v-row>
        <v-row justify="center">
            <v-col cols="12" md="4">
                <v-card outlined>
                    <v-list-item three-line>
                        <v-list-item-content>
                            <v-list-item-title class="text-h4 font-weight-bold b-1 secondary--text">
                                {{ total_students.length }} studenți
                            </v-list-item-title>
                            <v-list-item-subtitle>în total</v-list-item-subtitle>
                        </v-list-item-content>
                        <v-list-item-avatar tile size="80">
                            <v-icon size="80" color="primary">
                                mdi-google-classroom
                            </v-icon>
                        </v-list-item-avatar>
                    </v-list-item>
                </v-card>
            </v-col>
            <v-col cols="12" md="4">
                <v-card outlined>
                    <v-list-item three-line>
                        <v-list-item-content>
                            <v-list-item-title class="text-h4 font-weight-bold b-1 secondary--text">
                                {{ total_class_hours }} ore
                            </v-list-item-title>
                            <v-list-item-subtitle>de clase în total</v-list-item-subtitle>
                        </v-list-item-content>
                        <v-list-item-avatar tile size="80">
                            <v-icon size="80" color="primary">
                                mdi-human-male-board
                            </v-icon>
                        </v-list-item-avatar>
                    </v-list-item>
                </v-card>
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="12">
                <h3 class="text-h4 text-center">Total ore predate</h3>
            </v-col>
            <v-col cols="12" md="6" v-show="!chart.loading">
                <h4 class="d-block text-h5 text-center">Lunar</h4>
                <line-chart ref="monthly_chart" :chartData="chart.monthly_data"></line-chart>
            </v-col>

            <v-col cols="12" md="6" v-show="!chart.loading">
                <h4 class="d-block text-h5 text-center">Săptămânal</h4>
                <line-chart ref="weekly_chart" :chartData="chart.weekly_data"></line-chart>
            </v-col>
        </v-row>
    </template>


</v-container>