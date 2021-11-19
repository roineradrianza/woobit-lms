<v-menu content-class="notification" center bottom transition="slide-y-transition">
    <template #activator="{ on, attrs }">
        <v-btn icon v-bind="attrs" v-on="on">
            <?php if ($_SESSION['avatar'] == null): ?>
            <v-icon color="primary" md>mdi-account</v-icon>
            <?php else: ?>
            <v-avatar>
                <img src="<?php echo $_SESSION['avatar'] ?>"
                    alt="<?php echo $_SESSION['first_Meniul administrativme'] ?>">
            </v-avatar>
            <?php endif ?>
        </v-btn>
    </template>
    <v-list>

        <v-list-item class="d-flex justify-center" href="<?php echo SITE_URL ?>">
            <v-icon>mdi-magnify</v-icon>
        </v-list-item>
        <?php if ($_SESSION['user_type'] == 'administrador'): ?>
        <v-list-item href="<?php echo SITE_URL ?>">
            <v-list-item-content>
                <v-list-item-title class="text-center">Acasă</v-list-item-title>
            </v-list-item-content>
        </v-list-item>
        <v-list-item href="<?php echo SITE_URL ?>/admin/">
            <v-list-item-content>
                <v-list-item-title class="text-center">Meniul administrativ</v-list-item-title>
            </v-list-item-content>
        </v-list-item>
        <?php endif ?>
        <v-list-item href="<?php echo SITE_URL ?>/profile/">
            <v-list-item-content>
                <v-list-item-title class="text-center">Profil</v-list-item-title>
            </v-list-item-content>
        </v-list-item>
        <v-list-item>
            <v-btn color="red" href="<?php echo SITE_URL ?>/api/members/logout" text
                onclick="gapi.auth2.getAuthInstance().signOut()">Deconectați-vă</v-btn>
        </v-list-item>
    </v-list>
</v-menu>