<div class="d-flex justify-center">
    <v-avatar size="150px">
        <img class="mb-6 obj-cover" src="<?= $avatar ?>"></img>
    </v-avatar>
</div>
<h4 class="text-center font-weight-bold text-h6"><?= $full_name ?></h4>
<p class="text-center font-weight-bold">Lectori</p>
<p class="d-flex justify-center">
    <v-rating value="<?= round($ratings['average']) ?>" color="amber" dense half-increments readonly size="25">
    </v-rating>

    <strong>
        <?= round($ratings['average'], 1) ?>
    </strong>
</p>
<p class="grey--text lighten-1 text-center mt-n3">
    <?= !empty($ratings['total']) ? "{$ratings['total']} recenzie" : "{$ratings['total']} recenzii" ?>
</p>