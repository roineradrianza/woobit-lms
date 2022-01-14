<v-dialog v-model="lesson_messages.dialog" max-width="800px">
    <v-card>
        <v-toolbar elevation="0">
            <v-toolbar-title>Editați mesajul</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-toolbar-items>
                <v-btn icon @click="lesson_messages.dialog = false">
                    <v-icon color="grey">mdi-close</v-icon>
                </v-btn>
            </v-toolbar-items>
        </v-toolbar>

        <v-divider></v-divider>

        <v-card-text>
            <v-form>
                <v-row>
                    <v-col cols="12">
                        <label>Mesaj</label>
                        <vue-editor id="lesson_message_editor" v-model="lesson_messages.message.message" class="white mt-3"
                            :editor-toolbar="customToolbar" placeholder="Descrierea clasei" />
                    </v-col>
                </v-row>
            </v-form>
        </v-card-text>

        <v-card-actions class="px-8">
            <v-spacer></v-spacer>
            <v-btn color="secondary white--text" block @click="lesson_messages.save()"
                :disabled="lesson_messages.message == ''" :loading="lesson_messages.loading">
                Salvați
            </v-btn>
        </v-card-actions>
    </v-card>
</v-dialog>