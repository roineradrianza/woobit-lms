<v-navigation-drawer ref="drawer" v-if="!$vuetify.breakpoint.mdAndUp" app>
    <?php if(isset($_SESSION['user_id'])): ?>
        <?= new Controller\Template('parts/header/aside-menu/logged') ?>
    <?php else: ?>
        <?= new Controller\Template('parts/header/aside-menu/guest') ?>
    <?php endif ?>
</v-navigation-drawer>