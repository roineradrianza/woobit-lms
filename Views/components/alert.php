    <v-col cols="12">
        <v-alert class="white--text" :type="<?php echo !empty($type) ? $type : 'alert_type' ?>" elevation="2"
            v-if="<?php echo !empty($alert) ? $alert_type : 'alert' ?>">
            <span v-html="<?php echo !empty($alert_message) ? $alert_message : 'alert_message' ?>"></span>
        </v-alert>
    </v-col>