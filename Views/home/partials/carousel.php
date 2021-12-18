<v-carousel v-model="carousel" class="no-ha" :show-arrows="false" cycle hide-delimiters>
    <?php for ($i = 1; $i <= 1; $i++): ?>
    <v-carousel-item height="100%">
        <?= new Controller\Template("home/partials/slides/$i") ?>
    </v-carousel-item>
    <?php endfor?>
</v-carousel>