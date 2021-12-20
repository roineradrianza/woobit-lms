<v-row>
    <v-col cols="12">
        <h3 class="text-h4 text-center">Subiecte populare</h3>
    </v-col>
    <v-col class="mx-auto" cols="12" md="8">
        <v-row class="d-flex justify-center">
            <v-col cols="6" md="2" v-for="i in 10" :key="i">
                <v-chip color="primary">Topic {{ i }}</v-chip>
            </v-col>
        </v-row>
    </v-col>
</v-row>