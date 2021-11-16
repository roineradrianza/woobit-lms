<v-row class="d-flex justify-center" v-if="sections.length > 0">
    <v-col cols="12">
        <v-data-table :headers="orders.headers" :items="orders.items" class="elevation-1" :loading="my_orders_loading"
            sort-by="order_id" sort-desc>
            <template #item.payment_method="{ item }">
                <template v-if="item.payment_method == 'Bank Transfer(Bs)'">
                    Transferencia Bancaria(Bs)
                </template>
                <template v-else>
                    {{ item.payment_method }}
                </template>
            </template>
        </v-data-table>
    </v-col>
</v-row>