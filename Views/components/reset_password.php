<v-dialog v-model="dialog" max-width="60%">
    <v-card>
        <v-toolbar elevation="0">
            <v-toolbar-title>Cerere de resetare a parolei</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-toolbar-items>
                <v-btn icon @click="dialog = false">
                    <v-icon color="grey">mdi-close</v-icon>
                </v-btn>
            </v-toolbar-items>
        </v-toolbar>

        <v-divider></v-divider>

        <v-card-text>
            <v-container>
                <v-row>
                    <v-col cols="12">
                        <label>Adresa de email</label>
                        <v-text-field class="mt-3" v-model="email_reset" rounded outlined></v-text-field>
                    </v-col>
                </v-row>
            </v-container>
        </v-card-text>

        <v-card-actions class="px-8">
            <v-spacer></v-spacer>
            <v-btn color="secondary white--text" @click="resetPassword" :loading="reset_loading" block>
                Cerere de restabilire
            </v-btn>
        </v-card-actions>
    </v-card>
</v-dialog>