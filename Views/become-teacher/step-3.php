<h2 class="text-3">
    Pasul 3. Video Personal
</h2>
<v-form ref="step4_form" v-model="forms.step3" lazy-validation>
    <v-row>
        <v-col class="px-0" cols="12">
            <v-list-item>
                <v-list-item-content>
                    <v-list-item-title class="no-white-space">
                        Upload aici un scurt video în care te prezinți, spui o glumă, descrii pe scurt
                        interesele tale și cursul pe care îl vei preda. Arată-ne camera în care vei ține cursurile. Nu
                        uita sa zâmbești!
                    </v-list-item-title>
                </v-list-item-content>
            </v-list-item>
        </v-col>

        <v-file-input v-model="form.video_file" label="File input" truncate-length="66"
            accept=".mp4, .avi, .mkv, .wmv, .flv" :rules="validations.videoRules" show-size outlined
            v-if="form.hasOwnProperty('status') && parseInt(form.status) != 0">
            <template #selection="{ index, text }">
                <v-chip v-if="text != ''" color="primary" label small>
                    {{ text }}
                </v-chip>
            </template>
        </v-file-input>

        <template v-else>
            <v-col class="pr-12 pr-md-0" cols="12">
                <video :src="'<?= SITE_URL ?>' + form.meta.video_url" width="600" style="max-width: 100%" controls
                    v-if="form.meta.id_url != ''">
                </video>
            </v-col>
        </template>

    </v-row>
</v-form>