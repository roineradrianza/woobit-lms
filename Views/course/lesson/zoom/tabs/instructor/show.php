<v-card class="mx-auto outlined elevation-0">
    <v-list-item three-line>
        <v-list-item-content>
            <v-list-item-title class="headline mb-1 no-white-space">
                {{ resource.name }}
            </v-list-item-title>
            <?php if(!empty($canEdit)): ?>

            <div class="d-flex">
                <v-btn color="success" @click="resource.edit = true" icon>
                    <v-icon>mdi-pencil</v-icon>
                </v-btn>
                <v-btn color="error" @click="removeLessonMaterial(resource, index)" icon>
                    <v-icon>mdi-trash-can</v-icon>
                </v-btn>
            </div>

            <?php endif ?>
        </v-list-item-content>

        <v-list-item-avatar size="80" color="primary">
            <v-icon color="white" x-large>mdi-file-{{ getExtIcon(resource.url) }}</v-icon>
            <br>
        </v-list-item-avatar>
    </v-list-item>

    <v-card-actions>
        <v-row>
            <template v-if="resource.percent_loading_active">
                <v-col class="p-0 mb-n6" cols="12">
                    <p class="text-center" v-if="resource.percent_loading < 100">Descărcarea resursă</p>
                    <p class="text-center" v-else>Descărcare finalizată, vă rugăm să așteptați un
                        moment...</p>
                </v-col>
                <v-col class="p-0" cols="12">
                    <v-progress-linear :active="resource.percent_loading_active" :value="resource.percent_loading"
                        height="15" dark>
                        <template #default="{ value }">
                            <strong>{{ Math.ceil(value) }}%</strong>
                        </template>
                    </v-progress-linear>
                </v-col>
            </template>
            <v-col class="d-flex justify-center" cols="12">
                <v-btn color="secondary" @click="saveFile(resource.url, resource)" rounded>
                    Descărcați
                </v-btn>
            </v-col>
        </v-row>
    </v-card-actions>
</v-card>