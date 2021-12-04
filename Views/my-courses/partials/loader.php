<v-row>
    <v-col cols="4" v-for="i in 9" :key="i">
        <v-sheet class="pa-3">
            <v-skeleton-loader class="mx-auto" type="card"></v-skeleton-loader>
        </v-sheet>
    </v-col>
</v-row>