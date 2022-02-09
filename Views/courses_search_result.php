<?php if(!empty($search_item)) : ?>
<v-row class="gradient pt-12 pb-12 pl-md-16 pr-md-10">
    <v-col class="pl-10" cols="12">
        <h1 class="white--text text-h2">Rezultate pentru "<?= $search_item ?>"</h1>
    </v-col>
</v-row>
<?php endif ?>
<?php if( !empty($category) ) : ?>
<v-row class="gradient pt-12 pb-12 pl-md-16 pr-md-10">
    <v-col class="pl-10" cols="12">
        <h1 class="white--text text-h2">Cursuri pe categorii "<?= $category['name'] ?>"</h1>
    </v-col>
</v-row>
<?php endif ?>
<v-row class="d-flex justify-center">
    <v-col class="ml-md-n2" cols="12" md="5">
        <v-text-field v-model="search" name="search" class="font-weight-light" label="Ce dorești să înveți?" 
            @keyup.enter="searchCourse" light flat outlined solo>
            <template #append>
                <v-btn class="mx-md-0" color="secondary" :href="'<?= SITE_URL ?>/cursuri/get?search=' + search + 
                '&start_date=' + start_date + '&category=' + category"
                    text icon>
                    <v-icon size="25">mdi-magnify</v-icon>
                </v-btn>
            </template>
        </v-text-field>
    </v-col>
    
    <v-col class="ml-md-n2" cols="12" md="2">
        <v-dialog ref="start_date_dialog" v-model="start_date_modal" :return-value.sync="start_date"
            width="20vw">
            <template #activator="{ on, attrs }">
                <v-text-field v-model="start_date" name="start_date" label="Data de începere" readonly v-bind="attrs" v-on="on" outlined>
                    <template #append>
                        <v-icon v-bind="attrs" v-on="on">
                            mdi-calendar
                        </v-icon>
                    </template>
                </v-text-field>
            </template>
            <v-date-picker v-model="start_date" scrollable>
                <v-spacer></v-spacer>
                <v-btn text color="primary" @click="start_date_modal = false">
                    Anulează
                </v-btn>
                <v-btn text color="primary" @click="$refs.start_date_dialog.save(start_date)">
                    OK
                </v-btn>
            </v-date-picker>
        </v-dialog>
    </v-col>
    
    <v-col class="ml-md-n2" cols="12" md="2">
        <v-select v-model="category" :items="[
            {
                text: '',
                value: '',
            },
            <?php foreach($categories as $category): ?>
                <?php if($category['courses'] > 0) : ?>
                    {
                        text: '<?= $category['name'] ?>',
                        value: <?= $category['category_id'] ?>
                    },
                <?php endif ?>
            <?php endforeach?>
            ]" name="category" label="Categorie" outlined>
        </v-select>
    </v-col>
    
    <?php if (empty($courses)): ?>
    <?= new Controller\Template('courses/parts/not_results'); ?>
    <?php else: ?>
    <v-col cols="12" md="10">
        <?= new Controller\Template('courses/parts/search_results', $courses) ?>
    </v-col>
    <?php endif ?>
</v-row>