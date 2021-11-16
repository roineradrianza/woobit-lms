<v-row class="pl-6 pt-6 d-flex align-center" style="min-height: 82vh;">

    <v-row class="d-flex justify-center mb-16">
        <v-col class="mb-8" cols="12">
            <h3 class="text-h3 text-center primary--text">{{ title }}</h3>
        </v-col>
        <v-col cols="12" md="6">
            <v-sheet rounded="xl" color="white">
                <v-row class="px-8 py-4">
                    <v-col cols="12">
                        <p>
                            {{ FullName }}
                            <br>
                            {{ personal_info.email }}
                            <br>
                            {{ personal_info.telephone }}
                        </p>
                    </v-col>
                    <v-col cols="12">
                        <v-divider></v-divider>
                    </v-col>
                    <v-col cols="12">
                        <h4 class="text-h4 secondary--text">Método de pago</h4>
                    </v-col>
                    <v-col cols="12">
                        <v-radio-group class="mt-n4 mb-n4" v-model="info.payment_method" row>
                            <v-radio label="Paypal" value="Paypal"></v-radio>
                            <v-radio label="Zelle" value="Zelle"></v-radio>
                            <v-radio label="Bitcoin" value="Bitcoin" v-if="1 == 2"></v-radio>
                            <v-radio label="Transferencia Bancaria en Bs(Bolívares Soberanos)"
                                value="Bank Transfer(Bs)"></v-radio>
                            <v-radio label="PagoMóvil" value="PagoMovil"></v-radio>
                        </v-radio-group>
                    </v-col>
                    <v-col cols="12">
                        <v-row>
                            <v-col cols="12" v-if="info.payment_method != '' && info.payment_method != 'Paypal'">
                                <v-divider></v-divider>
                            </v-col>

                            <template v-if="info.payment_method == 'Zelle'">
                                <?php echo new Controller\Template('checkout/payments/zelle') ?>
                            </template>

                            <template v-else-if="info.payment_method == 'Bank Transfer(Bs)'">
                                <?php echo new Controller\Template('checkout/payments/bs-bank-transfer') ?>
                            </template>

                            <template v-else-if="info.payment_method == 'PagoMovil'">
                                <?php echo new Controller\Template('checkout/payments/pagomovil') ?>
                            </template>
                        </v-row>
                    </v-col>
                </v-row>
            </v-sheet>
        </v-col>
        <v-col cols="12" md="4">
            <v-sheet rounded="xl" color="white">
                <v-row class="px-8 py-4">
                    <v-col class="p-0" cols="12" md="6">
                        <h5 class="text-h5 font-weight-light">Total a Pagar</h5>
                    </v-col>
                    <v-col class="p-0 d-flex justify-end" cols="12" md="6">
                        <h5 class="secondary--text text-h5">${{ info.total_pay }}</h5>
                    </v-col>
                    <v-col cols="12">
                        <v-btn color="secondary" :disabled="disableByPayment()" @click="pay()" :loading="loading_btn"
                            v-if="!already_paid && info.payment_method != 'Paypal'" rounded block light>Realizar pago
                        </v-btn>
                        <div id="paypal-button-container" v-show="info.payment_method == 'Paypal' && !already_paid">
                        </div>
                    </v-col>
                    <?php echo new Controller\Template('components/alert') ?>
                </v-row>
            </v-sheet>
        </v-col>

    </v-row>
</v-row>