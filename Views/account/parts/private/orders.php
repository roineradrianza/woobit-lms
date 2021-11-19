          
          <v-col class="white px-12 py-md-8 info-container mx-md-6" cols="12" md="7" v-if="orders_container">
            <v-row>
              <v-col class="mt-6" cols="12">
                <v-data-table :headers="orders.headers" :items="orders.items" class="elevation-1" :loading="my_orders_loading" sort-by="order_id" sort-desc>
                  <template #top>
                      <v-toolbar flat>
                        <v-toolbar-title>Ordine de plată</v-toolbar-title>
                      </v-toolbar>
                  </template>
                  <template #item.actions="{ item }">
                    <v-icon md @click="previewOrderItem(item)" color="secondary">
                      mdi-eye
                    </v-icon>
                  </template>
                  <template #item.status="{ item }">
                    <v-chip :color="getOrderStatus(item.status).color">{{ getOrderStatus(item.status).name }}</v-chip>
                  </template>
                </v-data-table>
              </v-col>
              <?= new Controller\Template('account/parts/private/order/preview') ?>
            </v-row>
          </v-col>
