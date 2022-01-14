<div class="text-center">
    <v-snackbar color="snackbar_type" v-model="<?= !empty($snackbar) ? $snackbar : 'snackbar' ?>"
        :timeout="<?= !empty($snackbar_timeout) ? $snackbar_timeout : 'snackbar_timeout' ?>">
        {{ <?= !empty($snackbar_text) ? $snackbar_text : 'snackbar_text' ?> }}

        <template #action="{ attrs }">
            <v-btn text v-bind="attrs" @click="snackbar = false" dark>
              Închideți
            </v-btn>
        </template>
    </v-snackbar>
</div>