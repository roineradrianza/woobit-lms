<v-row class="px-8 pt-4 pb-2">
    <v-col class="p-0" cols="12" md="6">
        <h5 class="text-h5 font-weight-light">Rezumatul plăților</h5>
    </v-col>
    <v-col cols="12">
        <v-divider></v-divider>
    </v-col>
    <v-col cols="12">
        <h5 class="text-h5 font-weight-light">
            Cursuri:
            {{ title }}
        </h5>
    </v-col>
    <template v-show="info.total_pay > 0">
        <v-col cols="12">
            <v-divider>
            </v-divider>
        </v-col>
        <v-col class="p-0" cols="12" md="6">
            <h5 class="secondary--text text-h5">Plată totală</h5>
        </v-col>
        <v-col class="p-0 d-flex justify-end" cols="12" md="6">
            <h5 class="secondary--text text-h5">{{ info.total_pay }} RON</h5>
        </v-col>
        <v-col cols="12">
            <v-divider>
            </v-divider>
        </v-col>
        <v-col cols="12">
            <div ref="paypal_container" id="paypal-button-container"
                v-show="info.payment_method == 'Paypal' && !already_paid">
            </div>
        </v-col>
        <v-col class="p-0" cols="12">
            <p class="subtitle-2">Prin plasarea comenzii, sunteți de acord cu politica de confidențialitate
                și condițiile de utilizare a companiei noastre.</p>
        </v-col>
        <?= new Controller\Template('components/alert') ?>
    </template>
</v-row>