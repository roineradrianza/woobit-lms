    <v-col cols="12">
        <v-alert class="white--text" :type="<?= !empty($type) ? $type : 'alert_type' ?>" elevation="2"
            v-if="<?= !empty($alert) ? $alert_type : 'alert' ?>">
            <span v-html="<?= !empty($alert_message) ? $alert_message : 'alert_message' ?>"></span>
        </v-alert>
    </v-col>