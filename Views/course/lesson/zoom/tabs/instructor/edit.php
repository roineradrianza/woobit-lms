<v-card class="px-4 pb-4 elevation-0">
    <v-row class="d-flex align-center">
        <v-col class="d-flex justify-end" cols="12">
            <v-btn @click="removeLessonMaterial(resource, index)" icon>
                <v-icon color="error">mdi-trash-can</v-icon>
            </v-btn>
        </v-col>
    </v-row>
    <v-text-field type="text" v-model="resource.name" hint="Numele materialului" persistent-hint filled rounded dense>
    </v-text-field>
    <v-file-input v-model="resource.file" prepend-icon="mdi-file-document" filled rounded dense></v-file-input>
    <template v-if="resource.percent_loading_active">
        <v-col class="p-0 mb-n6" cols="12">
            <p class="text-center" v-if="resource.percent_loading < 100">Încărcarea datelor pe server</p>
            <p class="text-center" v-else>Date trimise, așteptând răspunsul serverului...</p>
        </v-col>
        <v-col class="p-0" cols="12">
            <v-progress-linear :active="resource.percent_loading_active" :value="resource.percent_loading">
            </v-progress-linear>
        </v-col>
    </template>
    <v-row class="px-3">
        <v-btn color="secondary" @click="updateLessonMaterial({resource, child_id: <?= $child_id ?>})" :loading="resource.loading" block>
            <template v-if="resource.url != ''">
                Actualizare
            </template>
            <template v-else>
                Încărcați materialul
            </template>
        </v-btn>
    </v-row>
</v-card>