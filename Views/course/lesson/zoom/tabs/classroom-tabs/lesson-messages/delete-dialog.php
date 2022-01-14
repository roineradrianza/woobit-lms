<v-dialog v-model="lesson_messages.delete_dialog" max-width="700px">
    <v-card>
        <v-card-title class="headline no-word-break">Sunteți sigur că doriți să ștergeți acest mesaj?</v-card-title>
        <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="blue darken-1" text @click="lesson_messages.reset(); lesson_messages.delete_dialog = false">Anulează</v-btn>
            <v-btn color="blue darken-1" text @click="lesson_messages.deleteItem()">Continuă</v-btn>
            <v-spacer></v-spacer>
        </v-card-actions>
    </v-card>
</v-dialog>