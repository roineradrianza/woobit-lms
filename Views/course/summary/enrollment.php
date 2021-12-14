<v-row>
    <v-col cols="12">
        <?php if (!isset($current_user_has_enroll) || empty($current_user_has_enroll)): ?>
        <?php if (isset($_SESSION['user_id'])): ?>
        <?php if ($data['price'] <= 0): ?>
        <v-col cols="12">
            <v-btn class="secondary white--text py-8 px-8" @click="enrollToCourse(<?= $course_id ?>)" block>
                Obțineți Cursuri <br> gratuit
            </v-btn>
        </v-col>
        <?php else: ?>
        <v-col cols="12">
            <v-btn class="secondary white--text py-6"
                href="<?= SITE_URL ?>/checkout/get?<?= "course_id=${course_id}&course=${title}" ?>" block>
                Obțineți Cursuri <?= $data['price'] ?> RON </v-btn>
        </v-col>
        <v-col class="mt-n4" cols="12">
            <label class="body-1 d-flex justify-center pl-1" v-if="1 == 2">Introduceți cuponul
                de
                reducere</label>
            <v-text-field type="text" v-model="coupon_code" name="coupon_code" class="mt-3 input-text-center"
                placeholder="Introduceți cuponul de reducere" v-if="1 == 2"></v-text-field>
            <v-row class="d-flex justify-center">
                <v-btn class="primary white--text py-4 px-4" @click="checkCoupon(<?= $course_id ?>)"
                    :loading="coupon_loading" v-if="1 == 2">Aplicați cuponul</v-btn>
            </v-row>
            <?php endif?>
            <?= new Controller\Template('components/alert') ?>
            <?php else: ?>

            <v-row>
                <v-col cols="12">
                    <p class="text-center">Pentru a achiziționa acest curs, trebuie mai întâi să
                        vă
                        autentificați.</p>
                </v-col>
                <v-btn class="secondary white--text py-6 px-6"
                    :href="'<?= SITE_URL ?>/login/go?redirect_url=' + current_url">
                    conectați-vă <br></v-btn>
            </v-row>

            <?php endif?>
        </v-col>
        <?php endif?>
    </v-col>
</v-row>