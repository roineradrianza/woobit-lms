<v-dialog v-model="dialogOrderRefund" max-width="50%">
    <v-card>
        <v-card-title class="headline d-flex justify-center">Sunteți sigur că doriți să rambursați acest ordin de plată?
        </v-card-title>
        <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="primary" text @click="closeOrderRefund">Anulează</v-btn>
            <v-btn color="secondary" text @click="refundOrderItemConfirm">Continuă</v-btn>
            <v-spacer></v-spacer>
        </v-card-actions>
    </v-card>
</v-dialog>