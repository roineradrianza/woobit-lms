<?php if(!empty($data)) : ?>
<v-row>
    <v-col cols="12">
        <h3 class="text-h4 text-center">Subiecte populare</h3>
    </v-col>
    <v-col class="mx-auto" cols="12" md="10">
        <v-row justify="center">
            <?php foreach($data as $category) : ?>
                <v-chip class="mx-2 my-2" color="primary" href="<?= SITE_URL?>/categorie/<?= $category['category_id'] ?>">
                    <?= $category['name'] ?>
                </v-chip>
            <?php endforeach ?>
        </v-row>
    </v-col>
</v-row>

<?php endif ?>