<v-container class="px-4 px-md-0 pt-16 pt-md-0 pb-6">
    <v-row justify="center" style="min-height: 82vh;">

        <v-col class="mb-8" cols="12">
            <h1 class="text-h3 primary--text">Checkout</h1>
        </v-col>
        <v-col cols="12" md="7">
            <v-sheet rounded="xl" color="#F6F6F6">
                <?= new Controller\Template('checkout/form/info') ?>
            </v-sheet>
        </v-col>
        <v-col cols="12" md="5">
            <v-sheet rounded="xl" color="#F6F6F6">
                <?= new Controller\Template('checkout/form/order-summary') ?>
            </v-sheet>
        </v-col>
        
    </v-row>
</v-container>