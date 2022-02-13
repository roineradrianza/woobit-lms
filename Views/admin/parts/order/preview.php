<template>
    <v-toolbar class="bg-transparent" flat>
        <v-spacer></v-spacer>
        <v-dialog v-model="rejectDialog" max-width="600">
            <v-card>
                <v-toolbar class="gradient" elevation="0">
                    <v-toolbar-title class="white--text">Motivul respingerii</v-toolbar-title>
                </v-toolbar>
                <v-card-text>
                    <v-form>
                        <v-row class="mb-n4">
                            <v-col cols="12">
                                <v-textarea class="fl-text-input" v-model="orders.editedItem.note" rows="1" dense filled
                                    rounded auto-grow></v-textarea>
                            </v-col>
                        </v-row>
                    </v-form>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="error white--text" @click="processOrder(2)" :loading="approve_loading" block>
                        Ordine de respingere
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-dialog v-model="dialogOrderPreview" max-width="95%" @click:outside="dialogOrderPreview = false">
            <v-card>
                <v-toolbar class="gradient" elevation="0">
                    <v-toolbar-title class="white--text">Informații de plată</v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-toolbar-items>
                        <v-btn icon @click="dialogOrderPreview = false">
                            <v-icon color="white">mdi-close</v-icon>
                        </v-btn>
                    </v-toolbar-items>
                </v-toolbar>

                <v-divider></v-divider>
                <v-card-text>
                    <v-container fluid>
                        <v-row v-if="orders.editedIndex != -1">
                            <v-col cols="12" md="8" offset-md="2" v-if="orders.editedItem.status == 3">
                                <v-alert color="#2A3B4D" dark icon="mdi-cash-refund" prominent>
                                    Banii pentru acest ordin de plată au fost rambursați.
                                </v-alert>
                            </v-col>
                            <template v-if="orders.editedItem.status == 1">
                                <v-col class="d-flex justify-end" cols="12" v-if="orders.editedItem.payment_method == 'Paypal'">
                                    <v-btn color="secondary" @click="dialogOrderRefund = true">Rambursare</v-btn>
                                </v-col>
                            </template>
                            <v-col cols="12">
                                <v-row>
                                    <v-col cols="4">
                                        <p class="body-1 primary--text">Nume și prenume: <span
                                                class="font-weight-light black--text">{{ FullName }}</span></p>
                                    </v-col>
                                    <v-col cols="4">
                                        <p class="body-1 primary--text">Adresa de e-mail: <span
                                                class="font-weight-light black--text">{{ orders.editedItem.meta.user_email }}</span>
                                        </p>
                                    </v-col>
                                    <v-col cols="4">
                                        <p class="body-1 primary--text">Telefon: <span
                                                class="font-weight-light black--text">{{ orders.editedItem.meta.telephone }}</span>
                                        </p>
                                    </v-col>

                                    <v-col cols="4">
                                        <p class="body-1 primary--text">Suma:
                                            <span class="font-weight-light black--text">
                                                {{ orders.editedItem.total_pay }} RON
                                            </span>
                                        </p>
                                    </v-col>

                                    <v-col cols="4">
                                        <p class="body-1 primary--text">Suma (USD):
                                            <span class="font-weight-light black--text">
                                                $ {{ orders.editedItem.meta.USD }}
                                            </span>
                                        </p>
                                    </v-col>

                                    <v-col cols="4">
                                        <p class="body-1 primary--text">
                                            <template v-if="parseInt(orders.editedItem.type) == 1">
                                                Curs:
                                            </template>
                                            <template v-else>
                                                Descriere:
                                            </template>
                                            <span
                                                class="font-weight-light black--text">{{ orders.editedItem.meta.course }}</span>
                                        </p>
                                    </v-col>

                                    <v-col cols="4">
                                        <p class="body-1 primary--text">
                                            Lectori:
                                            <span class="font-weight-light black--text">
                                                {{ orders.editedItem.instructor.first_name + ' ' + orders.editedItem.instructor.last_name }}
                                            </span>
                                        </p>
                                    </v-col>

                                    <v-col cols="4"
                                        v-if="orders.editedItem.note !== '' && parseInt(orders.editedItem.status) == 2">
                                        <p class="body-1 primary--text">
                                            Notă:
                                            <span
                                                class="font-weight-light black--text">{{ orders.editedItem.note }}</span>
                                        </p>
                                    </v-col>

                                    <template v-if="orders.editedItem.payment_method == 'Paypal'">
                                        <?= new Controller\Template('admin/parts/order/preview/paypal') ?>
                                    </template>
                                </v-row>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-card-text>
                <v-card-actions class="px-4 d-flex justify-center" v-if="parseInt(orders.editedItem.status) == 0">
                    <v-btn color="error white--text" @click="rejectDialog = true" :loading="approve_loading">
                        Refuzul plății
                    </v-btn>
                    <v-btn color="success white--text" @click="processOrder(1)" :loading="approve_loading">
                        Aprobarea plății
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-toolbar>
</template>