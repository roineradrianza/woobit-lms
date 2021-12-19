<!-- Sizes your content based upon application components -->
<v-row>
    <v-col class="px-10" cols="12">
        <?= new Controller\Template('admin/parts/course_form') ?>
        <v-data-table :headers="headers" :items="courses" sort-by="published_at" class="elevation-1"
            :search="course_search" :loading="table_loading" multi-sort>
            <template #top>
                <v-text-field type="text" placeholder="Căutați..." v-model="course_search" append-icon="mdi-magnify"
                    outlined></v-text-field>
            </template>
            <template #item.price="{ item }">
                <template v-if="item.price <= 0">
                    Gratuit
                </template>
                <template v-else>
                    {{ item.price }} RON
                </template>
            </template>
            <template #item.actions="{ item }">
                <a :href="'<?= SITE_URL ?>/cursuri/'+item.slug">
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
            <template #item.published_at="{ item }">
                {{ formatDate(item.published_at, 'LL') }}
            </template>
            <template #item.active="{ item }">
                <v-chip color="success" outlined v-if="parseInt(item.active)">Activ</v-chip>
                <v-chip color="error" outlined v-else>Inactiv</v-chip>
            </template>
        </v-data-table>
    </v-col>
</v-row>

<v-row class="d-flex justify-center">
    <v-col class="px-10" cols="12" md="6">
        <v-row class="d-flex align-center">
            <v-col class="text-h5" cols="12" md="6">
                <span>Categorii</span>
            </v-col>
            <v-col cols="12" md="6">
                <?= new Controller\Template('admin/parts/category_form') ?>
            </v-col>
        </v-row>
        <v-data-table :headers="categories.headers" :items="categories.items" sort-by="name" class="elevation-1"
            :search="category_search" :loading="categories.table_loading" multi-sort>
            <template #top>
                <v-text-field type="text" placeholder="Căutați..." v-model="category_search" append-icon="mdi-magnify"
                    outlined></v-text-field>
            </template>
            <template #item.actions="{ item }">
                <v-icon md @click="editCategoryItem(item)" color="#00BFA5">
                    mdi-pencil
                </v-icon>
                <v-icon md @click="deleteCategoryItem(item)" color="#F44336">
                    mdi-delete
                </v-icon>
            </template>
            <template #no-data>
                <p class="text-center mt-4">Nu s-au găsit categorii</p>
            </template>
        </v-data-table>
    </v-col>
</v-row>