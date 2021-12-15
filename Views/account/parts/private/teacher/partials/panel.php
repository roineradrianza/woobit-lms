<v-col cols="12" md="3">
    <v-card href="<?= SITE_URL ?>/become-teacher" class="pb-8 pt-12" color="primary" rounded="xl" flat>
        <div class="d-flex justify-center">
            <v-img src="<?= SITE_URL?>/img/profile/teacher/menu-icon-1.svg" max-width="90px" contain></v-img>
        </div>
        <v-card-title class="d-flex justify-center" primary-title>
            <div>
                <h3 class="headline mb-0 accent--text font-weight-bold">Aplică</h3>
            </div>
        </v-card-title>
        <v-card-actions class="d-flex justify-center">
            <v-btn href="<?= SITE_URL ?>/become-teacher" icon>
                <v-icon color="#024D96" x-large>mdi-plus</v-icon>
            </v-btn>
        </v-card-actions>
    </v-card>
</v-col>

<v-col cols="12" md="3">
    <v-card href="<?= SITE_URL ?>/my-profile" class="pb-8 pt-12" color="primary" rounded="xl" flat>
        <div class="d-flex justify-center">
            <v-img src="<?= SITE_URL?>/img/profile/teacher/menu-icon-2.svg" max-width="90px" contain></v-img>
        </div>
        <v-card-title class="d-flex justify-center" primary-title>
            <div>
                <h3 class="headline mb-0 accent--text font-weight-bold">Profilul tău public</h3>
            </div>
        </v-card-title>
        <v-card-actions class="d-flex justify-center">
            <v-btn href="<?= SITE_URL ?>/my-profile" icon>
                <v-icon color="#024D96" x-large>mdi-plus</v-icon>
            </v-btn>
        </v-card-actions>
    </v-card>
</v-col>
<?php if ($status) : ?>
<v-col cols="12" md="3">
    <v-card href="<?= SITE_URL ?>/my-courses" class="pb-8 pt-12" color="primary" rounded="xl" flat>
        <div class="d-flex justify-center">
            <v-img src="<?= SITE_URL?>/img/profile/teacher/menu-icon-3.svg" max-width="90px" contain></v-img>
        </div>
        <v-card-title class="d-flex justify-center" primary-title>
            <div>
                <h3 class="headline mb-0 accent--text font-weight-bold">Cursurile Tale</h3>
            </div>
        </v-card-title>
        <v-card-actions class="d-flex justify-center">
            <v-btn href="<?= SITE_URL ?>/my-courses" icon>
                <v-icon color="#024D96" x-large>mdi-plus</v-icon>
            </v-btn>
        </v-card-actions>
    </v-card>
</v-col>

<v-col cols="12" md="3">
    <v-card href="<?= SITE_URL ?>/become-teacher" class="pb-8 pt-12" color="primary" rounded="xl" flat>
        <div class="d-flex justify-center">
            <v-img src="<?= SITE_URL?>/img/profile/teacher/menu-icon-4.svg" max-width="90px" contain></v-img>
        </div>
        <v-card-title class="d-flex justify-center" primary-title>
            <div>
                <h3 class="headline mb-0 accent--text font-weight-bold">Retrospectiva</h3>
            </div>
        </v-card-title>
        <v-card-actions class="d-flex justify-center">
            <v-btn href="<?= SITE_URL ?>/become-teacher" icon>
                <v-icon color="#024D96" x-large>mdi-plus</v-icon>
            </v-btn>
        </v-card-actions>
    </v-card>
</v-col>
<?php endif?>