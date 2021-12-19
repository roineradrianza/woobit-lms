<?= new Controller\Template('parts/header/search-form') ?>
<v-app-bar ref="header_menu" class="bg-white sidebar pb-4" fixed flat prominent app>
    <v-container class="mb-0 pb-0 pt-0 d-flex justify-center">
        <v-row align="end">
            <v-col class="d-md-none" cols="1">
                <v-app-bar-nav-icon class="primary--text"
                    @click.stop="$refs.drawer.isActive = !$refs.drawer.isActive;$refs.drawer.$el.scrollIntoView()">
                </v-app-bar-nav-icon>
            </v-col>
            <v-col class="d-flex justify-center justify-md-start pt-6 px-md-0" :cols="$vuetify.breakpoint.mdAndUp ? 3 : 10">
                <a href="/">
                    <v-img class="d-none d-md-inline-block d-lg-none" src="<?= SITE_URL ?>/img/woobit-logo.png"
                        max-width="10vw" contain></v-img>
                    <v-img class="d-none d-lg-inline-block d-md-none" src="<?= SITE_URL ?>/img/woobit-logo.png"
                        max-width="6vw" contain></v-img>
                    <v-img class="d-inline-block d-lg-none d-md-none" src="<?= SITE_URL ?>/img/woobit-logo.png"
                        max-width="15vw" contain></v-img>
                </a>
            </v-col>
            <v-col class="d-flex justify-end px-md-0" :cols="$vuetify.breakpoint.mdAndUp ? 9 : 1">
                <v-btn class="d-md-none" @click="$refs.menu_search_dialog.isActive = true" icon>
                    <v-icon>mdi-magnify</v-icon>
                </v-btn>
                <?php if(isset($_SESSION['user_id'])): ?>
                <template v-if="!$vuetify.breakpoint.mdAndUp">
                    <?= new Controller\Template('parts/header/mobile/notification') ?>
                </template>
                <?php endif?>
                <v-tabs v-model="nav_tab" class="menu-items d-none d-md-inline" background-color="transparent" right>
                    <v-tab class="black--text font-weight-bold subtitle-1" key="search_courses" @click="$refs.menu_search_dialog.isActive = true">
                        <v-icon>mdi-magnify</v-icon>
                    </v-tab>
                    <v-tab class="black--text font-weight-bold subtitle-1" key="courses" class="d-none d-md-inline">
                        Cursuri
                    </v-tab>
                    <v-tab href="<?= SITE_URL ?>/lectori" class="black--text font-weight-bold subtitle-1"
                        key="instructors" class="d-none d-md-inline">
                        Lectori
                    </v-tab>
                    <v-tab href="<?= SITE_URL ?>/despre-noi" class="black--text font-weight-bold subtitle-1" key="about"
                        class="d-none d-md-inline">
                        Despre noi
                    </v-tab>
                    <?php if (!isset($_SESSION['user_id'])): ?>
                    <v-tab href="<?= SITE_URL ?>/inregistrare" class="black--text font-weight-bold subtitle-1"
                        key="register" class="d-none d-md-inline">
                        Înregistrează-te
                    </v-tab>
                    <v-btn href="<?= SITE_URL ?>/login"
                        class="white--text px-6 py-2 mt-1 text-uppercase font-weight-bold" color="#e70f66"
                        class="d-none d-md-inline">
                        Login
                    </v-btn>
                    <?php else: ?>
                    <?= new Controller\Template('parts/header/desktop/notification') ?>
                    <?= new Controller\Template('parts/header/desktop/account') ?>
                    <?php endif ?>
                </v-tabs>
            </v-col>
        </v-row>
    </v-container>
</v-app-bar>
<?= new Controller\Template('parts/aside') ?>
