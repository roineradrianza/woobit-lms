<v-col cols="12">
    <v-sheet class="extra-info-container white">
        <v-col class="primary" cols="12">
        </v-col>
        <v-row>
            <v-col cols="12" md="8">
                <v-row>
                    <v-col cols="12" md="4">
                        <v-list-item append-icon="mdi-account-group">
                            <v-list-item-content>
                                <v-list-item-title class="grey--text text--darken-1 no-white-space">Înregistrat:
                                    <span class="font-weight-light">
                                        <?php if (empty($students['total']) ) : ?>
                                        N/A
                                        <?php else: ?>
                                        <?= $students['total'] ?>
                                        <?php endif?>
                                    </span>
                                </v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </v-col>
                    <v-col cols="12" md="4">
                        <v-list-item>
                            <v-list-item-content>
                                <v-list-item-title class="grey--text text--darken-1 no-white-space">Ore video:
                                    <span class="font-weight-light"><?= $duration ?></span>
                                </v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </v-col>
                    <v-col cols="12" md="4">
                        <v-list-item>
                            <v-list-item-content>
                                <v-list-item-title class="grey--text text--darken-1 no-white-space">Clase:
                                    <span class="font-weight-light">
                                        <?php if (empty($classes['total']) ) : ?>
                                        Próximamente
                                        <?php else: ?>
                                        <?= $classes['total'] ?>
                                        <?php endif?>
                                    </span>
                                </v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </v-col>
                    <?php if(!empty($meta['complementary_material']) ) : ?>    
                    <v-col cols="12" md="4">
                        <v-list-item>
                            <v-list-item-content>
                                <v-list-item-title class="grey--text text--darken-1 no-white-space">Material suplimentar:
                                    <span class="font-weight-light">
                                        <?= $meta['complementary_material'] ?>
                                    </span>
                                </v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </v-col>
                    <?php endif?>
                    <v-col cols="12" md="4">
                        <v-list-item>
                            <v-list-item-content>
                                <v-list-item-title class="grey--text text--darken-1 no-white-space">Nivel: <span
                                        class="font-weight-light"><?= $level ?></span></v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </v-col>
                    <v-col cols="12" md="4">
                        <v-list-item>
                            <v-list-item-content>
                                <v-list-item-title class="grey--text text--darken-1 no-white-space">
                                    <?php if ($platform_owner) : ?>
                                    Por <span class="primary--text">Woobit</span>
                                    <?php else: ?>
                                        <?php if (!empty($meta['manual_teachers']) ) : ?>
                                            Profesori: <span
                                            class="font-weight-light"><?= $meta['manual_teachers'] ?></span>
                                        <?php else: ?>
                                            Profesor: <span
                                            class="font-weight-light"><?= $instructor['first_name'] . ' ' . $instructor['last_name'] ?></span>
                                        <?php endif?>
                                </v-list-item-title>
                                <?php endif?>
                            </v-list-item-content>
                        </v-list-item>
                    </v-col>
                    <v-col cols="12" md="4">
                        <v-list-item>
                            <v-list-item-content>
                                <v-list-item-title class="grey--text text--darken-1 no-white-space">Categoria:
                                    <span class="font-weight-light"><?= $data['category'][0]['name'] ?>
                                        <?php if (!empty($data['subcategory']) ) : ?>
                                        / <?= $data['subcategory'][0]['name'] ?>
                                        <?php endif?>
                                    </span>
                                </v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </v-col>

                </v-row>
            </v-col>
            <v-col cols="12" md="4">
                <?php if (!isset($current_user_has_enroll) || empty($current_user_has_enroll)): ?>
                <?php if (isset($_SESSION['user_id'])): ?>
                <?php if ($data['price'] <= 0): ?>
                <v-col class="d-flex justify-center mt-n4" cols="12">
                    <v-btn class="secondary white--text py-8 px-8" @click="enrollToCourse(<?= $course_id ?>)">
                        Obțineți cursul <br> gratuit
                    </v-btn>
                </v-col>
                <?php else: ?>
                <v-col class="d-flex justify-center mt-n4" cols="12">
                    <v-btn class="secondary white--text py-8 px-8"
                        href="<?= SITE_URL ?>/checkout/?<?= "course_id=${course_id}&course=${title}" ?>"
                        >Obțineți cursul <br>$<?= $data['price'] ?></v-btn>
                </v-col>
                <v-col cols="12">
                    <v-divider></v-divider>
                </v-col>
                <v-col class="mt-n4" cols="12">
                    <label class="body-1 d-flex justify-center pl-1" v-if="1 == 2">Introduceți cuponul de reducere</label>
                    <v-text-field type="text" v-model="coupon_code" name="coupon_code"
                        class="mt-3 input-text-center" placeholder="Introduceți cuponul de reducere" v-if="1 == 2"></v-text-field>
                    <v-row class="d-flex justify-center">
                        <v-btn class="primary white--text py-4 px-4" @click="checkCoupon(<?= $course_id ?>)"
                            :loading="coupon_loading" v-if="1 == 2">Aplicați cuponul</v-btn>
                    </v-row>
                    <?php endif?>
                    <?= new Controller\Template('components/alert') ?>
                    <?php else: ?>

                    <v-row class="d-flex justify-center">
                        <v-col cols="12">
                            <p class="text-center">Pentru a achiziționa acest curs, trebuie mai întâi să vă autentificați.</p>
                        </v-col>
                        <v-btn class="secondary white--text py-6 px-6"
                            :href="'<?= SITE_URL ?>/login/?redirect_url=' + current_url">
                            conectați-vă <br></v-btn>
                    </v-row>

                    <?php endif?>
                </v-col>
                <?php else: ?>
                <?php if (!empty($meta['paid_certified']) && !empty($current_user_has_enroll)): ?>
                <?php if (empty($data['current_user_has_paid_certified'])): ?>
                <v-alert icon="mdi-certificate" prominent type="secondary">
                    <v-row class="d-flex justify-center">
                        <v-col class="grow">
                            Obțineți certificatul de <b><?= $title ?></b> prin 
                            <b>$<?= $meta['certified_price'] ?></b>
                        </v-col>
                        <v-col class="shrink">
                            <v-btn color="white"
                                href="<?= SITE_URL ?>/checkout/?course_id=<?= $course_id ?>&course=<?= $title ?>&extra=certified"
                                outlined>Certificat de plată</v-btn>
                        </v-col>
                    </v-row>
                </v-alert>
                <?php endif?>
                <?php endif?>
                <?php endif?>
            </v-col>
            <?php if (!empty($meta['certified_by']) ) : ?>
            <v-row class="mx-3 mt-n4 white">
                <v-col class="mt-md-n6" cols="12" md="8">
                    <v-row class="d-flex justify-center align-center" no-gutters>
                        <v-col cols="12">
                            <p class="text-h6 text-center">Certificat de:</p>
                        </v-col>
                        <?php foreach (json_decode($meta['certified_by'], true) as $certified_by): ?> 
                        <v-col class="text-center p-0"
                            <?php if(count(json_decode($meta['certified_by'], true)) < 2) :?>
                            cols="12" md="6"
                            <?php else: ?> 
                            cols="6" md="2"
                            <?php endif?>>
                            <?php if(!empty($certified_by['website']) ) : ?>
                                <a href="<?= $certified_by['website'] ?>">
                                    <img src="<?= $certified_by['url'] ?>" style="max-width: 100%"></img>
                                </a>
                            <?php else: ?>
                                <img src="<?= $certified_by['url'] ?>" style="max-width: 100%"></img>
                            <?php endif?> 
                        </v-col>
                        <?php endforeach?>
                    </v-row>
                </v-col>
            </v-row>
            <?php endif?>
        </v-row>
    </v-sheet>
</v-col>