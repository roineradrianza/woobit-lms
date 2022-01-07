<v-menu content-class="menu_logged_mobile" center bottom transition="slide-y-transition">
    <template #activator="{ on, attrs }">
        <v-btn icon v-bind="attrs" v-on="on">
            <?php if ($_SESSION['avatar'] == null): ?>
            <v-icon color="primary" md>mdi-account</v-icon>
            <?php else: ?>
            <v-avatar>
                <img src="<?= $_SESSION['avatar'] ?>" alt="<?= $_SESSION['first_name'] ?>">
            </v-avatar>
            <?php endif ?>
        </v-btn>
    </template>
    <v-list>
        <v-list-item class="d-flex d-md-none justify-center">
            <v-icon>mdi-magnify</v-icon>
        </v-list-item>
        <?php if ($_SESSION['user_type'] == 'administrator'): ?>

        <v-list-item href="<?= SITE_URL ?>">
            <v-list-item-content>
                <v-list-item-title class="text-center">Acasă</v-list-item-title>
            </v-list-item-content>
        </v-list-item>
        <v-list-item href="<?= SITE_URL ?>/admin/">
            <v-list-item-content>
                <v-list-item-title class="text-center">Meniul administrativ</v-list-item-title>
            </v-list-item-content>
        </v-list-item>
        <?php endif ?>
        <v-list-item href="<?= SITE_URL ?>/panel/">
            <v-list-item-content>
                <v-list-item-title class="text-center">Panou</v-list-item-title>
            </v-list-item-content>
        </v-list-item>
        <v-list-item href="<?= SITE_URL ?>/profil-lector/">
            <v-list-item-content>
                <v-list-item-title class="text-center">Profil</v-list-item-title>
            </v-list-item-content>
        </v-list-item>
        <v-list-item>
            <v-btn color="primary" href="<?= SITE_URL ?>/lectori" block>Aplicație lector</v-btn>
        </v-list-item>
        <v-list-item>
            <v-btn color="red" href="<?= SITE_URL ?>/api/members/logout" text
                onclick="gapi.auth2.getAuthInstance().signOut()">Deconectează-te</v-btn>
        </v-list-item>
    </v-list>
</v-menu>