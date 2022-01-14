<v-toolbar class="bg-transparent" v-if="resource_preview_dialog" flat>
    <v-dialog v-model="resource_preview_dialog" transition="dialog-transition" @click:outside="resource_preview_loading = false">
        <v-card>
            <v-toolbar class="gradient" elevation="0">
                <v-toolbar-title class="white--text"></v-toolbar-title>
                <v-spacer></v-spacer>
                <v-toolbar-items>
                    <v-btn icon @click="resource_preview_dialog = false; resource_preview_loading = false">
                        <v-icon color="white">mdi-close</v-icon>
                    </v-btn>
                </v-toolbar-items>
            </v-toolbar>
            <v-card-text>
                <v-row class="d-flex justify-center" id="viewer">
                    <v-col class="mt-12" cols="12" v-if="resource_preview_loading">
                        <v-btn color="primary" :loading="resource_preview_loading" block text></v-btn>
                    </v-col>
                    <v-col cols="12" md="11" v-show="resource_preview_dialog">
                        <iframe :src="resource_preview.url + '#toolbar=0&navpanes=0&scrollbar=0'"
                            cols="12" width="100%" :height="ScreenHeight" @load="resource_preview_loading = false"
                            v-if="resource_preview.hasOwnProperty('url') && getExt(resource_preview.url) == 'pdf'" v-show="!resource_preview_loading">
                        </iframe>
                    </v-col>
                </v-row>
            </v-card-text>
        </v-card>
    </v-dialog>
</v-toolbar>