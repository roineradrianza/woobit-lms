<v-list dense>
    <v-list-item class="px-6" two-line>
        <?php if ($_SESSION['avatar'] == null): ?>
        <v-icon color="primary" md>mdi-account</v-icon>
        <?php else: ?>
        <v-list-item-avatar>
            <img src="<?= $_SESSION['avatar'] ?>" alt="<?= $_SESSION['first_name'] ?>">
        </v-list-item-avatar>
        <?php endif ?>
        <v-list-item-content>
            <v-list-item-title><?= "{$_SESSION['first_name']} {$_SESSION['last_name']}" ?>
            </v-list-item-title>
        </v-list-item-content>
    </v-list-item>

    <?php if ($_SESSION['user_type'] == 'administrator'): ?>
    <v-list-item>
        <v-btn href="<?= SITE_URL ?>" text>Acasă</v-btn>
    </v-list-item>
    <v-list-item>
        <v-btn href="<?= SITE_URL ?>/admin/" text>Meniul administrativ</v-btn>
    </v-list-item>
    <?php endif ?>
    <v-list-item>
        <v-btn href="<?= SITE_URL ?>/panel" text>Panou</v-btn>
    </v-list-item>
    <v-list-item>
        <v-btn href="<?= SITE_URL ?>/profil-lector" text>Profil</v-btn>
    </v-list-item>
    <v-list-item v-if="1 == 2">
        <v-btn href="<?= SITE_URL ?>/cursurile-mele" text>Cursurile meles</v-btn>
    </v-list-item>
    <v-list-item class="px-6">
        <v-btn color="primary" href="<?= SITE_URL ?>/lectori" block>Aplicație lector</v-btn>
    </v-list-item>
    <v-list-item>
        <v-btn color="red" href="<?= SITE_URL ?>/api/members/logout" text
            onclick="gapi.auth2.getAuthInstance().signOut()">Deconectați-vă</v-btn>
    </v-list-item>
</v-list>