
            <template>
              <v-toolbar class="bg-transparent" flat>
                <v-spacer></v-spacer>
                <v-dialog v-model="dialog" max-width="95%" @click:outside="dialog = false">
                  <v-card>
                    <v-toolbar class="gradient" elevation="0">
                      <v-toolbar-title class="white--text">{{ formTitle }}</v-toolbar-title>
                      <v-spacer></v-spacer>
                      <v-toolbar-items>
                      <v-btn icon dark @click="dialog = false">
                        <v-icon color="white">mdi-close</v-icon>
                      </v-btn>
                      </v-toolbar-items>
                    </v-toolbar>
                    
                    <v-divider></v-divider>
                    <v-form v-model="valid" lazy-validation>
                      <v-card-text>
                        <v-container fluid>
                          <v-row>
                          	<v-col cols="12">
                          		<v-row>
		                            
                                <template v-if="payments.editedItem.name == 'Zelle'">
                                  <?= new Controller\Template('admin/parts/payment/zelle') ?>
                                </template>

                                <template v-else-if="payments.editedItem.name == 'Bank Transfer(Bs)'">
                                  <?= new Controller\Template('admin/parts/payment/bs-bank-transfer') ?>
                                </template>

                                <template v-else-if="payments.editedItem.name == 'PagoMovil'">
                                  <?= new Controller\Template('admin/parts/payment/pagomovil') ?>
                                </template>

                          		</v-row>
                          	</v-col>
                          </v-row>
                        </v-container>
                      </v-card-text>

                      <v-card-actions class="px-4">
                        <v-spacer></v-spacer>
                        <v-btn color="secondary white--text" block @click="save" :disabled="!valid" :loading="loading">
                          {{ formTitle }}
                        </v-btn>
                      </v-card-actions>
                    </v-form>
                  </v-card>
                </v-dialog>
              </v-toolbar>
            </template>
