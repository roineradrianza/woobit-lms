<v-col cols="4">
    <p class="body-1 primary--text">ID-ul tranzacției Paypal:
        <span class="font-weight-light black--text">
            {{ orders.editedItem.meta.pp_transaction_id }}
        </span>
    </p>
</v-col>

<template v-if="orders.editedItem.status == 3">
    <v-col cols="4" v-if="orders.editedItem.meta.hasOwnProperty('pp_refund_id')">
        <p class="body-1 primary--text">ID-ul de rambursare Paypal:
            <span class="font-weight-light black--text">
                {{ orders.editedItem.meta.pp_refund_id }}
            </span>
        </p>
    </v-col>
</template>