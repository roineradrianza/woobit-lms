<v-menu content-class="notification" right bottom>
    <template #activator="{ on, attrs }">
        <v-btn icon v-bind="attrs" v-on="on">
            <?php if ($_SESSION['avatar'] == null): ?>
            <v-icon color="primary" md>mdi-account</v-icon>
            <?php else: ?>
            <v-avatar>
                <img src="<?php echo $_SESSION['avatar'] ?>" alt="<?php echo $_SESSION['first_name'] ?>">
            </v-avatar>
            <?php endif ?>
        </v-btn>
    </template>
    <v-list>
        <?php if ($_SESSION['user_type'] == 'administrador'): ?>
        <v-list-item class="d-flex justify-center">
            <v-btn href="<?php SITE_URL ?>" text>Inicio</v-btn>
        </v-list-item>
        <v-list-item class="d-flex justify-center">
            <v-btn href="<?php SITE_URL ?>/admin/" text>Panel Administrativo</v-btn>
        </v-list-item>
        <?php endif ?>
        <v-list-item class="d-flex justify-center">
            <v-btn href="<?php SITE_URL ?>/profile/" text>Perfil</v-btn>
        </v-list-item>
        <v-list-item class="d-flex justify-center" v-if="1 == 2">
            <v-btn href="<?php SITE_URL ?>/become-teacher" text>Conviértete en profesor</v-btn>
        </v-list-item>
        <v-list-item class="d-flex justify-center" v-if="1 == 2">
            <v-btn href="<?php SITE_URL ?>/my-courses" text>Mis cursos</v-btn>
        </v-list-item>
        <v-list-item class="d-flex justify-center">
            <v-btn color="red" href="<?php SITE_URL ?>/api/members/logout" text
                onclick="gapi.auth2.getAuthInstance().signOut()">Cerrar sesión</v-btn>
        </v-list-item>
    </v-list>
</v-menu>