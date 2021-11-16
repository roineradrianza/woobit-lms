<v-col cols="12" md="12">
    <v-divider></v-divider>
</v-col>
<v-col cols="12" md="12">
    <h3 class="text-h4 font-weight-bold">Recursos</h3>
</v-col>
<v-col class="px-3" cols="12" md="4" v-for="(resource, index) in lessons.item.resources" :key="index">
    <v-row class="d-flex align-center">
        <v-col cols="6" class="d-flex align-center">
            <template v-if="resource.file !== undefined">
                <v-switch class="py-0 my-n6 v-normal-input" v-model="resource.preview_only" label="Sólo Vista Previa" v-if="getExt(resource.file.name) == 'pdf'"
                    false-value="0" true-value="1" dense inset>
                </v-switch>
            </template>
            <template v-else-if="resource.file === undefined && resource.url != ''">
                <v-switch class="py-0 my-0 v-normal-input" v-model="resource.preview_only" label="Sólo Vista Previa" v-if="getExt(resource.url) == 'pdf'"
                    false-value="0" true-value="1" dense inset>
                </v-switch>
            </template>
        </v-col>
        <v-col class="d-flex justify-end align-center" cols="6">
            <v-btn @click="removeResource(resource, index)" text>
                <v-icon color="error">mdi-close</v-icon>
            </v-btn>
        </v-col>
    </v-row>
    <v-text-field type="text" v-model="resource.name" class="mt-3 fl-text-input" hint="Nombre del material"
        persistent-hint filled rounded dense></v-text-field>
    <v-file-input class="mt-3 fl-text-input" v-model="resource.file" prepend-icon="mdi-file-document"
        :hint="resource.url" persistent-hint filled rounded dense></v-file-input>
    <template v-if="resource.percent_loading_active">
        <v-col class="p-0 mb-n6" cols="12">
            <p class="text-center" v-if="resource.percent_loading < 100">Cargando datos al servidor</p>
            <p class="text-center" v-else>Datos enviados, esperando respuesta del servidor...</p>
        </v-col>
        <v-col class="p-0" cols="12">
            <v-progress-linear :active="resource.percent_loading_active" :value="resource.percent_loading">
            </v-progress-linear>
        </v-col>
    </template>
    <v-row class="px-3">
        <v-btn color="secondary" @click="updateResource(resource, index)" :loading="resource.loading" block dark>
            <template v-if="resource.url != ''">
                Actualizar material
            </template>
            <template v-else>
                Guardar material
            </template>
        </v-btn>
    </v-row>
</v-col>
<v-col class="d-flex align-end" cols="12" md="4">
    <v-btn color="primary"
        @click="lessons.item.resources.push({name: '', preview_only: '0', file: undefined, url: '', loading: false, percent_loading_active: false, percent_loading: 0})"
        block dark>Añadir material</v-btn>
</v-col>