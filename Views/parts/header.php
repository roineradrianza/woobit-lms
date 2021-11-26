<v-container class="mb-0 pb-0 d-flex justify-center menu white" tag="header" fluid>
    <v-row class="px-md-4 mt-n3 d-flex align-center mw-lg">
        <v-col class="px-8 d-flex justify-center justify-md-start pb-10 pb-md-0" cols="12" md="3">
            <a class="py-md-2" href="/">
                <v-img class="d-none d-md-inline-block d-lg-none" src="<?= SITE_URL ?>/img/woobit-logo.png"
                    max-width="10vw"></v-img>
                <v-img class="d-none d-lg-inline-block d-md-none" src="<?= SITE_URL ?>/img/woobit-logo.png"
                    max-width="6vw"></v-img>
                <v-img class="d-inline-block d-lg-none d-md-none" src="<?= SITE_URL ?>/img/woobit-logo.png"
                    width="25vw"></v-img>
            </a>
        </v-col>
        <v-col cols="12" md="9" class="mt-md-2 mt-n8 d-none d-md-flex justify-center justify-md-end align-center">
            <v-tabs v-model="nav_tab" class="menu-items" background-color="transparent" right>
                <v-tab class="black--text font-weight-bold subtitle-1" key="search_courses">
                    <v-icon>mdi-magnify</v-icon>
                </v-tab>
                <v-tab class="black--text font-weight-bold subtitle-1" key="courses">
                    Cursuri
                </v-tab>
                <v-tab class="black--text font-weight-bold subtitle-1" key="instructors">
                    Lectori
                </v-tab>
                <v-tab class="black--text font-weight-bold subtitle-1" key="about">
                    Despre noi
                </v-tab>
                <?php if (!isset($_SESSION['user_id'])): ?>
                <v-tab href="<?= SITE_URL ?>/register" class="black--text font-weight-bold subtitle-1"
                    key="register">
                    Inregistreaza-te
                </v-tab>
                <v-btn href="<?= SITE_URL ?>/login"
                    class="white--text px-12 py-3 mt-1 text-uppercase font-weight-bold" color="#e70f66">
                    Login
                </v-btn>
                <?php endif ?>
            </v-tabs>
            <?php if (isset($_SESSION['user_id'])): ?>

            <?= new Controller\Template('parts/header/desktop/notification') ?>
            <?= new Controller\Template('parts/header/desktop/account') ?>

            <?php endif ?>
        </v-col>

        <?php if (isset($_SESSION['user_id'])): ?>
        <v-col cols="12" class="mt-md-2 mt-n8 d-flex justify-center justify-md-end align-center d-inline d-md-none">

            <?= new Controller\Template('parts/header/mobile/notification') ?>
            <?= new Controller\Template('parts/header/mobile/account') ?>
        </v-col>
        <?php else: ?>

        <v-col cols="12" md="9" class="mt-md-2 mt-n8 d-flex d-md-none justify-center">
            <v-menu :offset-y="true" bottom transition="slide-y-transition">
                <template #activator="{ on, attrs }">
                    <v-btn icon v-bind="attrs" v-on="on">
                        <v-icon color="primary" md>mdi-menu</v-icon>
                    </v-btn>
                </template>
                <v-list>

                    <v-list-item href="<?= SITE_URL ?>">
                        <v-list-item-content>
                            <v-list-item-title class="text-center"><v-icon>mdi-magnify</v-icon></v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item href="<?= SITE_URL ?>">
                        <v-list-item-content>
                            <v-list-item-title class="text-center">Cursuri</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item href="<?= SITE_URL ?>">
                        <v-list-item-content>
                            <v-list-item-title class="text-center">Lectori</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item href="<?= SITE_URL ?>">
                        <v-list-item-content>
                            <v-list-item-title class="text-center">Despre noi</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item href="<?= SITE_URL ?>/register">
                        <v-list-item-content>
                            <v-list-item-title class="text-center">Înregistrare</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item href="<?= SITE_URL ?>/register">
                        <v-list-item-content>
                            <v-list-item-title class="text-center">
                                <v-btn href="<?= SITE_URL ?>/register"
                                    class="white--text px-12 py-3 mt-1 text-uppercase font-weight-light" color="#e70f66">
                                    Autentificare</v-btn>
                            </v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list>
            </v-menu>
        </v-col>

        <?php endif ?>
    </v-row>
</v-container>