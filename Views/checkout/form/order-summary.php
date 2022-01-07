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
        <template v-if="section.hasOwnProperty('section_id')">
            <h6 class="text-h6 font-weight-light text-capitalize">
                începere: {{ getFormatStartDate(section.start_date) }}
            </h6>
            <h6 class="text-h6 font-weight-light">
                Frecvență: {{ getFrecuencyText(section.frecuency, section.classes) }}
            </h6>
            <h6 class="text-h6 font-weight-light">
                Orarul: {{ section.start_time + ' - ' + section.end_time }}
            </h6>
        </template>
    </v-col>
    <template v-show="info.total_pay > 0">
        <v-col cols="12">
            <v-divider>
            </v-divider>
        </v-col>
        <v-col class="p-0" cols="12" md="6">
            <h5 class="text-h5 font-weight-light">Costul pe student</h5>
        </v-col>
        <v-col class="p-0 d-flex justify-end" cols="12" md="6">
            <h5 class="text-h5 font-weight-light">{{ initial_pay }} RON</h5>
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
        <v-col cols="12" v-show="info.payment_method == 'Stripe' && !already_paid">
            <form id="payment-form">
                <div id="payment-element">
                    <!--Stripe.js injects the Payment Element-->
                </div>
                <button id="submit">
                    <div class="spinner hidden" id="spinner"></div>
                    <span id="button-text">Pay now</span>
                </button>
                <div id="payment-message" class="hidden"></div>
            </form>
            <v-row>
                <v-col class="d-flex justify-end py-2" cols="12">
                    <v-img src="<?= SITE_URL?>/img/payment-logos/powered-by-stripe.svg" max-width="150"></v-img>
                </v-col>
            </v-row>
        </v-col>
        <v-col class="p-0" cols="12">
            <p class="subtitle-2">Prin plasarea comenzii, sunteți de acord cu politica de confidențialitate
                și condițiile de utilizare a companiei noastre.</p>
        </v-col>
        <?= new Controller\Template('components/alert') ?>
    </template>
</v-row>