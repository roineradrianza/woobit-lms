<!-- Sizes your content based upon application components -->
<v-row>
    <?= new Controller\Template('components/snackbar') ?>

    <v-col class="px-10 mt-6" cols="12">
        <v-data-table :headers="orders.headers" :items="orders.items" class="elevation-1" :search="orders.search"
            :loading="table_loading" sort-by="order_id" sort-desc>
            <template #top>
                <v-toolbar flat>
                    <v-toolbar-title>Ordine de plată</v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-text-field class="v-normal-input" v-model="orders.search" append-icon="mdi-magnify"
                        label="Căutare" single-line hide-details></v-text-field>
                </v-toolbar>
            </template>
            <template #item.actions="{ item }">
                <v-icon md @click="previewOrderItem(item)" color="secondary">
                    mdi-eye
                </v-icon>
                <v-icon md @click="deleteOrderItem(item)" color="error">
                    mdi-trash-can
                </v-icon>
            </template>
            <template #item.status="{ item }">
                <v-chip :color="getStatus(item.status).color">{{ getStatus(item.status).name }}</v-chip>
            </template>
        </v-data-table>
    </v-col>
    <?= new Controller\Template('admin/parts/order/preview') ?>
    <?= new Controller\Template('admin/parts/order/refund-dialog') ?>
    <?= new Controller\Template('admin/parts/order/delete') ?>
</v-row>