			
			<!-- Sizes your content based upon application components -->
			  <v-row >
			  	<v-col class="px-10" cols="12">
            <?php echo new Controller\Template('admin/parts/course_form') ?>
            <v-data-table :headers="headers" :items="courses" sort-by="published_at" class="elevation-1" :loading="table_loading" multi-sort>
              <template v-slot:item.actions="{ item }">
                <a :href="'<?php SITE_URL ?>/courses/'+item.slug">
                  <v-icon md color="primary">
                    mdi-eye
                  </v-icon>
                </a>
                <v-icon md @click="editItem(item)" color="#00BFA5">
                  mdi-pencil
                </v-icon>
                <v-icon md @click="deleteItem(item)" color="#F44336">
                  mdi-delete
                </v-icon>
              </template>
              <template v-slot:item.published_at="{ item }">
                {{ formatDate(item.published_at, 'LL') }}
              </template>
              <template v-slot:item.active="{ item }">
                <v-chip color="green" outlined v-if="parseInt(item.active)">Activo</v-chip>
                <v-chip color="red" outlined v-else>Inactivo</v-chip>
              </template>
            </v-data-table>
			  	</v-col>			  	
			  </v-row>

        <v-row class="d-flex justify-center">
          <v-col class="px-10" cols="12" md="6">
            <v-row class="d-flex align-center">
              <v-col class="text-h5" cols="12" md="6">
                <span>Categorías</span>
              </v-col>
              <v-col cols="12" md="6">
              <?php echo new Controller\Template('admin/parts/category_form') ?>                
              </v-col>
            </v-row>
            <v-data-table :headers="categories.headers" :items="categories.items" sort-by="name" class="elevation-1" :loading="categories.table_loading" multi-sort>
              <template v-slot:item.actions="{ item }">
                <v-icon md @click="editCategoryItem(item)" color="#00BFA5">
                  mdi-pencil
                </v-icon>
                <v-icon md @click="deleteCategoryItem(item)" color="#F44336">
                  mdi-delete
                </v-icon>
              </template>
              <template v-slot:no-data>
                <p class="text-center mt-4">No se encontraron categorías</p>
              </template>
            </v-data-table>
          </v-col>          
          <v-col class="px-10" cols="12" md="6">
            <v-row class="d-flex align-center">
              <v-col class="text-h5" cols="12" md="6">
                <span>Subcategorías</span>
              </v-col>
              <v-col cols="12" md="6">
              <?php echo new Controller\Template('admin/parts/subcategory_form') ?>                
              </v-col>
            </v-row>
            <v-data-table :headers="subcategories.headers" :items="subcategories.items" sort-by="name" class="elevation-1" :loading="subcategories.table_loading" multi-sort>
              <template v-slot:item.actions="{ item }">
                <v-icon md @click="editSubCategoryItem(item)" color="#00BFA5">
                  mdi-pencil
                </v-icon>
                <v-icon md @click="deleteSubCategoryItem(item)" color="#F44336">
                  mdi-delete
                </v-icon>
              </template>
              <template v-slot:no-data>
                <p class="text-center mt-4">No se encontraron subcategorías</p>
              </template>
            </v-data-table>
          </v-col>          
        </v-row>
