<v-col cols="12">
    <p class="subtitle-1">
        Cărți
    </p>
</v-col>
<template v-for="book, i in form.meta.experience.books">
    <v-col class="d-flex justify-end" cols="12" v-if="form.hasOwnProperty('status') && parseInt(form.status) != 0">
        <v-btn color="error" @click="removeItem(form.meta.experience.books, i)">Eliminați</v-btn>
    </v-col>

    <v-col cols="12" md="4">
        <label class="body-1 font-weight-thin pl-1">Numele cărții</label>
        <v-text-field type="text" name="book_position" v-model="book.name" :rules="validations.requiredRules" outlined
            :disabled="form.hasOwnProperty('status') && !parseInt(form.status)" reactive>
        </v-text-field>
    </v-col>

    <v-col cols="12" md="4">
        <label class="body-1 font-weight-thin pl-1">Editorial</label>
        <v-text-field type="text" name="book_position" v-model="book.publisher" outlined
            :disabled="form.hasOwnProperty('status') && !parseInt(form.status)" reactive>
        </v-text-field>
    </v-col>

    <v-col cols="12" md="4">
        <label class="body-1 font-weight-thin pl-1">URL-ul proiectului</label>
        <v-text-field type="url" name="book_url" v-model="book.url" :rules="validations.urlRules" outlined
            :disabled="form.hasOwnProperty('status') && !parseInt(form.status)" reactive>
        </v-text-field>
    </v-col>

    <v-col cols="12" md="4">
        <v-dialog ref="book_start_dialog" v-model="modals.experience.book.published"
            :return-value.sync="book.published_date" persistent width="290px">
            <template #activator="{ on, attrs }">
                <label class="body-1 font-weight-thin pl-1">Data publicării</label>
                <v-text-field v-model="book.published_date" readonly v-bind="attrs" v-on="on" reactive outlined
                    :disabled="form.hasOwnProperty('status') && !parseInt(form.status)">
                    <template #append>
                        <v-icon v-bind="attrs" v-on="on">mdi-calendar</v-icon>
                    </template>
                </v-text-field>
            </template>
            <v-date-picker v-model="book.published_date" type="month" reactive>
                <v-spacer></v-spacer>
                <v-btn text color="primary" @click="modals.experience.book.published = false">
                    Anulează
                </v-btn>
                <v-btn text color="primary" @click="$refs.book_start_dialog[i].save(book.published_date)">
                    OK
                </v-btn>
            </v-date-picker>
        </v-dialog>
    </v-col>

    <v-col cols="12">
        <label class="body-1 font-weight-thin pl-1">Descriere</label>
        <v-textarea name="book_description" v-model="book.description" counter="2000"
            :rules="validations.descriptionRules" outlined
            :disabled="form.hasOwnProperty('status') && !parseInt(form.status)" reactive>
        </v-textarea>
    </v-col>

</template>
<v-col class="d-flex justify-center py-0" cols="12" v-if="form.hasOwnProperty('status') && parseInt(form.status) != 0">
    <v-btn color="primary" @click="addBook">
        Adăugați
    </v-btn>
</v-col>