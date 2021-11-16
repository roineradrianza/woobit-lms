			
			<!-- Sizes your content based upon application components -->
			  <v-row >
			  	<v-col class="px-10" cols="12">
              <template>
                <v-toolbar class="bg-transparent" flat>
                  <v-spacer></v-spacer>
                  <v-dialog v-model="dialog" max-width="1400px" >
                      <template v-slot:activator="{ on, attrs }">
                          <v-btn color="secondary" dark pill class="mb-2" v-bind="attrs" v-on="on">
                            <v-icon>mdi-plus</v-icon>
                            Añadir cupón
                          </v-btn>
                      </template>
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
                      <?php echo new Controller\Template('admin/parts/coupon_form') ?>
                    </v-card>
                  </v-dialog>
                  <v-dialog v-model="dialogDelete" max-width="1200px">
                    <v-card>
                      <v-card-title class="headline">¿Estás seguro de que quieres eliminar este cupón?</v-card-title>
                      <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="blue darken-1" text @click="closeDelete">Cancelar</v-btn>
                        <v-btn color="blue darken-1" text @click="deleteItemConfirm">Continuar</v-btn>
                        <v-spacer></v-spacer>
                      </v-card-actions>
                    </v-card>
                  </v-dialog>
                </v-toolbar>
              </template>
            <v-data-table :headers="headers" :items="coupons" sort-by="coupon_name" class="elevation-1" :loading="table_loading">
              <template v-slot:item.actions="{ item }">
                <v-icon md @click="editItem(item)" color="#00BFA5">
                  mdi-pencil
                </v-icon>
                <v-icon md @click="deleteItem(item)" color="#F44336">
                  mdi-delete
                </v-icon>
              </template>
              <template v-slot:item.discount ="{ item }">
                {{ item.discount }} %
              </template>
            </v-data-table>
			  	</v-col>			  	
			  </v-row>
