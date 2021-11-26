<v-menu content-class="notification" right bottom>
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

        <v-list-item class="d-flex justify-center">
            <v-icon>mdi-magnify</v-icon>
        </v-list-item>
        <?php if ($_SESSION['user_type'] == 'administrador'): ?>
        <v-list-item class="d-flex justify-center">
            <v-btn href="<?php SITE_URL ?>" text>Acasă</v-btn>
        </v-list-item>
        <v-list-item class="d-flex justify-center">
            <v-btn href="<?php SITE_URL ?>/admin/" text>Meniul administrativ</v-btn>
        </v-list-item>
        <?php endif ?>
        <v-list-item class="d-flex justify-center">
            <v-btn href="<?php SITE_URL ?>/profile/" text>Profil</v-btn>
        </v-list-item>
        <v-list-item class="d-flex justify-center" v-if="1 == 2">
            <v-btn href="<?php SITE_URL ?>/my-courses" text>Cursurile meles</v-btn>
        </v-list-item>
        <v-list-item>
            <v-btn color="primary" href="<?= SITE_URL ?>/how-become-teacher"block>Aplică</v-btn>
        </v-list-item>
        <v-list-item class="d-flex justify-center">
            <v-btn color="red" href="<?php SITE_URL ?>/api/members/logout" text
                onclick="gapi.auth2.getAuthInstance().signOut()">Deconectați-vă</v-btn>
        </v-list-item>
    </v-list>
</v-menu>