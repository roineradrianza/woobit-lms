<v-row class="d-flex align-center" style="min-height: 83vh;">
    <v-dialog v-model="rejectDialog" max-width="600">
        <v-card>
            <v-toolbar class="gradient" elevation="0">
                <v-toolbar-title class="white--text">Motivo del rechazo</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-toolbar-items>
                    <v-btn icon dark @click="rejectDialog = false">
                        <v-icon color="white">mdi-close</v-icon>
                    </v-btn>
                </v-toolbar-items>
            </v-toolbar>
            <v-card-text>
                <v-form>
                    <v-row class="mb-n4">
                        <v-col cols="12">
                            <v-textarea class="fl-text-input" v-model="order.note" rows="1" dense filled rounded
                                auto-grow></v-textarea>
                        </v-col>
                    </v-row>
                </v-form>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="error white--text" @click="processOrder(2)" :loading="approve_loading" block>
                    Rechazar Orden
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
    <v-col class="mb-16" cols="10" md="8" offset-md="2" offset="1">

        <v-card v-if="order.hasOwnProperty('order_id')">
            <v-toolbar class="gradient" elevation="0">
                <v-toolbar-title class="white--text">Informații de plată</v-toolbar-title>
            </v-toolbar>

            <v-divider></v-divider>
            <v-card-text>
                <v-container fluid>
                    <v-row>
                        <v-col cols="12">
                            <v-row>
                                <v-col class="d-flex justify-end mt-n4" cols="12">
                                    <v-chip :color="getStatus(order.status).color">
                                        {{ getStatus(order.status).name }}</v-chip>
                                </v-col>
                                <v-col cols="4">
                                    <p class="body-1 primary--text">Înregistrare completo: <span
                                            class="font-weight-light black--text">{{ FullName }}</span>
                                    </p>
                                </v-col>
                                <v-col cols="4">
                                    <p class="body-1 primary--text">Correo electrónico: <span
                                            class="font-weight-light black--text">{{ order.meta.user_email }}</span>
                                    </p>
                                </v-col>
                                <v-col cols="4">
                                    <p class="body-1 primary--text">Teléfono: <span
                                            class="font-weight-light black--text">{{ order.meta.telephone }}</span>
                                    </p>
                                </v-col>

                                <v-col cols="4">
                                    <p class="body-1 primary--text">Suma:
                                        <span class="font-weight-light black--text">${{ order.total_pay }}
                                        </span>
                                    </p>
                                </v-col>

                                <v-col cols="4">
                                    <p class="body-1 primary--text">Curso: <span
                                            class="font-weight-light black--text">{{ order.meta.course }}</span>
                                    </p>
                                </v-col>

                                <v-col cols="12" v-if="order.note !== '' && parseInt(order.status) == 2">
                                    <p class="body-1 primary--text">Notă: <span
                                            class="font-weight-light black--text">{{ order.note }}</span>
                                    </p>
                                </v-col>


                                <template v-if="order.payment_method == 'Zelle'">
                                    <?php echo new Controller\Template('admin/parts/order/preview/zelle') ?>
                                </template>

                                <template v-else-if="order.payment_method == 'Bank Transfer(Bs)'">
                                    <?php echo new Controller\Template('checkout/preview/bs-bank-transfer') ?>
                                </template>

                                <template v-else-if="order.payment_method == 'PagoMovil'">
                                    <?php echo new Controller\Template('checkout/preview/pagomovil') ?>
                                </template>
                            </v-row>
                        </v-col>
                    </v-row>
                </v-container>
            </v-card-text>
            <v-card-actions class="px-4 d-flex justify-center" v-if="parseInt(order.status) == 0">
                <v-btn color="error white--text" @click="rejectDialog = true" :loading="approve_loading">
                    Rechazar Orden
                </v-btn>
                <v-btn color="success white--text" @click="processOrder" :loading="approve_loading">
                    Aprobar Orden
                </v-btn>
            </v-card-actions>
        </v-card>
        <v-row class="d-flex justify-center" v-else>
            <v-col cols="12" md="8">
                <v-img src="<?php echo SITE_URL ?>/img/order-not-fund.svg"></v-img>
            </v-col>
            <v-col cols="12">
                <h4 class="secondary--text text-center text-h5">
                    Desafortunadamente no se ha encontrado la orden solicitada.
                </h4>
            </v-col>
        </v-row>
    </v-col>
</v-row>