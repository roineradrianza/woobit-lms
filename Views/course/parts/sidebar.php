<v-col cols="12">
    <v-sheet class="extra-info-container white">
        <v-col class="primary" cols="12">
            <p class="white--text text-center text-h5 pt-2" block color="primary">Full Learning</p>
        </v-col>
        <v-row>
            <v-col cols="12" md="8">
                <v-row>
                    <v-col cols="12" md="4">
                        <v-list-item append-icon="mdi-account-group">
                            <v-list-item-content>
                                <v-list-item-title class="grey--text text--darken-1 no-white-space">Inscrito:
                                    <span class="font-weight-light">
                                        <?php if (empty($students['total']) ) : ?>
                                        N/A
                                        <?php else: ?>
                                        <?php echo $students['total'] ?>
                                        <?php endif?>
                                    </span>
                                </v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </v-col>
                    <v-col cols="12" md="4">
                        <v-list-item>
                            <v-list-item-content>
                                <v-list-item-title class="grey--text text--darken-1 no-white-space">Horas en video:
                                    <span class="font-weight-light"><?php echo $duration ?></span>
                                </v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </v-col>
                    <v-col cols="12" md="4">
                        <v-list-item>
                            <v-list-item-content>
                                <v-list-item-title class="grey--text text--darken-1 no-white-space">Clases:
                                    <span class="font-weight-light">
                                        <?php if (empty($classes['total']) ) : ?>
                                        Próximamente
                                        <?php else: ?>
                                        <?php echo $classes['total'] ?>
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
                                <v-list-item-title class="grey--text text--darken-1 no-white-space">Material complementario:
                                    <span class="font-weight-light">
                                        <?php echo $meta['complementary_material'] ?>
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
                                        class="font-weight-light"><?php echo $level ?></span></v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </v-col>
                    <v-col cols="12" md="4">
                        <v-list-item>
                            <v-list-item-content>
                                <v-list-item-title class="grey--text text--darken-1 no-white-space">
                                    <?php if ($platform_owner) : ?>
                                    Por <span class="primary--text">Full Learning</span>
                                    <?php else: ?>
                                        <?php if (!empty($meta['manual_teachers']) ) : ?>
                                            Profesores: <span
                                            class="font-weight-light"><?php echo $meta['manual_teachers'] ?></span>
                                        <?php else: ?>
                                            Profesor: <span
                                            class="font-weight-light"><?php echo $instructor['first_name'] . ' ' . $instructor['last_name'] ?></span>
                                        <?php endif?>
                                </v-list-item-title>
                                <?php endif?>
                            </v-list-item-content>
                        </v-list-item>
                    </v-col>
                    <v-col cols="12" md="4">
                        <v-list-item>
                            <v-list-item-content>
                                <v-list-item-title class="grey--text text--darken-1 no-white-space">Categoría:
                                    <span class="font-weight-light"><?php echo $data['category'][0]['name'] ?>
                                        <?php if (!empty($data['subcategory']) ) : ?>
                                        / <?php echo $data['subcategory'][0]['name'] ?>
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
                    <v-btn class="secondary white--text py-8 px-8" @click="enrollToCourse(<?php echo $course_id ?>)"
                        rounded pill>Obtén el curso <br> Gratis
                    </v-btn>
                </v-col>
                <?php else: ?>
                <v-col class="d-flex justify-center mt-n4" cols="12">
                    <v-btn class="secondary white--text py-8 px-8"
                        href="<?php echo SITE_URL ?>/checkout/?<?php echo "course_id=${course_id}&course=${title}" ?>"
                        rounded pill>Obtén el curso <br>$<?php echo $data['price'] ?></v-btn>
                </v-col>
                <v-col cols="12">
                    <v-divider></v-divider>
                </v-col>
                <v-col class="mt-n4" cols="12">
                    <label class="body-1 d-flex justify-center pl-1">Ingresar cupón de descuento</label>
                    <v-text-field type="text" v-model="coupon_code" name="coupon_code"
                        class="mt-3 fl-text-input input-text-center" placeholder="Ingresa tu cupón de descuento acá"
                        filled rounded dense></v-text-field>
                    <v-row class="d-flex justify-center">
                        <v-btn class="primary white--text py-4 px-4" @click="checkCoupon(<?php echo $course_id ?>)"
                            :loading="coupon_loading" rounded pill>Aplicar cupón</v-btn>
                    </v-row>
                    <?php endif?>
                    <?php echo new Controller\Template('components/alert') ?>
                    <?php else: ?>

                    <v-row class="d-flex justify-center">
                        <v-col cols="12">
                            <p class="text-center">Para adquirir este curso primero debes iniciar sesión.</p>
                        </v-col>
                        <v-btn class="secondary white--text py-6 px-6"
                            :href="'<?php echo SITE_URL ?>/login/?redirect_url=' + current_url" rounded pill>
                            iniciar sesión <br></v-btn>
                    </v-row>

                    <?php endif?>
                </v-col>
                <?php else: ?>
                <?php if (!empty($meta['paid_certified']) && !empty($current_user_has_enroll)): ?>
                <?php if (empty($data['current_user_has_paid_certified'])): ?>
                <v-alert icon="mdi-certificate" prominent type="secondary">
                    <v-row class="d-flex justify-center">
                        <v-col class="grow">
                            Obten tu certificado de <b><?php echo $title ?></b> por
                            <b>$<?php echo $meta['certified_price'] ?></b>
                        </v-col>
                        <v-col class="shrink">
                            <v-btn color="white"
                                href="<?php echo SITE_URL ?>/checkout/?course_id=<?php echo $course_id ?>&course=<?php echo $title ?>&extra=certified"
                                outlined>Pagar certificado</v-btn>
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
                            <p class="text-h6 text-center">Certificado por:</p>
                        </v-col>
                        <?php foreach (json_decode($meta['certified_by'], true) as $certified_by): ?> 
                        <v-col class="text-center p-0"
                            <?php if(count(json_decode($meta['certified_by'], true)) < 2) :?>
                            cols="12" md="6"
                            <?php else: ?> 
                            cols="6" md="2"
                            <?php endif?>>
                            <?php if(!empty($certified_by['website']) ) : ?>
                                <a href="<?php echo $certified_by['website'] ?>">
                                    <img src="<?php echo $certified_by['url'] ?>" style="max-width: 100%"></img>
                                </a>
                            <?php else: ?>
                                <img src="<?php echo $certified_by['url'] ?>" style="max-width: 100%"></img>
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