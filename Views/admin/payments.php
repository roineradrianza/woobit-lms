			
			<!-- Sizes your content based upon application components -->
			  <v-row >
			  	<v-col class="px-10 mt-6" cols="12">
            <v-data-table :headers="orders.headers" :items="orders.items" class="elevation-1" :search="orders.search" :loading="table_loading" sort-by="order_id" sort-desc>
              <template v-slot:top>
                  <v-toolbar flat>
                    <v-toolbar-title>Órdenes de Pago</v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-text-field class="v-normal-input" v-model="orders.search" append-icon="mdi-magnify" label="Buscar" single-line hide-details></v-text-field>
                  </v-toolbar>
              </template>
              <template v-slot:item.actions="{ item }">
                <v-icon md @click="previewOrderItem(item)" color="secondary">
                  mdi-eye
                </v-icon>
                <v-icon md @click="deleteOrderItem(item)" color="error">
                  mdi-trash-can
                </v-icon>
              </template>
              <template v-slot:item.status="{ item }">
                <v-chip :color="getStatus(item.status).color">{{ getStatus(item.status).name }}</v-chip>
              </template>
            </v-data-table>
			  	</v-col>
          <v-col class="px-10" cols="12" md="4">
            <v-data-table :headers="payments.headers" :items="payments.items" class="elevation-1" :loading="table_loading" multi-sort>
              <template v-slot:top>
                  <v-toolbar flat>
                    <v-toolbar-title>Métodos de pago</v-toolbar-title>
                  </v-toolbar>
              </template>
              <template v-slot:item.actions="{ item }">
                <v-icon md @click="editItem(item)" color="#00BFA5">
                  mdi-pencil
                </v-icon>
              </template>
            </v-data-table>
          </v-col>
          <v-col class="pr-10" cols="12" md="8">
            <v-data-table :headers="orders.headers" :items="orders.processing_items" class="elevation-1" :search="orders.search" :loading="table_loading" sort-by="order_id" sort-desc>
              <template v-slot:top>
                <v-toolbar flat>
                  <v-toolbar-title>Órdenes Pendientes</v-toolbar-title>
                  <v-spacer></v-spacer>
                  <v-text-field class="v-normal-input" v-model="orders.search" append-icon="mdi-magnify" label="Buscar" single-line hide-details></v-text-field>
                </v-toolbar>
              </template>
              <template v-slot:item.actions="{ item }">
                <v-icon md @click="previewOrderItem(item)" color="secondary">
                  mdi-eye
                </v-icon>
                <v-icon md @click="deleteOrderItem(item)" color="error">
                  mdi-trash-can
                </v-icon>
              </template>
              <template v-slot:item.status="{ item }">
                <v-chip :color="getStatus(item.status).color">{{ getStatus(item.status).name }}</v-chip>
              </template>
            </v-data-table>
          </v-col>
          <?= new Controller\Template('admin/parts/order/preview') ?>
          <?= new Controller\Template('admin/parts/order/delete') ?>
          <?= new Controller\Template('admin/parts/payment_form') ?>
			  </v-row>
