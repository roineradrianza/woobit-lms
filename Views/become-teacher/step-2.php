<h2 class="text-3">
    Pasul 2. Cazier și CI
</h2>
<v-form ref="step2_form" v-model="forms.step2" lazy-validation>
    <v-row>
        <v-col class="px-0" cols="12">
            <v-list-item>
                <v-list-item-content>
                    <v-list-item-title class="no-white-space">Upload o copie a cazierului și a CI aici
                    </v-list-item-title>
                </v-list-item-content>
            </v-list-item>
        </v-col>

        <v-file-input v-model="form.id_file" label="File input" truncate-length="66" accept=".jpg, .jpeg, .png, .pdf"
            :rules="validations.imageRules" show-size outlined
            v-if="form.hasOwnProperty('status') && parseInt(form.status) != 0">
            <template #selection="{ index, text }">
                <v-chip color="primary" label small>
                    {{ text }}
                </v-chip>
            </template>
        </v-file-input>

        <template v-else>
            <v-col cols="12">
                <v-img :src="'<?php echo SITE_URL ?>' + form.meta.id_url" max-width="600px"
                    v-if="form.meta.id_url != ''" contain>
                </v-img>
            </v-col>
        </template>

    </v-row>
</v-form>